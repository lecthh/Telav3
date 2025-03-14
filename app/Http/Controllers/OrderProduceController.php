<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Log;

class OrderProduceController extends Controller {
    use Toastable;

    //PENDING
    public function pending()
    {
        $pendingOrders = Order::where('status_id', '1')->get();
        return view('partner.printer.orders', compact('pendingOrders'));
    }

    public function pendingOrder($order_id)
    {
        $order = Order::find($order_id);
        $designers = Designer::all();
        return view('partner.printer.order', compact('order', 'designers'));
    }

    //DESIGN IN PROGRESS
    public function designInProgress()
    {
        $designInProgress = Order::where('status_id', '2')->get();
        return view('partner.printer.design.orders-design', compact('designInProgress'));
    }

    public function designOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.design.order', compact('order'));
    }

    //FINALIZE ORDER
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

    //AWAITING ORDER
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

    //PRINTING IN PROGRESS
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

    //READY
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

    //COMPLETE OR CANCEL
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

    //ASSIGN DESIGNER
    public function assignDesigner(Request $request, $order_id)
    {
        try {
            $validatedData = $request->validate([
                'selected_designer_id' => 'required|integer|exists:users,user_id',
            ]);

            $order = Order::findOrFail($order_id);
            $order->update([
                'assigned_designer_id' => intval($validatedData['selected_designer_id']),
                'status_id' => 2,
            ]);

            Notification::create([
                'user_id' => $order->user->user_id,
                'message' => 'Design in Progress',
                'is_read' => false,
                'order_id' => $order->order_id,
            ]);

            $this->toast('Designer assigned successfully!', 'success');
            return redirect()->route('partner.printer.orders');
        } catch (\Exception $e) {
            Log::error('Assign Designer Error: ' . $e->getMessage());
            $this->toast('An error occurred while assigning the designer.', 'error');
            return redirect()->back();
        }
    }
}