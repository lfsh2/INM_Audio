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

    public function countAllGears()
    {
        return $this->countAll();
    }

    public function getLowStockProducts($threshold = 5)
    {
        return $this->where('stock_quantity <=', $threshold)->findAll();
    }

    public function createLowStockNotification()
    {
        $lowStockProducts = $this->getLowStockProducts(5);

        foreach ($lowStockProducts as $product) {
            $notificationExist = $this->db->table('notifications')
                                          ->where('status', 'unread')
                                          ->where('message', "Stock for product {$product['product_name']} is below 5.")
                                          ->countAllResults();

            if ($notificationExist == 0) {
                $this->db->table('notifications')->insert([
                    'status' => 'unread',
                    'message' => "Stock for product {$product['product_name']} is below 5.",
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
