<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Customization extends Controller
{
    public function customization()
    {
        return view('customer.place-order.customization');
    }
}
