<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductionCompany;
use App\Models\ApparelType;
use App\Models\ProductionType as ModelsProductionType;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemImage;
use App\Models\CartItemImages;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with('status')->findOrFail($id);
        return response()->json($order);
    }

    //ORDER STEPS

    //STEP 1
    public function selectApparel()
    {
        $currentStep = 1;
        return view('customer.place-order.select-apparel', compact('currentStep'));
    }

    //STEP 2

    public function selectProductionType($apparel)
    {
        $currentStep = 2;
        return view('customer.place-order.select-production-type', compact('currentStep', 'apparel'));
    }

    //STEP 3

    public function selectProductionCompany($apparel, $productionType)
    {
        $currentStep = 3;
        return view('customer.place-order.select-production-company', compact('apparel', 'productionType', 'currentStep'));
    }

    public function selectProductionCompanyPost(Request $request)
    {
        $productionCompany = $request->input('production_company');
        $apparel = $request->input('apparel');
        $productionType = $request->input('productionType');


        return redirect()->route('customization', [
            'apparel' => $apparel, 
            'productionType' => $productionType, 
            'productionCompany' => $productionCompany,
        ]);
    }

    //STEP 4

    public function customization($apparel, $productionType, $company)
    {
        $currentStep = 4;
        return view('customer.place-order.customization', compact('apparel', 'productionType', 'company', 'currentStep'));
    }

    public function storeCustomization(Request $request, $apparel, $productionType, $company)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
            'media.*' => 'nullable|mimes:jpeg,png|max:102400',
            'order_type' => 'required|in:bulk,single',
            'custom_type' => 'required|in:standard,personalized',
        ]);

        //handle canvas
        if ($request->has('canvas_image')) {
            $canvasImage = $request->input('canvas_image');
            $canvasImage = str_replace('data:image/png;base64,', '', $canvasImage);
            $canvasImage = str_replace(' ', '+', $canvasImage);
            $imageName = 'canvas_' . time() . '.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put('uploads/designs/' . $imageName, base64_decode($canvasImage));
        }

        if ($request->hasFile('media')) {
            $mediaPaths = [];
            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads/designs', 'public');
                $mediaPaths[] = $path;
            }
        }

        if ($request->has('canvas_image')) {
            session()->put('canvas_image', $request->input('canvas_image'));
        }

        $customizationData = [
            'description' => $request->input('description'),
            'media' => $mediaPaths ?? [],
            'order_type' => $request->input('order_type'),
            'custom_type' => $request->input('custom_type'),
        ];

        session()->put('customization', $customizationData);

        return redirect()->route('customer.place-order.review', ['apparel' => $apparel, 'productionType' => $productionType, 'company' => $company]);
    }

    //STEP 5

    public function review($apparel, $productionType, $company)
    {
        $customization = session()->get('customization');
        $canvasImage = session()->get('canvas_image');
        $productionCompany = ProductionCompany::find($company);
        $apparelName = ApparelType::find($apparel)->name;
        $productionTypeName = ModelsProductionType::find($productionType)->name;

        $currentStep = 5;
        return view('customer.place-order.review', compact('apparel', 'productionType', 'company', 'currentStep', 'customization', 'productionCompany', 'apparelName', 'productionTypeName', 'canvasImage'));
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
