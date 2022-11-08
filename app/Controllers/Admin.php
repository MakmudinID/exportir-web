<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function dashboard()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Dashboard';
        $data['js'] = array("admin-dashboard.js?r=" . uniqid());
        $data['main_content']   = 'admin/dashboard';
        echo view('template/adminlte', $data);
    }

    public function index()
    {
        //Profil
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Profil';
        $data['js'] = array("admin-profil.js?r=" . uniqid());
        $data['main_content']   = 'admin/profil';
        echo view('template/adminlte', $data);
    }

    public function admin()
    {
        //admin
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'admin';
        $data['js'] = array("admin-admin.js?r=" . uniqid());
        $data['main_content']   = 'admin/admin';
        echo view('template/adminlte', $data);
    }

    public function admin_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
    }

    public function umkm()
    {
        //UMKM
        $data['title'] = 'UMKM';
        $data['js'] = array("admin-umkm.js?r=" . uniqid());
        $data['pengguna'] = $this->db->query('select * from tbl_pengguna')->getResult();
        $data['kategori_umkm'] = $this->db->query('select * from tbl_kategori_umkm')->getResult();
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['kota'] = $this->server_side->getKotaAll();
        $data['main_content']   = 'admin/setting/umkm';
        echo view('template/adminlte', $data);
    }

    public function update_selesai()
    {
        $id = $this->request->getPost('id_transaksi');
        $data['status'] = 'SELESAI';
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_transaksi';

        $result = $this->server_side->updateRows($id, $data, $table);
        $r['result'] = true;
        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }


    public function umkm_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_umkm';
        $select = 'tbl_umkm.*, tbl_pengguna.nama as nama_pengguna, tbl_pengguna.email as email, tbl_kategori_umkm.nama as nama_kategori';
        $join = array(
            array('tbl_pengguna', 'tbl_pengguna.id = tbl_umkm.id_pengguna'),
            array('tbl_kategori_umkm', 'tbl_kategori_umkm.id = tbl_umkm.id_kategori')
        );
        $where = array(
            array('tbl_umkm.status !=', 'DELETED')
        );
        $column_order = array(NULL, 'tbl_pengguna.nama', 'tbl_umkm.nama', 'tbl_umkm.foto', 'tbl_umkm.deskripsi', 'tbl_umkm.status');
        $column_search = array('tbl_pengguna.nama', 'tbl_umkm.nama');
        $order = array('role' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama_pengguna'] = $field->nama_pengguna;
            $row['nama_umkm'] = $field->nama;
            // $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['email'] = $field->email;
            $row['kategori'] = $field->nama_kategori;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-alamat="' . $field->alamat . '" data-kota="' . $field->city_id . '" data-propinsi="' . $field->province_id . '" data-id="' . $field->id . '" data-idpengguna="' . $field->id_pengguna . '" data-idkategori="' . $field->id_kategori . '" data-umkm="' . $field->nama . '" data-deskripsi="' . $field->deskripsi . '" data-status="' . $field->status . '" data-foto="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');

        $data['id_pengguna']  = htmlspecialchars($this->request->getPost('id_pengguna'), ENT_QUOTES);
        $data['id_kategori']  = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['slug']   =  strtolower(url_title($this->request->getPost('nama')));
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['province_id']  = htmlspecialchars($this->request->getPost('propinsi'), ENT_QUOTES);
        $data['city_id']  = htmlspecialchars($this->request->getPost('kota'), ENT_QUOTES);
        $data['alamat']  = htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-umkm/', $foto->getName());
            $filepath = base_url() . '/assets/photo-umkm/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }

        $table = 'tbl_umkm';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $foto = $this->request->getFile('foto');

        $data['id_pengguna']  = htmlspecialchars($this->request->getPost('id_pengguna'), ENT_QUOTES);
        $data['id_kategori']  = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['slug']   =  strtolower(url_title($this->request->getPost('nama')));
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['province_id']  = htmlspecialchars($this->request->getPost('propinsi'), ENT_QUOTES);
        $data['city_id']  = htmlspecialchars($this->request->getPost('kota'), ENT_QUOTES);
        $data['alamat']  = htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-umkm/', $foto->getName());
            $filepath = base_url() . '/assets/photo-umkm/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        }

        $table = 'tbl_umkm';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_umkm';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);

        $umkm = $this->db->table('tbl_umkm')->getWhere(['id_pengguna' => $id_])->getRow();

        $table_pengguna = 'tbl_pengguna';
        $data_pengguna['status'] = 'DELETED';
        $this->server_side->updateRows($umkm->id_pengguna, $data_pengguna, $table_pengguna);

        $table = 'tbl_umkm';
        $data_umkm['status'] = 'DELETED';
        $result = $this->server_side->updateRowsByField('id', $id_, $data_umkm, $table);

        if ($result) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }

        // if ($this->server_side->deleteRows($id_, $table)) {
        //     $r['title'] = 'Sukses!';
        //     $r['icon'] = 'success';
        //     $r['status'] = 'Berhasil di Hapus!';
        // } else {
        //     $r['title'] = 'Maaf!';
        //     $r['icon'] = 'error';
        //     $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        // }
        echo json_encode($r);
        return;
    }

    public function produk()
    {
        //Produk management
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Produk';
        $data['js'] = array("admin-produk.js?r=" . uniqid());
        $data['kategori_produk_umkm'] = $this->server_side->getKategoriProduk();
        $data['umkm'] = $this->server_side->getUMKM();
        $data['main_content']   = 'admin/data/produk';
        echo view('template/adminlte', $data);
    }

    public function get_kategori_produk_umkm()
    {
        $kategori = $this->server_side->getKategoriProdukById($this->request->getPost('id_umkm'));
        echo '<option value="">- Pilih Kategori -</option>';
        foreach ($kategori as $k) {
            echo '<option value="' . $k->id . '">' . $k->nama . '</option>';
        }
        return;
    }

    public function create_produk()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');
        $id_umkm = htmlspecialchars($this->request->getPost('id_umkm'), ENT_QUOTES);
        $data['id_umkm'] = $id_umkm;
        $data['id_kategori']   = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);
        $data['qty_min']  = htmlspecialchars($this->request->getPost('qty_min'), ENT_QUOTES);
        $data['harga_min']  = htmlspecialchars($this->request->getPost('harga_kerjasama'), ENT_QUOTES);
        $data['harga']  = htmlspecialchars($this->request->getPost('harga'), ENT_QUOTES);
        $data['satuan']  = htmlspecialchars($this->request->getPost('satuan'), ENT_QUOTES);
        $data['weight']  = htmlspecialchars($this->request->getPost('weight'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-produk/', $foto->getName());
            $filepath = base_url() . '/assets/photo-produk/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }


        $r['result'] = true;

        $table = 'tbl_produk_umkm';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_produk()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $id_umkm = htmlspecialchars($this->request->getPost('id_umkm'), ENT_QUOTES);
        $data['id_umkm'] = $id_umkm;
        $data['id_kategori']   = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);
        $data['harga']  = htmlspecialchars($this->request->getPost('harga'), ENT_QUOTES);
        $data['harga_min']  = htmlspecialchars($this->request->getPost('harga_kerjasama'), ENT_QUOTES);
        $data['qty_min']  = htmlspecialchars($this->request->getPost('qty_min'), ENT_QUOTES);
        $data['satuan']  = htmlspecialchars($this->request->getPost('satuan'), ENT_QUOTES);
        $data['weight']  = htmlspecialchars($this->request->getPost('weight'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-produk/', $foto->getName());
            $filepath = base_url() . '/assets/photo-produk/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
                echo json_encode($r);
                return;
            }
        }

        $r['result'] = true;

        $table = 'tbl_produk_umkm';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_produk()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_produk_umkm';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function produk_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_produk_umkm';
        $select = 'tbl_produk_umkm.*, tbl_umkm.nama as nama_umkm, tbl_kategori_produk.nama as nama_kategori';
        $join = array(
            array('tbl_umkm', 'tbl_umkm.id = tbl_produk_umkm.id_umkm'),
            array('tbl_kategori_produk', 'tbl_kategori_produk.id = tbl_produk_umkm.id_kategori')
        );
        $where = array();
        $column_order = array(NULL, 'tbl_produk_umkm.nama', null, 'tbl_produk_umkm.nama', 'nama_kategori', 'tbl_produk_umkm.qty');
        $column_search = array('tbl_produk_umkm.nama', 'tbl_umkm.nama');
        $order = array('tbl_produk_umkm.id' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['nama'] = $field->nama;
            $row['umkm'] = $field->nama_umkm;
            $row['kategori'] = $field->nama_kategori;
            $row['qty'] = $field->qty . " " . $field->satuan;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-id_umkm="' . $field->id_umkm . '" data-harga="' . $field->harga . '" data-harga_kerjasama="' . $field->harga_min . '"  data-id_kategori="' . $field->id_kategori . '" data-nama="' . $field->nama . '" data-deskripsi="' . $field->deskripsi . '" data-qty="' . $field->qty . '" data-qty_min="' . $field->qty_min . '" data-satuan="' . $field->satuan . '" data-weight="' . $field->weight . '" data-status="' . $field->status . '" data-foto="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_user()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $photo = $this->request->getFile('photo');

        $data['role']   = htmlspecialchars($this->request->getPost('role'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['email']  = htmlspecialchars($this->request->getPost('email'), ENT_QUOTES);
        $data['no_hp']  = htmlspecialchars($this->request->getPost('no_hp'), ENT_QUOTES);
        $options = [
            'cost' => 10,
        ];
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $data['password'] = $password_hash;
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['id_propinsi']  = htmlspecialchars($this->request->getPost('propinsi'), ENT_QUOTES);
        $data['id_kota']  = htmlspecialchars($this->request->getPost('kota'), ENT_QUOTES);
        $data['alamat']  = htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($photo->getName() != '') {
            $photo->move('../public/assets/photo-user/', $photo->getName());
            $filepath = base_url() . '/assets/photo-user/' . $photo->getName();
            $path = $photo->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }

        $table = 'tbl_pengguna';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_user()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $photo = $this->request->getFile('photo');
        $photo_ = $this->request->getPost('photo_');

        $data['role']   = htmlspecialchars($this->request->getPost('role'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['email']  = htmlspecialchars($this->request->getPost('email'), ENT_QUOTES);
        $data['no_hp']  = htmlspecialchars($this->request->getPost('no_hp'), ENT_QUOTES);

        if ($this->request->getPost('password') != '') {
            $options = [
                'cost' => 10,
            ];
            $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
            $data['password'] = $password_hash;
        }

        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['id_propinsi']  = htmlspecialchars($this->request->getPost('propinsi'), ENT_QUOTES);
        $data['id_kota']  = htmlspecialchars($this->request->getPost('kota'), ENT_QUOTES);
        $data['alamat']  = htmlspecialchars($this->request->getPost('alamat'), ENT_QUOTES);

        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($photo->getName() != '') {
            $photo->move('../public/assets/photo-user/', $photo->getName());
            $filepath = base_url() . '/assets/photo-user/' . $photo->getName();
            $path = $photo->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = $photo_;
        }

        $table = 'tbl_pengguna';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_user()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $role = htmlspecialchars($this->request->getPost('role'), ENT_QUOTES);
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);

        if ($role == 'UMKM') {
            $table_pengguna = 'tbl_pengguna';
            $data_pengguna['status'] = 'DELETED';
            $this->server_side->updateRows($id_, $data_pengguna, $table_pengguna);

            $table = 'tbl_umkm';
            $data_umkm['status'] = 'DELETED';
            $result = $this->server_side->updateRowsByField('id_pengguna', $id_, $data_umkm, $table);

            if ($result) {
                $r['title'] = 'Sukses!';
                $r['icon'] = 'success';
                $r['status'] = 'Berhasil di Hapus!';
            } else {
                $r['title'] = 'Maaf!';
                $r['icon'] = 'error';
                $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
            }
        } else {
            $table_pengguna = 'tbl_pengguna';
            $data_pengguna['status'] = 'DELETED';
            $result = $this->server_side->updateRows($id_, $data_pengguna, $table_pengguna);

            if ($result) {
                $r['title'] = 'Sukses!';
                $r['icon'] = 'success';
                $r['status'] = 'Berhasil di Hapus!';
            } else {
                $r['title'] = 'Maaf!';
                $r['icon'] = 'error';
                $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
            }
        }

        echo json_encode($r);
        return;
    }

    public function user()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $data['title'] = 'Pengguna';
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['kota'] = $this->server_side->getKotaAll();
        $data['js'] = array("admin-user.js?r=" . uniqid());
        $data['main_content']   = 'admin/setting/user';
        echo view('template/adminlte', $data);
    }

    public function user_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_pengguna';
        $select = '*';
        $join = NULL;
        $where = array(
            array('tbl_pengguna.status !=', 'DELETED')
        );
        $column_order = array(NULL, 'foto', 'nama', 'email', 'role', 'status');
        $column_search = array('nama', 'email');
        $order = array('role' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['photo'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['nama'] = $field->nama;
            $row['email'] = $field->email;
            $row['role'] = $field->role;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-propinsi="' . $field->id_propinsi . '" data-kota="' . $field->id_kota . '" data-nama="' . $field->nama . '" data-email="' . $field->email . '" data-no_hp="' . $field->no_hp . '" data-role="' . $field->role . '" data-status="' . $field->status . '" data-photo="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-role="' . $field->role . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function metode_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $data['title'] = 'Metode Bayar';
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['kota'] = $this->server_side->getKotaAll();
        $data['js'] = array("admin-metode-bayar.js?r=" . uniqid());
        $data['main_content']   = 'admin/setting/metode-bayar';
        echo view('template/adminlte', $data);
    }

    public function metode_bayar_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $table = 'tbl_metode_bayar';
        $select = '*';
        $join = NULL;
        $where = array();
        $column_order = array(NULL, 'nama', 'nomor_rekening', 'status', NULL);
        $column_search = array('nama', 'nomor_rekening');
        $order = array('nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['nomor_rekening'] = $field->nomor_rekening;
            $row['status'] = $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-nomor_rekening="' . $field->nomor_rekening . '" data-status="' . $field->status . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-nomor_rekening="' . $field->nomor_rekening . '" data-status="' . $field->status . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_metode_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $data['nama']  = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['nomor_rekening']  = htmlspecialchars($this->request->getPost('nomor_rekening'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;
        $table = 'tbl_metode_bayar';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_metode_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);

        $data['nama']  = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['nomor_rekening']  = htmlspecialchars($this->request->getPost('nomor_rekening'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_metode_bayar';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_metode_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_transaksi_pembayaran';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);

        //check 
        $check = $this->db->query("select * from tbl_transaksi_pembayaran where id_metode_bayar=?", array($id_))->getNumRows();
        if ($check > 0) {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
            echo json_encode($r);
        } else {
            if ($this->server_side->deleteRows($id_, 'tbl_metode_bayar')) {
                $r['title'] = 'Sukses!';
                $r['icon'] = 'success';
                $r['status'] = 'Berhasil di Hapus!';
            } else {
                $r['title'] = 'Maaf!';
                $r['icon'] = 'error';
                $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
            }
            echo json_encode($r);
        }
    }

    public function berita()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Berita';
        $data['js'] = array("admin-berita.js?r=" . uniqid());
        $data['kategori'] = $this->db->query('select * from tbl_berita_kategori')->getResult();
        $data['main_content']   = 'admin/berita/berita';
        echo view('template/adminlte', $data);
    }

    public function berita_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita';
        $select = 'tbl_berita.*, tbl_berita_kategori.nama as nama_kategori';
        $join = array(
            array('tbl_berita_kategori', 'tbl_berita_kategori.id = tbl_berita.id_kategori')
        );
        $where = array();
        $column_order = array(NULL, NULL, 'tbl_berita.judul', 'nama_kategori', 'tbl_berita.slug', 'tbl_berita.flag', 'tbl_berita.penulis', 'tbl_berita.status');
        $column_search = array('tbl_berita.judul', 'nama_kategori');
        $order = array('tbl_berita.id' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['judul'] = $field->judul;
            $row['nama_kategori'] = $field->nama_kategori;
            $row['slug'] = $field->slug;
            $row['flag'] = $field->flag;
            $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['penulis'] = $field->penulis;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-ringkasan="' . $field->ringkasan . '" data-idkategori="' . $field->id_kategori . '" data-judul="' . $field->judul . '" data-isi="' . $field->isi . '" data-slug="' . $field->slug . '" data-flag="' . $field->flag . '" data-penulis="' . $field->penulis . '" data-status="' . $field->status . '" data-foto="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-judul="' . $field->judul . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_berita()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $foto = $this->request->getFile('foto');

        $data['id_kategori']  = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['judul']   = htmlspecialchars($this->request->getPost('judul'), ENT_QUOTES);
        $data['ringkasan']  = htmlspecialchars($this->request->getPost('ringkasan'), ENT_QUOTES);
        $data['isi']  = htmlspecialchars($this->request->getPost('isi'), ENT_QUOTES);
        $data['slug']  = htmlspecialchars($this->request->getPost('slug'), ENT_QUOTES);
        $data['flag']  = htmlspecialchars($this->request->getPost('flag'), ENT_QUOTES);
        $data['penulis']  = htmlspecialchars($this->request->getPost('penulis'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-berita/', $foto->getName());
            $filepath = base_url() . '/assets/photo-berita/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || $ext == 'JPG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
                echo json_encode($r);
                return;
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }

        $table = 'tbl_berita';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_berita()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $foto = $this->request->getFile('foto');

        $data['id_kategori']  = htmlspecialchars($this->request->getPost('id_kategori'), ENT_QUOTES);
        $data['judul']   = htmlspecialchars($this->request->getPost('judul'), ENT_QUOTES);
        $data['isi']  = htmlspecialchars($this->request->getPost('isi'), ENT_QUOTES);
        $data['ringkasan']  = htmlspecialchars($this->request->getPost('ringkasan'), ENT_QUOTES);
        $data['slug']  = htmlspecialchars($this->request->getPost('slug'), ENT_QUOTES);
        $data['flag']  = htmlspecialchars($this->request->getPost('flag'), ENT_QUOTES);
        $data['penulis']  = htmlspecialchars($this->request->getPost('penulis'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-berita/', $foto->getName());
            $filepath = base_url() . '/assets/photo-berita/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
                echo json_encode($r);
                return;
            }
        }

        $table = 'tbl_berita';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_berita()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function berita_kategori()
    {
        //UMKM
        $data['title'] = 'Berita Kategori';
        $data['js'] = array("admin-beritakategori.js?r=" . uniqid());
        $data['main_content']   = 'admin/berita/berita_kategori';
        echo view('template/adminlte', $data);
    }

    public function berita_kategori_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita_kategori';
        $select = '*';
        $join = null;
        $where = array();
        $column_order = array(NULL, 'nama', 'status');
        $column_search = array('nama');
        $order = array('nama' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '"  data-nama="' . $field->nama . '" data-status="' . $field->status . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_berita_kategori()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_berita_kategori';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_berita_kategori()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_berita_kategori';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_berita_kategori()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita_kategori';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function kategori_umkm()
    {
        //UMKM
        $data['title'] = 'Kategori UMKM';
        $data['js'] = array("admin-kategori-umkm.js?r=" . uniqid());
        $data['main_content']   = 'admin/data/kategori-umkm';
        echo view('template/adminlte', $data);
    }

    public function kategori_umkm_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_kategori_umkm';
        $select = '*';
        $join = null;

        $where = array(
            array('tbl_kategori_umkm.status !=', 'DELETED')
        );

        $column_order = array(NULL, 'nama', 'status');
        $column_search = array('nama');
        $order = array('nama' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '"  data-nama="' . $field->nama . '" data-status="' . $field->status . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center ml-2 delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function create_kategori_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_umkm';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_kategori_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_umkm';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_kategori_umkm()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_kategori_umkm';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function update_status_transaksi()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $id = $this->request->getPost('id_pembayaran');
        $kode_transaksi = $this->request->getPost('kode_transaksi');

        $tbl_transaksi['status'] = $this->request->getPost('status_transaksi');
        $tbl_transaksi['no_resi'] = $this->request->getPost('no_resi_transaksi');

        $table_transaksi = 'tbl_transaksi';
        $this->server_side->updateRowsByField('id_pembayaran', $id, $tbl_transaksi, $table_transaksi);

        $table_transaksi_pembayaran = 'tbl_transaksi_pembayaran';
        $tbl_transaksi_pembayaran['status'] = $this->request->getPost('status_bayar');
        $this->server_side->updateRowsByField('id', $id, $tbl_transaksi_pembayaran, $table_transaksi_pembayaran);

        return redirect()->to('admin/transaksi/' . $kode_transaksi);
    }

    public function update_kirim()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $id = $this->request->getPost('id_transaksi');
        $no_resi = $this->request->getPost('no_resi');
        $foto = $this->request->getFile('foto');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-bukti-kirim/', $foto->getName());
            $filepath = base_url() . '/assets/photo-bukti-kirim/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['bukti_url'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        }

        $data['status'] = 'SUDAH_DIKIRIM';
        $data['no_resi'] = $no_resi;
        $data['tanggal_kirim'] = date('Y-m-d');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_transaksi';

        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        } else {
            $r['result'] = true;
        }
        echo json_encode($r);
        return;
    }

    public function update_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $id = $this->request->getPost('id_pembayaran');
        $foto = $this->request->getFile('foto');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-bukti-bayar/', $foto->getName());
            $filepath = base_url() . '/assets/photo-bukti-bayar/' . $foto->getName();
            $path = $foto->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif' || 'JPEG') {
                $data['bukti_url'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        }

        $data['status'] = 'MENUNGGU_KONFIRMASI';
        $data['keterangan'] = htmlspecialchars($this->request->getPost('keterangan'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $table = 'tbl_transaksi_pembayaran';

        $result = $this->server_side->updateRows($id, $data, $table);

        $data_transaksi['status'] = 'SEDANG_DIPROSES';
        $data_transaksi['edit_date'] = date('Y-m-d H:i:s');

        $table_transaksi = 'tbl_transaksi';
        $result = $this->server_side->updateRowsByField('id_pembayaran', $id, $data_transaksi, $table_transaksi);

        $r['result'] = true;
        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function konfirmasi_bayar()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $id = $this->request->getPost('id_pembayaran');
        $konfirmasi = $this->request->getPost('konfirmasi');
        $catatan_konfirmasi = $this->request->getPost('catatan_konfirmasi');

        if ($konfirmasi == 'LUNAS') {
            $data['status'] = 'SUDAH_DIBAYAR';
            $data['keterangan'] = htmlspecialchars($catatan_konfirmasi);
            $data['edit_user'] = session()->get('nama');
            $data['edit_date'] = date('Y-m-d H:i:s');

            $table = 'tbl_transaksi_pembayaran';

            $result = $this->server_side->updateRows($id, $data, $table);
        } else {
            $keterangan = htmlspecialchars($catatan_konfirmasi);
            $result = $this->server_side->updateBatalTransaksi($id, $keterangan);
        }

        $r['result'] = true;
        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function transaksi()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi Penjualan';
        $data['js'] = array("admin-transaksi.js?r=" . uniqid());
        $data['main_content']   = 'admin/transaksi';
        echo view('template/adminlte', $data);
    }

    public function transaksi_detail($kode_bayar)
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi Penjualan';
        $data['js'] = array("admin-transaksi-detail.js?r=" . uniqid());
        $data['pembayaran'] = $this->server_side->pembayaran($kode_bayar);
        // var_dump($data['pembayaran']); die;
        $data['transaksi'] = $this->server_side->transaksi_in_kodebayar($kode_bayar);
        $data['main_content']   = 'admin/transaksi_detail';
        echo view('template/adminlte', $data);
    }

    public function transaksi_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if ($this->request->getPost('status') == 'ALL') {
            $status = "";
        } else {
            $status = $this->request->getPost('status');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        $list = $this->transaksi->limitRowstTransaksi($status, $start_date, $end_date);

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();

            $row['tanggal_transaksi'] = $field->create_date;
            $row['batas_bayar'] = $field->batas_bayar;

            $row['kode_bayar'] = $field->kode_bayar;
            $row['total_tagihan'] = 'Rp ' . number_format($field->total_tagihan, 0, ',', '.');

            if ($field->status == 'BELUM_DIBAYAR') {
                $row['status'] = '
                <div class="d-flex justify-content-center">
                    <div class="badge badge-danger align-self-center">Belum Dibayar</div>
                    <div class="align-self-center ml-2 unggah-bukti-bayar" data-id_pembayaran="' . $field->id . '" role="button"><i class="fas fa-upload text-danger"></i></div>
                </div>';
            } else if ($field->status == 'MENUNGGU_KONFIRMASI') {
                $row['status'] = '
                <div class="d-flex justify-content-center">
                    <div class="badge badge-warning align-self-center">Menunggu Konfirmasi</div>
                    <div class="align-self-center ml-2 konfirmasi-bukti-bayar" data-id_pembayaran="' . $field->id . '" data-bukti_url="' . $field->bukti_url . '" data-keterangan="' . $field->keterangan . '" role="button"><i class="fas fa-edit"></i></div>
                </div>';
            } else if ($field->status == 'SUDAH_DIBAYAR') {
                $row['status'] = '<span class="badge badge-success">Lunas</span>';
            } else {
                $row['status'] = '<span class="badge badge-danger">Batal</span>';
            }

            $row['detail'] = '
            <div class="d-flex justify-content-center">
                <a href="' . base_url('admin/transaksi/' . $field->kode_bayar) . '" class="p-1"><i class="fas fa-search-plus"></i></a>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->transaksi->countFilteredTransaksi($status, $start_date, $end_date),
            "recordsFiltered" => $this->transaksi->countFilteredTransaksi($status, $start_date, $end_date),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    //KERJASAMA
    public function kerjasama()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi Kerja Sama';
        $data['js'] = array("admin-kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'admin/kerjasama';
        echo view('template/adminlte', $data);
    }

    public function konfirmasi_kerjasama()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        $status_kerjasama = $this->request->getPost('status_kerjasama');
        $no_kerjasama = $this->request->getPost('no_kerjasama');

        if ($status_kerjasama == 'SUDAH_DISETUJUI') {
            $data['status'] = $status_kerjasama;
            $table = 'tbl_transaksi_kerjasama';
            $result = $this->server_side->updateRowsByField('no_kerjasama', $no_kerjasama, $data, $table);
            $r['result'] = true;
            if (!$result) {
                $r['result'] = false;
                $r['title'] = 'Maaf Gagal Menyimpan!';
                $r['icon'] = 'error';
                $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
            }
            echo json_encode($r);
            return;
        } else {
            $alasan_ditolak = $this->request->getPost('alasan_ditolak');

            $result = $this->server_side->updateBatalKerjasama($no_kerjasama, $alasan_ditolak);
            $r['result'] = true;
            if ($result == 0) {
                $r['result'] = false;
                $r['title'] = 'Maaf Gagal Dibatalkan!';
                $r['icon'] = 'error';
                $r['status'] = '<br><b>Tidak dapat di Batalkan! <br> Silakan hubungi Administrator.</b>';
            }
            echo json_encode($r);
            return;
        }
    }

    public function kerjasama_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }

        if ($this->request->getPost('tgl_transaksi') <> "") {
            $start_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[0];
            $end_date = explode(" - ", $this->request->getPost('tgl_transaksi'))[1];
        } else {
            $start_date = "";
            $end_date = "";
        }

        if ($this->request->getPost('status') == 'ALL') {
            $status = "";
        } else {
            $status = $this->request->getPost('status');
        }

        $list = $this->transaksi->limitRowsKerjasama($status, $start_date, $end_date);

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['tanggal_pengajuan'] = $field->create_date;
            $row['no_kerjasama'] = '<a target="_blank" href="' . base_url('reseller/pdf/' . $field->no_kerjasama) . '">' . $field->no_kerjasama . '</a>';
            $row['umkm'] = $field->nama_umkm;
            $progress = round($this->transaksi->progress($field->lama_kerjasama, $field->no_kerjasama));

            $row['progress'] = '
                <div class="progress progress-sm active">
                  <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $progress . '%">
                    <span class="sr-only">' . $progress . '% Complete</span>
                  </div>
                </div>
                <div class="align-self-center">' . $progress . '%</div>
            ';
            $row['kontrak'] = $field->lama_kerjasama . ' Bulan';

            if ($field->status == 'MENUNGGU_PERSETUJUAN') {
                $url = $field->file_kerjasama;

                $row['status'] = '<div class="d-flex justify-content-center">
                                    <div class="badge badge-warning">Menunggu Persetujuan</div>
                                    <div class="align-self-center ml-2 unggah-perjanjian" data-no_kerjasama="' . $field->no_kerjasama . '" data-url="' . $url . '" role="button"><i class="fas fa-edit"></i></div>
                                </div>';
            } else if ($field->status == 'DITOLAK') {
                $url = $field->file_kerjasama;
                $row['status'] = '<span class="badge badge-danger align-self-center">Kerjasama Ditolak</span>';
            } else {
                $url = $field->file_kerjasama;

                $row['status'] = '<span class="badge badge-success">Disetujui</span>';
            }

            $row['detail'] = '
            <div class="d-flex justify-content-center">
                <a href="' . base_url('admin/kerjasama/' . $field->no_kerjasama) . '" class="p-1"><i class="fas fa-search-plus"></i></a>
            </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->transaksi->countFilteredKerjasama($status, $start_date, $end_date),
            "recordsFiltered" => $this->transaksi->countFilteredKerjasama($status, $start_date, $end_date),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function kerjasama_detail($no_kerjasama)
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Transaksi Kerja Sama';
        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);
        $data['js'] = array("admin-kerjasama-detail.js?r=" . uniqid());
        $data['main_content']   = 'admin/kerjasama_detail';
        echo view('template/adminlte', $data);
    }

    public function kerjasama_pdf($no_kerjasama)
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - ' . $no_kerjasama);

        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);

        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('Dokumen Perjanjian Kerjasama.pdf', 'I'); // opens in browser
    }

    public function kerjasama_pdf_download($no_kerjasama)
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetTitle('Surat Perjanjian Kerja Sama Usaha - ' . $no_kerjasama);

        $data['kerjasama'] = $this->server_side->getKerjasama($no_kerjasama);

        $html = view('reseller/kerjasama_pdf', $data);

        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output('arjun.pdf', 'D'); // opens in browser
    }
}
