<?php

namespace App\Controllers;

use App\Models\LibraryModel;
use CodeIgniter\Controller;

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
    $data['gears'] = $this->libraryModel->getAllGears();

    if (empty($data['gears'])) {
        return redirect()->to('/library')->with('error', 'No gears found.');
    }

    return view('all-gears', $data);
}

}
