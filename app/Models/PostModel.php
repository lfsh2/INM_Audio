<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'user_name', 'post_text', 'image_url', 'status', 'created_at'];
    
    public function getPendingPosts()
    {
        return $this->where('status', 'pending')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getApprovedPosts()
    {
        return $this->where('status', 'approved')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}