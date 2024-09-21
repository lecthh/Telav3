<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomizationController extends Controller
{
    public function customization($apparel, $productionType, $productionCompany)
    {
        return view('customization', compact('apparel', 'productionType', 'productionCompany'));
    }
}
