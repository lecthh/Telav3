<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectAparrelController extends Controller
{
    public function selectApparel()
    {
        $currentStep = 1;
        return view('customer.place-order.select-apparel', compact('currentStep'));
    }
}
