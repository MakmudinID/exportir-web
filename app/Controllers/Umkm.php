<?php

namespace App\Controllers;

class Umkm extends BaseController
{
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
        $table = 'tbl_kategori_produk';
        $select = '*';
        $join = NULL;
        $where = array(
            array('id_umkm', session()->get('id'))
        );
        $column_order = array(NULL, 'nama', 'status');
        $column_search = array('nama');
        $order = array('nama' => 'asc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
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
}
