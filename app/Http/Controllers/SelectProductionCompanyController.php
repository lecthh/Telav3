<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelectProductionCompanyController extends Controller
{

    public function selectProductionCompany($apparel, $productionType)
    {
        return view('select-production-company', ['apparel' => $apparel, 'productionType' => $productionType]);
    }

    public function selectProductionCompanyPost(Request $request)
    {
        $productionCompany = $request->input('production_company');
        return view('select-production-company', ['productionCompany' => $productionCompany]);
    }
}
