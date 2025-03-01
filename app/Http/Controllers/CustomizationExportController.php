<?php

namespace App\Http\Controllers;

use App\Exports\CustomizationDetailsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Traits\Toastable;


class CustomizationExportController extends Controller
{
    use Toastable;
    public function export($order_id)
    {
        try {
            return Excel::download(new CustomizationDetailsExport($order_id), $order_id . '_JobOrder.xlsx');
        } catch (\Exception $e) {
            $this->toast('An error occurred while exporting the file.', 'error');
            return redirect()->back();
        }
    }
}
