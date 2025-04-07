<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ProfileController extends Controller
{
    public function showProfileDetails() {
        $user = Auth::user();
        return view('customer.profile.profile-basics', compact('user'));
    }

    public function profileOrders()
    {
        $user = Auth::user(); 
        // Get orders with relationships and sort by latest created
        $orders = $user->orders()
            ->with(['status', 'apparelType', 'productionType', 'productionCompany', 'notifications'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('customer.profile.profile-orders', compact('orders'));
    }

    public function profileReviews()
    {
        $user = Auth::user();
        $reviews = Review::where('user_id', $user->user_id)
                    ->with([
                        'order', 
                        'productionCompany',
                        'designer',
                        'designer.user',
                        'designer.productionCompany'
                    ])
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('customer.profile.profile-reviews', compact('reviews'));
    }
}