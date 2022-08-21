<?php

namespace App\Controllers;

class Frontend extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function index()
    {
        //Home
        // $data['js'] = array("home.js?r=".uniqid());
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
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="'.base_url('/produk/'.$p->id).'"><img src="'.$p->foto.'" alt="'.$p->nama.'"></a>
                </div>
                <h3 >'. $p->nama.'</h3>
                <p class="product-price"><span>'. $p->satuan.'</span> Rp. '. number_format($p->harga).' </p>
                <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            </div>
        </div>';
        }

        echo $html;
    }

    public function produk($id=NULL)
    {
        //Berita
        $data['produk'] = $this->server_side->getProdukById($id);
        $data['produk_related'] = $this->server_side->getProdukRelated($data['produk']->id_kategori);
        // var_dump($data);die;
        $data['js'] = array("produk.js?r=".uniqid());
		$data['main_content']   = 'frontend/produk'; 
		echo view('template/fruitkha', $data);
    }

    public function berita($id)
    {
        //Berita
        $data['berita']   = $this->server_side->getBeritaByid($id); 
        $data['berita_random'] = $this->server_side->getBeritaRandom();
        // var_dump($data); die;
        // $data['js'] = array("home.js?r=".uniqid());
		$data['main_content']   = 'frontend/berita'; 
		echo view('template/fruitkha', $data);
    }

    public function list_berita(){
        $data['js'] = array("user-list-berita.js?r=".uniqid());
		$data['main_content']   = 'frontend/list-berita'; 
		// $data['produk']   = $this->server_side->getProdukRand();
        $data['kategori_berita'] = $this->server_side->getKategoriBerita();
		echo view('template/fruitkha', $data);
    }

    public function list_berita_(){
        $kategori = $this->request->getPost('kategori');
        $berita = $this->server_side->getListBerita($kategori);
        $html = '';
        foreach($berita as $b){
            $html .= '<div class="col-lg-4 col-md-6">
                        <div class="single-latest-news">
                            <a href="'.base_url('/berita/'.$b->id).'"><img src="'.$b->foto.'" alt="'. $b->judul.'" style="float: left;width:100%;height:200px;object-fit: cover; padding-bottom: 20px;"></a>
                            <div class="news-text-box">
                                <h3><a href="'.base_url('/berita/'.$b->id).'" class="text-dark">'. $b->judul.'</a></h3>
                                <p class="blog-meta">
                                    <span class="author"><i class="fas fa-user"></i> '. $b->penulis.'</span>
                                    <span class="date"><i class="fas fa-calendar"></i> '. $b->create_date.'</span>
                                </p>
                                <p class="excerpt">'. html_entity_decode($b->ringkasan).'</p>
                                <a href="'.base_url('/berita/'.$b->id).'" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>';
        }

        echo $html;
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
