<?php

namespace App\Models;

use CodeIgniter\Model;

class IEMCustomizationModel extends Model
{
    protected $table = 'iem_customizations';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'design_name', 'left_color', 'right_color', 
        'left_faceplate_color', 'right_faceplate_color',
        'left_texture', 'right_texture', 
        'left_faceplate_texture', 'right_faceplate_texture',
        'material', 'size', 'category', 'uploaded_image', 
        'created_at', 'updated_at', 'shipping_name', 'shipping_phone', 'shipping_address'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
