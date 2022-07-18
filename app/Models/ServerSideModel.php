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

    public function get_profil(){
        $q = $this->db->query("select tbl_pengguna.*, tbl_umkm.id as id_umkm,tbl_umkm.nama as nama_umkm from tbl_pengguna left join tbl_umkm on tbl_umkm.id_pengguna = tbl_pengguna.id where tbl_pengguna.id = ?", array(session()->get('id')))->getRow();
        return $q;
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

    public function verify($email, $password)
    {
        $builder =  $this->db->table('tbl_pengguna');
        $builder->select('*');
        $builder->where('email', $email);
        $builder->where('status', 'ACTIVE');
        $num = $builder->countAllResults(false);
        $row = $builder->get()->getRow();

        if ($num == 1 && password_verify($password, $row->password)) {
            $myid = $row->id;

            $data = [
                'id'  => $row->id,
                'nama' => $row->nama,
                'email'  => $row->email,
                'foto'  => $row->foto,
                'role' => $row->role,
            ];
            return $data;
        } else {
            return 0;
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

    public function limitRows($table, $select, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->selectField($table, $select, $where, $column_order, $column_search, $order, $join, $like, $notlike);
        if (isset($_POST['length'])) {
            if ($_POST['length'] != -1) {
                $this->builder->limit($_POST['length'], $_POST['start']);
            }
        }

        $query = $this->builder->get();
        return $query->getResult();
    }

    protected function selectField($table, $select, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->builder = $this->db->table($table);
        $this->builder->select($select);

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

    public function countFiltered($table, $select, $where, $column_order, $column_search, $order, $join = NULL, $like = null, $notlike = null)
    {
        $this->selectField($table, $select, $where, $column_order, $column_search, $order, $join, $like, $notlike);
        return $this->builder->countAllResults();
    }

    public function countAll($table)
    {
        $this->builder = $this->db->table($table);
        return $this->builder->countAllResults();
    }
}
