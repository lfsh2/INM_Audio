<?php

namespace App\Controllers;

use App\Models\LibraryModel;
use CodeIgniter\Controller;
use App\Models\GearModel;

class LibraryController extends Controller
{
    protected $libraryModel;

    public function __construct()
    {
        $this->libraryModel = new LibraryModel();
    }

    // Display library categories
    public function index()
    {
        $data['categories'] = $this->libraryModel->getCategories();
        return view('library', $data);
    }

    public function category($category_id)
    {
        $data['category'] = $this->libraryModel->getCategoryById($category_id);
        $data['gears'] = $this->libraryModel->getGearsByCategory($category_id);

        if (!$data['category']) {
            return redirect()->to('/library')->with('error', 'Category not found.');
        }

        return view('category_gears', $data);
    }
    public function allGears()
    {
        $gears = $this->libraryModel->getAllGears();
        $categories = $this->libraryModel->getCategories();
    
        $gears_by_category = [];
    
        foreach ($categories as $category) {
            $gears_by_category[$category['category']] = [];
        }
    
        foreach ($gears as $gear) {
            $category = $this->libraryModel->getCategoryById($gear['category_id']);
            $categoryName = $category['category'] ?? 'Uncategorized';
            $gears_by_category[$categoryName][] = $gear;
        }
    
        return view('all-gears', ['gears_by_category' => $gears_by_category]);
    }
    


public function addToComparison()
{
    $session = session();
    $productId = $this->request->getPost('product_id');

    if (!$productId) {
        return $this->response->setJSON(['success' => false, 'message' => 'Invalid product ID']);
    }

    $gearModel = new GearModel();
    $gear = $gearModel->getGearWithSpecs($productId);

    if (!$gear) {
        return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
    }

    // Store in session
    $session->set('comparison_left', $gear);

    return $this->response->setJSON(['success' => true]);
}

public function comparison()
{
    $session = session();
    $comparisonLeft = $session->get('comparison_left');

    return view('comparison', ['leftGear' => $comparisonLeft]);
}

}
