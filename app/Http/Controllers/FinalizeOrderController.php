<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Log;

class FinalizeOrderController extends Controller
{
    use Toastable;
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
        try {
            $order = Order::findOrFail($order_id);

            foreach ($order->imagesWithStatusTwo as $image) {
                $image->update(['status_id' => 4]);
            }

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Your Order Is Waiting To Be Printed',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $order->update(['status_id' => 4]);

            $this->toast('Order finalized and waiting for printing!', 'success');
            return redirect()->route('partner.printer.awaiting-printing');
        } catch (\Exception $e) {
            Log::error('Finalize Order Error: ' . $e->getMessage());
            $this->toast('An error occurred while finalizing the order.', 'error');
            return redirect()->back();
        }
    }
}
