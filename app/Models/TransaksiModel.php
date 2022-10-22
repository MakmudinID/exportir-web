<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $q;
    protected $up;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
    }

    public function limitRowsKerjasama()
    {
        $sql = $this->selectFieldKerjasama();
        if ($_POST['length'] != -1) {
            $sql .= "limit " . $_POST['start'] . "," . $_POST['length'];
        }

        // echo $sql; die;

        $query = $this->db->query($sql);
        return $query->getResult();
    }

    protected function selectFieldKerjasama()
    {
        $column_order = array('tbl_transaksi_kerjasama.create_date', 'tbl_transaksi_kerjasama.no_kerjasama', 'tbl_umkm.nama', 'tbl_transaksi_kerjasama.lama_kerjasama'); //field yang ada di table user
        $column_search = array('tbl_transaksi_kerjasama.create_date', 'tbl_transaksi_kerjasama.no_kerjasama', 'tbl_umkm.nama', 'tbl_transaksi_kerjasama.lama_kerjasama');

        $sql = "SELECT tbl_transaksi_kerjasama.*, tbl_umkm.nama as nama_umkm, dtl.jumlah_barang, dtl.total_barang
        FROM tbl_transaksi_kerjasama 
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_kerjasama.no_kerjasama = tbl_transaksi_pembayaran.no_kerjasama
        JOIN tbl_transaksi ON tbl_transaksi.id_pembayaran = tbl_transaksi_pembayaran.id
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm 
        JOIN (
                SELECT COUNT(tbl_transaksi_detail.id_barang) as jumlah_barang, tbl_transaksi_detail.id_transaksi, SUM(tbl_transaksi_detail.qty) as total_barang
                FROM tbl_transaksi
                JOIN tbl_transaksi_detail ON tbl_transaksi_detail.id_transaksi = tbl_transaksi.id
                GROUP BY tbl_transaksi.id
            ) as dtl ON dtl.id_transaksi = tbl_transaksi.id
        WHERE 1";

        $i = 0;
        if (isset($_POST['search']['value'])) {
            $sql .= " AND ( ";
            foreach ($column_search as $item) {
                if ($i === 0) {
                    $sql .= " " . $item . " like '%" . $_POST['search']['value'] . "%' ";
                } else {
                    $sql .= "or " . $item . " like '%" . $_POST['search']['value'] . "%' ";
                }
                $i++;
            }
            $sql .= " ) ";
        }

        $sql .= "GROUP BY tbl_transaksi_kerjasama.no_kerjasama ";

        if(isset($_POST['order'])) {
            $sql .= " ORDER BY ".$column_order[$_POST['order']['0']['column']] ." ". $_POST['order']['0']['dir'] ." ";
        }
        else {
            $sql .= " ORDER BY tbl_transaksi_kerjasama.create_date DESC ";
        }

        return $sql;
    }

    public function countFilteredKerjasama()
    {
        $sql = $this->selectFieldKerjasama();
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }
}
