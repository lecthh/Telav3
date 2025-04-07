<?php

namespace App\Livewire;

use App\Models\ProductionCompany;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ProductionCompanyDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'general';
    public $type = '';

    protected function getListeners()
    {
        return [
            'showCompanyDetails' => 'showDetails',
        ];
    }

    public function onRowClick($orderId)
    {
        Log::info('Row clicked with orderId: ' . $orderId);
        $this->dispatch('showOrderDetails', $orderId);
    }

    public function showDetails($id, $type)
    {
        $this->selectedItem = ProductionCompany::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.production-company-details-modal');
    }
}
