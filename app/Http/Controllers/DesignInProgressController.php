<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DesignInProgressController extends Controller
{
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
}
