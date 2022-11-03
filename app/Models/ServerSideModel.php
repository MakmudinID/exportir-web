<?php

namespace App\Models;

use CodeIgniter\Model;

class ServerSideModel extends Model
{
    protected $q;
    protected $up;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
    }

    public function getTransaksiPembayaran($no_kerjasama)
    {
        $sql = "SELECT tbl_transaksi_pembayaran.*, tbl_metode_bayar.nama as metode_bayar, tbl_metode_bayar.nomor_rekening, tbl_transaksi.kode_transaksi, tbl_transaksi.id as id_transaksi, tbl_transaksi.kurir, tbl_transaksi.catatan_beli, tbl_transaksi.ongkir, tbl_transaksi.no_resi, tbl_transaksi.status as status_transaksi, tbl_transaksi.tanggal_kirim
        FROM tbl_transaksi_pembayaran
        JOIN tbl_metode_bayar ON tbl_metode_bayar.id = tbl_transaksi_pembayaran.id_metode_bayar
        JOIN tbl_transaksi ON tbl_transaksi.id_pembayaran = tbl_transaksi_pembayaran.id
        WHERE no_kerjasama = ? ";

        return $this->db->query($sql, array($no_kerjasama))->getResult();
    }

    public function getKerjasama($no_kerjasama)
    {
        $sql = "SELECT tbl_transaksi.catatan_beli, tbl_transaksi.ongkir, tbl_transaksi.kurir, tbl_transaksi.kode_transaksi, tbl_transaksi.id as id_transaksi, tbl_transaksi_kerjasama.*, tbl_umkm.nama as nama_umkm, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota, tbl_umkm.alamat as alamat_umkm, tbl_umkm.no_telepon as telepon_umkm
        FROM tbl_transaksi_kerjasama
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.no_kerjasama = tbl_transaksi_kerjasama.no_kerjasama
        JOIN tbl_transaksi ON tbl_transaksi.id_pembayaran = tbl_transaksi_pembayaran.id
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi_kerjasama.no_kerjasama = ?
        GROUP BY tbl_transaksi_kerjasama.no_kerjasama";

        return $this->db->query($sql, array($no_kerjasama))->getRow();
    }

    public function transaksi_in($list)
    {
        $sql = "SELECT tbl_transaksi.*, tbl_umkm.nama as nama_toko, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi.id_pengguna = ?
        AND tbl_transaksi.status='CART'
        AND tbl_transaksi.id IN ($list)";

        return $this->db->query($sql, array(session()->get('id')))->getResult();
    }

    public function pembayaran($kode_bayar)
    {
        $sql = "SELECT tbl_transaksi.*, tbl_metode_bayar.nama as metode_bayar, tbl_metode_bayar.nomor_rekening, tbl_transaksi_pembayaran.status as status_bayar, tbl_transaksi_pembayaran.bukti_url, tbl_transaksi_pembayaran.total_tagihan, tbl_transaksi_pembayaran.batas_bayar, tbl_transaksi_pembayaran.kode_bayar, tbl_umkm.nama as nama_toko, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.id = tbl_transaksi.id_pembayaran
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_metode_bayar ON tbl_metode_bayar.id = tbl_transaksi_pembayaran.id_metode_bayar
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi_pembayaran.kode_bayar=?
        LIMIT 1";

        return $this->db->query($sql, array($kode_bayar))->getRow();
    }

    public function transaksi_in_kodebayar($kode_bayar)
    {
        $sql = "SELECT tbl_transaksi.*, tbl_umkm.nama as nama_toko, tbl_umkm.nama as slug
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.id = tbl_transaksi.id_pembayaran
        WHERE tbl_transaksi_pembayaran.kode_bayar=?";

        return $this->db->query($sql, array($kode_bayar))->getResult();
    }

    public function transaksi_in_kode($kode_transaksi)
    {
        $sql = "SELECT tbl_transaksi.*, tbl_umkm.nama as nama_toko, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi.id_pengguna = ?
        AND tbl_transaksi.status='CART'
        AND tbl_transaksi.kode_transaksi=? ";

        return $this->db->query($sql, array(session()->get('id'), $kode_transaksi))->getResult();
    }

    public function transaksi_in_kode_detail($kode_transaksi)
    {

        $sql = "SELECT tbl_transaksi.*, tbl_metode_bayar.nama as metode_bayar, tbl_metode_bayar.nomor_rekening, tbl_transaksi_pembayaran.total_tagihan,  tbl_transaksi_pembayaran.tanggal_bayar, tbl_transaksi_pembayaran.status as status_bayar, tbl_transaksi_pembayaran.keterangan as keterangan_bayar, tbl_transaksi_pembayaran.bukti_url as bukti_bayar, tbl_transaksi_pembayaran.batas_bayar, tbl_transaksi_pembayaran.kode_bayar, tbl_umkm.nama as nama_toko, tbl_umkm.slug, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.id = tbl_transaksi.id_pembayaran
        JOIN tbl_metode_bayar ON tbl_metode_bayar.id = tbl_transaksi_pembayaran.id_metode_bayar
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi.kode_transaksi=?
        LIMIT 1 ";
        return $this->db->query($sql, array($kode_transaksi))->getRow();
    }

    public function getTransaksiKodeResult($kode_transaksi)
    {

        $sql = "SELECT tbl_transaksi.*, tbl_metode_bayar.nama as metode_bayar, tbl_metode_bayar.nomor_rekening, tbl_transaksi_pembayaran.total_tagihan,  tbl_transaksi_pembayaran.tanggal_bayar, tbl_transaksi_pembayaran.status as status_bayar, tbl_transaksi_pembayaran.keterangan as keterangan_bayar, tbl_transaksi_pembayaran.bukti_url as bukti_bayar, tbl_transaksi_pembayaran.batas_bayar, tbl_transaksi_pembayaran.kode_bayar, tbl_umkm.nama as nama_toko, tbl_umkm.slug, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.id = tbl_transaksi.id_pembayaran
        JOIN tbl_metode_bayar ON tbl_metode_bayar.id = tbl_transaksi_pembayaran.id_metode_bayar
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi.kode_transaksi=?";
        return $this->db->query($sql, array($kode_transaksi))->getResult();
    }

    public function transaksi_in_limit($list)
    {
        $sql = "SELECT tbl_transaksi.*, tbl_umkm.nama as nama_toko, tbl_umkm.city_id as kota_pengirim, tbl_propinsi.province as nama_propinsi, tbl_city.city_name as nama_kota
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        JOIN tbl_propinsi ON tbl_propinsi.province_id = tbl_transaksi.province_id
        JOIN tbl_city ON tbl_city.city_id = tbl_transaksi.city_id
        WHERE tbl_transaksi.id_pengguna = ?
        AND tbl_transaksi.status='CART'
        AND tbl_transaksi.id IN ($list)
        LIMIT 1";

        return $this->db->query($sql, array(session()->get('id')))->getRow();
    }

    public function transaksi()
    {
        $sql = "SELECT tbl_transaksi.*, tbl_umkm.nama as nama_toko, tbl_umkm.slug as slug_url
        FROM tbl_transaksi
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm
        WHERE tbl_transaksi.id_pengguna = ?
        AND tbl_transaksi.status='CART'";

        return $this->db->query($sql, array(session()->get('id')))->getResult();
    }

    public function transaksi_detail($id_transaksi)
    {
        $sql = "SELECT tbl_transaksi_detail.*, tbl_produk_umkm.harga as harga_produk, tbl_produk_umkm.harga_min as harga_min, tbl_produk_umkm.nama, tbl_produk_umkm.foto, tbl_produk_umkm.satuan, tbl_produk_umkm.qty as max_qty, tbl_produk_umkm.qty_min as min_qty_kerjasama
        FROM `tbl_transaksi_detail`
        JOIN tbl_produk_umkm ON tbl_produk_umkm.id = tbl_transaksi_detail.id_barang
        WHERE tbl_transaksi_detail.id_transaksi = ?";

        return $this->db->query($sql, array($id_transaksi))->getResult();
    }

    public function count_cart()
    {
        $sql = "SELECT count(id_transaksi) as jumlah 
        FROM tbl_transaksi 
        JOIN tbl_transaksi_detail ON tbl_transaksi_detail.id_transaksi = tbl_transaksi.id
        WHERE tbl_transaksi.id_pengguna = ?
        AND tbl_transaksi.status='CART'";

        $jumlah = $this->db->query($sql, array(session()->get('id')))->getRow()->jumlah;
        return $jumlah;
    }

    public function count_cart_by($kode_transaksi)
    {
        $sql = "SELECT count(id_transaksi) as jumlah 
        FROM tbl_transaksi 
        JOIN tbl_transaksi_detail ON tbl_transaksi_detail.id_transaksi = tbl_transaksi.id
        WHERE tbl_transaksi.kode_transaksi=? ";

        $jumlah = $this->db->query($sql, array($kode_transaksi))->getRow()->jumlah;
        return $jumlah;
    }

    public function jumlah_transaksi($id_transaksi)
    {
        $q = $this->db->query("SELECT SUM(subtotal) as jumlah_transaksi FROM `tbl_transaksi_detail` WHERE id_transaksi=? GROUP BY id_transaksi", array($id_transaksi))->getRow();
        return $q->jumlah_transaksi;
    }

    public function jumlah_barang($id_transaksi)
    {
        $q = $this->db->query("SELECT * FROM `tbl_transaksi_detail` WHERE id_transaksi=? ", array($id_transaksi))->getNumRows();
        return $q;
    }

    public function jumlah_berat($id_transaksi)
    {
        $q = $this->db->query("SELECT SUM(weight) as total_berat FROM `tbl_transaksi_detail` WHERE id_transaksi=? GROUP BY id_transaksi", array($id_transaksi))->getRow()->total_berat;
        return $q;
    }

    public function jumlah_total_bayar($transaksi_list)
    {
        $q = $this->db->query("SELECT (SUM(jumlah)+SUM(ongkir)) as total_bayar FROM `tbl_transaksi` WHERE id IN ($transaksi_list)")->getRow()->total_bayar;
        return $q;
    }

    public function getFotoBy($id)
    {
        $q = $this->db->query("SELECT tbl_pengguna.foto FROM tbl_pengguna where tbl_pengguna.id = ?", array($id))->getRow();
        if ($q->foto != NULL) {
            return $q->foto;
        } else {
            return base_url('/assets/admin/img/avatar.png');
        }
    }

    public function getFoto()
    {
        $q = $this->db->query("SELECT tbl_pengguna.foto FROM tbl_pengguna where tbl_pengguna.id = ?", array(session()->get('id')))->getRow();
        if ($q->foto != NULL) {
            return $q->foto;
        } else {
            return base_url('/assets/admin/img/avatar.png');
        }
    }

    public function getFotoUMKM()
    {
        $q = $this->db->query("SELECT tbl_umkm.foto FROM tbl_umkm where tbl_umkm.id = ?", array(session()->get('id_umkm')))->getRow();
        if ($q->foto != NULL) {
            return $q->foto;
        } else {
            return base_url('/assets/admin/img/avatar.png');
        }
    }

    public function getNama($id)
    {
        $q = $this->db->query("SELECT tbl_pengguna.nama, tbl_umkm.nama as nama_umkm 
                            FROM tbl_pengguna LEFT JOIN tbl_umkm ON tbl_umkm.id_pengguna = tbl_pengguna.id where tbl_pengguna.id = ?", array($id))->getRow();
        if ($q->nama != NULL) {
            if($q->nama_umkm != NULL){
                return $q->nama_umkm;
            }else{
                return $q->nama;
            }
        } else {
            return 'NULL';
        }
    }

    public function get_profil()
    {
        $q = $this->db->query("SELECT tbl_pengguna.*, tbl_umkm.id as id_umkm, tbl_umkm.nama as nama_umkm, tbl_umkm.deskripsi, tbl_umkm.foto as foto_umkm, tbl_umkm.alamat as alamat_umkm, tbl_umkm.city_id, tbl_city.province_id FROM tbl_pengguna left join tbl_umkm on tbl_umkm.id_pengguna = tbl_pengguna.id left join tbl_city on tbl_umkm.city_id = tbl_city.city_id where tbl_pengguna.id = ?", array(session()->get('id')))->getRow();
        return $q;
    }

    public function getPropinsi()
    {
        $q = $this->db->query("SELECT tbl_propinsi.* FROM tbl_propinsi")->getResult();
        return $q;
    }

    public function getKota($id_prov)
    {
        $q = $this->db->query("SELECT tbl_city.* FROM tbl_city where province_id=?", array($id_prov))->getResult();
        return $q;
    }

    public function getKotaAll()
    {
        $q = $this->db->query("SELECT tbl_city.* FROM tbl_city")->getResult();
        return $q;
    }

    public function getProdukRand()
    {
        $q = $this->db->query("SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
        FROM tbl_produk_umkm 
        join tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
        join tbl_umkm on tbl_umkm.id = tbl_produk_umkm.id_umkm 
        join tbl_city on tbl_city.city_id = tbl_umkm.city_id
        where tbl_produk_umkm.status = 'ACTIVE' 
        LIMIT 9");
        return $q->getResult();
    }

    public function getProdukByUMKM($slug)
    {
        $q = $this->db->query("SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
        FROM tbl_produk_umkm 
        join tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
        join tbl_umkm on tbl_umkm.id = tbl_produk_umkm.id_umkm 
        join tbl_city on tbl_city.city_id = tbl_umkm.city_id
        where tbl_produk_umkm.status = 'ACTIVE'
        and tbl_umkm.slug=?", array($slug));
        return $q->getResult();
    }

    public function getProdukByUMKMfilter($umkm, $keyword, $sort_by, $kategori=NULL)
    {
        $sql = "SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
        FROM tbl_produk_umkm 
        JOIN tbl_kategori_produk ON tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
        JOIN tbl_umkm ON tbl_umkm.id = tbl_produk_umkm.id_umkm 
        JOIN tbl_city on tbl_city.city_id = tbl_umkm.city_id
        WHERE tbl_produk_umkm.status = 'ACTIVE' ";

        if ($umkm != '') {
            $sql .= "AND tbl_umkm.id=$umkm ";
        }

        if ($keyword != '') {
            $sql .= "AND tbl_produk_umkm.nama LIKE '%$keyword%' ";
        }
        
        if ($kategori != '') {
            $sql .= "AND tbl_umkm.id_kategori = $kategori ";
        }

        if ($sort_by == 'TERBARU') {
            $sql .= "ORDER BY tbl_produk_umkm.id DESC ";
        } else {
            //terlaris
            $sql .= "ORDER BY tbl_produk_umkm.id ASC ";
        }

        $q = $this->db->query($sql);
        return $q->getResult();
    }

    public function getKodeTransaksibySlug($slug)
    {
        $q = $this->db->query("SELECT kode_transaksi
        FROM tbl_transaksi 
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm 
        WHERE tbl_transaksi.status = 'CART'
        AND tbl_transaksi.id_pengguna =? 
        AND tbl_umkm.slug=?", array(session()->get('id'), $slug));

        if ($q->getNumRows() > 0) {
            return $q->getRow()->kode_transaksi;
        } else {
            return false;
        }
    }

    public function getKodeTransaksibyIdUMKM($id)
    {
        $q = $this->db->query("SELECT kode_transaksi
        FROM tbl_transaksi 
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm 
        WHERE tbl_transaksi.status = 'CART'
        AND tbl_transaksi.id_pengguna =? 
        AND tbl_umkm.id=?", array(session()->get('id'), $id));

        if ($q->getNumRows() > 0) {
            return $q->getRow()->kode_transaksi;
        } else {
            return false;
        }
    }

    public function getKategoriByUMKM($slug)
    {
        $q = $this->db->query("SELECT tbl_kategori_produk.nama as kategori, tbl_kategori_produk.id FROM tbl_kategori_produk JOIN tbl_umkm ON tbl_umkm.id = tbl_kategori_produk.id_umkm where tbl_kategori_produk.status = 'ACTIVE' and tbl_umkm.slug=?", array($slug));
        return $q->getResult();
    }

    public function getProduk($kategori)
    {
        $sql = "SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
                FROM tbl_produk_umkm 
                join tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
                join tbl_umkm on tbl_umkm.id = tbl_produk_umkm.id_umkm 
                join tbl_city on tbl_city.city_id = tbl_umkm.city_id
                where tbl_produk_umkm.status = 'ACTIVE' ";
        if ($kategori != '') {
            $sql .= " and tbl_kategori_produk.id = $kategori ";
        }
        $q = $this->db->query($sql);
        return $q->getResult();
    }

    public function getProdukById($id)
    {
        $sql = "SELECT tbl_produk_umkm.*, tbl_umkm.nama as nama_umkm, tbl_umkm.slug, tbl_kategori_produk.nama as nama_kategori 
                FROM tbl_produk_umkm 
                join tbl_umkm ON tbl_umkm.id = tbl_produk_umkm.id_umkm
                left join tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori
                where tbl_produk_umkm.id= $id and tbl_produk_umkm.status = 'ACTIVE'";
        $q = $this->db->query($sql)->getRow();
        return $q;
    }

    public function getProdukRelated($kategori)
    {
        $sql = "SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
                FROM tbl_produk_umkm 
                join tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
                join tbl_umkm on tbl_umkm.id = tbl_produk_umkm.id_umkm 
                join tbl_city on tbl_city.city_id = tbl_umkm.city_id
                where tbl_produk_umkm.status = 'ACTIVE' and tbl_kategori_produk.id = $kategori order by rand() limit 4";
        $q = $this->db->query($sql);
        return $q->getResult();
    }

    public function getKategoriUMKM()
    {
        $q = $this->db->query("SELECT tbl_kategori_umkm.id, tbl_kategori_umkm.nama FROM tbl_kategori_umkm where tbl_kategori_umkm.status = 'ACTIVE'");
        return $q->getResult();
    }

    public function getKategoriUMKMreal()
    {
        $q = $this->db->query("SELECT tbl_kategori_umkm.id, tbl_kategori_umkm.nama 
        FROM tbl_kategori_umkm 
        WHERE tbl_kategori_umkm.status = 'ACTIVE'
        AND tbl_kategori_umkm.id IN (SELECT tbl_umkm.id_kategori 
                                  FROM tbl_umkm JOIN tbl_produk_umkm ON tbl_produk_umkm.id_umkm = tbl_umkm.id 
                                 WHERE tbl_produk_umkm.status='ACTIVE' GROUP BY tbl_umkm.id)");
        return $q->getResult();
    }

    public function getProdukByKategoriUMKM($id_kategori_umkm)
    {
        $q = $this->db->query("SELECT tbl_kategori_produk.nama as kategori, tbl_produk_umkm.*, tbl_city.city_name, tbl_umkm.nama as nama_toko, tbl_umkm.slug
                FROM tbl_produk_umkm 
                JOIN tbl_kategori_produk on tbl_kategori_produk.id = tbl_produk_umkm.id_kategori 
                JOIN tbl_umkm on tbl_umkm.id = tbl_produk_umkm.id_umkm 
                JOIN tbl_city on tbl_city.city_id = tbl_umkm.city_id
                JOIN tbl_kategori_umkm ON tbl_kategori_umkm.id = tbl_umkm.id_kategori
                WHERE tbl_umkm.id_kategori=? AND tbl_produk_umkm.status='ACTIVE';", array($id_kategori_umkm));
        return $q->getResult();
    }

    public function getBerita()
    {
        $q = $this->db->query("SELECT tbl_berita_kategori.nama as kategori, tbl_berita.* FROM tbl_berita join tbl_berita_kategori on tbl_berita.id_kategori = tbl_berita_kategori.id where tbl_berita.status = 'ACTIVE' and flag='BLOG' limit 3");
        return $q->getResult();
    }

    public function getBeritaById($id)
    {
        $q = $this->db->query("SELECT * FROM tbl_berita where status = 'ACTIVE' and id = $id")->getRow();
        return $q;
    }

    public function getBeritaRandom()
    {
        $q = $this->db->query("SELECT tbl_berita_kategori.nama as kategori, tbl_berita.* FROM tbl_berita join tbl_berita_kategori on tbl_berita.id_kategori = tbl_berita_kategori.id where tbl_berita.status = 'ACTIVE' and flag='BLOG' order by rand() limit 5");
        return $q->getResult();
    }

    public function getListBerita($kategori, $keyword)
    {
        $sql = "SELECT tbl_berita_kategori.nama as kategori, tbl_berita.* 
                FROM tbl_berita 
                join tbl_berita_kategori on tbl_berita.id_kategori = tbl_berita_kategori.id 
                where tbl_berita.status = 'ACTIVE' and flag='BLOG' ";
        if ($kategori != '') {
            $sql .= "and tbl_berita_kategori.id = $kategori ";
        }

        if ($keyword != '') {
            $sql .= "and tbl_berita.judul like '%$keyword%' ";
        }

        $q = $this->db->query($sql)->getResult();
        return $q;
    }


    public function getKategoriBerita()
    {
        $q = $this->db->query("SELECT * FROM tbl_berita_kategori where status = 'ACTIVE'");
        return $q->getResult();
    }

    public function getUMKM()
    {
        $q = $this->db->query("SELECT * FROM tbl_umkm");
        return $q->getResult();
    }

    public function getUMKMbySlug($slug)
    {
        $q = $this->db->query("SELECT tbl_umkm.*, tbl_pengguna.logout_date FROM tbl_umkm JOIN tbl_pengguna ON tbl_pengguna.id = tbl_umkm.id_pengguna where slug=?", array($slug));
        return $q->getRow();
    }

    public function getUMKMbyIdTransaksi($slug)
    {
        $q = $this->db->query("SELECT tbl_umkm.* FROM tbl_umkm JOIN tbl_transaksi ON tbl_transaksi.id_umkm = tbl_umkm.id WHERE tbl_transaksi.id=?", array($slug));
        return $q->getRow();
    }

    public function getUMKMbyKodeTransaksi($slug)
    {
        $q = $this->db->query("SELECT tbl_umkm.* FROM tbl_umkm JOIN tbl_transaksi ON tbl_transaksi.id_umkm = tbl_umkm.id WHERE tbl_transaksi.kode_transaksi=?", array($slug));
        return $q->getRow();
    }

    public function getKategoriProduk()
    {
        $q = $this->db->query("SELECT * FROM tbl_kategori_produk");
        return $q->getResult();
    }

    public function getKategoriProdukById($id)
    {
        $q = $this->db->query("SELECT * FROM tbl_kategori_produk where id_umkm = $id");
        return $q->getResult();
    }

    public function getMenuTitle()
    {
        $role = session()->get('role');
        $sql = "SELECT DISTINCT tbl_menu.id_menu_title, tbl_menu_title.title
        FROM `tbl_menu`
        JOIN tbl_menu_title ON tbl_menu_title.id=tbl_menu.id_menu_title
        WHERE role=?
        AND tbl_menu.status=?
        ORDER BY tbl_menu_title.urutan ASC;";
        $query = $this->db->query($sql, array($role, 'ACTIVE'));
        return $query->getResult();
    }

    public function getMenu($id)
    {
        $role = session()->get('role');
        $sql = "SELECT tbl_menu.* 
        FROM tbl_menu 
        WHERE tbl_menu.status = ?
        AND tbl_menu.id_menu_title = ?
        AND tbl_menu.role = ?
        ORDER BY tbl_menu.urutan ASC
        ";
        $query = $this->db->query($sql, array('ACTIVE', $id, $role));
        return $query->getResult();
    }

    public function getIdPenggunaUMKM($kode_transaksi)
    {
        return $this->db->query("SELECT tbl_pengguna.id FROM tbl_transaksi JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm JOIN tbl_pengguna ON tbl_pengguna.id = tbl_umkm.id_pengguna WHERE kode_transaksi=?", array($kode_transaksi))->getRow()->id;
    }

    public function check_chat($kode_transaksi){
        $builder =  $this->db->table('tbl_chat');
        $builder->SELECT('*');
        $builder->where('tbl_chat.kode_transaksi', $kode_transaksi);
        $num = $builder->countAllResults(false);
        if($num > 0){
            return false;
        }else{
            return true;
        }
    }

    public function verify($email, $password)
    {
        $builder =  $this->db->table('tbl_pengguna');
        $builder->SELECT('*');
        $builder->where('tbl_pengguna.email', $email);
        $builder->where('tbl_pengguna.status', 'ACTIVE');
        $num = $builder->countAllResults(false);
        $row = $builder->get()->getRow();

        if ($num == 1 && password_verify($password, $row->password)) {
            if ($row->role == 'UMKM') {
                $umkm = $this->db->table('tbl_umkm')->getWhere(['id_pengguna' => $row->id])->getRow();
                $data = [
                    'id'  => $row->id,
                    'id_umkm' => $umkm->id,
                    'nama_umkm' => $umkm->nama,
                    'nama' => $row->nama,
                    'email'  => $row->email,
                    'foto'  => $row->foto,
                    'role' => $row->role,
                ];
                return $data;
            } else {
                $data = [
                    'id'  => $row->id,
                    'nama' => $row->nama,
                    'email'  => $row->email,
                    'foto'  => $row->foto,
                    'role' => $row->role,
                    'nohp' => $row->no_hp,
                    'alamat' => $row->alamat,
                    'province_id' => $row->id_propinsi,
                    'city_id' => $row->id_kota,
                ];
                return $data;
            }
        } else {
            return 0;
        }
    }

    public function verify_daftar($email)
    {
        $builder =  $this->db->table('tbl_pengguna');
        $builder->where('tbl_pengguna.email', $email);
        $num = $builder->countAllResults(false);
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function formatTanggal($Tgal, $jam = "yes", $idBahasa = 'id')
    {
        if ($Tgal == "") {
            return;
        }
        $tanggal = explode(' ', $Tgal);
        $mdy = explode('-', $tanggal[0]);
        $mBul = $mdy[1];

        if ($idBahasa == "id") {

            if ($mBul == '01') {
                $isBulan = 'Januari';
            } elseif ($mBul == '02') {
                $isBulan = 'Februari';
            } elseif ($mBul == '03') {
                $isBulan = 'Maret';
            } elseif ($mBul == '04') {
                $isBulan = 'April';
            } elseif ($mBul == '05') {
                $isBulan = 'Mei';
            } elseif ($mBul == '06') {
                $isBulan = 'Juni';
            } elseif ($mBul == '07') {
                $isBulan = 'Juli';
            } elseif ($mBul == '08') {
                $isBulan = 'Agustus';
            } elseif ($mBul == '09') {
                $isBulan = 'September';
            } elseif ($mBul == '10') {
                $isBulan = 'Oktober';
            } elseif ($mBul == '11') {
                $isBulan = 'Nopember';
            } elseif ($mBul == '12') {
                $isBulan = 'Desember';
            } elseif ($mBul == '00') {
                $isBulan = '00';
            }

            $hasil = $mdy[2] . ' ' . $isBulan . ' ' . $mdy[0];
            if (count($tanggal) == 2) {
                if ($jam == "yes") {
                    $hasil = $mdy[2] . ' ' . $isBulan . ' ' . $mdy[0] . ', ' . substr($tanggal[1], 0, 5) . ' WIB';
                } else {
                    $hasil = $mdy[2] . ' ' . $isBulan . ' ' . $mdy[0];
                }
            }
        }
        return $hasil;
    }

    public function createRows($data, $table)
    {
        $q = $this->db->table($table);
        $q->insert($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createRowsReturnID($data, $table)
    {
        $q = $this->db->table($table);
        $q->insert($data);

        if ($this->db->affectedRows() > 0) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }

    public function updateRows($id, $data, $table)
    {
        $q = $this->db->table($table);
        $q->where('id', $id);
        $q->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateBatalTransaksi($id_pembayaran, $keterangan)
    {
        $sql = "UPDATE tbl_transaksi, tbl_transaksi_pembayaran 
        SET tbl_transaksi.status='BATAL', 
        tbl_transaksi_pembayaran.status='BATAL', 
        tbl_transaksi_pembayaran.keterangan= ?
        WHERE tbl_transaksi_pembayaran.id=tbl_transaksi.id_pembayaran  
        AND tbl_transaksi_pembayaran.id =? ";
        $this->db->query($sql, array($keterangan, $id_pembayaran));
        return true;
    }

    public function updateBatalKerjasama($no_kerjasama, $alasan_ditolak)
    {
        $sql = "UPDATE tbl_transaksi, tbl_transaksi_pembayaran, tbl_transaksi_kerjasama 
        SET tbl_transaksi.status='BATAL', tbl_transaksi_pembayaran.status='BATAL', tbl_transaksi_kerjasama.status='DITOLAK', tbl_transaksi_kerjasama.alasan_ditolak=? 
        WHERE tbl_transaksi_kerjasama.no_kerjasama = tbl_transaksi_pembayaran.no_kerjasama 
        AND tbl_transaksi_pembayaran.id=tbl_transaksi.id_pembayaran  
        AND tbl_transaksi_pembayaran.no_kerjasama =? ";
        $this->db->query($sql, array($alasan_ditolak, $no_kerjasama));
        return true;
    }

    public function updateRowsByField($field, $val, $data, $table)
    {
        $q = $this->db->table($table);
        $q->where($field, $val);
        $q->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRows($id, $table)
    {
        $id_ = htmlspecialchars($id, ENT_QUOTES);
        $up = $this->db->table($table);
        $up->delete(['id' => $id_]);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteRowsBy($id_label, $id_val, $table)
    {
        $id_ = htmlspecialchars($id_val, ENT_QUOTES);
        $up = $this->db->table($table);
        $up->delete([$id_label => $id_]);

        if ($this->db->affectedRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function limitRows($table, $SELECT, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->SELECTField($table, $SELECT, $where, $column_order, $column_search, $order, $join, $like, $notlike);
        if (isset($_POST['length'])) {
            if ($_POST['length'] != -1) {
                $this->builder->limit($_POST['length'], $_POST['start']);
            }
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    protected function SELECTField($table, $SELECT, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->builder = $this->db->table($table);
        $this->builder->SELECT($SELECT);

        if ($join != NULL) {
            for ($i = 0; $i < count($join); $i++) {
                $this->builder->join($join[$i][0], $join[$i][1], 'left');
            }
        };

        if ($where != NULL) {
            for ($i = 0; $i < count($where); $i++) {
                $this->builder->where($where[$i][0], $where[$i][1]);
            }
        };

        if ($like != NULL) {
            for ($i = 0; $i < count($like); $i++) {
                $this->builder->like($like[$i][0], $like[$i][1], $like[$i][2]);
            }
        };

        if ($notlike != NULL) {
            for ($i = 0; $i < count($notlike); $i++) {
                $this->builder->notLike($notlike[$i][0], $notlike[$i][1], $notlike[$i][2]);
            }
        };

        $i = 0;
        foreach ($column_search as $item) {
            if (isset($_POST['search'])) {
                if ($_POST['search']['value']) {
                    if ($i === 0) {
                        $this->builder->groupStart();
                        $this->builder->like($item, $_POST['search']['value']);
                    } else {
                        $this->builder->orLike($item, $_POST['search']['value']);
                    }

                    if (count($column_search) - 1 == $i) {
                        $this->builder->groupEnd();
                    }
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($order)) {
            $order = $order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function countFiltered($table, $SELECT, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->SELECTField($table, $SELECT, $where, $column_order, $column_search, $order, $join, $like, $notlike);
        return $this->builder->countAllResults();
    }

    public function countAll($table)
    {
        $this->builder = $this->db->table($table);
        return $this->builder->countAllResults();
    }
}
