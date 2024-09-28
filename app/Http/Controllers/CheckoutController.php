<?php

namespace App\Http\Controllers;

use App\Models\AddressInformation;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\OrderStatus;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = session()->get('selected_cart_items', []);
        $cartItems = collect($cartItems);
        $user = Auth::user();
        $contactInformation = $user->addressInformation;
        return view('cart.checkout', compact('cartItems', 'user'));
    }

    public function postCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'contact_number' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);
        $user = Auth::user();

        $addressInformation = AddressInformation::updateOrCreate(
            ['user_id' => $user->user_id],
            [
                'phone_number' => $validatedData['contact_number'],
                'address' => $validatedData['address'],
                'state' => $validatedData['state'],
                'city' => $validatedData['city'],
                'zip_code' => $validatedData['zip_code'],
            ]
        );
        $selectedCartItems = session()->get('selected_cart_items', []);
        if (empty($selectedCartItems)) {
            return back()->with('error', 'No items selected for checkout.');
        }
        $cartItems = collect($selectedCartItems);
        DB::beginTransaction();
        try {
            foreach ($cartItems as $cartItemId) {
                $cartItem = CartItem::with(['apparelType', 'productionCompany', 'productionType', 'cartItemImages'])
                    ->where('cart_item_id', $cartItemId->cart_item_id)
                    ->first();

                if ($cartItem) {
                    $isBulkOrder = ($cartItem->orderType == 'bulk') ? true : false;
                    $isCustomized = ($cartItem->customization == 'custom') ? true : false;
                    $order = Order::create([
                        'order_id' => uniqid(),
                        'user_id' => $user->user_id,
                        'production_company_id' => $cartItem->production_company_id,
                        'assigned_designer_id' => null,
                        'is_customized' => $isCustomized,
                        'is_bulk_order' => $isBulkOrder,
                        'quantity' => $cartItem->quantity,
                        'status_id' => OrderStatus::STATUS_ORDER_PLACED,
                        'apparel_type' => $cartItem->apparel_type_id,
                        'production_type' => $cartItem->production_type,
                        'downpayment_amount' => $cartItem->price,
                        'final_price' => null,
                        'custom_design_info' => $cartItem->description,
                        'revision_count' => 0,
                    ]);
                    foreach ($cartItem->cartItemImages as $image) {
                        OrderImages::create([
                            'order_id' => $order->order_id,
                            'image' => $image->image,
                            'status_id' => 1,
                        ]);
                    }
                    $cartItem->delete();
                }
            }

            session()->forget('selected_cart_items');

            DB::commit();

            return redirect()->route('customer.confirmation')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }

    public function deleteCartItem($cartItemId)
    {
        $selectedCartItems = session()->get('selected_cart_items', []);
        if ($cartItemId) {
            DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();
        }
        $updatedCartItems = collect($selectedCartItems)->reject(function ($item) use ($cartItemId) {
            return $item->cart_item_id == $cartItemId;
        })->values()->all();

        session()->put('selected_cart_items', $updatedCartItems);
        if (empty($updatedCartItems)) {
            return redirect()->route('customer.cart')->with('message', 'Cart is empty, redirected to cart page.');
        }

        return redirect()->route('customer.checkout')->with('success', 'Cart item removed successfully.');
    }
}
