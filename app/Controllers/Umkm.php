<?php

namespace App\Controllers;

class Umkm extends BaseController
{
    public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->db = db_connect();
		helper(['url', 'form', 'array']);
	}

    public function index()
    {
        //Profil
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Dashboard';
        $data['js'] = array("umkm-dashboard.js?r=" . uniqid());
        $data['main_content']   = 'umkm/dashboard';
        echo view('template/adminlte', $data);
    }

    public function profil(){
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Profile';
        $data['js'] = array("umkm-profil.js?r=" . uniqid());
        $data['get_profil'] = $this->server_side->get_profil();
        // var_dump($data);
        $data['main_content']   = 'umkm/profil';
        echo view('template/adminlte', $data);
    }

    public function edit_profil(){
        $id = $this->request->getPost('id');
        $foto = $this->request->getFile('foto');
        $data['nama'] = $this->request->getPost('nama');
        $data['email'] = $this->request->getPost('email');
        $data['no_hp'] = $this->request->getPost('nohp');

        if ($foto->getName() != '') {
            $foto->move('../public/assets/photo-user/', $foto->getName());
            $filepath = base_url() . '/assets/photo-user/' . $foto->getName();
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
            $data['foto'] = $this->request->getPost('foto_');
        }

        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $result = $this->server_side->updateRows($id, $data, 'tbl_pengguna');
        if($result){
            $r['result'] = true;
        }else{
            $r['result'] = false;
        }

        return json_encode($r);
        
    }

    public function edit_umkm(){
        $id = $this->request->getPost('id_umkm');
        $foto = $this->request->getFile('foto_umkm');
        $data['nama'] = $this->request->getPost('nama_umkm');
        $data['deskripsi'] = $this->request->getPost('deskripsi_umkm');

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
            $data['foto'] = $this->request->getPost('foto_umkm_');
        }

        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $result = $this->server_side->updateRows($id, $data, 'tbl_umkm');
        if($result){
            $r['result'] = true;
        }else{
            $r['result'] = false;
        }

        return json_encode($r);
        
    }

    public function produk()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Produk';
        $data['js'] = array("umkm-produk.js?r=".uniqid());
		$data['main_content']   = 'umkm/produk'; 
		echo view('template/adminlte', $data);
    }

    public function produk_(){
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $cek = session()->get('id_umkm');
        $table = 'tbl_produk_umkm';
        $select = '*';
        $join = null;
        $where = array(
            array('id_umkm', $cek)
        );
        $column_order = array(NULL, 'nama', 'deskripsi', 'qty');
        $column_search = array('nama');
        $order = array('nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump(session()->get('id'));die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['deskripsi'] = $field->deskripsi;
            $row['qty'] = $field->qty;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-deskripsi="' . $field->deskripsi . '" data-qty="'. $field->qty .'" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
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

    public function create_produk()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);

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
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['deskripsi']  = htmlspecialchars($this->request->getPost('deskripsi'), ENT_QUOTES);
        $data['qty']  = htmlspecialchars($this->request->getPost('qty'), ENT_QUOTES);

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
        if(session()->get('role') != 'UMKM'){
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

    public function kategori_produk()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Kategori Produk';
        $data['js'] = array("umkm-kategori-produk.js?r=".uniqid());
		$data['main_content']   = 'umkm/kategori-produk'; 
		echo view('template/adminlte', $data);
    }

    public function kategori_produk_()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $cek = session()->get('id_umkm');
        $table = 'tbl_kategori_produk';
        $select = '*';
        $join = NULL;
        $where = array(
            array('id_umkm', $cek)
        );
        $column_order = array(NULL, 'nama', 'status');
        $column_search = array('nama');
        $order = array('nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        // var_dump(session()->get('id'));die;
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-status="' . $field->status . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
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

    public function create_kategori()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_produk';
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

    public function update_kategori()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $id_umkm = session()->get('id_umkm');
        $data['id_umkm'] = $id_umkm;
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['edit_user'] = session()->get('nama');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        $table = 'tbl_kategori_produk';
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

    public function delete_kategori()
    {
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $table = 'tbl_kategori_produk';
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

    public function kerjasama(){
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $data['title'] = 'UMKM | Kerjasama';
        $data['js'] = array("umkm-kerjasama.js?r=".uniqid());
		$data['main_content']  = 'umkm/kerjasama'; 
		echo view('template/adminlte', $data);
    }

    public function kerjasama_(){
        if(session()->get('role') != 'UMKM'){
            return redirect()->route('logout');
        }
        $id = session()->get('id');
        $cek = session()->get('id_umkm');
        $table = 'tbl_kerjasama';
        $select = 'tbl_pengguna.nama as nama_pengguna, tbl_umkm.nama as nama_umkm, tbl_kerjasama.*';
        $join = array(
            array('tbl_pengguna', 'tbl_pengguna.id = tbl_kerjasama.id_pengguna', 'left'),
            array('tbl_umkm', 'tbl_umkm.id = tbl_kerjasama.id_umkm', 'left')
        );;
        $where = array(
            array('tbl_kerjasama.id_umkm', $cek),
            array('tbl_kerjasama.id_pengguna', $id)
        );
        $column_order = array(NULL, 'nama_pengguna', 'nama_umkm', null, 'tbl_kerjasama.status');
        $column_search = array('nama_pengguna');
        $order = array('nama_pengguna' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['nama'] = $field->nama_pengguna;
            $row['umkm'] = $field->nama_umkm;
            $row['file'] = '<a href="'.$field->file_kerjasama.'" target="blank_">'.$field->file_kerjasama.'</a>';
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
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
}
