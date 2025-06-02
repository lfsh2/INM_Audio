<?php

namespace App\Controllers;

use App\Models\IEMCustomizationModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User_Account_Model;

class IEMCustomizationController extends BaseController
{
    public function saveDesign()
    {
        $request = $this->request->getJSON();
        $userId = session()->get('user_id');
        
        // Check if user is logged in
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'login_required',
                'message' => 'Please login to save your design.'
            ]);
        }

        $categoryPrices = [
            'Vanilla Series'  => 13650,
            'Stage Series'    => 16000,
            'Prestige Series' => 60000
        ];

        $category = $request->category;
        $basePrice = isset($categoryPrices[$category]) ? $categoryPrices[$category] : 13650;

        $data = [
            'user_id'               => $userId,
            'design_name'           => $request->designName,
            'left_color'            => $request->leftColor,
            'right_color'           => $request->rightColor,
            'left_faceplate_color'  => $request->leftFaceplateColor ?? $request->leftColor,
            'right_faceplate_color' => $request->rightFaceplateColor ?? $request->rightColor,
            'left_texture'          => $request->leftTexture,
            'right_texture'         => $request->rightTexture,
            'left_faceplate_texture'  => $request->leftFaceplateTexture ?? $request->leftTexture,
            'right_faceplate_texture' => $request->rightFaceplateTexture ?? $request->rightTexture,
            'material'              => $request->material,
            'size'                  => $request->size,
            'category'              => $category,
            'price'                 => $basePrice, 
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s') 
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
        
        $userModel = new User_Account_Model(); 
        $userData = $userModel->where('user_id', $userId)->first();

        if ($userData) {
            $data['user_name'] = $userData['firstname'] . ' ' . $userData['lastname'];
            $data['user_address'] = $userData['address'];
            $data['user_phone'] = $userData['phone_number'];
        } else {
            $data['user_name'] = '';
            $data['user_address'] = '';
            $data['user_phone'] = '';
        }
    
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

public function getUserDetails($user_id)
{
    $userModel = new User_Account_Model();  
    $userData = $userModel->getUserNameAndAddress($user_id);

    $user_name = $userData ? $userData['firstname'] . ' ' . $userData['lastname'] : '';
    $address = $userData['address'] ?? '';
    $city_municipality = $userData['city_municipality'] ?? '';
    $zipcode = $userData['zipcode'] ?? '';
    $country = $userData['country'] ?? '';

    $full_address = trim($address . ' ' . $city_municipality . ' ' . $zipcode . ' ' . $country);

    return [
        'user_name' => $user_name,
        'user_address' => $full_address,
    ];
}

public function myDesigns()
{
    $user_id = session()->get('user_id'); 
    $userModel = new User_Account_Model(); 
    $userData = $userModel->where('user_id', $user_id)->first();

    if ($userData) {
        $data['user_name'] = $userData['firstname'] . ' ' . $userData['lastname'];
        $data['user_address'] = $userData['address'];
        $data['user_phone'] = $userData['phone_number'];
    } else {
        $data['user_name'] = '';
        $data['user_address'] = '';
        $data['user_phone'] = '';
    }

    return view('UserSide/my_designs', $data);
}


}
