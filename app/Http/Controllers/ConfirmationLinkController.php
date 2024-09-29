<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ConfirmationLinkController extends Controller
{
    public function confirmBulk(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('customer.order-confirmation.standard-bulk', compact('order'));
    }
    public function confirmBulkCustom(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('customer.order-confirmation.bulk-customized', compact('order'));
    }
    public function confirmJerseyBulkCustom(Request $request)
    {
        $order = Order::find($request->order_id);
        return view('customer.order-confirmation.jersey-bulk-customized', compact('order'));
    }
}
