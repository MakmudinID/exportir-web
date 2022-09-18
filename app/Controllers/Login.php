<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function daftar()
    {
        return view('daftar-akun');
    }

    public function daftar_()
    {
        $data['nama']  = $this->request->getPost('nama');
        $data['email'] = $this->request->getPost('email');
        $password_hash =  password_hash(htmlspecialchars($this->request->getPost('password'), ENT_QUOTES), PASSWORD_BCRYPT, $options);
        $data['password'] = $password_hash;
        $data['no_hp'] = $this->request->getPost('no_hp');
        $data['role']  = $this->request->getPost('role');
        $data['status'] = 'ACTIVE';
    
        $val = $this->validate(
            [
                'nama' => 'required',
                'email' => 'required|valid_email',
                'password' => 'required',
                'no_hp' => 'required',
                'role' => 'required'
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
                ]
            ]
        );

        if ($val) {
            $result = $this->server_side->verify_daftar($data['email']);
            if ($result) {
                $create = $this->server_side->createRows($data, 'tbl_pengguna');
                if($create){
                    $alert='<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-info"></i> Berhasil Daftar!</h5>
                                Silahkan login dengan akun yang anda buat.
                            </div>';
                    session()->setFlashdata('message', $alert);
                    return redirect()->to('login');
                }else{
                    $alert='<div class="alert alert-info alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-info"></i> Gagal Daftar!</h5>
                                Silahkan ulangi proses daftar
                            </div>';
                    session()->setFlashdata('message', $alert);
                    return redirect()->to('daftar-akun');
                }
            } else {
                $alert='<div class="alert alert-warning alert-dismissible">
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
                if($result['role'] == 'SUPERADMIN'){
                    return redirect()->to('/admin/dashboard');
                }else if($result['role'] == 'UMKM'){
                    return redirect()->to('/umkm/dashboard');
                }else{
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
        session()->destroy();
        return redirect()->route('login');
    }
}
