<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectProductionTypeController extends Controller
{
    public function selectProductionType()
    {
        return view('customer.place-order.select-production-type');
    }
    // public function selectProductionType($apparel)
    // {
    //     return view('select-production-type', ['apparel' => $apparel]);
    // }

    // public function selectProductionTypePost(Request $request)
    // {
    //     $productionType = $request->input('production_type');
    //     $apparel = $request->input('apparel');
    //     return redirect()->route('select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]);
    // }
}
