<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
