<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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

        return view('customer.order-confirmation.standard-bulk', compact('order'));
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
}
