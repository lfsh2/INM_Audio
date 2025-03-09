<?php

namespace App\Controllers;

use App\Models\IEMCustomizationModel;
use CodeIgniter\Controller;

class IEMCustomizationController extends Controller
{
    public function saveCustomization()
    {
        helper(['form', 'url']);

        $session = session();
        $user_id = $session->get('user_id'); 
        if (!$user_id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not logged in']);
        }

        $model = new IEMCustomizationModel();

        $leftTexture = $this->request->getPost('left_texture');
        $rightTexture = $this->request->getPost('right_texture');

        $uploadedImage = $this->request->getFile('uploaded_image');
        $uploadedImagePath = null;

        if ($uploadedImage && $uploadedImage->isValid() && !$uploadedImage->hasMoved()) {
            $newName = $uploadedImage->getRandomName();
            $uploadedImage->move('uploads/', $newName);
            $uploadedImagePath = 'uploads/' . $newName;
        }

        $data = [
            'user_id' => $user_id,
            'left_texture' => $leftTexture,
            'right_texture' => $rightTexture,
            'uploaded_image' => $uploadedImagePath
        ];

        $model->insert($data);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Customization saved successfully']);
    }
}
