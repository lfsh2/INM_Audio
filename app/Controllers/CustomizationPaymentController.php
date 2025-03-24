<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use App\Models\OrderModel;
use App\Models\IEMCustomizationModel;

class CustomizationPaymentController extends Controller
{
    public function checkout()
{
    $userId = session()->get('user_id');
    $designId = $this->request->getPost('design_id');
    $price = $this->request->getPost('price');
    $fullname = $this->request->getPost('fullname');
    $phone = $this->request->getPost('phone');
    $address = $this->request->getPost('address');

    if (!$designId || !$price || !$fullname || !$phone || !$address) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Missing required fields.']);
    }

    $orderModel = new OrderModel();
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
        'shipping_address' => $address
    ];

    // Save Order and Get Order ID
    $orderId = $orderModel->insert($orderData, true);

    try {
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
                                'name'     => 'Customized IEM',
                                'amount'   => (int) ($price * 100),
                                'currency' => 'PHP',
                                'quantity' => 1
                            ]
                        ],
                        'payment_method_types' => ['gcash', 'card'],
                        'success_url' => base_url('/customization/checkout/success/' . $orderId),
                        'cancel_url'  => base_url('/customization/checkout/cancel/' . $orderId)
                    ]
                ]
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['data']['attributes']['checkout_url'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'payment_url' => $result['data']['attributes']['checkout_url']
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid PayMongo response: ' . json_encode($result)
            ]);
        }

    } catch (\Exception $e) {
        log_message('error', 'PayMongo API Error: ' . $e->getMessage());
        return $this->response->setJSON(['status' => 'error', 'message' => 'Payment failed. ' . $e->getMessage()]);
    }
}


    
public function success($orderId)
{
    $orderModel = new OrderModel();

    $orderModel->update($orderId, [
        'order_status'   => 'completed',
        'date_completed' => date('Y-m-d H:i:s')
    ]);

    return view('UserSide/checkout_success', ['order_id' => $orderId]);
}

public function cancel($orderId)
{
    $orderModel = new OrderModel();

    $orderModel->update($orderId, [
        'order_status'   => 'cancelled',
        'date_cancelled' => date('Y-m-d H:i:s')
    ]);

    return view('UserSide/checkout_cancel', ['order_id' => $orderId]);
}

}
