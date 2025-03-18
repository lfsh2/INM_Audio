<?php

namespace App\Controllers;

use App\Models\IEMCustomizationModel;
use CodeIgniter\HTTP\ResponseInterface;

class IEMCustomizationController extends BaseController
{
    public function saveDesign()
    {
        $request = $this->request->getJSON();

        $data = [
            'user_id'        => session()->get('user_id'), 
            'left_color'     => $request->leftColor,
            'right_color'    => $request->rightColor,
            'left_texture'   => $request->leftTexture,
            'right_texture'  => $request->rightTexture,
            'material'       => $request->material,
            'size'           => $request->size,
            'category'       => $request->category,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s') 
        ];

        $model = new IEMCustomizationModel();
        if ($model->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Design saved successfully!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save design.']);
        }
    }
    public function myDesign()
    {
        $model = new IEMCustomizationModel();
        $userId = session()->get('user_id'); 

        $data['designs'] = $model->where('user_id', $userId)->findAll();

        return view('UserSide/my_designs', $data);
    }

}
