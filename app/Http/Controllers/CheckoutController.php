<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = session()->get('selected_cart_items', []);

        return view('cart.checkout', compact('cartItems'));
    }
}
