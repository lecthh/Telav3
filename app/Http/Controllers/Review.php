<?php

namespace App\Http\Controllers;

use App\Livewire\ProductionType;
use App\Models\ApparelType;
use App\Models\ProductionCompany;
use App\Models\ProductionType as ModelsProductionType;
use Illuminate\Http\Request;

class Review extends Controller
{
    public function review($apparel, $productionType, $company)
    {
        $customization = session()->get('customization');
        $productionCompany = ProductionCompany::find($company);
        $apparelName = ApparelType::find($apparel)->name;
        $productionTypeName = ModelsProductionType::find($productionType)->name;

        $currentStep = 5;
        return view('customer.place-order.review', compact('apparel', 'productionType', 'company', 'currentStep', 'customization', 'productionCompany', 'apparelName', 'productionTypeName'));
    }
}
