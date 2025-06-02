<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    
    protected $allowedFields = [
        'product_name', 'description', 'price', 'stock_quantity', 
        'category_id', 'image_url', 'created_at', 'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getProductsWithLowStock($threshold = 5)
    {
        return $this->where('stock_quantity <', $threshold)
                    ->findAll();
    }
    
    public function getProductsByCategory($categoryId)
    {
        return $this->where('category_id', $categoryId)
                    ->findAll();
    }
    
    public function getProductDetails($productId)
    {
        return $this->where('product_id', $productId)
                    ->first();
    }
    
    public function searchProducts($keyword)
    {
        return $this->like('product_name', $keyword)
                    ->orLike('description', $keyword)
                    ->findAll();
    }
}
