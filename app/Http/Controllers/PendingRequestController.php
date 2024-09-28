<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Order;
use Illuminate\Http\Request;

class PendingRequestController extends Controller
{
    public function index()
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
    // Create/update notification here
    public function assignDesigner(Request $request, $order_id)
    {
        $request->validate([
            'selected_designer_id' => 'required',
        ]);
        $order = Order::find($order_id);
        $order->assigned_designer_id = intval($request->selected_designer_id);
        $order->status_id = 2;
        $order->save();

        return redirect()->route('partner.printer.orders');
    }
}
