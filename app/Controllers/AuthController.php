<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function checkLogin()
    {
        $isLoggedIn = session()->get('user_id') ? true : false;

        return $this->response->setJSON(['isLoggedIn' => $isLoggedIn]);
    }
}
