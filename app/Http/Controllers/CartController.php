<?php

namespace App\Http\Controllers;

use App\Livewire\ProductionType;
use App\Models\ApparelType;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductionCompany;
use App\Models\ProductionType as ModelsProductionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        }
        return view('cart.cart', compact('cartItems'));
    }

    public function removeCartItem($cartItemId)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();


            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('cart_item_id', $cartItemId)
                ->first();
            if ($cartItem) {
                DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();
            }
        }
        return redirect()->route('customer.cart');
    }


    public function checkout(Request $request)
    {
        $selectedItemIds = $request->input('cart_items', []);

        if (empty($selectedItemIds)) {
            return redirect()->back()->with('error', 'No items selected for checkout.');
        }

        $cartItems = CartItem::whereIn('cart_item_id', $selectedItemIds)
            ->with(['cartItemImages', 'apparelType', 'productionCompany', 'productionType'])
            ->get();

        session()->put('selected_cart_items', $cartItems);

        return redirect()->route('customer.checkout');
    }
}
