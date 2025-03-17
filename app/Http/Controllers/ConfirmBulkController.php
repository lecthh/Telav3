<?php

namespace App\Http\Controllers;

use App\Models\CustomizationDetails;
use App\Models\Order;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Toastable;

class ConfirmBulkController extends Controller
{
    use Toastable;
    public function confirmBulk(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('home')->withErrors('Invalid token or order.');
        }

        $sizes = Sizes::all();

        return view('customer.order-confirmation.standard-bulk', compact('order', 'sizes'));
    }

    public function confirmBulkPost(Request $request)
    {
        try {
            if (!Auth::check()) {
                $this->toast('Please login first before confirming this order.', 'error');
                return redirect()->back();
            }

            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'sizes' => 'required|array',
                'sizes.*' => 'nullable|integer|min:0',
                'token' => 'required|exists:orders,token',
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->firstOrFail();

            if ($order->token == null) {
                $this->toast('This order has already been confirmed.', 'error');
                return redirect()->route('home');
            }

            if (Auth::user()->email !== $order->user->email) {
                $this->toast('You are not allowed to edit this order.', 'error');
                return redirect()->back();
            }

            $totalQuantity = collect($request->sizes)->sum();

            if ($totalQuantity < 10) {
                $this->toast('The total quantity of the order must be at least 10.', 'error');
                return redirect()->back();
            }

            foreach ($request->sizes as $sizes_ID => $quantity) {
                if ($quantity > 0) {
                    CustomizationDetails::create([
                        'customization_details_ID' => uniqid(),
                        'order_ID' => $order->order_id,
                        'sizes_ID' => $sizes_ID,
                        'quantity' => $quantity,
                    ]);
                }
            }

            $order->token = null;
            $order->save();

            $this->toast('Order customization details saved successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->toast('An error occurred while saving order details.', 'error');
            return redirect()->back();
        }
    }
    
    public function confirmSingle(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('home')->withErrors('Invalid token or order.');
        }

        $sizes = Sizes::all();

        return view('customer.order-confirmation.standard-single', compact('order', 'sizes'));
    }

    public function confirmSinglePost(Request $request)
    {
        try {
            if (!Auth::check()) {
                $this->toast('Please login first before confirming this order.', 'error');
                return redirect()->back();
            }

            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,order_id',
                'sizes' => 'required|array',
                'sizes.*' => 'nullable|integer|min:0',
                'token' => 'required|exists:orders,token',
            ]);

            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->firstOrFail();

            if ($order->token == null) {
                $this->toast('This order has already been confirmed.', 'error');
                return redirect()->route('home');
            }

            if (Auth::user()->email !== $order->user->email) {
                $this->toast('You are not allowed to edit this order.', 'error');
                return redirect()->back();
            }

            $totalQuantity = collect($request->sizes)->sum();

            if ($totalQuantity < 1) {
                $this->toast('The total quantity of the order must be at least 1.', 'error');
                return redirect()->back();
            }

            if ($totalQuantity > 9) {
                $this->toast('The total quantity for a single order should not exceed 9 items. For 10 or more items, please place a bulk order.', 'error');
                return redirect()->back();
            }

            foreach ($request->sizes as $sizes_ID => $quantity) {
                if ($quantity > 0) {
                    CustomizationDetails::create([
                        'customization_details_ID' => uniqid(),
                        'order_ID' => $order->order_id,
                        'sizes_ID' => $sizes_ID,
                        'quantity' => $quantity,
                    ]);
                }
            }

            $order->token = null;
            $order->save();

            $this->toast('Order customization details saved successfully!', 'success');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->toast('An error occurred while saving order details.', 'error');
            return redirect()->back();
        }
    }
}
