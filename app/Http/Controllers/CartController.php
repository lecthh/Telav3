<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function showCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartItems = $cart ? CartItem::where('cart_id', $cart->cart_id)
                ->with(['cartItemImages', 'apparelType', 'productionCompany', 'productionType'])
                ->get() : collect();
            $cartImage = $cartItems->map(function ($item) {
                return $item->cartItemImages->isNotEmpty() ? $item->cartItemImages->first()->image : null;
            });
            $totalPrice = $cartItems->sum('price');
        } else {
            $cartItems = collect(Session::get('cart_items', []));

            $totalPrice = $cartItems->sum('price');
        }

        return view('cart.cart', compact('cartItems', 'totalPrice', 'cartImage'));
    }
}
