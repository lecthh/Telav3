<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = session()->get('selected_cart_items', []);
        $cartItems = collect($cartItems);
    
        return view('cart.checkout', compact('cartItems'));
    }
    

    public function deleteCartItem($cartItemId)
    {
        $selectedCartItems = session()->get('selected_cart_items', []);
        if ($cartItemId) {
            DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();
        }
        $updatedCartItems = collect($selectedCartItems)->reject(function($item) use ($cartItemId) {
            return $item->cart_item_id == $cartItemId; 
        })->values()->all();
    
        session()->put('selected_cart_items', $updatedCartItems);
        if (empty($updatedCartItems)) {
            return redirect()->route('customer.cart')->with('message', 'Cart is empty, redirected to cart page.');
        }
    
        return redirect()->route('customer.checkout')->with('success', 'Cart item removed successfully.');
    }
    
    
    
}
