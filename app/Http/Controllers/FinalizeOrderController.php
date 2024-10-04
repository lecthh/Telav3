<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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

        $customizationDetails = $order->customizationDetails()->get();

        if ($customizationDetails->isEmpty()) {
            $customizationDetails = null;
        }

        return view('partner.printer.finalize.order', compact('order', 'customizationDetails'));
    }

    public function finalizeOrderPost($order_id)
    {
        $order = Order::find($order_id);
        foreach ($order->imagesWithStatusTwo as $image) {
            $image->status_id = 4;
            $image->save();
        }

        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order Is Waiting To Be Printed',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);

        $order->status_id = 4;
        $order->save();

        return redirect()->route('partner.printer.awaiting-printing');
    }
}
