<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;
use Illuminate\Support\Facades\Log;

class ProductionCompanyCard extends Component
{

    public $productionCompanies;
    public $selectedProductionCompany;
    public $apparel;
    public $productionType;
    public $pricingData = [];

    public function selectProductionCompany($productionCompanyId)
    {
        $this->selectedProductionCompany = $productionCompanyId;
    }

    public function submit()
    {
        if ($this->selectedProductionCompany) {
            return redirect()->route('customer.place-order.customization', [
                'apparel' => $this->apparel, 
                'productionType' => $this->productionType, 
                'company' => $this->selectedProductionCompany
            ]);
        } else {
            session()->flash('error', 'Please select a production company');
        }
    }

    public function back()
    {
        return redirect()->route('customer.place-order.select-production-type', ['apparel' => $this->apparel]);
    }

    public function mount($apparel, $productionType)
    {
        $this->productionType = $productionType;
        $this->apparel = $apparel;
        
        $this->productionCompanies = ProductionCompany::whereHas('productionCompanyPricing', function($query) {
            $query->where('apparel_type', $this->apparel)
                  ->where('production_type', $this->productionType);
        })->get();
        
        if ($this->productionCompanies->isEmpty()) {
            $this->productionCompanies = ProductionCompany::all();
        }
        
        $this->loadPricingData();
    }

    protected function loadPricingData()
    {
        foreach ($this->productionCompanies as $company) {
            $pricing = ProductionCompanyPricing::where('production_company_id', $company->id)
                ->where('apparel_type', $this->apparel)
                ->where('production_type', $this->productionType)
                ->first();
            
            if ($pricing) {
                $this->pricingData[$company->id] = [
                    'base_price' => $pricing->base_price,
                    'bulk_price' => $pricing->bulk_price
                ];
            } else {
                // Default pricing if no specific pricing is found
                $this->pricingData[$company->id] = [
                    'base_price' => 0,
                    'bulk_price' => 0
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.production-company-card');
    }
}
