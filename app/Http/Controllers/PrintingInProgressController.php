<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class PrintingInProgressController extends Controller
{
    public function printingInProgress()
    {
        $printingInProgress = Order::where('status_id', '5')->get();
        return view('partner.printer.printing.orders-printing', compact('printingInProgress'));
    }

    public function printingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.printing.order', compact('order'));
    }

    public function printingOrderPost($order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = 6;
        $order->save();
        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order Is Ready to be Collected/Delivered',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        return redirect()->route('partner.printer.ready');
    }
}
