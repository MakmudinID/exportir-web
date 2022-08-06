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
        $data['umkm'] = $this->server_side->getUMKM(); 
        $data['berita'] = $this->server_side->getBerita(); 
		$data['kategori']   = $this->server_side->getKategoriUMKM(); 
		echo view('template/fruitkha', $data);
    }
    
    public function kategori()
    {
        //Kategori
        return view('welcome_message');
    }

    public function list_produk(){
        $data['js'] = array("user-list-produk.js?r=".uniqid());
		$data['main_content']   = 'frontend/list-produk'; 
		// $data['produk']   = $this->server_side->getProdukRand();
        $data['umkm'] = $this->server_side->getUMKM();
        $data['kategori_produk'] = $this->server_side->getKategoriProduk();
		echo view('template/fruitkha', $data);
    }

    public function list_produk_(){
        $umkm = $this->request->getPost('umkm');
        $kategori = $this->request->getPost('kategori');
        $produk = $this->server_side->getProduk($umkm, $kategori);
        $html = '';
        foreach($produk as $p){
            $html .= '<div class="col-lg-4 col-md-4 col-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="'.base_url('/produk/1').'"><img src="'.$p->foto.'" alt="'.$p->nama.'"></a>
                </div>
                <h3 >'. $p->nama.'</h3>
                <p class="product-price"><span>Per '. $p->satuan.'</span> Rp. '. number_format($p->harga).' </p>
                <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            </div>
        </div>';
        }

        echo $html;
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
