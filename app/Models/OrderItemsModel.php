<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemsModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';

    protected $allowedFields = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    protected $useTimestamps = false;

    public function getItemsByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }
}
