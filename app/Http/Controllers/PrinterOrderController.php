<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrinterOrderController extends Controller
{
    public function index()
    {
        return view('partner.printer.orders');
    }

    public function pendingOrder() {
        return view('partner.printer.order');
    }

    public function designInProgress()
    {
        return view('partner.printer.design.orders-design');
    }

    public function finalizeOrder()
    {
        return view('partner.printer.finalize.orders-finalize');
    }

    public function awaitingPrinting()
    {
        return view('partner.printer.awaiting.orders-awaiting');
    }

    public function printingInProgress()
    {
        return view('partner.printer.printing.orders-printing');
    }

    public function ready()
    {
        return view('partner.printer.ready.orders-ready');
    }

    public function completed()
    {
        return view('partner.printer.complete.orders-complete');
    }
}