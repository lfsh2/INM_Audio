<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use App\Models\OrderModel;
use App\Models\IEMCustomizationModel;
use App\Models\User_Account_Model;

class CustomizationPaymentController extends Controller
{
    public function checkout()
{
    $userId = session()->get('user_id');
    $designId = $this->request->getPost('design_id');
    $price = $this->request->getPost('price');
    
    if (!$userId || !$designId || !$price) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Missing required fields.']);
    }
    
    $db = \Config\Database::connect();
    $query = $db->query("SELECT * FROM user_accounts WHERE user_id = {$userId}");
    $userData = $query->getRowArray();
    
    if (!$userData) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'User profile not found.']);
    }
    
    $fullname = $userData['firstname'] . ' ' . $userData['lastname'];
    $phone = $userData['phone_number'] ?? '';
    $address = $userData['address'] ?? '';
    
    $completeAddress = $address;
    if (!empty($userData['city_municipality'])) {
        $completeAddress .= ', ' . $userData['city_municipality'];
    }
    if (!empty($userData['zipcode'])) {
        $completeAddress .= ', ' . $userData['zipcode'];
    }
    if (!empty($userData['country'])) {
        $completeAddress .= ', ' . $userData['country'];
    }
    
    $orderModel = new OrderModel();
    
    $query = $db->query("SELECT * FROM iem_customizations WHERE id = {$designId}");
    $customizationData = $query->getRowArray();
    
    if (!$customizationData) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Customization not found.']);
    }
    
    $orderReference = 'CUSTOM-' . strtoupper(substr(md5(uniqid()), 0, 8)) . '-' . date('Ymd');
    
    $designName = $customizationData['design_name'] ?? 'Custom IEM';
    $category = $customizationData['category'] ?? 'Standard';
    
    $orderData = [
        'user_id'        => $userId,
        'product_id'     => $designId,
        'order_status'   => 'pending',
        'quantity'       => 1,
        'price'          => $price,
        'payment_method' => 'PayMongo',
        'created_at'     => date('Y-m-d H:i:s'),
        'shipping_name'  => $fullname,
        'shipping_phone' => $phone,
        'shipping_address' => $completeAddress,
        'is_custom_iem'  => 1,
        'order_ref'      => $orderReference,
        'custom_details' => json_encode([
            'design_name' => $designName,
            'category' => $category,
            'left_color' => $customizationData['left_color'] ?? '',
            'right_color' => $customizationData['right_color'] ?? '',
            'left_faceplate_color' => $customizationData['left_faceplate_color'] ?? '',
            'right_faceplate_color' => $customizationData['right_faceplate_color'] ?? '',
            'left_texture' => $customizationData['left_texture'] ?? '',
            'right_texture' => $customizationData['right_texture'] ?? '',
            'left_faceplate_texture' => $customizationData['left_faceplate_texture'] ?? '',
            'right_faceplate_texture' => $customizationData['right_faceplate_texture'] ?? '',
            'material' => $customizationData['material'] ?? '',
            'size' => $customizationData['size'] ?? '',
            'order_reference' => $orderReference
        ])
    ];
    
    $orderId = $orderModel->insert($orderData);

    try {
        $priceInCents = (int) ($price * 100);
        
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://api.paymongo.com/v1/checkout_sessions', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('sk_test_gjaFGtP5ZHPVJjbTtqbRcVVK:'),  
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'data' => [
                    'attributes' => [
                        'line_items' => [
                            [
                                'name'     => "Custom IEM: {$designName} ({$category})",
                                'amount'   => $priceInCents,
                                'currency' => 'PHP',
                                'quantity' => 1
                            ]
                        ],
                        'payment_method_types' => ['gcash', 'card'],
                        'success_url' => base_url('/customization/checkout/success/' . $orderId),
                        'cancel_url'  => base_url('/customization/checkout/cancel/' . $orderId),
                        'reference_number' => $orderReference
                    ]
                ]
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data']['attributes']['checkout_url'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'redirect_url' => $result['data']['attributes']['checkout_url'],
                'order_id' => $orderId,
                'reference' => $orderReference
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Payment gateway error. Please try again.'
            ]);
        }

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => 'Payment processing failed. Please try again.'
        ]);
    }
}


    
public function success($orderId)
{
    $orderModel = new OrderModel();
    $order = $orderModel->find($orderId);
    
    if (!$order) {
        return redirect()->to('/')->with('error', 'Order not found.');
    }
    
    if ($order['order_status'] === 'pending') {
        $orderModel->update($orderId, [
            'order_status'   => 'to ship', 
            'date_completed' => date('Y-m-d H:i:s')
        ]);
        
        log_message('info', 'Custom IEM order payment successful: Order ID {orderId}', ['orderId' => $orderId]);
    }
    
    $customDetails = json_decode($order['custom_details'] ?? '{}', true);
    $designName = $customDetails['design_name'] ?? 'Custom IEM';
    $orderReference = $customDetails['order_reference'] ?? '';
    
    return view('UserSide/checkout_success', [
        'order_id' => $orderId,
        'design_name' => $designName,
        'order_reference' => $orderReference,
        'price' => $order['price'],
        'date' => date('Y-m-d H:i:s')
    ]);
}

public function cancel($orderId)
{
    $orderModel = new OrderModel();
    $order = $orderModel->find($orderId);
    
    if (!$order) {
        return redirect()->to('/')->with('error', 'Order not found.');
    }
    
    if ($order['order_status'] === 'pending') {
        $orderModel->update($orderId, [
            'order_status'   => 'cancelled',
            'date_cancelled' => date('Y-m-d H:i:s')
        ]);
        
        log_message('info', 'Custom IEM order payment cancelled: Order ID {orderId}', ['orderId' => $orderId]);
    }
    
    $customDetails = json_decode($order['custom_details'] ?? '{}', true);
    $designName = $customDetails['design_name'] ?? 'Custom IEM';
    $orderReference = $customDetails['order_reference'] ?? '';
    
    return view('UserSide/checkout_cancel', [
        'order_id' => $orderId,
        'design_name' => $designName,
        'order_reference' => $orderReference
    ]);
}

public function getUserDetails($user_id)
{
    $userModel = new User_Account_Model();  
    $userData = $userModel->getUserNameAndAddress($user_id);

    $user_name = $userData ? $userData['firstname'] . ' ' . $userData['lastname'] : '';
    $address = $userData['address'] ?? '';
    $city_municipality = $userData['city_municipality'] ?? '';
    $zipcode = $userData['zipcode'] ?? '';
    $country = $userData['country'] ?? '';

    $full_address = trim($address . ' ' . $city_municipality . ' ' . $zipcode . ' ' . $country);

    return [
        'user_name' => $user_name,
        'user_address' => $full_address,
    ];
}

public function myDesigns()
{
    $user_id = session()->get('user_id'); 
    $userModel = new User_Account_Model(); 
    $userData = $userModel->where('user_id', $user_id)->first();

    if ($userData) {
        if (is_object($userData)) {
            $userData = (array) $userData;
        }
        
        $profileFields = [
            'firstname', 'lastname', 'phone_number', 'address',
            'city_municipality', 'country', 'zipcode'
        ];
        
        foreach ($profileFields as $field) {
            if (isset($userData[$field])) {
                session()->set($field, $userData[$field]);
            }
        }
        
        $data['user_name'] = $userData['firstname'] . ' ' . $userData['lastname'];
        $data['user_address'] = $userData['address'];
        $data['user_phone'] = $userData['phone_number'];
        $data['user_data'] = $userData; 
    } else {
        $data['user_name'] = '';
        $data['user_address'] = '';
        $data['user_phone'] = '';
        $data['user_data'] = null;
    }

    return view('UserSide/my_designs', $data);
}

public function checkUserData()
{
    $user_id = session()->get('user_id');
    if (!$user_id) {
        return $this->response->setJSON(['error' => 'No user logged in']);
    }
    
    $userModel = new User_Account_Model();
    
    $results = [
        'getUserById' => $userModel->getUserById($user_id),
        'find' => $userModel->find($user_id),
        'where' => $userModel->where('user_id', $user_id)->first(),
        'session' => [
            'user_id' => session()->get('user_id'),
            'firstname' => session()->get('firstname'),
            'lastname' => session()->get('lastname'),
            'phone_number' => session()->get('phone_number'),
            'address' => session()->get('address'),
            'city_municipality' => session()->get('city_municipality'),
            'country' => session()->get('country'),
            'zipcode' => session()->get('zipcode')
        ]
    ];
    
    $db = \Config\Database::connect();
    $directQuery = $db->query("SELECT * FROM user_accounts WHERE user_id = {$user_id}");
    $directResult = $directQuery->getResultArray();
    
    $results['direct_query'] = $directResult;
    
    $tableInfo = $db->query("DESCRIBE user_accounts")->getResultArray();
    $results['table_structure'] = $tableInfo;
    
    return $this->response->setJSON($results);
}



}
