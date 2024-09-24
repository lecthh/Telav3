<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function profileBasics()
    {
        return view('customer.profile.profile-basics');
    }

    public function profileOrders()
    {
        return view('customer.profile.profile-orders');
    }

    public function profileReviews()
    {
        return view('customer.profile.profile-reviews');
    }
}
