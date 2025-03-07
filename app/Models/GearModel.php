<?php

namespace App\Models;

use CodeIgniter\Model;

class GearModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $allowedFields = ['category_id', 'product_name', 'description', 'price', 'stock_quantity', 'image_url'];

    public function getGearWithSpecs($product_id)
    {
        return $this->db->table('products')
            ->select('products.*, product_specs.driver_type, product_specs.cable_type, product_specs.frequency_range')
            ->join('product_specs', 'products.product_id = product_specs.product_id', 'left') 
            ->where('products.product_id', $product_id)
            ->get()
            ->getRowArray();
    }
}
