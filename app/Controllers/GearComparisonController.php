<?php

namespace App\Controllers;

class GearComparisonController extends BaseController
{

    public function getComparison() {
        return view('comparison');
    }
}