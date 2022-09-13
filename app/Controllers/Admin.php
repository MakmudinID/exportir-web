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
        $data['title'] = 'Admin | dashboard';
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
        $data['title'] = 'Admin | Profil';
        $data['js'] = array("admin-profil.js?r=" . uniqid());
        $data['main_content']   = 'admin/profil';
        echo view('template/adminlte', $data);
    }

    public function reseller()
    {
        //Reseller
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Admin | Reseller';
        $data['js'] = array("admin-reseller.js?r=" . uniqid());
        $data['main_content']   = 'admin/reseller';
        echo view('template/adminlte', $data);
    }

    public function reseller_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
    }

    public function umkm()
    {
        //UMKM
        $data['title'] = 'Admin | UMKM';
        $data['js'] = array("admin-umkm.js?r=" . uniqid());
        $data['pengguna'] = $this->db->query('select * from tbl_pengguna')->getResult();
        $data['kategori_umkm'] = $this->db->query('select * from tbl_kategori_umkm')->getResult();
        $data['main_content']   = 'admin/setting/umkm';
        echo view('template/adminlte', $data);
    }

    public function umkm_()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $table = 'tbl_umkm';
        $select = 'tbl_umkm.*, tbl_pengguna.nama as nama_pengguna, tbl_kategori_umkm.nama as nama_kategori';
        $join = array(
            array('tbl_pengguna', 'tbl_pengguna.id = tbl_umkm.id_pengguna'),
            array('tbl_kategori_umkm', 'tbl_kategori_umkm.id = tbl_umkm.id_kategori')
        );
        $where = array();
        $column_order = array(NULL, 'nama_pengguna', 'tbl_umkm.nama', 'tbl_umkm.foto', 'tbl_umkm.deskripsi', 'tbl_umkm.status');
        $column_search = array('nama_pengguna', 'tbl_umkm.nama');
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
            $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['kategori'] = $field->nama_kategori;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-idpengguna="' . $field->id_pengguna . '" data-idkategori="' . $field->id_kategori . '" data-umkm="' . $field->nama . '" data-deskripsi="' . $field->deskripsi . '" data-status="' . $field->status . '" data-foto="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
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


    public function produk()
    {
        //Produk management
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Admin | Produk';
        $data['js'] = array("admin-produk.js?r=" . uniqid());
        $data['main_content']   = 'admin/data/produk';
        echo view('template/adminlte', $data);
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
        $column_search = array('tbl_produk_umkm.nama');
        $order = array('tbl_produk_umkm.id' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump($list);die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['umkm'] = $field->nama_umkm;
            $row['foto'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['nama'] = $field->nama;
            $row['kategori'] = $field->nama_kategori;
            $row['qty'] = $field->qty . " " . $field->satuan;
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
        $options = [
            'cost' => 10,
        ];
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $data['password'] = $password_hash;
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
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
        $table = 'tbl_pengguna';
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

    public function user()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Admin | User';
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
        $where = array();
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
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-email="' . $field->email . '" data-no_hp="' . $field->no_hp . '" data-role="' . $field->role . '" data-status="' . $field->status . '" data-photo="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
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

    public function berita()
    {
        if (session()->get('role') != 'SUPERADMIN') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Admin | Berita';
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
        $data['title'] = 'Admin | Berita Kategori';
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
        $data['title'] = 'Admin | Kategori UMKM';
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
}
