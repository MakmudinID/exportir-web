<?php

namespace App\Controllers;

class Umkm extends BaseController
{
    public function produk()
    {
        $data['title'] = 'UMKM | Produk';
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'umkm/produk'; 
		echo view('template/sb-admin', $data);
    }
}
