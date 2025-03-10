<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\Toastable;


class AwaitingOrderController extends Controller
{
    use Toastable;

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
        try {
            $order = Order::findOrFail($order_id);
            $order->status_id = 5;
            $order->save();

            Notification::create([
                'user_id'  => $order->user->user_id,
                'message'  => 'Your Order Is Being Printed',
                'is_read'  => false,
                'order_id' => $order->order_id,
            ]);


            $this->toast('Order status updated successfully!', 'success');

            return redirect()->route('partner.printer.printing-in-progress');
        } catch (\Exception $e) {

            $this->toast('Error updating order status: ' . $e->getMessage(), 'error');

            return redirect()->back();
        }
    }
}
