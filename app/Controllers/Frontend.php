<?php

namespace App\Controllers;

use Hashids\Hashids;

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

    public function wilayah($method, $id_province = null)
    {
        // var_dump($method, $id_province);
        // die;
        $endPoint = $this->url . $method;

        if ($id_province != null) {
            $endPoint = $endPoint . "?province=" . $id_province;
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
                "key: " . $this->apiKey
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
        $weight = $this->request->getPost('weight');
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
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $destination . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . $this->apiKey,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        return $response;
    }

    public function index()
    {
        //Home
        $data['main_content']   = 'frontend/home';
        $data['produk']   = $this->server_side->getProdukRand();
        $data['umkm'] = $this->server_side->getUMKM();

        $data['berita'] = $this->server_side->getBerita();
        $data['kategori']   = $this->server_side->getKategoriUMKM();
        echo view('template/fruitkha', $data);
    }

    public function kategori($id_kategori_umkm)
    {
        //Kategori
        $data['main_content']   = 'frontend/kategori-produk-umkm';
        $data['kategori'] = $this->db->query("select nama from tbl_kategori_umkm where id=?", array($id_kategori_umkm))->getRow();
        $data['produk_umkm'] = $this->server_side->getProdukByKategoriUMKM($id_kategori_umkm);
        if (count($data['produk_umkm']) > 0) {
            echo view('template/fruitkha', $data);
        } else {
            return redirect()->to('/');
        }
    }

    public function list_produk()
    {
        $data['js'] = array("user-list-produk.js?r=" . uniqid());
        $data['main_content']   = 'frontend/list-produk';
        // $data['produk']   = $this->server_side->getProdukRand();
        $data['umkm'] = $this->server_side->getUMKM();
        $data['kategori_produk'] = $this->server_side->getKategoriProduk();
        echo view('template/fruitkha', $data);
    }

    public function list_produk_()
    {
        $umkm = $this->request->getPost('umkm');
        $kategori = $this->request->getPost('kategori');
        $produk = $this->server_side->getProduk($umkm, $kategori);
        $html = '';

        foreach ($produk as $p) {
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="' . base_url('/produk/' . $p->id) . '"><img src="' . $p->foto . '" alt="' . $p->nama . '"></a>
                </div>
                <h3 >' . $p->nama . '</h3>
                <p class="product-price">Rp. ' . number_format($p->harga) . ' </p>
                <a href="#" data-id="' . $p->id . '" data-img="' . $p->foto . '" data-produk="' . $p->nama . '" data-qty="1" data-harga="' . $p->harga . '" data-weight="' . $p->weight . '" data-umkm="' . $p->id_umkm . '" class="cart-btn add-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
                <hr>
                <span><b><a href="' . base_url('profil-umkm/' . $p->slug) . '">' . $p->nama_toko . '</a></b></span><br>
                <span><i class="fas fa-city mr-1"></i>' . $p->city_name . '</span>
        </div>
        </div>';
        }

        if (empty($produk)) {
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
                        <div class="card">
                            <div class="card-body">
                            <p class="text-danger">Produk tidak ditemukan</p>
                            </div>
                        </div>
                    </div>';
        }
        echo $html;
    }

    public function produk($id = NULL)
    {
        //Berita
        $data['produk'] = $this->server_side->getProdukById($id);
        $data['produk_related'] = $this->server_side->getProdukRelated($data['produk']->id_kategori);
        // var_dump($data);die;
        $data['js'] = array("produk.js?r=" . uniqid());
        $data['main_content']   = 'frontend/produk';
        echo view('template/fruitkha', $data);
    }

    public function kerjasama($slug = NULL)
    {
        $this->auth->is_login();
        if ($slug == null) {
            redirect('/');
        }
        $data['umkm'] = $this->server_side->getUMKMbySlug($slug);
        $data['produk'] = $this->server_side->getProdukByUMKM($slug);
        $data['js'] = array("form-kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'frontend/form-kerjasama';
        echo view('template/fruitkha', $data);
    }

    public function umkm($slug = NULL)
    {
        if ($slug == null) {
            redirect('/');
        }
        $data['umkm'] = $this->server_side->getUMKMbySlug($slug);
        $data['produk'] = $this->server_side->getProdukByUMKM($slug);
        $data['produk_kategori'] = $this->server_side->getKategoriByUMKM($slug);
        $data['js'] = array("umkm.js?r=" . uniqid());
        $data['main_content']   = 'frontend/umkm';
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

    public function list_berita()
    {
        $data['js'] = array("user-list-berita.js?r=" . uniqid());
        $data['main_content']   = 'frontend/list-berita';
        // $data['produk']   = $this->server_side->getProdukRand();
        $data['kategori_berita'] = $this->server_side->getKategoriBerita();
        echo view('template/fruitkha', $data);
    }

    public function list_berita_()
    {
        $kategori = $this->request->getPost('kategori');
        $berita = $this->server_side->getListBerita($kategori);
        $html = '';
        foreach ($berita as $b) {
            $html .= '<div class="col-lg-4 col-md-6">
                        <div class="single-latest-news">
                            <a href="' . base_url('/berita/' . $b->id) . '"><img src="' . $b->foto . '" alt="' . $b->judul . '" style="float: left;width:100%;height:200px;object-fit: cover; padding-bottom: 20px;"></a>
                            <div class="news-text-box">
                                <h3><a href="' . base_url('/berita/' . $b->id) . '" class="text-dark">' . $b->judul . '</a></h3>
                                <p class="blog-meta">
                                    <span class="author"><i class="fas fa-user"></i> ' . $b->penulis . '</span>
                                    <span class="date"><i class="fas fa-calendar"></i> ' . $b->create_date . '</span>
                                </p>
                                <p class="excerpt">' . html_entity_decode($b->ringkasan) . '</p>
                                <a href="' . base_url('/berita/' . $b->id) . '" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
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
        $data['js'] = array("home.js?r=" . uniqid());
        $data['main_content']   = 'frontend/tentang';
        echo view('template/fruitkha', $data);
    }

    public function keranjang()
    {
        $data['transaksi'] = $this->server_side->transaksi();
        $data['js'] = array("cart.js?r=" . uniqid());
        $data['main_content']   = 'frontend/keranjang';
        echo view('template/fruitkha', $data);
    }

    public function add_cart()
    {
        if (session()->get('role') != 'RESELLER') {
            $r['result'] = false;
            echo json_encode($r);
            return;
        }

        //Check transaksi di keranjang
        $id_umkm = $this->request->getPost('id_umkm');
        $transaksi = $this->db->table('tbl_transaksi')->getWhere(['status' => 'CART', 'id_umkm' => $id_umkm]);

        if ($transaksi->getNumRows() > 0) {
            //tambah detail produk 
            $id_transaksi = $transaksi->getRow()->id;

            //Check id_produk 
            $check_detail = $this->db->table('tbl_transaksi_detail')->getWhere(['id_transaksi' => $id_transaksi, 'id_barang' => $this->request->getPost('id')]);
            if($check_detail->getNumRows() > 0){
                //update
                $id = $check_detail->getRow()->id;

                $tbl_transaksi_detail['qty'] = $check_detail->getRow()->qty + $this->request->getPost('qty');
                $tbl_transaksi_detail['harga'] = $this->request->getPost('harga');
                $tbl_transaksi_detail['subtotal'] = $check_detail->getRow()->subtotal * ($check_detail->getRow()->qty + $this->request->getPost('qty'));
                $tbl_transaksi_detail['weight'] = $check_detail->getRow()->weight * ($check_detail->getRow()->qty + $this->request->getPost('qty'));

                $result = $this->server_side->updateRows($id, $tbl_transaksi_detail, 'tbl_transaksi_detail');
                
                if($result){
                    $r['result'] = true;
                    $r['total'] =  $this->server_side->count_cart();
                    echo json_encode($r);
                }else{
                    $r['result'] = false;
                    $r['total'] =  $this->server_side->count_cart();
                    echo json_encode($r);
                }
            }else{
                $tbl_transaksi_detail['id_transaksi'] = $id_transaksi;
                $tbl_transaksi_detail['id_barang'] = $this->request->getPost('id');
                $tbl_transaksi_detail['qty'] = $this->request->getPost('qty');
                $tbl_transaksi_detail['harga'] = $this->request->getPost('harga');
                $tbl_transaksi_detail['subtotal'] = $this->request->getPost('harga') * $this->request->getPost('qty');
                $tbl_transaksi_detail['weight'] = $this->request->getPost('weight') * $this->request->getPost('qty');
                
                $result = $this->server_side->createRows($tbl_transaksi_detail, 'tbl_transaksi_detail');

                if($result){
                    $r['result'] = true;
                    $r['total'] = $this->server_side->count_cart();
                    echo json_encode($r);
                }else{
                    $r['result'] = false;
                    $r['total'] = $this->server_side->count_cart();
                    echo json_encode($r);
                }
            }
        } else {
            //tambah transaksi + detail produk
            $this->server_side->db->transBegin();
            try {
                $hashids = new Hashids('', 8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                $milis = time() + (60 * 60 * 4);
                $convert = $hashids->encode($milis);
                $kode = substr($convert, 0, 8);

                $tbl_transaksi['kode_transaksi'] = 'TR' . date('ymd') . '-' . $kode;
                $tbl_transaksi['id_pengguna'] = session()->get('id');
                $tbl_transaksi['id_umkm'] = $this->request->getPost('id_umkm');
                $tbl_transaksi['status'] = "CART";

                $id_transaksi = $this->server_side->createRowsReturnID($tbl_transaksi, 'tbl_transaksi');

                $tbl_transaksi_detail['id_transaksi'] = $id_transaksi;
                $tbl_transaksi_detail['id_barang'] = $this->request->getPost('id');
                $tbl_transaksi_detail['qty'] = $this->request->getPost('qty');
                $tbl_transaksi_detail['harga'] = $this->request->getPost('harga');
                $tbl_transaksi_detail['subtotal'] = $this->request->getPost('harga') * $this->request->getPost('qty');
                $tbl_transaksi_detail['weight'] = $this->request->getPost('weight') * $this->request->getPost('qty');

                $result = $this->server_side->createRows($tbl_transaksi_detail, 'tbl_transaksi_detail');
                $this->server_side->db->transCommit();
                
                if($result){
                    $r['result'] = true;
                    $r['total'] =  $this->db->table('tbl_transaksi')->getWhere(['status' => 'CART', 'id_pengguna' => session()->get('id')])->getNumRows();
                    echo json_encode($r);
                }else{
                    $r['result'] = false;
                    $r['total'] =  $this->db->table('tbl_transaksi')->getWhere(['status' => 'CART', 'id_pengguna' => session()->get('id')])->getNumRows();
                    echo json_encode($r);
                }
            } catch (\Exception $e) {
                $this->server_side->db->transRollback();
                $r['result'] = false;
                $r['total'] =  $this->db->table('tbl_transaksi')->getWhere(['status' => 'CART', 'id_pengguna' => session()->get('id')])->getNumRows();
                echo json_encode($r);
            }
        }
    }

    function count_cart()
    {
        echo $this->server_side->count_cart();
    }

    function cart_()
    {
        $cart = \Config\Services::cart();
        $data_cart = $cart->contents();
        $data = [];
        foreach ($data_cart as $val) {
            $row = [];
            $row['close'] = '<a href="#"><i class="fas fa-trash-alt text-danger remove" data-id="' . $val['rowid'] . '">';
            $row['photo'] = '<img src="' . $val['img'] . '" alt="">';
            $row['produk'] = $val['name'];
            $row['harga'] = $val['price'];
            $row['qty'] = '<input type="number" value="' . $val['qty'] . '" name="qty" min="1" id="qty" data-rowid="' . $val['rowid'] . '">';
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

    public function update_qty()
    {
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

    public function remove_cart()
    {
        $cart = \Config\Services::cart();
        $row_id = $this->request->getPost('id');
        $cart->remove($row_id);
        $datas['total'] =  count($cart->contents());
        echo json_encode($datas);
    }

    public function checkout()
    {
        $cart = \Config\Services::cart();
        $propins = json_decode($this->wilayah('province'));
        $carts = $cart->contents();
        // var_dump($carts);die;
        $id_umkm = $carts[array_key_first($carts)]['id_umkm'];

        $kota = $this->db->query("select * from tbl_umkm where id = $id_umkm")->getRow();
        $data['reseller'] = $this->db->query("select * from tbl_pengguna where id =?", session()->get('id'))->getRow();
        $data['total_weight'] = array_sum(array_column($carts, 'weight'));
        $data['id_umkm'] = $id_umkm;
        $data['kota_asal'] = $kota->city_id;
        $data['cart'] = $carts;
        $data['propinsi'] = $propins->rajaongkir->results;
        $data['js'] = array("checkout.js?r=" . uniqid());
        $data['main_content']   = 'frontend/checkout';
        // var_dump($data);die;
        echo view('template/fruitkha', $data);
    }

    public function transaksi()
    {
        $cart = \Config\Services::cart();

        $hashids = new Hashids('', 8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $milis = time() + (60 * 60 * 4);
        $convert = $hashids->encode($milis);
        $kode = substr($convert, 0, 8);

        $pembayaran['total_tagihan'] = $this->request->getPost('jumlah');
        $pembayaran['status'] = 'BELUM';
        $pembayaran['create_user'] = session()->get('nama');

        $this->server_side->db->transBegin();
        try {
            $id_pembayaran = $this->server_side->createRowsReturnID($pembayaran, 'tbl_transaksi_pembayaran');

            $tbl_transaksi['id_pembayaran'] = $id_pembayaran;
            $tbl_transaksi['kode_transaksi'] = 'TR' . date('ymd') . '-' . $kode;
            $tbl_transaksi['id_pengguna'] = session()->get('id');
            $tbl_transaksi['id_umkm'] = $this->request->getPost('id_umkm');
            $tbl_transaksi['nama'] = $this->request->getPost('nama');
            $tbl_transaksi['email'] = $this->request->getPost('email');
            $tbl_transaksi['alamat'] = $this->request->getPost('alamat');
            $tbl_transaksi['nohp'] = $this->request->getPost('nohp');
            $tbl_transaksi['keterangan'] = $this->request->getPost('keterangan');
            $tbl_transaksi['kurir'] = $this->request->getPost('kurir');
            $tbl_transaksi['service'] = $this->request->getPost('service');
            $tbl_transaksi['ongkir'] = $this->request->getPost('ongkir');
            $tbl_transaksi['status'] = "BELUM";
            $tbl_transaksi['jumlah'] = $this->request->getPost('jumlah');

            $id_transaksi = $this->server_side->createRowsReturnID($tbl_transaksi, 'tbl_transaksi');
            // var_dump($id_transaksi);die;
            $data_cart = $cart->contents();
            foreach ($data_cart as $val) {
                $tbl_transaksi_detail['id_transaksi'] = $id_transaksi;
                $tbl_transaksi_detail['id_barang'] = $val['id'];
                $tbl_transaksi_detail['qty'] = $val['qty'];
                $tbl_transaksi_detail['harga'] = $val['price'];
                $tbl_transaksi_detail['subtotal'] = $val['subtotal'];
                $tbl_transaksi_detail['weight'] = $val['weight'];

                $this->server_side->createRows($tbl_transaksi_detail, 'tbl_transaksi_detail');
                $cart->remove($val['rowid']);
            }
            $this->server_side->db->transCommit();
            $r['result'] = true;
            $r['total'] =  count($cart->contents());
        } catch (\Exception $e) {
            $this->server_side->db->transRollback();
            $r['result'] = false;
            $r['total'] =  count($cart->contents());
        }

        echo json_encode($r);
        return;
    }
}
