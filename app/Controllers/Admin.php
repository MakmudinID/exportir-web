<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        //Profil
        $data['title'] = 'Admin | Profil';
        $data['js'] = array("admin-profil.js?r=" . uniqid());
        $data['main_content']   = 'admin/profil';
        echo view('template/adminlte', $data);
    }

    public function reseller()
    {
        //Reseller
        $data['title'] = 'Admin | Reseller';
        $data['js'] = array("admin-reseller.js?r=" . uniqid());
        $data['main_content']   = 'admin/reseller';
        echo view('template/adminlte', $data);
    }

    public function reseller_()
    {
    }

    public function umkm()
    {
        //UMKM
        $data['title'] = 'Admin | UMKM';
        $data['js'] = array("admin-umkm.js?r=" . uniqid());
        $data['main_content']   = 'admin/umkm';
        echo view('template/sb-admin', $data);
    }

    public function umkm_()
    {
    }

    public function produk()
    {
        //Produk management
        $data['title'] = 'Admin | Produk';
        $data['js'] = array("admin-produk.js?r=" . uniqid());
        $data['main_content']   = 'admin/produk';
        echo view('template/sb-admin', $data);
    }

    public function produk_()
    {
    }

    public function create_user()
    {
        $photo = $this->request->getFile('photo');

        $data['role']   = htmlspecialchars($this->request->getPost('role'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['email']  = htmlspecialchars($this->request->getPost('email'), ENT_QUOTES);
        $data['no_hp']  = htmlspecialchars($this->request->getPost('no_hp'), ENT_QUOTES);
        $options = [
            'cost' => 10,
        ];
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $data['password'] = $password_hash;
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($photo->getName() != '') {
            $photo->move('../public/assets/photo-user/', $photo->getName());
            $filepath = base_url() . '/assets/photo-user/' . $photo->getName();
            $path = $photo->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = base_url('/assets/admin/img/avatar5.png');
        }

        $table = 'tbl_pengguna';
        $result = $this->server_side->createRows($data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function update_user()
    {
        $id = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        $photo = $this->request->getFile('photo');
        $photo_ = $this->request->getPost('photo_');

        $data['role']   = htmlspecialchars($this->request->getPost('role'), ENT_QUOTES);
        $data['nama']   = htmlspecialchars($this->request->getPost('nama'), ENT_QUOTES);
        $data['email']  = htmlspecialchars($this->request->getPost('email'), ENT_QUOTES);
        $data['no_hp']  = htmlspecialchars($this->request->getPost('no_hp'), ENT_QUOTES);
        $options = [
            'cost' => 10,
        ];
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $data['password'] = $password_hash;
        $data['status']  = htmlspecialchars($this->request->getPost('status'), ENT_QUOTES);
        $data['create_user'] = session()->get('nama');
        $data['create_date'] = date('Y-m-d H:i:s');

        $r['result'] = true;

        if ($photo->getName() != '') {
            $photo->move('../public/assets/photo-user/', $photo->getName());
            $filepath = base_url() . '/assets/photo-user/' . $photo->getName();
            $path = $photo->getName();
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'svg' || $ext == 'gif') {
                $data['foto'] = $filepath;
            } else {
                $r['result'] = false;
                $r['title'] = 'Gagal!';
                $r['icon'] = 'error';
                $r['status'] = 'Format File Tidak Diijinkan!';
            }
        } else {
            $data['foto'] = $photo_;
        }

        $table = 'tbl_pengguna';
        $result = $this->server_side->updateRows($id, $data, $table);

        if (!$result) {
            $r['result'] = false;
            $r['title'] = 'Maaf Gagal Menyimpan!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Simpan! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
        return;
    }

    public function delete_user()
    {
        $table = 'tbl_pengguna';
        $id_ = htmlspecialchars($this->request->getPost('id'), ENT_QUOTES);
        if ($this->server_side->deleteRows($id_, $table)) {
            $r['title'] = 'Sukses!';
            $r['icon'] = 'success';
            $r['status'] = 'Berhasil di Hapus!';
        } else {
            $r['title'] = 'Maaf!';
            $r['icon'] = 'error';
            $r['status'] = '<br><b>Tidak dapat di Hapus! <br> Silakan hubungi Administrator.</b>';
        }
        echo json_encode($r);
    }

    public function user()
    {
        $data['title'] = 'Admin | User';
        $data['js'] = array("admin-user.js?r=" . uniqid());
        $data['main_content']   = 'admin/user';
        echo view('template/adminlte', $data);
    }

    public function user_()
    {
        $table = 'tbl_pengguna';
        $select = '*';
        $join = NULL;
        $where = array();
        $column_order = array(NULL, 'foto', 'nama', 'email', 'role', 'status');
        $column_search = array('nama', 'email');
        $order = array('role' => 'desc');

        $list = $this->server_side->limitRows($table, $select, $where, $column_order, $column_search, $order, $join);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row['no'] = $no;
            $row['photo'] = '<img src="' . $field->foto . '" class="img-fluid">';
            $row['nama'] = $field->nama;
            $row['email'] = $field->email;
            $row['role'] = $field->role;
            $row['status'] = ($field->status == 'ACTIVE') ? $field->status : $field->status;
            $row['aksi'] = '<div class="d-flex justify-content-center align-items-center">
            <div class="text-warning align-items-center text-decoration-none edit mr-1" data-id="' . $field->id . '" data-nama="' . $field->nama . '" data-email="' . $field->email . '" data-no_hp="' . $field->no_hp . '" data-role="' . $field->role . '" data-status="' . $field->status . '" data-photo="' . $field->foto . '" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</div>
            <div class="text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-nama="' . $field->nama . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
      </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table, $select, $where, $column_order, $column_search, $order, $join),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $where, $column_order, $column_search, $order, $join),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function modul()
    {
        //Modul Management
        $data['title'] = 'Admin | Modul';
        $data['js'] = array("admin-modul.js?r=" . uniqid());
        $data['main_content']  = 'admin/modul';
        echo view('template/sb-admin', $data);
    }

    public function modul_()
    {
        $column_order = array('program.nama', 'program.judul', 'layanan.nama', 'program_kategori.nama', 'program.target_dana');
        $column_search = array('program.nama', 'program.judul');
        $order = array('program.create_date' => 'desc');

        $table = 'modul';
        $select = '*';
        $join = array();
        $whereIn = array();
        $like = array();
        $notlike = array();

        $list = $this->server_side->limitRows($table, $select, $whereIn, $column_order, $column_search, $order, $join, $like, $notlike);
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $field) {
            $row = array();
            $no++;
            $row['no'] = $no;
            $row['nama'] = $field->modul;
            $row['group'] = $field->groups;
            $row['status'] = ($field->status == 'ACTIVE') ? '<span class="badge bg-primary">' . $field->status . '</span>' : '<span class="badge bg-danger">' . $field->status . '</span>';
            $row['action'] = '<div class="d-flex justify-content-center align-items-center">
                                <a href="' . base_url() . '/data/edit-program/" class="text-warning align-items-center text-decoration-none" role="button"><i class="fa fa-pencil-alt mr-1"></i> Edit</a>
                                <div class="ms-2 text-danger align-items-center delete" role="button" data-id="' . $field->id . '" data-modul="' . $field->modul . '"><i class="fa fa-trash-alt mr-1"></i> Delete</div>
                              </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $this->server_side->countAll($table),
            "recordsFiltered" => $this->server_side->countFiltered($table, $select, $whereIn, $column_order, $column_search, $order, $join, $like, $notlike),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
