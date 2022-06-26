<?php

namespace App\Controllers;

class Frontend extends BaseController
{

    public function index()
    {
        //Home
        $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/home'; 
		echo view('template/fruitkha', $data);
    }
    
    public function kategori()
    {
        //Kategori
        return view('welcome_message');
    }

    public function berita()
    {
        //Kategori
        return view('welcome_message');
    }

    public function tentang()
    {
        //Tentang
        return view('welcome_message');
    }
}
