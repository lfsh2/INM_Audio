<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use GuzzleHttp\Client;
use App\Models\OrderModel;

class PaymentController extends Controller
{
    public function checkout()
    {
        $totalPrice = $this->request->getPost('total_price');
        $totalQuantity = $this->request->getPost('total_quantity');

        if (!$totalPrice || $totalQuantity == 0) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $orderModel = new OrderModel();
        $orderData = [
            'user_id'        => session()->get('user_id'),
            'product_id'     => 0,
            'order_status'   => 'pending',
            'quantity'       => $totalQuantity,
            'price'          => $totalPrice,
            'payment_method' => 'PayMongo',
            'delivery_date'  => null,
            'date_completed' => null,
            'date_returned'  => null,
            'date_cancelled' => null,
            'created_at'     => date('Y-m-d H:i:s')
        ];

        $orderId = $orderModel->insert($orderData, true); 

        try {
            $client = new Client();
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
                                    'name'     => 'Cart Purchase',
                                    'amount'   => (int) ($totalPrice * 100), 
                                    'currency' => 'PHP',
                                    'quantity' => 1
                                ]
                            ],
                            'payment_method_types' => ['gcash', 'card'],
                            'success_url' => base_url('/checkout/success/' . $orderId),
                            'cancel_url'  => base_url('/checkout/cancel/' . $orderId)
                        ]
                    ]
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            return redirect()->to($result['data']['attributes']['checkout_url']);

        } catch (\Exception $e) {
            log_message('error', 'PayMongo API Error: ' . $e->getMessage());
            return redirect()->to('/cart')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function success($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->update($orderId, [
            'order_status'   => 'completed',
            'date_completed' => date('Y-m-d H:i:s')
        ]);

        return view('shop/checkout_success');
    }

    public function cancel($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->update($orderId, [
            'order_status'   => 'cancelled',
            'date_cancelled' => date('Y-m-d H:i:s')
        ]);

        return view('shop/checkout_cancel');
    }
}
