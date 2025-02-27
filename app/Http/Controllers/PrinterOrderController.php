<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\Toastable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrinterOrderController extends Controller
{
    use Toastable;
    public function cancelOrder($order_id)
    {
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 8]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Has Been Cancelled',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order cancelled successfully!', 'success');
            return redirect()->route('printer-dashboard');
        } catch (\Exception $e) {
            Log::error('Cancel Order Error: ' . $e->getMessage());
            $this->toast('An error occurred while canceling the order.', 'error');
            return redirect()->back();
        }
    }


    public function completed()
    {
        $completedOrders = Order::where('status_id', '7')->get();
        return view('partner.printer.complete.orders-complete', compact('completedOrders'));
    }
    public function completedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.complete.order', compact('order'));
    }
}
