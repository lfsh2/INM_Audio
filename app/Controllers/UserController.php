<?php
namespace App\Controllers;
use App\Models\OrderModel;

class UserController extends BaseController
{
## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- SESSION ----- ##
    private function checkUserSession($path, $data = null) {
        if($this->isAdmin()) {
            return redirect()->to('/admin/dashboard');
        }
        if(!$this->isUser()) {
            return redirect()->to('/');
        }        
        if($this->isSessionExpired()) {
            $this->deleteCookiesAndSession("user");
            return redirect()->to('/')->with('sessionTimeout', 'Session Timeout, login again');
        }
        return view($path, $data);
    }

## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- LOGOUT ----- ##
    ## logout method
    public function logout(){
        $this->load->requireMethod('userAccount');
        helper('cookie');
        
        $user_id = $this->load->session->get('user_id');
        if($user_id) {
            $this->load->userAccount->update($user_id, ['remember_token' => null]);
        }
        
        $this->load->session->destroy();    
        delete_cookie('remember_token');
        return redirect()->to('/');
    }


## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- ROUTES ----- ##
    ## User Setting
    public function userSettings() {
        $this->load->requireMethod('userAccount');
        $data = [
            'userAccount' => $this->load->userAccount->getUser('user_id', $this->load->session->get('user_id'))
        ];
        return $this->checkUserSession('UserSide/userAccount', $data);
    }



    
    public function getOrders() {
        $userId = session()->get('user_id'); 
        $orderModel = new OrderModel();
        $orders = $orderModel->where('user_id', $userId)->findAll();
        return $this->response->setJSON($orders);
    }
    public function manageOrders() {
        $orderModel = new OrderModel();
        $userId = session()->get('user_id');
        
        // Get all orders with product information
        $orders = $orderModel->getUserOrdersWithProducts($userId);
        
        $data = [
            'orders' => $orders
        ];
        
        return $this->checkUserSession('UserSide/manage_orders', $data);
    }
    
    public function fetchOrders()
    {
        $status = $this->request->getPost('order_status');
        
        if (!in_array($status, ['pending', 'shipped', 'delivered', 'cancelled'])) {
            $status = 'pending'; // Default status if invalid
        }
        
        $orderModel = new OrderModel();
        $userId = session()->get('user_id');
        
        // Get filtered orders with product information
        $filteredOrders = $orderModel->getUserOrdersByStatus($userId, $status);
        
        // Include the partial view with filtered orders
        return view('UserSide/orders_partial', [
            'filteredOrders' => $filteredOrders,
            'status' => $status
        ]);
    }
    
    public function cancelOrder()
    {
        $orderId = $this->request->getPost('order_id');
        $orderModel = new OrderModel();
        $userId = session()->get('user_id');
    
        $order = $orderModel->find($orderId);
        
        if (!$order) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Order not found.'
            ]);
        }
        
        if ($order['user_id'] != $userId) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'You do not have permission to cancel this order.'
            ]);
        }
        
        if ($order['order_status'] !== 'pending') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Only pending orders can be cancelled.'
            ]);
        }
    
        $orderModel->update($orderId, [
            'order_status' => 'cancelled',
            'date_cancelled' => date('Y-m-d H:i:s')
        ]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Order cancelled successfully.'
        ]);
    }

    ## User likes
    public function myLikes() {
        $this->load->requireMethod('userAccount');
        $this->load->requireMethod('likes');
        $user_id = $this->load->session->get('user_id');
        $bookmarks = $this->load->likes->getAllProductBookmarks();
        $filteredBookmarks = array_filter($bookmarks, function($bookmark) use ($user_id) {
            return $bookmark['user_id'] === $user_id;
        });
    
        $data = [
            'userAccount' => $this->load->userAccount->getUser('user_id', $this->load->session->get('user_id')),
            'bookmark' => $filteredBookmarks
        ];
        return $this->checkUserSession('UserSide/myLikes', $data);
    }

## ------------------------------------------------------------------------------------------------------------------------------------------------------------------------
## ----- Controller functions ----- ##
    public function updateAccount() {
        $this->load->requireMethod('userAccount');
        $data = [
            'userId' => $this->load->session->get('user_id'),
            'pfp' => $this->request->getFile('pfp'),
            'username' => $this->request->getPost('username'),
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phonenumber'),
            'address' => $this->request->getPost('address'),
            'citymunicipality' => $this->request->getPost('cityMunicipality'),
            'zipcode' => $this->request->getPost('zipcode'),
            'country' =>  $this->request->getPost('country'), 
            'cpass' =>  $this->request->getPost('currentPass'),
            'npass' => $this->request->getPost('newPass') 
        ];
         ## change profile picture
        if(!empty($data['pfp']) && $data['pfp']->isValid()) {
            $dataPfp['profile_pic'] = file_get_contents($data['pfp']->getTempName());
            $this->load->userAccount->update($data['userId'], $dataPfp);
        }
        ## change username
        if(isset($data['username'])) {
            $this->load->userAccount->update($data['userId'], ['username' => $data['username']]);
        }
        ## change firstname
        if(isset($data['firstname'])) {
            $this->load->userAccount->update($data['userId'], ['firstname' => $data['firstname']]);
        }
        ## change lastname
        if(isset($data['lastname'])) {
            $this->load->userAccount->update($data['userId'], ['lastname' => $data['lastname']]);
        }
        ## change email
        if(isset($data['email'])) {
            $this->load->userAccount->update($data['userId'], ['email' => $data['email']]);
        }
        ## change phone number
        if(isset($data['phone'])) {
            $this->load->userAccount->update($data['userId'], ['phone_number' => $data['phone']]);
        }
        ## change home address
        if(isset($data['address'])) {
            $this->load->userAccount->update($data['userId'], ['address' => $data['address']]);
        }
        ## change state/city/municipality
        if(isset($data['citymunicipality'])) {
            $this->load->userAccount->update($data['userId'], ['city_municipality' =>  $data['citymunicipality']] );
        }
        ## change zipcode
        if(isset($data['zipcode'])) {
            $this->load->userAccount->update($data['userId'], ['zipcode'=> $data['zipcode']]);
        }
        ## change country
        if(isset($data['country'])) {
            $this->load->userAccount->update($data['userId'], ['country'=> $data['country']]);
        }
        ## change password
        if($data['cpass'] && $data['npass']) {
            $pass = $this->load->userAccount->getUser('user_id', $data['userId']);
            if(password_verify($data['cpass'], $pass['password'])) {
                if($data['cpass'] == $data['npass']) {
                    $this->load->session->setFlashdata('npassInvalid', '*Password is already in use.');
                    return redirect()->back();
                }

                $hashedPassword = password_hash($data['npass'], PASSWORD_DEFAULT);

                $this->load->userAccount->update($data['userId'], ['password' => $hashedPassword]);
                $this->load->session->setFlashdata('profileUpdated', '*Password Changed successfully.');
                return redirect()->back();
            }
            else {
                $this->load->session->setFlashdata('cpassInvalid', '*Input your current password!');
                return redirect()->back();
            }
        }
        return redirect()->back()->with('profileUpdated', '*Account updated.');
    }


    public function removeToLikes($id) {
        $this->load->requireMethod('userAccount');
        $this->load->requireMethod('likes');
        if($this->load->session->has('isLoggedIn') && $this->load->session->has('user_id')) {
            $user_id = $this->load->session->get('user_id');
            $this->load->likes->where('user_id', $user_id)->where('product_id', $id)->delete();
            return redirect()->to('/user/myLikes');
        }
        return redirect()->to('/login')->with('noAccount', '**Login to your account**');
    }

/*
    public function cancelOrder($productId) {
        $this->load->requireMethod('userAccount');
        $this->load->requireMethod('orders');
        $this->load->requireMethod('placed');

        $placedOrderItem = $this->load->placed->getOrderItemById($productId);
        $dateOfCancellation = date('Y-m-d');
        $this->load->orders->save([
            'user_id' => $this->load->session->get('user_id'),
            'product_id' => $placedOrderItem->product_id,
            'order_status' => "cancelled",
            'quantity' => $placedOrderItem->quantity,
            'price' => $placedOrderItem->total_price,
            'payment_method' => $placedOrderItem->payment_method,
            'date_cancelled' => $dateOfCancellation
        ]);
        $this->load->placed->deleteItemByProductId($productId);
        return redirect()->back()->with('success', 'item canccelled!');
    } */

}


