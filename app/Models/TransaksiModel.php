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

    public function limitRowsKerjasama($status, $start_date, $end_date)
    {
        $sql = $this->selectFieldKerjasama($status, $start_date, $end_date);
        if ($_POST['length'] != -1) {
            $sql .= "limit " . $_POST['start'] . "," . $_POST['length'];
        }

        // echo $sql; die;

        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function progress($lama_kerjasama, $no_kerjasama)
    {
        $jumlah_seluruh = $lama_kerjasama;

        $sql = "SELECT lama_kerjasama as total
        FROM `tbl_transaksi_kerjasama`
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.no_kerjasama=tbl_transaksi_kerjasama.no_kerjasama
        JOIN tbl_transaksi ON tbl_transaksi.id_pembayaran = tbl_transaksi_pembayaran.id
        WHERE tbl_transaksi_kerjasama.no_kerjasama=?
        AND tbl_transaksi.status='SELESAI'
        ";
        $jumlah_bagian = $this->db->query($sql, array($no_kerjasama))->getNumRows();

        $count = ($jumlah_bagian / $jumlah_seluruh) * 100;

        return $count;
    }

    protected function selectFieldKerjasama($status, $start_date, $end_date)
    {
        $id_pengguna = session()->get('id');
        
        $column_order = array('tbl_transaksi_kerjasama.create_date', 'tbl_transaksi_kerjasama.no_kerjasama', 'tbl_umkm.nama', 'tbl_transaksi_kerjasama.lama_kerjasama', 'tbl_transaksi_kerjasama.status', null, null); //field yang ada di table user
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
        WHERE 1
        AND tbl_transaksi.kerjasama = 'Y'
        AND tbl_transaksi.id_pengguna = $id_pengguna
        ";

        if($start_date != '' && $end_date != ''){
            $sql.=" AND (tbl_transaksi_kerjasama.create_date BETWEEN '$start_date' AND '$end_date') ";
        }

        if($status != ''){
            $sql.=" AND tbl_transaksi_kerjasama.status='$status' ";
        }

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

    public function countFilteredKerjasama($status, $start_date, $end_date)
    {
        $sql = $this->selectFieldKerjasama($status, $start_date, $end_date);
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }

    public function countFilteredTransaksi($status, $start_date, $end_date)
    {
        $sql = $this->selectFieldTransaksi($status, $start_date, $end_date);
        $query = $this->db->query($sql);
        return $query->getNumRows();
    }

    //TRANSAKSI
    public function limitRowstTransaksi($status, $start_date, $end_date)
    {
        $sql = $this->selectFieldTransaksi($status, $start_date, $end_date);
        if ($_POST['length'] != -1) {
            $sql .= "limit " . $_POST['start'] . "," . $_POST['length'];
        }

        // echo $sql; die;

        $query = $this->db->query($sql);
        return $query->getResult();
    }

    protected function selectFieldTransaksi($status, $start_date, $end_date)
    {
        $id_pengguna = session()->get('id');

        $column_order = array('tbl_transaksi.create_date', 'tbl_transaksi.kode_transaksi', 'tbl_umkm.nama', null, null); //field yang ada di table user
        $column_search = array('tbl_transaksi.kode_transaksi', 'tbl_umkm.nama');

        $sql = "SELECT tbl_transaksi_pembayaran.status, tbl_transaksi.*, tbl_umkm.nama as nama_umkm, dtl.jumlah_barang, dtl.total_barang
        FROM tbl_transaksi 
        JOIN tbl_transaksi_pembayaran ON tbl_transaksi_pembayaran.id = tbl_transaksi.id_pembayaran
        JOIN tbl_umkm ON tbl_umkm.id = tbl_transaksi.id_umkm 
        JOIN (
                SELECT COUNT(tbl_transaksi_detail.id_barang) as jumlah_barang, tbl_transaksi_detail.id_transaksi, SUM(tbl_transaksi_detail.qty) as total_barang
                FROM tbl_transaksi
                JOIN tbl_transaksi_detail ON tbl_transaksi_detail.id_transaksi = tbl_transaksi.id
                GROUP BY tbl_transaksi.id
            ) as dtl ON dtl.id_transaksi = tbl_transaksi.id
        WHERE 1
        AND tbl_transaksi.kerjasama = 'T'
        AND tbl_transaksi.id_pengguna = $id_pengguna ";

        if($start_date != '' && $end_date != ''){
            $sql.=" AND (tbl_transaksi.create_date BETWEEN '$start_date' AND '$end_date') ";
        }

        if($status != ''){
            $sql.=" AND tbl_transaksi.status='$status' ";
        }

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

        if(isset($_POST['order'])) {
            $sql .= " ORDER BY ".$column_order[$_POST['order']['0']['column']] ." ". $_POST['order']['0']['dir'] ." ";
        }
        else {
            $sql .= " ORDER BY tbl_transaksi.create_date DESC ";
        }

        return $sql;
    }
}
