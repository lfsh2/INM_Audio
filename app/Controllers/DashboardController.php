<?php

namespace App\Controllers;

use App\Models\Admin_Account_Model;
use App\Models\GearModel;
use App\Models\OrderModel;
use App\Models\Placed_Orders_Model;

class DashboardController extends BaseController
{
    public function index()
    {
        $adminAccountModel = new Admin_Account_Model();
        $gearModel = new GearModel();
        $orderModel = new OrderModel();
        $placedOrdersModel = new Placed_Orders_Model();

        $data = [
            'adminAccount'    => $adminAccountModel->getUser('admin_account_id', session()->get('admin_id')),
            'numberItems'     => $gearModel->countAllGears(),
            'totalOrders'     => $orderModel->getTotalOrders(),
            'totalPlaced'     => $placedOrdersModel->getTotalPlaced()->totalPlacedOrders ?? 0,
            'totalConfirmed'  => $orderModel->getTotalConfirmed(),
            'totalCancelled'  => $orderModel->getTotalCancelled(),
            'totalComplete'   => $orderModel->getTotalComplete(),
            'totalRevenue'    => $orderModel->getTotalRevenue(),
            'recentOrders'    => $placedOrdersModel->getAllOrders()
        ];

        return view('AdminSide/dashboard', $data);
    }
}
