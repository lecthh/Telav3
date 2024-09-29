<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class FinalizeOrderController extends Controller
{
    public function finalize()
    {
        $finalizeOrders = Order::where('status_id', '3')->get();
        return view('partner.printer.finalize.orders-finalize', compact('finalizeOrders'));
    }

    public function finalizeOrder($order_id)
    {
        $order = Order::find($order_id);

        return view('partner.printer.finalize.order', compact('order'));
    }
}
