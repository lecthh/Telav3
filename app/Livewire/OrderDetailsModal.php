<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'general';

    protected function getListeners()
    {
        return [
            'showOrderDetails' => 'showDetails',
        ];
    }

    public function showDetails($id)
    {
        $this->selectedItem = Order::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
    }

    public function render()
    {
        return view('livewire.order-details-modal');
    }
}
