<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\ProductionType;
use App\Models\ProductionCompanyPricing;
use App\Models\ApparelType;
use App\Models\ProductionCompany;

class ProductionCompanyController extends Controller
{
    //#[Rule('required')]
    protected $company_name;

    protected $company_logo;

    //#[Rule('required')]
    protected $production_type;

    //#[Rule('required')]
    protected $address;

   // #[Rule('required')]
    protected $phone;

    protected $avg_rating;

    protected $review_count;

    /**
     * Display the production companies page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productionTypes = ProductionType::all();
        return view('prod-services', [
            'productionTypes' => $productionTypes
        ]);
    }

    public function show($id)
    {
        $productionCompany = ProductionCompany::findOrFail($id);
        
        $pricingRecords = ProductionCompanyPricing::with(['apparelType', 'productionType'])
            ->where('production_company_id', $id)
            ->get();
        
        $apparelTypes = ApparelType::all();
        $productionTypes = ProductionType::all();
        
        return view('production-company-profile', compact(
            'productionCompany',
            'pricingRecords',
            'apparelTypes',
            'productionTypes'
        ));
        
    }
}
