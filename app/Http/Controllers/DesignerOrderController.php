<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignerOrderController extends Controller
{

    public function dashboard()
    {
        $designer = session('admin');
        $assignedOrdersCount = 0;
        $completedOrdersCount = 0;

        $assignedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '>=', 2)
            ->where('status_id', '!=', 7)
            ->count();


        $completedOrdersCount = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', 7)
            ->count();

        return view('partner.designer.dashboard', compact('assignedOrdersCount', 'completedOrdersCount'));
    }


    public function index()
    {
        $designer = session('admin');
        $assignedOrders = Order::where('assigned_designer_id', $designer->designer_id)
            ->where('status_id', '>=', 2)
            ->where('status_id', '!=', 7)
            ->get();

        return view('partner.designer.orders', compact('assignedOrders'));
    }

    public function assignedOrder($order_id)
    {
        $order = Order::find($order_id);
        return view('partner.designer.order', compact('order'));
    }

    public function complete()
    {
        return view('partner.designer.complete.orders-complete');
    }

    public function completeOrder()
    {
        return view('partner.designer.complete.order');
    }
}
