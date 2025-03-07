<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class ComparisonController extends Controller
{
    public function index()
    {
        $session = session();
        $productModel = new ProductModel();

        $comparisonList = $session->get('comparison') ?? [];

        $gears = [];
        if (!empty($comparisonList)) {
            $gears = $productModel->getMultipleProductsWithSpecs($comparisonList);
        }

        return view('comparison', ['gears' => $gears]);
    }

    public function clearComparison()
    {
        session()->remove('comparison');
        return redirect()->to(base_url('library/comparison'));
    }
}
