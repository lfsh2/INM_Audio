<?php

namespace App\Controllers;

use App\Models\Admin_Account_Model;
use App\Models\GearModel;
use App\Models\OrderModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $adminAccountModel = new Admin_Account_Model();
        $gearModel = new GearModel();
        $orderModel = new OrderModel();

        $data = [
            'adminAccount'    => $adminAccountModel->getUser('admin_account_id', session()->get('admin_id')),
            'numberItems'     => $gearModel->countAllGears(),
            'totalOrders'     => $orderModel->getTotalOrders(),
            'totalPending'    => $orderModel->getTotalByStatus('pending'),
            'totalShipped'    => $orderModel->getTotalByStatus('shipped'),
            'totalDelivered'  => $orderModel->getTotalByStatus('delivered'),
            'totalCancelled'  => $orderModel->getTotalByStatus('cancelled'),
            'totalRevenue'    => $orderModel->getTotalRevenue(),
            'recentOrders'    => $orderModel->getRecentOrders(5)
        ];

        return view('AdminSide/dashboard', $data);
    }
}
