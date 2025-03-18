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
use App\Traits\Toastable;

class CartController extends Controller
{
    use Toastable;

    public function showCart()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $cartItems = collect();
            
            if ($cart) {
                $cartItems = CartItem::where('cart_id', $cart->cart_id)
                    ->with(['cartItemImages', 'apparelType', 'productionCompany', 'productionType'])
                    ->get();
                    
                // Ensure cart items have properly calculated fields
                foreach ($cartItems as $cartItem) {
                    if (!$cartItem->total_price || $cartItem->total_price == 0) {
                        $cartItem->total_price = $cartItem->price * $cartItem->quantity;
                        $cartItem->save();
                    }
                    
                    if (!$cartItem->downpayment || $cartItem->downpayment == 0) {
                        $cartItem->downpayment = $cartItem->total_price / 2;
                        $cartItem->save();
                    }
                }
                
                \Illuminate\Support\Facades\Log::info('Cart items loaded:', [
                    'count' => $cartItems->count(),
                    'items' => $cartItems->toArray()
                ]);
            }
        } else {
            $cartItems = collect();
        }
        
        return view('cart.cart', compact('cartItems'));
    }

    public function removeCartItem($cartItemId)
    {
        try {
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();

                if (!$cart) {
                    $this->toast('Cart not found.', 'error');
                    return redirect()->route('customer.cart');
                }

                $cartItem = CartItem::where('cart_id', $cart->cart_id)
                    ->where('cart_item_id', $cartItemId)
                    ->first();

                if ($cartItem) {
                    DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();
                    $this->toast('Item removed from cart.', 'success');
                } else {
                    $this->toast('Cart item not found.', 'error');
                }
            } else {
                $this->toast('You need to log in to manage your cart.', 'error');
            }
        } catch (\Exception $e) {
            $this->toast('An error occurred while removing the item.', 'error');
        }

        return redirect()->route('customer.cart');
    }


    public function checkout(Request $request)
    {
        try {
            $selectedItemIds = $request->input('cart_items', []);

            if (empty($selectedItemIds)) {
                $this->toast('No items selected for checkout.', 'error');
                return redirect()->back();
            }

            $cartItems = CartItem::whereIn('cart_item_id', $selectedItemIds)
                ->with(['cartItemImages', 'apparelType', 'productionCompany', 'productionType'])
                ->get();

            if ($cartItems->isEmpty()) {
                $this->toast('Selected items not found in cart.', 'error');
                return redirect()->back();
            }

            foreach ($cartItems as $item) {
                if (!$item->total_price) {
                    $item->total_price = $item->price * $item->quantity;
                }
                
                if (!$item->downpayment) {
                    $item->downpayment = $item->total_price / 2;
                }
                
                $item->save();
            }

            session()->put('selected_cart_items', $cartItems);

            $this->toast('Proceeding to checkout.', 'success');
            return redirect()->route('customer.checkout');
        } catch (\Exception $e) {
            $this->toast('An error occurred during checkout.', 'error');
            return redirect()->back();
        }
    }
}
