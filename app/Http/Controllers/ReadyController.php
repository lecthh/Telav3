<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order is Completed',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        return redirect()->route('partner.printer.completed');
    }
}
