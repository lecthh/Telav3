<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class OrderDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'general';

    protected function getListeners()
    {
        Log::info('Listeners initialized for OrderDetailsModal');
        return [
            'showOrderDetails' => 'showDetails',
        ];
    }

    public function showDetails($id)
    {
        $this->selectedItem = Order::find($id);
        $this->showModal = true;
        $this->activeTab = 'general';
        Log::info('Order details modal opened for order ID: ' . $id);
    }

    public function render()
    {
        return view('livewire.order-details-modal');
    }
}
