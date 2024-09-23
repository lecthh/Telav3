<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductionCompany;

class ProductionCompanyCard extends Component
{

    public $productionCompanies;
    public $selectedProductionCompany;
    public $apparel;
    public $productionType;

    public function selectProductionCompany($productionCompanyId)
    {
        $this->selectedProductionCompany = $productionCompanyId;
    }

    public function submit()
    {
        if ($this->selectedProductionCompany) {
            return redirect()->route('customer.place-order.customization', ['apparel' => $this->apparel, 'productionType' => $this->productionType, 'company' => $this->selectedProductionCompany]);
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
        $this->productionCompanies = ProductionCompany::all();
    }

    public function render()
    {
        return view('livewire.production-company-card');
    }
}
