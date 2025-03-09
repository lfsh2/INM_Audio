<?php

namespace App\Models;

use CodeIgniter\Model;

class IEMCustomizationModel extends Model
{
    protected $table = 'iem_customizations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'left_texture', 'right_texture', 'uploaded_image', 'created_at'];
}
