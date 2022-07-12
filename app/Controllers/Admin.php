<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        //Profil
        $data['title'] = 'Admin | Profil';
        $data['js'] = array("admin-profil.js?r=" . uniqid());
        $data['main_content']   = 'admin/profil';
        echo view('template/sb-admin', $data);
    }

    public function reseller()
    {
        //Reseller
        $data['title'] = 'Admin | Reseller';
        $data['js'] = array("admin-reseller.js?r=" . uniqid());
        $data['main_content']   = 'admin/reseller';
        echo view('template/sb-admin', $data);
    }

    public function reseller_()
    {
    }

    public function umkm()
    {
        //UMKM
        $data['title'] = 'Admin | UMKM';
        $data['js'] = array("admin-umkm.js?r=" . uniqid());
        $data['main_content']   = 'admin/umkm';
        echo view('template/sb-admin', $data);
    }

    public function umkm_()
    {
    }

    public function produk()
    {
        //Produk management
        $data['title'] = 'Admin | Produk';
        $data['js'] = array("admin-produk.js?r=" . uniqid());
        $data['main_content']   = 'admin/produk';
        echo view('template/sb-admin', $data);
    }

    public function produk_()
    {
    }

    public function user()
    {
        //User Management
        $data['title'] = 'Admin | User';
        $data['js'] = array("admin-user.js?r=" . uniqid());
        $data['main_content']   = 'admin/user';
        echo view('template/sb-admin', $data);
    }

    public function user_()
    {
    }

    public function modul()
    {
        //Modul Management
        $data['title'] = 'Admin | Modul';
        $data['js'] = array("admin-modul.js?r=" . uniqid());
        $data['main_content']  = 'admin/modul';
        echo view('template/sb-admin', $data);
    }

    public function modul_()
    {
        $column_order = array('program.nama', 'program.judul', 'layanan.nama', 'program_kategori.nama', 'program.target_dana');
		$column_search = array('program.nama', 'program.judul');
		$order = array('program.create_date' => 'desc');

		$table = 'modul';
		$select = '*';
		$join = array();
		$whereIn = array();
		$like = array();
		$notlike = array();

		$list = $this->server_side->limitRows($table, $select, $whereIn, $column_order, $column_search, $order, $join, $like, $notlike);
		$data = array();
		$no = $this->request->getPost('start');
		foreach ($list as $field) {
			$row = array();
			$no++;
			$row['no'] = $no;
			$row['nama'] = $field->modul;
			$row['group'] = $field->groups;
	        $row['status'] = ($field->status == 'ACTIVE') ? '<span class="badge bg-primary">'.$field->status.'</span>' : '<span class="badge bg-danger">'.$field->status.'</span>';
			$row['action'] = '<div class="d-flex justify-content-center align-items-center">
                                <a href="' . base_url() . '/data/edit-program/" class="text-warning align-items-center text-decoration-none" role="button"><i class="fa fa-pencil-alt mr-2"></i> Edit</a>
                                <div class="ms-2 text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-modul="' . $field->modul . '"><i class="fa fa-trash-alt mr-2"></i> Delete</div>
                              </div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->request->getPost('draw'),
			"recordsTotal" => $this->server_side->countAll($table),
			"recordsFiltered" => $this->server_side->countFiltered($table, $select, $whereIn, $column_order, $column_search, $order, $join, $like, $notlike),
			"data" => $data,
		);
		echo json_encode($output);
    }
}
