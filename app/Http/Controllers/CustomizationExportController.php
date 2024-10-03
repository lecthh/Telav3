<?php

namespace App\Http\Controllers;

use App\Exports\CustomizationDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class CustomizationExportController extends Controller
{
    public function export($order_id)
    {
        return Excel::download(new CustomizationDetailsExport($order_id), $order_id . '_JobOrder.xlsx');
    }
}
