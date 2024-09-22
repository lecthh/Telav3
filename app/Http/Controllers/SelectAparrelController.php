<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectAparrelController extends Controller
{
    public function selectApparel()
    {
        return view('customer.place-order.select-apparel');
    }
    
}
