<?php

namespace App\Http\Controllers;

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

        return redirect()->route('partner.printer.printing-in-progress');
    }
}
