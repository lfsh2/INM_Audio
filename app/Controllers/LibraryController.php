<?php

namespace App\Controllers;

use App\Models\LibraryModel;
use CodeIgniter\Controller;
use App\Models\GearModel;
use App\Models\IemModel; // <-- Add this line


class LibraryController extends Controller
{
    protected $libraryModel;

    public function __construct()
    {
        $this->libraryModel = new LibraryModel();
    }

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
    

    
public function comparison()
{
    $model = new IemModel();

    $data['leftGear'] = session()->get('leftGear') ?? [];
    $data['rightGear'] = session()->get('rightGear') ?? [];

    return view('comparison', $data);
}

public function getIemsByCategory($category)
{
    $iemModel = new IemModel();

    $categoryMap = [
        'Vanilla Series' => 1,
        'Stage Series' => 2,
        'Prestige Series' => 3,
        'Personalized Series' => 4
    ];

    if (!isset($categoryMap[$category])) {
        return $this->response->setJSON([]);
    }

    $categoryId = $categoryMap[$category];
    $iems = $iemModel->where('category_id', $categoryId)->findAll();

    return $this->response->setJSON($iems);
}

public function clearComparison()
{
    session()->remove('left_gear');
    session()->remove('right_gear');

    session()->setFlashdata('success', 'Comparison cleared successfully.');

    return redirect()->to(base_url('comparison'));
}


}
    