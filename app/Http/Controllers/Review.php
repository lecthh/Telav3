<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Review extends Controller
{
    public function review()
    {
        return view('customer.place-order.review');
    }
}
