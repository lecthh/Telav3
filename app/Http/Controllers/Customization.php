<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Customization extends Controller
{
    public function customization($apparel, $productionType, $company)
    {
        $currentStep = 4;
        return view('customer.place-order.customization', compact('apparel', 'productionType', 'company', 'currentStep'));
    }
}
