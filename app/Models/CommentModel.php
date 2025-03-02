<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'user_name', 'comment_text', 'created_at'];

    public function getCommentsByPostId($post_id)
    {
        return $this->where('post_id', $post_id)->orderBy('created_at', 'DESC')->findAll();
    }
}
