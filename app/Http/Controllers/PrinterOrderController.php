<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PrinterOrderController extends Controller
{
    public function cancelOrder($order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = 8;
        $order->save();
        return redirect()->route('printer-dashboard');
    }

    public function completed()
    {
        $completedOrders = Order::where('status_id', '7')->get();
        return view('partner.printer.complete.orders-complete', compact('completedOrders'));
    }
    public function completedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.complete.order');
    }
}
