<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\Toastable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrintingInProgressController extends Controller
{
    use Toastable;
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
        try {
            $order = Order::findOrFail($order_id);
            $order->update(['status_id' => 6]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Is Ready to be Collected/Delivered',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Order marked as ready for collection/delivery!', 'success');
            return redirect()->route('partner.printer.ready');
        } catch (\Exception $e) {
            Log::error('Printing Order Update Error: ' . $e->getMessage());
            $this->toast('An error occurred while updating the order status.', 'error');
            return redirect()->back();
        }
    }
}
