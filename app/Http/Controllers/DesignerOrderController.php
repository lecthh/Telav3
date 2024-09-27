<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DesignerOrderController extends Controller
{
    public function index()
    {
        return view('partner.designer.orders');
    }

    public function assignedOrder() {
        return view('partner.designer.order');
    }

    public function complete() {
        return view('partner.designer.complete.orders-complete');
    }

    public function completeOrder() {
        return view('partner.designer.complete.order');
    }
}
