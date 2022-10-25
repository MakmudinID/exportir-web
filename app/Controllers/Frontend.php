<?php

namespace App\Controllers;

use Hashids\Hashids;

class Frontend extends BaseController
{
    private $url = "https://api.rajaongkir.com/starter/";
    // private $apiKey = "2a304d172f3b55cb66741ce72a3a6eb9";
    private $apiKey = "402f8932f6311186b7ce7e6211ac2b66";

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function get_kota($id_prov)
    {
        $kota = $this->server_side->getKota($id_prov);
        echo "- Pilih Kota -";
        foreach ($kota as $k) {
            echo "<option value='$k->city_id'>$k->city_name</option>";
        }
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

    public function index()
    {
        //Home
        $data['main_content']   = 'frontend/home';
        $data['produk']   = $this->server_side->getProdukRand();
        $data['umkm'] = $this->server_side->getUMKM();
        $data['title'] = 'Home';
        $data['berita'] = $this->server_side->getBerita();
        $data['kategori']   = $this->server_side->getKategoriUMKM();
        echo view('template/fruitkha', $data);
    }

    public function kategori($id_kategori_umkm)
    {
        //Kategori
        $data['title'] = 'Kategori';
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
        $data['title'] = 'Produk';
        $data['umkm'] = $this->server_side->getUMKM();
        $data['kategori_produk'] = $this->server_side->getKategoriProduk();
        echo view('template/fruitkha', $data);
    }

    public function list_produk_by_umkm()
    {
        $umkm = $this->request->getPost('umkm');
        $kategori = $this->request->getPost('kategori');
        $keyword = $this->request->getPost('keyword');

        $produk = $this->server_side->getProdukByUMKMfilter($umkm, $kategori, $keyword);
        $html = '';

        foreach ($produk as $p) {
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="' . base_url('/produk/' . $p->id) . '"><img src="' . $p->foto . '" alt="' . $p->nama . '"></a>
                </div>
                <label style="font-size:17px"><a href="' . base_url('/produk/' . $p->id) . '"><b>' . $p->nama . '</b></a></label>
                <p class="product-price">Rp ' . number_format($p->harga, 0, ',', '.') . ' </p>
                <a href="#" data-id="' . $p->id . '" data-img="' . $p->foto . '" data-produk="' . $p->nama . '" data-qty="1" data-harga="' . $p->harga . '" data-weight="' . $p->weight . '" data-umkm="' . $p->id_umkm . '" class="cart-btn add-cart"><i class="fas fa-shopping-cart btn-sm"></i> Masukkan Keranjang</a>
                <hr>
                <span><b><a href="' . base_url('profil-umkm/' . $p->slug) . '">' . $p->nama_toko . '</a></b></span><br>
                <span><i class="fas fa-city mr-1"></i>' . $p->city_name . '</span>
        </div>
        </div>';
        }

        if (empty($produk)) {
            $html .= '<div class="col-lg-12 col-md-12 abt-textcol-6 text-center">
                        <div class="card">
                            <div class="card-body">
                            <p class="text-danger"><b>Produk tidak ditemukan</b></p>
                            </div>
                        </div>
                    </div>';
        }
        echo $html;
    }

    public function list_produk_()
    {
        $kategori = $this->request->getPost('kategori');
        $produk = $this->server_side->getProduk($kategori);
        $html = '';

        foreach ($produk as $p) {
            $html .= '<div class="col-lg-3 col-md-3 abt-textcol-6 text-center">
            <div class="single-product-item">
                <div class="product-image">
                    <a href="' . base_url('/produk/' . $p->id) . '"><img src="' . $p->foto . '" alt="' . $p->nama . '"></a>
                </div>
                <h3 >' . $p->nama . '</h3>
                <p class="product-price">Rp. ' . number_format($p->harga) . ' </p>
                <a href="#" data-id="' . $p->id . '" data-img="' . $p->foto . '" data-produk="' . $p->nama . '" data-qty="1" data-harga="' . $p->harga . '" data-weight="' . $p->weight . '" data-umkm="' . $p->id_umkm . '" class="cart-btn add-cart btn-sm"><i class="fas fa-shopping-cart"></i> Masukkan Keranjang</a>
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
        $data['title'] = 'Produk';
        $data['js'] = array("produk.js?r=" . uniqid());
        $data['main_content']   = 'frontend/produk';
        echo view('template/fruitkha', $data);
    }


    public function kerjasama()
    {
        $this->auth->is_login();
        $data['title'] = 'Kerja Sama';
        $data['js'] = array("kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'frontend/kerjasama';
        echo view('template/fruitkha', $data);
    }

    public function kerjasama_umkm($slug = NULL)
    {
        $this->auth->is_login();
        if ($slug == null) {
            return redirect()->to('/');
        }
        $data['kode_transaksi'] = $slug;
        $data['title'] = 'Kerja Sama';
        $data['umkm'] = $this->server_side->getUMKMbyKodeTransaksi($slug);
        $data['transaksi'] = $this->server_side->transaksi_in_kode($slug);
        $data['js'] = array("user-kerjasama.js?r=" . uniqid());
        $data['main_content']   = 'frontend/form-kerjasama';
        echo view('template/fruitkha', $data);
    }

    public function kerjasama_pengajuan()
    {
        $total_tagihan = $this->request->getPost('total_tagihan');
        $kode_transaksi = $this->request->getPost('kode_transaksi');

        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $no_kerjasama = 'KJS' . date('ymd') . '-' . substr(str_shuffle($str), 0, 8);
        $this->server_side->db->transBegin();

        $tbl_transaksi_kerjasama['no_kerjasama'] = $no_kerjasama;
        $tbl_transaksi_kerjasama['lama_kerjasama'] = $this->request->getPost('kontrak');
        $tbl_transaksi_kerjasama['no_telepon'] = $this->request->getPost('no_telp');
        $tbl_transaksi_kerjasama['jumlah_produk'] = $this->server_side->count_cart_by($kode_transaksi);
        $tbl_transaksi_kerjasama['nama'] = $this->request->getPost('nama');
        $tbl_transaksi_kerjasama['alamat'] = $this->request->getPost('alamat');
        $tbl_transaksi_kerjasama['email'] = $this->request->getPost('email');
        $tbl_transaksi_kerjasama['no_ktp'] = $this->request->getPost('nik');
        $tbl_transaksi_kerjasama['status'] = 'BELUM_UPLOAD';

        $id_kerjasama = $this->server_side->createRows($tbl_transaksi_kerjasama, 'tbl_transaksi_kerjasama');
        if (!$id_kerjasama) {
            echo 'error create transaksi kerjasama<br>';
            $this->server_side->db->transRollback();
            die;
        }

        for ($i = 1; $i <= $this->request->getPost('kontrak'); $i++) {
            $kode_bayar = 'INV' . date('ymd') . '-' . substr(str_shuffle($str), 0, 8) . '' . $i;

            $tbl_transaksi_pembayaran['id_pengguna'] = session()->get('id');
            $tbl_transaksi_pembayaran['no_kerjasama'] = $no_kerjasama;
            $tbl_transaksi_pembayaran['bayar_bulan_ke'] = $i;
            $tbl_transaksi_pembayaran['kode_bayar'] = $kode_bayar;
            $tbl_transaksi_pembayaran['total_tagihan'] = $total_tagihan;

            $datetime_now = date('Y-m-d H:i:s');
            $date_now = date('Y-m-d');

            if ($i == 1) {
                $tbl_transaksi_pembayaran['create_date'] = $datetime_now;
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 2 days'));
            } else if ($i == 2) {
                $tbl_transaksi_pembayaran['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 1 month'));
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($tbl_transaksi_pembayaran['create_date'] . ' + 2 days'));
            } else if ($i == 3) {
                $tbl_transaksi_pembayaran['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 2 month'));
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($tbl_transaksi_pembayaran['create_date'] . ' + 2 days'));
            } else if ($i == 4) {
                $tbl_transaksi_pembayaran['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 3 month'));
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($tbl_transaksi_pembayaran['create_date'] . ' + 2 days'));
            } else if ($i == 5) {
                $tbl_transaksi_pembayaran['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 4 month'));
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($tbl_transaksi_pembayaran['create_date'] . ' + 2 days'));
            } else if ($i == 6) {
                $tbl_transaksi_pembayaran['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 5 month'));
                $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($tbl_transaksi_pembayaran['create_date'] . ' + 2 days'));
            }

            $tbl_transaksi_pembayaran['status'] = 'BELUM_DIBAYAR';
            $tbl_transaksi_pembayaran['create_user'] = session()->get('nama');

            $id_pembayaran = $this->server_side->createRowsReturnID($tbl_transaksi_pembayaran, 'tbl_transaksi_pembayaran');
            if (!$id_pembayaran) {
                echo 'error create transaksi pembayaran<br>';
                $this->server_side->db->transRollback();
                die;
            } else {
                if ($i == 1) {
                    if ($i == 1) {
                        $tbl_transaksi['create_date'] = $datetime_now;
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_now . ' + 3 days'));
                    } else if ($i == 2) {
                        $tbl_transaksi['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 1 month'));
                        $date_ = date('Y-m-d', strtotime($date_now . ' + 1 month'));
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_. ' + 3 days'));
                    } else if ($i == 3) {
                        $tbl_transaksi['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 2 month'));
                        $date_ = date('Y-m-d', strtotime($date_now . ' + 2 month'));
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_ . ' + 3 days'));
                    } else if ($i == 4) {
                        $tbl_transaksi['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 3 month'));
                        $date_ = date('Y-m-d', strtotime($date_now . ' + 3 month'));
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_ . ' + 3 days'));
                    } else if ($i == 5) {
                        $tbl_transaksi['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 4 month'));
                        $date_ = date('Y-m-d', strtotime($date_now . ' + 4 month'));
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_ . ' + 3 days'));
                    } else if ($i == 6) {
                        $tbl_transaksi['create_date'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 5 month'));
                        $date_ = date('Y-m-d', strtotime($date_now . ' + 5 month'));
                        $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($date_ . ' + 3 days'));
                    }

                    $tbl_transaksi['id_pembayaran'] = $id_pembayaran;
                    $tbl_transaksi['status'] = 'BELUM_DIBAYAR';
                    $tbl_transaksi['kerjasama'] = 'Y';
                    $this->server_side->updateRowsByField('kode_transaksi', $kode_transaksi, $tbl_transaksi, 'tbl_transaksi');

                    //update transaksi_detail
                    $id_transaksi = $this->db->table('tbl_transaksi')->getWhere(['kode_transaksi' => $kode_transaksi])->getRow()->id;
                    $data_detail = $this->db->table('tbl_transaksi_detail')->getWhere(['id_transaksi' => $id_transaksi])->getResult();

                    foreach ($data_detail as $d) {
                        $produk = $this->db->table('tbl_produk_umkm')->getWhere(['id' => $d->id_barang])->getRow();
                        if ($d->qty <= 10) {
                            $tbl_transaksi_detail['qty'] = 10;
                            $tbl_transaksi_detail['weight'] = $produk->weight * 10;
                            $tbl_transaksi_detail['harga'] = $produk->harga_min;
                            $tbl_transaksi_detail['subtotal'] = $produk->harga_min * 10;
                            $this->server_side->updateRows($d->id, $tbl_transaksi_detail, 'tbl_transaksi_detail');
                        } else {
                            $tbl_transaksi_detail['qty'] = $d->qty;
                            $tbl_transaksi_detail['weight'] = $produk->weight * $d->qty;
                            $tbl_transaksi_detail['harga'] = $produk->harga_min;
                            $tbl_transaksi_detail['subtotal'] = $produk->harga_min * $d->qty;
                            $this->server_side->updateRows($d->id, $tbl_transaksi_detail, 'tbl_transaksi_detail');
                        }
                    }
                } else {
                    $data = $this->db->table('tbl_transaksi')->getWhere(['kode_transaksi' => $kode_transaksi])->getRow();

                    $id_transaksi_ = $data->id;
                    $tbl_transaksi['id_pembayaran'] = $id_pembayaran;
                    $tbl_transaksi['kode_transaksi'] = $kode_transaksi;
                    $tbl_transaksi['id_pengguna'] = $data->id_pengguna;
                    $tbl_transaksi['id_umkm'] = $data->id_umkm;
                    $tbl_transaksi['jumlah'] = $data->jumlah;
                    $tbl_transaksi['ongkir'] = $data->ongkir;
                    $tbl_transaksi['nama'] = $data->nama;
                    $tbl_transaksi['email'] = $data->email;
                    $tbl_transaksi['nohp'] = $data->nohp;
                    $tbl_transaksi['alamat'] = $data->alamat;
                    $tbl_transaksi['province_id'] = $data->province_id;
                    $tbl_transaksi['city_id'] = $data->city_id;
                    $tbl_transaksi['kurir'] = $data->kurir;
                    $tbl_transaksi['service'] = $data->service;
                    $tbl_transaksi['catatan_beli'] = $data->catatan_beli;
                    $tbl_transaksi['tanggal_kirim'] = date('Y-m-d', strtotime($data->tanggal_kirim . ' + 1 month'));
                    $id_transaksi = $this->server_side->createRowsReturnID($tbl_transaksi, 'tbl_transaksi');

                    $data_detail = $this->db->table('tbl_transaksi_detail')->getWhere(['id_transaksi' => $id_transaksi_])->getResult();
                    foreach ($data_detail as $d) {
                        $tbl_transaksi_detail['id_transaksi'] = $id_transaksi;
                        $tbl_transaksi_detail['id_barang'] = $d->id_barang;
                        $tbl_transaksi_detail['qty'] = $d->qty;
                        $tbl_transaksi_detail['weight'] = $d->weight;
                        $tbl_transaksi_detail['harga'] = $d->harga;
                        $tbl_transaksi_detail['subtotal'] = $d->harga;

                        $result = $this->server_side->createRows($tbl_transaksi_detail, 'tbl_transaksi_detail');
                        if (!$result) {
                            $this->server_side->db->transRollback();
                            echo 'gagal';
                            die;
                        }
                    }
                }
            }
        }

        if ($this->server_side->db->transStatus() === false) {
            $this->server_side->db->transRollback();
            echo 'gagal';
            die;
        } else {
            $this->server_side->db->transCommit();
            return redirect()->to('/notifikasi-kerjasama/' . $no_kerjasama);
        }
    }

    public function umkm($slug = NULL)
    {
        if ($slug == null) {
            return redirect()->to('/');
        }
        $data['title'] = 'Kerja Sama';
        $data['kode_transaksi'] = $this->server_side->getKodeTransaksibySlug($slug);
        $data['url'] = base_url('kerjasama/umkm/' . $data['kode_transaksi']);
        if (!$data['kode_transaksi']) {
            $data['url'] = base_url('kerjasama');
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
        $data['title'] = 'Berita';
        $data['berita']   = $this->server_side->getBeritaByid($id);
        $data['berita_random'] = $this->server_side->getBeritaRandom();
        // var_dump($data); die;
        // $data['js'] = array("home.js?r=".uniqid());
        $data['main_content']   = 'frontend/berita';
        echo view('template/fruitkha', $data);
    }

    public function list_berita()
    {
        $data['title'] = 'Berita';
        $data['js'] = array("user-list-berita.js?r=" . uniqid());
        $data['main_content']   = 'frontend/list-berita';
        // $data['produk']   = $this->server_side->getProdukRand();
        $data['kategori_berita'] = $this->server_side->getKategoriBerita();
        echo view('template/fruitkha', $data);
    }

    public function list_berita_()
    {
        $keyword = $this->request->getPost('keyword');
        $kategori = $this->request->getPost('kategori');
        $berita = $this->server_side->getListBerita($kategori, $keyword);
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

        if (!empty($berita)) {
            echo $html;
        } else {
            $html .= '<div class="col-lg-12 col-md-12 abt-textcol-6 text-center">
                            <div class="card">
                                <div class="card-body">
                                <p class="text-danger"><b>Berita tidak ditemukan</b></p>
                                </div>
                            </div>
                        </div>';
            echo $html;
        }
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
        $data['title'] = 'Keranjang';
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
            if ($check_detail->getNumRows() > 0) {
                //update
                $id = $check_detail->getRow()->id;

                $tbl_transaksi_detail['qty'] = $check_detail->getRow()->qty + $this->request->getPost('qty');
                $tbl_transaksi_detail['harga'] = $this->request->getPost('harga');
                $tbl_transaksi_detail['subtotal'] = $check_detail->getRow()->subtotal * ($check_detail->getRow()->qty + $this->request->getPost('qty'));
                $tbl_transaksi_detail['weight'] = $check_detail->getRow()->weight * ($check_detail->getRow()->qty + $this->request->getPost('qty'));

                $result = $this->server_side->updateRows($id, $tbl_transaksi_detail, 'tbl_transaksi_detail');

                if ($result) {
                    $r['result'] = true;
                    $r['total'] =  $this->server_side->count_cart();
                    echo json_encode($r);
                } else {
                    $r['result'] = false;
                    $r['total'] =  $this->server_side->count_cart();
                    echo json_encode($r);
                }
            } else {
                $tbl_transaksi_detail['id_transaksi'] = $id_transaksi;
                $tbl_transaksi_detail['id_barang'] = $this->request->getPost('id');
                $tbl_transaksi_detail['qty'] = $this->request->getPost('qty');
                $tbl_transaksi_detail['harga'] = $this->request->getPost('harga');
                $tbl_transaksi_detail['subtotal'] = $this->request->getPost('harga') * $this->request->getPost('qty');
                $tbl_transaksi_detail['weight'] = $this->request->getPost('weight') * $this->request->getPost('qty');

                $result = $this->server_side->createRows($tbl_transaksi_detail, 'tbl_transaksi_detail');

                if ($result) {
                    $r['result'] = true;
                    $r['total'] = $this->server_side->count_cart();
                    echo json_encode($r);
                } else {
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

                $tbl_transaksi['kode_transaksi']    = 'TR' . date('ymd') . '-' . $kode;
                $tbl_transaksi['id_pengguna']       = session()->get('id');
                $tbl_transaksi['nama'] = session()->get('nama');
                $tbl_transaksi['email'] = session()->get('email');
                $tbl_transaksi['nohp'] = session()->get('nohp');
                $tbl_transaksi['alamat'] = session()->get('alamat');
                $tbl_transaksi['province_id'] = session()->get('province_id');
                $tbl_transaksi['city_id'] = session()->get('city_id');
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

                if ($result) {
                    $r['kode_transaksi'] = $this->server_side->getKodeTransaksibyIdUMKM($id_umkm);
                    $r['url'] = base_url('kerjasama/umkm/' . $r['kode_transaksi']);
                    if (!$r['kode_transaksi']) {
                        $r['url'] = base_url('kerjasama');
                    }

                    $r['result'] = true;
                    $r['total'] =  $this->db->table('tbl_transaksi')->getWhere(['status' => 'CART', 'id_pengguna' => session()->get('id')])->getNumRows();
                    echo json_encode($r);
                } else {
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
        $cart_ = '';
        foreach ($this->server_side->transaksi() as $t) {
            $cart_ .= '<div class="card mb-3">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="form-check">
                            <input class="form-check-input" onchange="calculateAll()" type="checkbox" id="' . $t->id . '" data-id_transaksi="' . $t->id . '" data-jumlah_barang="' . $this->server_side->jumlah_barang($t->id) . '" name="' . $t->id . '" value="' . $this->server_side->jumlah_transaksi($t->id) . '">
                            <label class="form-check-label" for="' . $t->id . '">
                                <h5>' . $t->nama_toko . '</h5>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>';
            foreach ($this->server_side->transaksi_detail($t->id) as $td) {
                $cart_ .= '<tr>
                                    <td class="product-image" width="60%">
                                        <div class="d-flex">
                                            <div class="p-2 align-self-center">
                                                <img src="' . $td->foto . '" alt="">
                                            </div>
                                            <div class="p-2 align-self-center">
                                                <b>' . $td->nama . '</b>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle" class="text-center"><div class="d-flex align-items-center"><input type="number" onchange="qty(' . $td->id . ')" id="qty_' . $td->id . '" min="1" max="' . $td->max_qty . '" class="form-control" value="' . $td->qty . '"><label class="p-2">' . $td->satuan . '</label></div></td>
                                    <td style="vertical-align:middle" class="text-right"><b>Rp ' . number_format($td->subtotal, 0, ',', '.') . '</b></td>
                                    <td style="vertical-align:middle" width="5%"><a href="javascript:void(0)" class="remove" data-id="' . $td->id . '" data-id_transaksi="' . $t->id . '"><i class="fas fa-trash-alt text-danger"></i></a></td>
                                </tr>';
            }
            $cart_ .= '</tbody>
                    </table>
                    <div class="form-group">
                        <label for="catatan">Catatan Pesanan</label>
                        <textarea class="form-control" onchange="catatan(' . $t->id . ')" id="catatan_' . $t->id . '">' . $t->catatan_beli . '</textarea>
                    </div>
                </div>
            </div>';
        }

        if (!empty($this->server_side->transaksi())) {
            echo $cart_;
        } else {
            $cart_ .= '<div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>Wah, keranjang belanjamu kosong</h3>
                            <p>Yuk, isi dengan barang-barang kebutuhanmu!</p>
                            <a href="' . base_url('/list-produk') . '" class="btn btn-primary">Mulai Belanja</a>
                        </div>
                    </div>';
            echo $cart_;
        }
    }

    public function kerjasama_()
    {
        $cart_ = '';
        foreach ($this->server_side->transaksi() as $t) {
            $cart_ .= '
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex align-self-center">
                                <div class="mr-auto">
                                    <label class="form-check-label" for="' . $t->id . '">
                                        <a href="' . base_url('profil-umkm/' . $t->slug_url) . '"><h5>' . $t->nama_toko . '</h5></a>
                                    </label>
                                </div>
                                <div class="ml-auto">
                                    <a href="' . base_url('kerjasama/umkm/' . $t->kode_transaksi) . '" class="btn btn-success"><i class="fas fa-plus-circle"></i> <b>Pengajuan Kerja Sama</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody>';
            foreach ($this->server_side->transaksi_detail($t->id) as $td) {
                if ($td->qty >= $td->min_qty_kerjasama) {
                    $subtotal = $td->harga_min * $td->qty;
                    $qty = $td->qty;
                } else {
                    $qty = 10;
                    $subtotal = $td->harga_min * $qty;
                }
                $cart_  .= '<tr>
                                        <td class="product-image" width="60%">
                                            <div class="d-flex">
                                                <div class="p-2 align-self-center">
                                                    <img src="' . $td->foto . '" alt="">
                                                </div>
                                                <div class="p-2 align-self-center">
                                                    <b>' . $td->nama . '</b>
                                                    <p class="text-warning">Minimal order pengajuan kerjasama <b>' . $td->min_qty_kerjasama . ' ' . $td->satuan . '</b></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align:middle" class="text-center"><div class="d-flex align-items-center"><input type="number" onchange="qty(' . $td->id . ')" id="qty_' . $td->id . '" min="' . $td->min_qty_kerjasama . '" max="' . $td->max_qty . '" class="form-control" value="' . $qty . '"><label class="p-2"><b>' . $td->satuan . '</b></label></div></td>
                                        <td style="vertical-align:middle" class="text-right">
                                            <div class="text-danger"><s>Rp ' . number_format($td->harga_produk * $qty, 0, ',', '.') . '</s></div>
                                            <b>Rp ' . number_format($subtotal, 0, ',', '.') . '</b>
                                        </td>
                                        <td style="vertical-align:middle" width="5%"><a href="javascript:void(0)" class="remove p-2" data-id="' . $td->id . '" data-id_transaksi="' . $t->id . '"><i class="fas fa-trash-alt text-danger"></i></a></td>
                                    </tr>';
            }
            $cart_ .= '</tbody>
                            </table>
                            <div class="form-group">
                                <label for="catatan">Catatan Pesanan</label>
                                <textarea class="form-control" onchange="catatan(' . $t->id . ')" id="catatan_' . $t->id . '">' . $t->catatan_beli . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        if (!empty($this->server_side->transaksi())) {
            echo $cart_;
        } else {
            $cart_ .= '<div class="card mb-3">
                        <div class="card-body text-center">
                            <h3>Wah, keranjang belanjamu kosong</h3>
                            <p>Yuk, isi dengan barang-barang kebutuhanmu!</p>
                            <a href="' . base_url('/') . '" class="btn btn-primary">Mulai Belanja</a>
                        </div>
                    </div>';
            echo $cart_;
        }
    }

    public function update_qty()
    {
        $row_id = $this->request->getPost('id');
        $qty = $this->request->getPost('jumlah');

        $id_barang = $this->db->table('tbl_transaksi_detail')->getWhere(['id' => $row_id])->getRow()->id_barang;
        $harga = $this->db->table('tbl_produk_umkm')->getWhere(['id' => $id_barang])->getRow()->harga;

        $tbl_transaksi_detail['harga'] = $harga;
        $tbl_transaksi_detail['qty'] = $qty;
        $tbl_transaksi_detail['subtotal'] = $qty * $harga;

        $this->server_side->updateRows($row_id, $tbl_transaksi_detail, 'tbl_transaksi_detail');
    }

    public function update_catatan()
    {
        $row_id = $this->request->getPost('id');
        $catatan = $this->request->getPost('catatan');

        $tbl_transaksi['id'] = $row_id;
        $tbl_transaksi['catatan_beli'] = $catatan;

        $this->server_side->updateRows($row_id, $tbl_transaksi, 'tbl_transaksi');
    }

    public function remove_cart()
    {
        $row_id = $this->request->getPost('id');
        $id_transaksi = $this->request->getPost('id_transaksi');

        $check = $this->db->table('tbl_transaksi_detail')->getWhere(['id_transaksi' => $id_transaksi])->getNumRows();

        if ($check > 1) {
            $this->server_side->deleteRows($row_id, 'tbl_transaksi_detail');
        } else {
            $this->server_side->deleteRows($row_id, 'tbl_transaksi_detail');
            $this->server_side->deleteRows($id_transaksi, 'tbl_transaksi');
        }

        $datas['total'] =  $this->server_side->count_cart();
        echo json_encode($datas);
    }

    public function checkout()
    {
        if (session()->get('role') != 'RESELLER') {
            return redirect()->to('/login');
        }

        $transaksi_list = rtrim($this->request->getPost('id_transaksi'), ',');
        $data['title'] = 'Checkout';
        $data['id_transaksi'] = $transaksi_list;
        $data['transaksi']  = $this->server_side->transaksi_in($transaksi_list);
        $data['pemesan']  = $this->server_side->transaksi_in_limit($transaksi_list);
        $data['js'] = array("checkout.js?r=" . uniqid());
        $data['main_content']   = 'frontend/checkout';
        echo view('template/fruitkha', $data);
    }

    public function proses_checkout()
    {
        $transaksi_list = $this->request->getPost('id_transaksi');

        $hashids = new Hashids('', 6, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $milis = time() + (60 * 60 * 4);
        $convert = $hashids->encode($milis);
        $kode_ = substr($convert, 0, 6);

        $kode_bayar = 'INV' . date('ymd') . '-' . $kode_;

        $tbl_transaksi_pembayaran['id_pengguna'] = session()->get('id');
        $tbl_transaksi_pembayaran['kode_bayar'] = $kode_bayar;

        $datetime_now = date('Y-m-d H:i:s');

        $tbl_transaksi_pembayaran['batas_bayar'] = date('Y-m-d H:i:s', strtotime($datetime_now . ' + 2 days'));
        $tbl_transaksi_pembayaran['total_tagihan'] = $this->server_side->jumlah_total_bayar($transaksi_list);
        $tbl_transaksi_pembayaran['status'] = 'BELUM_DIBAYAR';
        $tbl_transaksi_pembayaran['create_user'] = session()->get('nama');

        $id_pembayaran = $this->server_side->createRowsReturnID($tbl_transaksi_pembayaran, 'tbl_transaksi_pembayaran');
        foreach (explode(',', $transaksi_list) as $val) {
            $id_transaksi = $val;
            $tbl_transaksi['id_pembayaran'] = $id_pembayaran;
            $tbl_transaksi['status'] = 'BELUM_DIBAYAR';
            $tbl_transaksi['kerjasama'] = 'T';
            $this->server_side->updateRows($id_transaksi, $tbl_transaksi, 'tbl_transaksi');
        }

        return redirect()->to('/notifikasi/' . $kode_bayar);
    }

    public function notifikasi($inv)
    {
        $data['kode'] = $inv;
        $data['title'] = 'Notifikasi';
        $data['total_bayar'] = $this->db->table('tbl_transaksi_pembayaran')->getWhere(['kode_bayar' => $inv])->getRow()->total_tagihan;
        $data['main_content']   = 'frontend/notifikasi';
        echo view('template/fruitkha', $data);
    }

    public function notifikasi_kerjasama($kode)
    {
        $data['kode'] = $kode;
        $data['title'] = 'Notifikasi';
        // $data['total_bayar'] = $this->db->table('tbl_transaksi_pembayaran')->getWhere(['kode_bayar' => $inv])->getRow()->total_tagihan;
        $data['main_content']   = 'frontend/notifikasi_kerjasama';
        echo view('template/fruitkha', $data);
    }

    public function set_kurir()
    {
        $id_transaksi = $this->request->getPost('id_transaksi');
        $tbl_transaksi['service'] = $this->request->getPost('service');
        $tbl_transaksi['ongkir'] = $this->request->getPost('ongkir');
        $tbl_transaksi['jumlah'] = $this->server_side->jumlah_transaksi($id_transaksi);

        $result = $this->server_side->updateRows($id_transaksi, $tbl_transaksi, 'tbl_transaksi');
        if ($result) {
            echo $result;
        } else {
            echo false;
        }
    }

    public function kurir()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');
        $id_transaksi = $this->request->getPost('id_transaksi');

        $tbl_transaksi['kurir'] = $courier;
        $this->server_side->updateRows($id_transaksi, $tbl_transaksi, 'tbl_transaksi');

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
        curl_close($curl);

        return $response;
    }
}
