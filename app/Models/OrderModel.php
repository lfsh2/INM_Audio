<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    protected $allowedFields = [
        'user_id', 'product_id', 'order_status', 'quantity', 'price', 
        'payment_method', 'delivery_date', 'date_completed',
        'date_returned', 'date_cancelled', 'created_at'
    ];

    protected $useTimestamps = false;  

    // ✅ Total Orders
    public function getTotalOrders()
    {
        return $this->countAll();
    }

    // ✅ Total Confirmed Orders
    public function getTotalConfirmed()
    {
        return $this->where('order_status', 'confirmed')->countAllResults();
    }

    // ✅ Total Cancelled Orders
    public function getTotalCancelled()
    {
        return $this->where('order_status', 'cancelled')->countAllResults();
    }

    // ✅ Total Completed Orders
    public function getTotalComplete()
    {
        return $this->where('order_status', 'completed')->countAllResults();
    }

    // ✅ Total Revenue from Completed Orders
    public function getTotalRevenue() {
        return $this->select('SUM(quantity * price) AS totalRevenue')
                    ->where('order_status', 'completed')
                    ->get()
                    ->getRow()
                    ->totalRevenue ?? 0;
    }
    

    // ✅ Recent Orders (Limit 5)
    public function getRecentOrders($limit = 5)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    public function getOrdersByMonth($month) {
        return $this->where('MONTH(created_at)', $month)
                    ->countAllResults();
    }
    
    
    public function getRevenueByMonth($month) {
        return $this->selectSum('total_price')
                    ->where('MONTH(date_placed)', $month)
                    ->get()->getRow()->total_price ?? 0;
    }
    
}
