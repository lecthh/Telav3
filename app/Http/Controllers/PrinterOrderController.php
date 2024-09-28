<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PrinterOrderController extends Controller
{


    public function designInProgress()
    {
        $designInProgress = Order::where('status_id', '2')->get();
        return view('partner.printer.design.orders-design', compact('designInProgress'));
    }

    public function designOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.design.order');
    }

    public function finalize()
    {
        $finalizeOrders = Order::where('status_id', '3')->get();
        return view('partner.printer.finalize.orders-finalize', compact('finalizeOrders'));
    }

    public function finalizeOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.finalize.order');
    }

    public function awaitingPrinting()
    {
        $awaitingPrinting = Order::where('status_id', '4')->get();
        return view('partner.printer.awaiting.orders-awaiting', compact('awaitingPrinting'));
    }

    public function awaitingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.awaiting.order');
    }

    public function printingInProgress()
    {
        $printingInProgress = Order::where('status_id', '5')->get();
        return view('partner.printer.printing.orders-printing', compact('printingInProgress'));
    }

    public function printingOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.printing.order');
    }

    public function ready()
    {
        $readyOrders = Order::where('status_id', '6')->get();
        return view('partner.printer.ready.orders-ready', compact('readyOrders'));
    }
    public function readyOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.printer.ready.order');
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
}
