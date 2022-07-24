<?php

namespace App\Controllers;

class Frontend extends BaseController
{

    public function index()
    {
        //Home
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/home'; 
		$data['produk']   = $this->server_side->getProdukRand(); 
		$data['kategori']   = $this->server_side->getKategoriUMKM(); 
		echo view('template/fruitkha', $data);
    }
    
    public function kategori()
    {
        //Kategori
        return view('welcome_message');
    }

    public function produk($id=NULL)
    {
        //Berita
        $data['js'] = array("produk.js?r=".uniqid());
		$data['main_content']   = 'frontend/produk'; 
		echo view('template/fruitkha', $data);
    }

    public function berita()
    {
        //Berita
        $data['kategori']   = $this->server_side->getKategoriUMKM(); 
        $data['berita']   = $this->server_side->getBerita(); 
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/berita'; 
		echo view('template/fruitkha', $data);
    }

    public function tentang()
    {
        //Tentang
        $data['kategori']   = $this->server_side->getKategoriUMKM(); 
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/tentang'; 
		echo view('template/fruitkha', $data);
    }
    
    public function keranjang()
    {
        //Tentang
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/keranjang'; 
		echo view('template/fruitkha', $data);
    }
}
