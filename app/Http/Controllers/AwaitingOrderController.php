<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class AwaitingOrderController extends Controller
{
    public function awaitingPrinting()
    {
        $awaitingPrinting = Order::where('status_id', '4')->get();
        return view('partner.printer.awaiting.orders-awaiting', compact('awaitingPrinting'));
    }

    public function awaitingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.awaiting.order', compact('order'));
    }

    public function awaitingOrderPost($order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = 5;
        $order->save();

        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order Is Being Printed',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        return redirect()->route('partner.printer.printing-in-progress');
    }
}
