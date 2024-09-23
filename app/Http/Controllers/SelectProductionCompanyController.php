<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectProductionCompanyController extends Controller
{

    public function selectProductionCompany()
    {
        return view('customer.place-order.select-production-company');
    }

    public function selectProductionCompanyPost(Request $request)
    {
        $productionCompany = $request->input('production_company');
        $apparel = $request->input('apparel');
        $productionType = $request->input('productionType');

        return redirect()->route('customization', ['apparel' => $apparel, 'productionType' => $productionType, 'productionCompany' => $productionCompany]);
    }
}
