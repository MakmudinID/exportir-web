<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $q;
    protected $up;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->db = db_connect();
    }

	public function is_login()
	{
		$username = session()->get('id');
		$role = session()->get('role');
		if($username == "" || $role == "")
		{
			$alert='<div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-warning"></i> Access Dennied!</h5>
                        Silahkan login atau daftar terlebih dahulu.
                    </div>';
            session()->setFlashdata('message', $alert);
            return redirect()->to('login');
		}
	}
}