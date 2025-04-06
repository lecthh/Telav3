<?php

namespace App\Livewire;

use App\Models\Designer;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DesignerDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'general';
    public $type = '';

    protected function getListeners()
    {
        return [
            'showDesignerDetails' => 'showDetails',
        ];
    }

    public function onRowClick($orderId)
    {
        Log::info('Row clicked with orderId: ' . $orderId);
        $this->dispatch('showOrderDetails', $orderId);
    }

    public function showDetails($id, $type)
    {
        $this->selectedItem = Designer::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.designer-details-modal');
    }
}
