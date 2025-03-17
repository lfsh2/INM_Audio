<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    public function orderTransactions()
    {
        $orderModel = new OrderModel();

        $data = [
            'confirmOrder'      => $orderModel->getConfirmedOrders(),
            'orders'            => $orderModel->getAllOrders(),
            'complete'          => $orderModel->getCompletedOrders(),
            'cancelledOrders'   => $orderModel->getCancelledOrders()
        ];

        return view('Admin/orderTransactions', $data);
    }

    public function completeOrder($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['order_status' => 'complete', 'date_completed' => date('Y-m-d')]);
        return redirect()->to('/admin/orders_transactions')->with('success', 'Order marked as completed!');
    }

    public function cancelOrder($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->update($orderId, ['order_status' => 'cancelled', 'date_cancelled' => date('Y-m-d')]);
        return redirect()->to('/admin/orders_transactions')->with('success', 'Order marked as cancelled!');
    }

    public function deleteOrder($orderId)
    {
        $orderModel = new OrderModel();
        $orderModel->delete($orderId);
        return redirect()->to('/admin/orders_transactions')->with('success', 'Order deleted successfully!');
    }
}
