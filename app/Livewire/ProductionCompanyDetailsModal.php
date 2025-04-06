<?php

namespace App\Livewire;

use App\Models\ProductionCompany;
use Livewire\Component;

class ProductionCompanyDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'general';

    protected function getListeners()
    {
        return [
            'showCompanyDetails' => 'showDetails',
        ];
    }

    public function showDetails($id)
    {
        $this->selectedItem = ProductionCompany::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
    }

    public function render()
    {
        return view('livewire.production-company-details-modal');
    }
}
