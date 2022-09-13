<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
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
                    return redirect()->to('/umkm/index');
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
