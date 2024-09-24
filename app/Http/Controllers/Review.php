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

class Review extends Controller
{
    public function review($apparel, $productionType, $company)
    {
        $customization = session()->get('customization');
        $productionCompany = ProductionCompany::find($company);
        $apparelName = ApparelType::find($apparel)->name;
        $productionTypeName = ModelsProductionType::find($productionType)->name;

        $currentStep = 5;
        return view('customer.place-order.review', compact('apparel', 'productionType', 'company', 'currentStep', 'customization', 'productionCompany', 'apparelName', 'productionTypeName'));
    }

    public function storeReview(Request $request, $apparel, $productionType, $productionCompany)
    {
        $customization = session()->get('customization');
        if (Auth::check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);

            CartItem::create([
                'cart_id' => $cart->cart_id,
                'apparel_type_id' => $apparel,
                'production_type' => $productionType,
                'productionCompany' => $productionCompany->id,
                'price' => $productionCompany->price,
                'orderType' => $customization['order_type'],
                'images[]' => $customization['media'],
            ]);
        } else {
            $cartItems = Session::get('cart_items', []);

            $cartItems[] = [
                'apparel_type_id' => $apparel,
                'production_type' => $productionType,
                'price' => $productionCompany->price,
                'productionCompany' => $productionCompany->id,
                'orderType' => $customization['order_type'],
                'images[]' => $customization['media'],
            ];

            Session::put('cart_items', $cartItems);
        }
    }
}
