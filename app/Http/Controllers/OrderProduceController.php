<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderProduceController extends Controller {

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
        $order = Order::find($order_id);
        $order->status_id = 7;
        $order->save();
        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order is Completed',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        return redirect()->route('partner.printer.completed');
    }

    //COMPLETE OR CANCEL
    public function cancelOrder($order_id)
    {
        $order = Order::find($order_id);
        $order->status_id = 8;
        $order->save();
        Notification::create([
            'user_id' => $order->user->user_id,
            'message' => 'Your Order Has Been Cancelled',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);
        return redirect()->route('printer-dashboard');
    }

    public function completed()
    {
        $completedOrders = Order::where('status_id', '7')->get();
        return view('partner.printer.complete.orders-complete', compact('completedOrders'));
    }
    public function completedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.complete.order');
    }

    //ASSIGN DESIGNER
    public function assignDesigner(Request $request, $order_id)
    {
        $request->validate([
            'selected_designer_id' => 'required',
        ]);
        $order = Order::find($order_id);
        $order->assigned_designer_id = intval($request->selected_designer_id);
        $order->status_id = 2;
        $order->save();

        $user_id = $order->user->user_id;

        Notification::create([
            'user_id' => $user_id,
            'message' => 'Design in Progress',
            'is_read' => false,
            'order_id' => $order->order_id,
        ]);

        return redirect()->route('partner.printer.orders');
    }
}