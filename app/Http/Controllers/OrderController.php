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
use App\Models\ProductionCompanyPricing;

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

        if ($request->input('order_type') === 'bulk' && $request->input('quantity') < 10) {
            return redirect()->back()->withErrors(['quantity' => 'Bulk orders require a minimum of 10 items.'])->withInput();
        }

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
            'quantity' => $request->input('quantity'),
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

        $pricing = \App\Models\ProductionCompanyPricing::where('production_company_id', $company)
        ->where('apparel_type', $apparel)
        ->where('production_type', $productionType)
        ->first();

        $basePrice = 0;
        $bulkPrice = 0;
        
        if ($pricing) {
            $basePrice = $pricing->base_price;
            $bulkPrice = $pricing->bulk_price;
        }

        $orderPrice = isset($customization['order_type']) && $customization['order_type'] === 'bulk' 
        ? $bulkPrice 
        : $basePrice;

        $quantity = isset($customization['quantity']) ? $customization['quantity'] : 
        (isset($customization['order_type']) && $customization['order_type'] === 'bulk' ? 10 : 1);

        $totalPrice = $orderPrice * $quantity;
        $downpayment = $totalPrice / 2;

        $currentStep = 5;
        return view('customer.place-order.review', compact(
            'apparel', 
            'productionType', 
            'company', 
            'currentStep', 
            'customization', 
            'productionCompany', 
            'apparelName', 
            'productionTypeName', 
            'canvasImage',
            'basePrice',
            'bulkPrice',
            'orderPrice',
            'quantity',
            'totalPrice',
            'downpayment'
        ));
    }

    public function storeReview($apparel, $productionType, $company)
    {
        try {
            $company = ProductionCompany::find($company);
            $customization = session()->get('customization');
            $canvasImage = session()->get('canvas_image');
    
            $pricing = \App\Models\ProductionCompanyPricing::where('production_company_id', $company->id)
                ->where('apparel_type', $apparel)
                ->where('production_type', $productionType)
                ->first();
    
            $unitPrice = 0;
            if ($pricing) {
                $unitPrice = ($customization['order_type'] === 'bulk') 
                    ? $pricing->bulk_price 
                    : $pricing->base_price;
            }
    
            $quantity = isset($customization['quantity']) ? $customization['quantity'] : 
                ($customization['order_type'] === 'bulk' ? 10 : 1);
    
            $totalPrice = $unitPrice * $quantity;
            $downpayment = $totalPrice / 2;
    
            \Illuminate\Support\Facades\Log::info('Creating cart item with data:', [
                'unitPrice' => $unitPrice,
                'quantity' => $quantity,
                'totalPrice' => $totalPrice,
                'downpayment' => $downpayment
            ]);
            
            $cartItemData = [
                'apparel_type_id' => $apparel,
                'production_type' => $productionType,
                'price' => $unitPrice,
                'quantity' => $quantity, 
                'production_company_id' => $company->id,
                'orderType' => $customization['order_type'],
                'customization' => $customization['custom_type'],
                'description' => $customization['description'],
                'total_price' => $totalPrice,
                'downpayment' => $downpayment,
            ];
    
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);
            
            $cartItem = CartItem::create(array_merge($cartItemData, ['cart_id' => $cart->cart_id]));
            
            // Verify the cart item was created with correct values
            \Illuminate\Support\Facades\Log::info('Cart item created:', [
                'cart_item_id' => $cartItem->cart_item_id,
                'price' => $cartItem->price,
                'total_price' => $cartItem->total_price,
                'downpayment' => $cartItem->downpayment
            ]);
            
            // Add media if available
            if (isset($customization['media']) && is_array($customization['media'])) {
                foreach ($customization['media'] as $image) {
                    CartItemImages::create([
                        'cart_item_id' => $cartItem->cart_item_id,
                        'image' => $image,
                    ]);
                }
            }
    
            // Handle canvas image if available
            if (!empty($canvasImage)) {
                $canvasImage = str_replace('data:image/png;base64,', '', $canvasImage);
                $canvasImage = str_replace(' ', '+', $canvasImage);
                $imageName = 'canvas_' . time() . '.png';
                $path = 'uploads/designs/' . $imageName;
                
                // Store the image
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, base64_decode($canvasImage));
                
                // Save the path to the database
                CartItemImages::create([
                    'cart_item_id' => $cartItem->cart_item_id,
                    'image' => $path,
                ]);
            }
    
            session()->forget(['customization', 'canvas_image']);
            
            return redirect()->route('customer.cart');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating cart item: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'There was an error adding the item to your cart. Please try again.');
        }
    }
}
