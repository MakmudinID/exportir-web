<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $q;
    protected $up;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
    }

    private function datatables_transaksi()
    {
        $column_order = array(null,'tbl_pembayaran.create_date', 'tbl_pengguna.nama', 'tbl_transaksi.status', 'tbl_transaksi.kurir', 'tbl_transaksi.service' ,'tbl_pembayaran.total_tagihan',null);
        $column_search = array('tbl_transaksi.nama');
        $sql = " select
                    tbl_pembayaran.id,
                    tbl_pembayaran.total_tagihan,
                    tbl_pembayaran.create_date,
                    tbl_pembayaran.bukti_url,
                    tbl_pembayaran.status as status_bayar,
                    tbl_transaksi.status,
                    tbl_transaksi.id as id_transaksi,
                    tbl_transaksi.kode_transaksi,
                    tbl_transaksi.jumlah,
                    tbl_transaksi.ongkir,
                    tbl_transaksi.nama as nama_penerima,
                    tbl_transaksi.email as email_penerima,
                    tbl_transaksi.nohp as nohp_penerima,
                    tbl_transaksi.alamat as alamat_penerima,
                    tbl_transaksi.keterangan as ket_penerima,
                    tbl_transaksi.kurir,
                    tbl_transaksi.service,
                    tbl_umkm.nama as umkm,
                    tbl_pengguna.nama
                from tbl_pembayaran
                    left join tbl_transaksi on tbl_transaksi.id_pembayaran = tbl_pembayaran.id
                    left join tbl_pengguna on tbl_pengguna.id = tbl_transaksi.id_pengguna
                    left join tbl_umkm on tbl_umkm.id = tbl_transaksi.id_umkm
            ";

        $arr = [];
        if(session()->get('role') != 'SUPERADMIN'){
            $sql .= "where tbl_transaksi.id_umkm = ? ";
            $arr[] = $this->db->escapeString(session()->get('id_umkm'));
        }


        
        $i = 0;
        if(isset($_POST['search']['value'])){
            if ($_POST['search']['value']) {
                $sql .= " and ( ";
                foreach ($column_search as $item) {
                    if ($i === 0) {
                        $sql .= " " . $item . " like '%" . $_POST['search']['value'] . "%' escape '!' ";
                    } else {
                        $sql .= "or " . $item . " like '%" . $_POST['search']['value'] . "%' escape '!' ";
                    }
                    $i++;
                }
                $sql .= " ) ";
            }
        }


        if (isset($_POST['order'])) {
            $sql .= " order by " . $column_order[$_POST['order']['0']['column']] . " " . $_POST['order']['0']['dir'] . " ";
        } else {
            $sql .= " order by tbl_pembayaran.create_date desc ";
        }
        $sql_ = [$sql, $arr];

        return $sql_;
    }

    public function laporan_transaksi()
    {
        $sql = $this->datatables_transaksi();
        if(isset($_POST['length'])){
            if ($_POST['length'] != -1) {
                $sql[0] .= "limit " . $_POST['start'] . "," . $_POST['length'];
            }
        }
        $query = $this->db->query($sql[0], $sql[1]);

        // echo $sql; die;
        return $query->getResult();
        // return $sql;
    }

    public function count_filtered_transaksi()
    {
        $sql = $this->datatables_transaksi();
        $query = $this->db->query($sql[0], $sql[1]);
        return $query->getNumRows();
    }

    public function count_all_transaksi(){
        $sql = $this->datatables_transaksi();
        $query = $this->db->query($sql[0], $sql[1]);
        return $query->getNumRows();
    }

    public function detail_transaksi($id_transaksi)
    {
        $sql = "select
                    tbl_detail_transaksi.*,
                    tbl_produk_umkm.nama
                from tbl_detail_transaksi 
                    left join tbl_produk_umkm on tbl_detail_transaksi.id_barang = tbl_produk_umkm.id
                  
                where tbl_detail_transaksi.id_transaksi = ? ";
        $arr = [];
        $arr[] = $this->db->escapeString($id_transaksi);

        $query = $this->db->query($sql, $arr);
        return $query->getResult();
    }

}