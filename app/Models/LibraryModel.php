<?php

namespace App\Models;

use CodeIgniter\Model;

class LibraryModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $allowedFields = ['category_id', 'product_name', 'description', 'price', 'stock_quantity', 'image_url'];

    public function getCategories()
    {
        return $this->db->table('category')->get()->getResultArray();
    }

    public function getCategoryById($category_id)
    {
        return $this->db->table('category')->where('category_id', $category_id)->get()->getRowArray();
    }

    public function getGearsByCategory($category_id)
    {
        return $this->where('category_id', $category_id)->findAll();
    }

    public function getAllGears()
    {
        return $this->findAll();
    }
}
