<?php

namespace App\Http\Controllers;

use App\Models\ApparelType;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemImage;
use App\Models\CartItemImages;
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

    public function storeReview($apparel, $productionType, $company)
    {
        $company = ProductionCompany::find($company);
        $customization = session()->get('customization');
        $cartItemData = [
            'apparel_type_id' => $apparel,
            'production_type' => $productionType,
            'price' => rand(5, 2500), // TO BE IMPLEMENTED
            'production_company_id' => $company->id,
            'orderType' => $customization['order_type'],
            'customization' => $customization['custom_type'],
            'description' => $customization['description'],
        ];

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);
        $cartItem = CartItem::create(array_merge($cartItemData, ['cart_id' => $cart->cart_id]));
        if (isset($customization['media'])) {
            foreach ($customization['media'] as $image) {
                CartItemImages::create([
                    'cart_item_id' => $cartItem->cart_item_id,
                    'image' => $image,
                ]);
            }
        }

        return redirect()->route('customer.cart');
    }
}
