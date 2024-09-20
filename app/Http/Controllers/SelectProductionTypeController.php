<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectProductionTypeController extends Controller
{
    public function selectProductionType($apparel)
    {
        return view('select-production-type', ['apparel' => $apparel]);
    }

    public function selectProductionTypePost(Request $request)
    {
        $productionType = $request->input('productionType');
        return view('select-production-type', ['productionType' => $productionType]);
    }
}
