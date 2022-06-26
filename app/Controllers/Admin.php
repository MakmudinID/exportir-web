<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        //dashboard
        return view('welcome_message');
    }
}
