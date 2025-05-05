<?php

namespace App\Controllers;

class ShopController extends BaseController
{
## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- SESSION ----- ##
    private function checkUserSession($path) {
        if($this->isAdmin()) {
            return redirect()->to('/admin/dashboard');
        }
        if($this->isSessionExpired()) {
            $this->deleteCookiesAndSession("user");
            return redirect()->to('/')->with('sessionTimeout', 'Session Timeout, login again');
        }
        return view($path);
    }

## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- ROUTES ----- ##
    // redirect to shop
    public function shop() {
        return $this->checkUserSession('shop/shop');
    }

    public function customize() {
        if(!$this->isUser()) {
            return redirect()->to('/login');
        }
        return redirect()->to('/customize');
    }
}
