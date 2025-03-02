<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductionCompany;
use App\Models\ProductionType;
use App\Models\ProductionCompanyPricing;

class ProductionCompaniesComponent extends Component
{
    public $selectedProductionType = [];
    public $selectedApparelType = [];
    public $selectedBasePrice = null;
    public $selectedProductionCompany = null;
    
    protected $listeners = ['filterByBasePrice'];

    public function mount()
    {
        // Initialize with default values if needed
    }

    public function filterByBasePrice($basePrice)
    {
        $this->selectedBasePrice = $basePrice;
    }

    public function selectProductionCompany($id)
    {
        $this->selectedProductionCompany = $id;
    }

    public function submit()
    {
        if ($this->selectedProductionCompany) {
            return redirect()->route('order.details', ['productionCompany' => $this->selectedProductionCompany]);
        }
    }

    public function back()
    {
        return redirect()->route('previous.page');
    }

    public function render()
    {
        $query = ProductionCompany::query();

        // Apply filters if they exist
        if (!empty($this->selectedProductionType)) {
            $query->whereJsonContains('production_type', $this->selectedProductionType);
        }

        if (!empty($this->selectedApparelType)) {
            $query->whereJsonContains('apparel_type', $this->selectedApparelType);
        }

        if ($this->selectedBasePrice) {
            $query->whereHas('productionCompanyPricing', function ($q) {
                $q->where('base_price', '<=', $this->selectedBasePrice);
            });
        }

        $productionCompanies = $query->get();

        return view('livewire.production-companies-component', [
            'productionCompanies' => $productionCompanies,
        ]);
    }
}