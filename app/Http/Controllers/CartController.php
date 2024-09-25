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
        } else {
            $cartItems = collect(Session::get('cart_items', []));
            $cartItems = $cartItems->map(function ($item) {
                $apparelType = ApparelType::find($item['apparel_type_id']);
                $item['apparel_type_name'] = $apparelType ? $apparelType->name : 'Unknown Apparel';
    
                $productionCompany = ProductionCompany::find($item['productionCompany']);
                $item['production_company_name'] = $productionCompany ? $productionCompany->company_name : 'Unknown Company';
                
                $productionType = ModelsProductionType::find($item['production_type']);
                $item['production_type_name'] = $productionType ? $productionType->name : 'Unknown Production Type';
                return $item;
            });
        }
        return view('cart.cart', compact('cartItems'));
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
