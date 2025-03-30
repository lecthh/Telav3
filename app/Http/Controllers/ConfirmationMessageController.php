<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ConfirmationMessageController extends Controller
{
    public function confirmation(Request $request)
    {
        // If order_id is provided, use that specific order
        if ($request->has('order_id')) {
            $order = Order::with(['user', 'productionCompany', 'apparelType', 'productionType'])
                ->where('order_id', $request->order_id)
                ->first();
                
            // Security check - only allow access if:
            // 1. The user is the customer who placed the order, or
            // 2. The user is the printer assigned to the order
            if (Auth::check() && $order) {
                $user = Auth::user();
                $isCustomer = $user->user_id == $order->user_id;
                $isPrinter = false;
                
                if ($user->role_type_id == 2) { // Production company admin
                    $productionCompany = \App\Models\ProductionCompany::where('user_id', $user->user_id)->first();
                    if ($productionCompany) {
                        $isPrinter = $productionCompany->id == $order->production_company_id;
                    }
                }
                
                if (!$isCustomer && !$isPrinter) {
                    return redirect()->route('home')
                        ->with('error', 'You do not have permission to view this order receipt.');
                }
            }
        } else {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->route('home')
                    ->with('error', 'You must be logged in to view order confirmations.');
            }
            
            // Use the user's most recent order
            $order = Order::with(['user', 'productionCompany', 'apparelType', 'productionType'])
                ->where('user_id', Auth::id())
                ->latest()
                ->first();
        }
            
        if (!$order) {
            return redirect()->route('home')
                ->with('error', 'No order found to confirm.');
        }
        
        return view('cart.confirmation', compact('order'));
    }
}
