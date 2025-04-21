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
    public $modalType = '';

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

    public function showApproveModal()
    {
        $this->dispatch('approveEntity', 'App\Models\ProductionCompany', $this->selectedItem->id, $this->modalType, 'company_name', 'id');
    }

    public function showBlockModal()
    {
        $this->dispatch('deleteEntity', 'App\Models\ProductionCompany', $this->selectedItem->id, $this->modalType, 'company_name', 'id');
    }

    public function showDetails($id, $type)
    {
        $this->selectedItem = ProductionCompany::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
        $this->modalType = $type;
    }

    public function render()
    {
        return view('livewire.production-company-details-modal');
    }
}
