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
        $data['nama'] = $this->request->getPost('nama');
        $data['email'] = $this->request->getPost('email');
        $data['no_hp'] = $this->request->getPost('nohp');

        $result = $this->server_side->updateRows($id, $data, 'tbl_pengguna');
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
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'umkm/produk'; 
		echo view('template/sb-admin', $data);
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
        $cek = $this->server_side->get_profil();
        $table = 'tbl_kategori_produk';
        $select = '*';
        $join = NULL;
        $where = array(
            array('id_umkm', $cek->id_umkm)
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
        $id_umkm = $this->server_side->get_profil();
        $data['id_umkm'] = $id_umkm->id_umkm;
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
        $id_umkm = $this->server_side->get_profil();
        $data['id_umkm'] = $id_umkm->id_umkm;
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
}
