<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfileDetails() {
        $user = Auth::user();
        return view('customer.profile.profile-basics', compact('user'));
    }

    public function profileOrders()
    {
        $user = Auth::user(); 
        $orders = $user->orders;

        return view('customer.profile.profile-orders', compact('orders'));
    }

    public function profileReviews()
    {
        return view('customer.profile.profile-reviews');
    }

    public function showOrder($orderId) {
        $order = Order::with('status')->findOrFail($orderId);
        return view('customer.profile.profile-order', compact('order'));
    }
}
