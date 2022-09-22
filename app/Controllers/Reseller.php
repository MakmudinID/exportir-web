<?php
namespace App\Controllers;
class Reseller extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function profil()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Profil';
        $data['profil'] = $this->server_side->get_profil();
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['js'] = array("reseller-profil.js?r=" . uniqid());
        $data['main_content']   = 'reseller/profil';
        echo view('template/adminlte', $data);
    }

    public function berita()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Berita';
        $data['js'] = array("reseller-berita.js?r=" . uniqid());
        $data['kategori'] = $this->db->query('select * from tbl_berita_kategori')->getResult();
        $data['main_content']   = 'reseller/berita';
        echo view('template/adminlte', $data);
    }

    public function detail_berita($slug)
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $data['title'] = 'Berita';
        $data['berita'] = $this->db->query('select tbl_berita.*, tbl_berita_kategori.nama as kategori from tbl_berita join tbl_berita_kategori on tbl_berita_kategori.id = tbl_berita.id_kategori where tbl_berita.slug=?', array($slug))->getRow();
        $data['main_content']   = 'reseller/berita-detail';
        echo view('template/adminlte', $data);
    }

    public function berita_()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->route('logout');
        }
        $table = 'tbl_berita';
        $select = 'tbl_berita.*, tbl_berita_kategori.nama as nama_kategori';
        $join = array(
            array('tbl_berita_kategori', 'tbl_berita_kategori.id = tbl_berita.id_kategori')
        );
        $where = array(
            array('tbl_berita.flag', 'INFO RESELLER')
        );
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
            $row['judul'] = $field->judul.'<br><small>'.$field->create_date.'</small>';
            $row['nama_kategori'] = $field->nama_kategori;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <a class="text-info align-items-center text-decoration-none detail mr-1" href="' .base_url('/reseller/detail-berita/'.$field->slug) . '" role="button"><i class="fa fa-eye mr-1"></i> Detail</a>
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

    public function create_berita()
    {
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
        if (session()->get('role') != 'RESELLER') {
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
