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
        'date_returned', 'date_cancelled', 'created_at','shipping_name', 'shipping_phone', 'shipping_address'
    ];

    protected $useTimestamps = false;  

    public function getTotalOrders()
    {
        return $this->countAll();
    }

    public function getTotalConfirmed()
    {
        return $this->where('order_status', 'delivered')->countAllResults();
    }

    
    public function getTotalCancelled()
    {
        return $this->where('order_status', 'cancelled')->countAllResults();
    }

    public function getTotalComplete()
    {
        return $this->where('order_status', 'completed')->countAllResults();
    }

    public function getTotalRevenue() {
        return $this->select('SUM(quantity * price) AS totalRevenue')
                    ->where('order_status', 'delivered')
                    ->get()
                    ->getRow()
                    ->totalRevenue ?? 0;
    }
    

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
      public function getConfirmedOrders()
      {
          return $this->where('order_status', 'to ship')->findAll();
      }
  
      public function getAllOrders()
      {
          return $this->findAll();
      }
  
      public function getCompletedOrders()
      {
          return $this->where('order_status', 'complete')->findAll();
      }
  
      public function getCancelledOrders()
      {
          return $this->where('order_status', 'cancelled')->findAll();
      }
  
      public function getOrderById($orderId)
      {
          return $this->where('order_id', $orderId)->first();
      }
  }

