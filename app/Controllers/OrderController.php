<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\IEMCustomizationModel;
use App\Models\User_Account_Model;

class OrderController extends BaseController
{
    public function orderTransactions()
    {
        $orderModel = new OrderModel();

        $data = [
            'confirmOrder'      => $orderModel->getConfirmedOrders(),
            'orders'            => $orderModel->getAllOrders(),
            'complete'          => $orderModel->getCompletedOrders(),
            'cancelledOrders'   => $orderModel->getCancelledOrders(),
            'totalOrders'       => $orderModel->getTotalOrders(),
            'totalCustomIEMOrders' => $orderModel->getTotalCustomIEMOrders(),
            'totalRevenue'      => $orderModel->getTotalRevenue(),
            'totalCustomIEMRevenue' => $orderModel->getTotalCustomIEMRevenue()
        ];

        return view('AdminSide/orders_transactions', $data);
    }
    
    public function dashboard()
    {
        $orderModel = new OrderModel();
        $productModel = new ProductModel();
        $userModel = new User_Account_Model();
        
        // Get monthly data for charts
        $monthlyData = [];
        $monthlyCustomIEMData = [];
        $monthlyRevenue = [];
        $monthlyCustomIEMRevenue = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $orderModel->getOrdersByMonth($i);
            $monthlyCustomIEMData[$i] = $orderModel->getCustomIEMOrdersByMonth($i);
            $monthlyRevenue[$i] = $orderModel->getRevenueByMonth($i);
            $monthlyCustomIEMRevenue[$i] = $orderModel->getCustomIEMRevenueByMonth($i);
        }
        
        $data = [
            'totalOrders' => $orderModel->getTotalOrders(),
            'totalCustomIEMOrders' => $orderModel->getTotalCustomIEMOrders(),
            'totalProducts' => $productModel->countAll(),
            'totalUsers' => $userModel->countAll(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'totalCustomIEMRevenue' => $orderModel->getTotalCustomIEMRevenue(),
            'recentOrders' => $orderModel->getRecentOrders(5),
            'monthlyData' => json_encode(array_values($monthlyData)),
            'monthlyCustomIEMData' => json_encode(array_values($monthlyCustomIEMData)),
            'monthlyRevenue' => json_encode(array_values($monthlyRevenue)),
            'monthlyCustomIEMRevenue' => json_encode(array_values($monthlyCustomIEMRevenue))
        ];
        
        return view('AdminSide/dashboard', $data);
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
    
    public function updateOrderStatus()
    {
        $orderId = $this->request->getPost('order_id');
        $status = $this->request->getPost('order_status');
        
        if (!$orderId || !$status) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing required parameters']);
        }
        
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);
        
        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Order not found']);
        }
        
        $updateData = ['order_status' => $status];
        
        // Add date fields based on status
        if ($status == 'complete') {
            $updateData['date_completed'] = date('Y-m-d H:i:s');
        } else if ($status == 'cancelled') {
            $updateData['date_cancelled'] = date('Y-m-d H:i:s');
        } else if ($status == 'delivered') {
            $updateData['delivery_date'] = date('Y-m-d H:i:s');
        } else if ($status == 'shipped') {
            $updateData['date_shipped'] = date('Y-m-d H:i:s');
        }
        
        $isCustomIEM = false;
        $oldStatus = 'pending';
        
        if (is_array($order)) {
            $isCustomIEM = isset($order['is_custom_iem']) && $order['is_custom_iem'] == 1;
            $oldStatus = $order['order_status'] ?? 'pending';
        } else {
            $isCustomIEM = isset($order->is_custom_iem) && $order->is_custom_iem == 1;
            $oldStatus = $order->order_status ?? 'pending';
        }
        
        $orderType = $isCustomIEM ? 'Custom IEM' : 'Regular';
        
        log_message('info', '{orderType} order status updated: Order ID {orderId}, Old Status: {oldStatus}, New Status: {newStatus}', [
            'orderType' => $orderType,
            'orderId' => $orderId,
            'oldStatus' => $oldStatus,
            'newStatus' => $status
        ]);
        
        if ($orderModel->update($orderId, $updateData)) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Order status updated successfully',
                'order_type' => $orderType,
                'new_status' => $status
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update order status']);
        }
    }
    
    public function viewOrderDetails($orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);
        
        if (!$order) {
            return redirect()->to('/admin/orders_transactions')->with('error', 'Order not found');
        }
        
        // Handle both array and object formats
        $isCustomIEM = false;
        $productId = null;
        $customDetailsJson = '{}';
        
        if (is_array($order)) {
            $isCustomIEM = isset($order['is_custom_iem']) && $order['is_custom_iem'] == 1;
            $productId = $order['product_id'] ?? null;
            $customDetailsJson = $order['custom_details'] ?? '{}';
        } else {
            $isCustomIEM = isset($order->is_custom_iem) && $order->is_custom_iem == 1;
            $productId = $order->product_id ?? null;
            $customDetailsJson = $order->custom_details ?? '{}';
        }
        
        if ($isCustomIEM) {
            $customizationModel = new IEMCustomizationModel();
            $customization = $customizationModel->find($productId);
            $customDetails = json_decode($customDetailsJson, true);
            
            $data = [
                'order' => $order,
                'customization' => $customization,
                'customDetails' => $customDetails
            ];
            
            return view('AdminSide/custom_iem_order_details', $data);
        } else {
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
            
            $data = [
                'order' => $order,
                'product' => $product
            ];
            
            return view('AdminSide/order_details', $data);
        }
    }
}
