<?php

namespace App\Exports;

use App\Models\CustomizationDetails;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CustomizationDetailsExport implements FromView
{
    protected $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Return a view for Excel export.
     */
    public function view(): View
    {
        $order = Order::findOrFail($this->order_id);
        $customizations = CustomizationDetails::where('order_ID', $this->order_id)->get();

        return view('excel.customization_details', [
            'order' => $order,
            'customizations' => $customizations,
        ]);
    }
}
