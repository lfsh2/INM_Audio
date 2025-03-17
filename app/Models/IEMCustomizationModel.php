<?php

namespace App\Models;

use CodeIgniter\Model;

class IEMCustomizationModel extends Model
{
    protected $table      = 'iem_customizations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'left_color',
        'right_color',
        'left_texture',
        'right_texture',
        'uploaded_image',
        'captured_image',
        'material',
        'size',
        'category',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
