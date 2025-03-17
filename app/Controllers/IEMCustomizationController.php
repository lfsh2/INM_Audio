<?php

namespace App\Controllers;

use App\Models\IEMCustomizationModel;
use CodeIgniter\Controller;

class IEMCustomizationController extends Controller
{
    public function saveCustomization()
    {
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'You must log in to save your customization.']);
        }

        $model = new IEMCustomizationModel();

        $data = [
            'user_id'         => session()->get('user_id'),
            'left_color'      => $this->request->getPost('left_color'),
            'right_color'     => $this->request->getPost('right_color'),
            'left_texture'    => $this->request->getPost('left_texture'),
            'right_texture'   => $this->request->getPost('right_texture'),
            'material'        => $this->request->getPost('material'),
            'size'            => $this->request->getPost('size'),
            'category'        => $this->request->getPost('category'),
        ];

        $uploadedImage = $this->request->getFile('uploaded_image');
        if ($uploadedImage && $uploadedImage->isValid() && !$uploadedImage->hasMoved()) {
            $newName = $uploadedImage->getRandomName();
            $uploadedImage->move('uploads/customizations/', $newName);
            $data['uploaded_image'] = 'uploads/customizations/' . $newName;
        }

        $capturedImage = $this->request->getFile('captured_image');
        if ($capturedImage && $capturedImage->isValid() && !$capturedImage->hasMoved()) {
            $designName = 'design_' . time() . '.png';
            $capturedImage->move('uploads/designs/', $designName);
            $data['captured_image'] = 'uploads/designs/' . $designName;
        }

        if ($model->insert($data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save customization.']);
        }
    }
}
