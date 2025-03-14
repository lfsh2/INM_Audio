<?php

namespace App\Models;

use CodeIgniter\Model;

class IemModel extends Model
{
    protected $table = 'products';  // Your IEM table
    protected $primaryKey = 'product_id';
    protected $allowedFields = [
        'product_id',
        'category_id',
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'image_url'
    ];
}
