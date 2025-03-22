<?php

namespace App\Controllers;

use App\Models\IEMCustomizationModel;
use CodeIgniter\HTTP\ResponseInterface;

class IEMCustomizationController extends BaseController
{
    public function saveDesign()
    {
        $request = $this->request->getJSON();
        $userId = session()->get('user_id'); 

        $categoryPrices = [
            'Vanilla Series'  => 13650,
            'Stage Series'    => 16000,
            'Prestige Series' => 60000
        ];

        $category = $request->category;
        $basePrice = isset($categoryPrices[$category]) ? $categoryPrices[$category] : 13650;

        $data = [
            'user_id'        => $userId,
            'design_name'    => $request->designName,
            'left_color'     => $request->leftColor,
            'right_color'    => $request->rightColor,
            'left_texture'   => $request->leftTexture,
            'right_texture'  => $request->rightTexture,
            'material'       => $request->material,
            'size'           => $request->size,
            'category'       => $category,
            'price'          => $basePrice, 
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s') 
        ];

        $model = new IEMCustomizationModel();
        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Design saved successfully!',
                'price' => $basePrice 
            ]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save design.']);
        }
    }

    public function myDesign()
    {
        $model = new IEMCustomizationModel();
        $userId = session()->get('user_id'); 
    
        $categoryPrices = [
            'Vanilla Series'  => 13650,
            'Stage Series'    => 16000,
            'Prestige Series' => 60000
        ];
    
        $designs = $model->where('user_id', $userId)->findAll();
    
        foreach ($designs as &$design) {
            $design['price'] = isset($categoryPrices[$design['category']]) ? $categoryPrices[$design['category']] : 13650;
        }
    
        $data['designs'] = $designs;
    
        return view('UserSide/my_designs', $data);
    }
    public function delete($id)
{
    $designModel = new IEMCustomizationModel();

    $design = $designModel->find($id);
    if (!$design) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Design not found.']);
    }

    if ($designModel->delete($id)) {
        return $this->response->setJSON(['status' => 'success', 'message' => 'Design deleted successfully.']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete the design.']);
    }
}

}
