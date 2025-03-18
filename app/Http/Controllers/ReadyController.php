<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\Toastable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReadyController extends Controller
{
    use Toastable;
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
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 7]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order is Completed',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order marked as completed!', 'success');
            return redirect()->route('partner.printer.completed');
        } catch (\Exception $e) {
            Log::error('Ready Order Update Error: ' . $e->getMessage());
            $this->toast('An error occurred while completing the order.', 'error');
            return redirect()->back();
        }
    }
}
