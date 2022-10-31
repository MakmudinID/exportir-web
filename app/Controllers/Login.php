<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
        helper(['url', 'form', 'array']);
    }

    public function index()
    {
        return view('login');
    }

    public function daftar()
    {
        $data['kategori_umkm'] = $this->db->query('select * from tbl_kategori_umkm')->getResult();
        $data['propinsi'] = $this->server_side->getPropinsi();
        $data['kota'] = $this->server_side->getKotaAll();
        return view('daftar-akun', $data);
    }

    public function daftar_()
    {
        $role = $this->request->getPost('role');
        $kategori_umkm = $this->request->getPost('kategori_umkm');
        $nama = $this->request->getPost('nama');
        $nama_umkm = $this->request->getPost('nama_umkm');
        $deskripsi_umkm = $this->request->getPost('deskripsi_umkm');
        $provinsi = $this->request->getPost('provinsi');
        $kota = $this->request->getPost('kota');
        $no_hp = $this->request->getPost('no_hp');
        $alamat = $this->request->getPost('alamat');

        $tbl_pengguna['nama']  = $nama;
        $tbl_pengguna['email'] = $this->request->getPost('email');
        $options = [
            'cost' => 10,
        ];
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $tbl_pengguna['password'] = $password_hash;
        $tbl_pengguna['no_hp'] = $no_hp;
        $tbl_pengguna['role']  = $role;
        $tbl_pengguna['status'] = 'ACTIVE';
        $tbl_pengguna['alamat'] = $alamat;
        $tbl_pengguna['id_propinsi'] = $provinsi;
        $tbl_pengguna['id_kota'] = $kota;
        $tbl_pengguna['create_user'] = $nama;
        $tbl_pengguna['create_date'] = date('Y-m-d H:i:s');

        $val = $this->validate(
            [
                'nama' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required',
                'no_hp' => 'required',
                'role' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kota' => 'required',
            ],
            [
                'email' => [
                    'required' => 'You must have username',
                    'valid_email' => 'You must have valid email'
                ],
                'password' => [
                    'required' => 'You must have password'
                ],
                'nama' => [
                    'required' => 'You must have nama'
                ],
                'no_hp' => [
                    'required' => 'You must have nomor handphone'
                ],
                'role' => [
                    'required' => 'You must have role'
                ],
                'alamat' => [
                    'required' => 'You must have alamat'
                ],
                'provinsi' => [
                    'required' => 'You must have provinsi'
                ],
                'kota' => [
                    'required' => 'You must have kota'
                ]
            ]
        );

        if ($val) {
            $result = $this->server_side->verify_daftar($tbl_pengguna['email']);
            if ($result) {
                $id_pengguna = $this->server_side->createRowsReturnID($tbl_pengguna, 'tbl_pengguna');

                if ($id_pengguna != '') {
                    if ($role == 'UMKM') {
                        $tbl_umkm['id_pengguna'] = $id_pengguna;
                        $tbl_umkm['id_kategori'] = $kategori_umkm;
                        $tbl_umkm['nama'] = $nama_umkm;
                        $tbl_umkm['alamat'] = $alamat;
                        $tbl_umkm['no_telepon'] = $no_hp;
                        $tbl_umkm['slug'] = strtolower(url_title($nama_umkm));
                        $tbl_umkm['city_id'] = $kota;
                        $tbl_umkm['province_id'] = $provinsi;
                        $tbl_umkm['deskripsi'] = $deskripsi_umkm;
                        $tbl_umkm['status'] = 'ACTIVE';
                        $tbl_umkm['create_user'] = $nama;
                        $tbl_umkm['create_date'] = date('Y-m-d H:i:s');

                        $this->server_side->createRows($tbl_umkm, 'tbl_umkm');
                    }

                    $alert = '<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-info"></i> Berhasil Daftar!</h5>
                                Silahkan login dengan akun yang anda buat.
                            </div>';
                    session()->setFlashdata('message', $alert);
                    return redirect()->to('login');
                } else {
                    $alert = '<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-info"></i> Gagal Daftar!</h5>
                                Silahkan ulangi proses daftar
                            </div>';
                    session()->setFlashdata('message', $alert);
                    return redirect()->to('daftar-akun');
                }
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-info"></i> Gagal Daftar!</h5>
                            Alamat email sudah terdaftar
                        </div>';
                session()->setFlashdata('message', $alert);
                return redirect()->to('daftar-akun');
            }
        } else {
            $data['validation'] = $this->validator;
            echo view('login', $data);
        }
    }

    public function proses()
    {
        $email   = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        $val = $this->validate(
            [
                'email' => 'required|valid_email',
                'password' => 'required',
            ],
            [
                'email' => [
                    'required' => 'You must have username',
                    'valid_email' => 'You must have valid email'
                ],
                'password' => [
                    'required' => 'You must have password'
                ]
            ]
        );

        if ($val) {
            $result = $this->server_side->verify($email, $password);
            if ($result) {
                session()->set($result);
                if ($result['role'] == 'SUPERADMIN') {
                    return redirect()->to('/admin/dashboard');
                } else if ($result['role'] == 'UMKM') {
                    return redirect()->to('/umkm/dashboard');
                } else {
                    return redirect()->to('/');
                }
            } else {
                $data['error'] = 'Could not enter, please contact your administrator';
                echo view('login', $data);
            }
        } else {
            $data['validation'] = $this->validator;
            echo view('login', $data);
        }
    }

    public function logout()
    {
        $data['logout_date'] = date('Y-m-d H:i:s');
        $this->server_side->updateRows(session()->get('id'), $data, 'tbl_pengguna');

        session()->destroy();
        return redirect()->route('login');
    }
}
