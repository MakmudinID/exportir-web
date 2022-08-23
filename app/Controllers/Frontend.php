<?php

namespace App\Controllers;

class Frontend extends BaseController
{
    private $url = "https://api.rajaongkir.com/starter/";
    private $apiKey = "2a304d172f3b55cb66741ce72a3a6eb9";

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function wilayah($method, $id_province=null)
	{
		// var_dump($method, $id_province);
        // die;
		$endPoint = $this->url.$method;

		if($id_province!=null)
		{
			$endPoint = $endPoint."?province=".$id_province;
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $endPoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: ".$this->apiKey
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $response;
	}

    public function kurir()
	{
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination'); 
        $weight= $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');
        
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=".$courier,
		  CURLOPT_HTTPHEADER => array(
		    "content-type: application/x-www-form-urlencoded",
		    "key: ".$this->apiKey,
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		return $response;
	}

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
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="'.base_url('/produk/'.$p->id).'"><img src="'.$p->foto.'" alt="'.$p->nama.'"></a>
                </div>
                <h3 >'. $p->nama.'</h3>
                <p class="product-price"><span>Per '. $p->satuan.'</span> Rp. '. number_format($p->harga).' </p>
                <a href="#" data-id="'.$p->id.'" data-img="'.$p->foto.'" data-produk="'.$p->nama.'" data-qty="1" data-harga="'.$p->harga.'" data-umkm="'.$p->id_umkm.'" class="cart-btn add-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
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
        $cart = \Config\Services::cart();
        $data['cart'] = $cart->contents();
        $data['js'] = array("cart.js?r=".uniqid());
		$data['main_content']   = 'frontend/keranjang'; 
		echo view('template/fruitkha', $data);
    }

    public function add_cart(){
        if (session()->get('role') != 'RESELLER') {
            $r['result'] = false;
            echo json_encode($r);
            return;
        }
        $cart = \Config\Services::cart();
        $id = $this->request->getPost('id');
        $id_umkm = $this->request->getPost('id_umkm');
        $img = $this->request->getPost('img');
        $produk = $this->request->getPost('produk');
        $harga = $this->request->getPost('harga');
        $qty = $this->request->getPost('qty');

        $data = array(
            'id' => ($id != '') ? $id : null,
            'id_umkm' => ($id_umkm != '') ? $id_umkm : null,
            'img' => ($img != '') ? $img : null,
            'name' => ($produk != '') ? $produk : null,
            'price' => ($harga != '') ? $harga : null,
            'qty' => ($qty != '') ? $qty : null,
        );

        // var_dump($cart);
        // die;
		$cart->insert($data);
        $datas['total'] =  count($cart->contents());
        $datas['result'] = true;
        echo json_encode($datas);
    }

    function count_cart(){
        $cart = \Config\Services::cart();
        $total =  count($cart->contents());
        echo json_encode($total);
    }

    function cart_(){
        $cart = \Config\Services::cart();
        $data_cart = $cart->contents();
        $data = [];
        foreach($data_cart as $val){
            $row = [];
            $row['close'] = '<a href="#"><i class="far fa-window-close remove" data-id="'.$val['rowid'].'">';
            $row['photo'] = '<img src="'.$val['img'].'" alt="">';
            $row['produk'] = $val['name'];
            $row['harga'] = $val['price'];
            $row['qty'] = '<input type="number" value="'.$val['qty'].'" name="qty" id="qty" data-rowid="'.$val['rowid'].'">';
            $row['total'] = $val['subtotal'];
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => count($cart->contents()),
            "recordsFiltered" => count($cart->contents()),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function update_qty(){
        $cart = \Config\Services::cart();
		$row_id = $this->request->getPost('rowId');
		$qty = $this->request->getPost('qty');

        $data = array(
            'rowid' => $row_id,
            'qty' => $qty
        );

        $cart->update($data);
        echo 'berhasil';
    }

    public function remove_cart(){
        $cart = \Config\Services::cart();
		$row_id = $this->request->getPost('id');
		$cart->remove($row_id);
        $datas['total'] =  count($cart->contents());
        echo json_encode($datas);
    }

    public function checkout(){
        $cart = \Config\Services::cart();
        $propins = json_decode($this->wilayah('province'));
        $carts = $cart->contents();
        $id_umkm = $carts[array_key_first($carts)]['id_umkm'];
        $kota = $this->db->query("select * from tbl_umkm where id = $id_umkm")->getRow();

        $data['kota_asal'] = $kota->city_id;
        $data['cart'] = $carts;
        $data['propinsi'] = $propins->rajaongkir->results;
        $data['js'] = array("checkout.js?r=".uniqid());
		$data['main_content']   = 'frontend/checkout'; 
		echo view('template/fruitkha', $data);
    }
}
