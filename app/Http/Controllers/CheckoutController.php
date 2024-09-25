<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Retrieve selected cart items from the session
        $cartItems = session()->get('selected_cart_items', []);
    
        // Convert the array to a collection to use collection methods in the view
        $cartItems = collect($cartItems);
    
        return view('cart.checkout', compact('cartItems'));
    }
    

    public function deleteCartItem($cartItemId)
    {
        // Get the selected items from the session, defaulting to an empty array if not set
        $selectedCartItems = session()->get('selected_cart_items', []);
    
        // Delete the item from the database
        if ($cartItemId) {
            DB::table('cart_items')->where('cart_item_id', $cartItemId)->delete();
        }
    
        // Use collect() to work with the array as a collection
        $updatedCartItems = collect($selectedCartItems)->reject(function($item) use ($cartItemId) {
            return $item->cart_item_id == $cartItemId;  // Remove the item matching the deleted cartItemId
        })->values()->all();  // Use values() to reset the array keys and all() to return as array
    
        // Update the session with the remaining cart items
        session()->put('selected_cart_items', $updatedCartItems);
    
        // If no items remain in the cart, redirect to the cart page
        if (empty($updatedCartItems)) {
            return redirect()->route('customer.cart')->with('message', 'Cart is empty, redirected to cart page.');
        }
    
        // Redirect back to checkout with a success message
        return redirect()->route('customer.checkout')->with('success', 'Cart item removed successfully.');
    }
    
    
    
}
