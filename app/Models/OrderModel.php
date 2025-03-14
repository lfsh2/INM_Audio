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

    public function getCancelledOrdersForUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('order_status', 'cancelled')
                    ->findAll();
    }
    public function getToShipOrdersForUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('order_status', 'to_ship')
                    ->findAll();
    }
    public function getCompleteOrdersForUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('order_status', 'completed')
                    ->findAll();
    }
}
