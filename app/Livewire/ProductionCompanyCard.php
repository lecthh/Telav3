<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductionCompany;

class ProductionCompanyCard extends Component
{

    public $productionCompanies;

    public function mount()
    {
        $this->productionCompanies = ProductionCompany::all();
    }
    
    public function render()
    {
        return view('livewire.production-company-card');
    }

}
