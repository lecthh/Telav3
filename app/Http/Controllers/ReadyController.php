<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReadyController extends Controller
{
    public function ready()
    {
        $readyOrders = Order::where('status_id', '6')->get();
        return view('partner.printer.ready.orders-ready', compact('readyOrders'));
    }
    public function readyOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.ready.order', compact('order'));
    }

    public function readyOrderPost($order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = 7;
        $order->save();
        return redirect()->route('partner.printer.completed');
    }
}
