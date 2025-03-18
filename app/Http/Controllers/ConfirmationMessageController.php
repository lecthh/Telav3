<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ConfirmationMessageController extends Controller
{
    public function confirmation()
    {
        $order = Order::where('user_id', Auth::id())
            ->latest()
            ->first();
            
        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'No order found to confirm.');
        }
        
        return view('cart.confirmation', compact('order'));
    }
}
