<?php

namespace App\Http\Controllers;

use App\Models\CustomizationDetails;
use App\Models\Order;
use App\Models\Sizes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmationLinkController extends Controller
{
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
        if (!Auth::check()) {
            return redirect()->back()->withErrors('Please login first before confirming this order.');
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
            return redirect()->to('home');
        }
        if (Auth::user()->email !== $order->user->email) {
            return redirect()->back()->withErrors('You are not allowed to edit this order.');
        }

        $totalQuantity = collect($request->sizes)->sum();

        if ($totalQuantity < 10) {
            return redirect()->back()->withErrors('The total quantity of the order must be at least 10.');
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

        return redirect()->route('home')->with('message', 'Order customization details saved successfully!');
    }




    public function confirmBulkCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('home')->withErrors('Invalid token or order.');
        }

        return view('customer.order-confirmation.bulk-customized', compact('order'));
    }

    public function confirmBulkCustomPost() {}

    public function confirmJerseyBulkCustom(Request $request, $token)
    {
        $order = Order::where('order_id', $request->order_id)
            ->where('token', $token)
            ->first();

        if (!$order) {
            return redirect()->route('home')->withErrors('Invalid token or order.');
        }

        return view('customer.order-confirmation.jersey-bulk-customized', compact('order'));
    }

    public function confirmJerseyBulkCustomPost() {}
}
