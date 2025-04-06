<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    public $activeTab = 'profile';

    protected function getListeners()
    {
        return [
            'showUserDetails' => 'showDetails',
        ];
    }

    public function onRowClick($orderId)
    {
        Log::info('Row clicked with orderId: ' . $orderId);
        $this->dispatch('showOrderDetails', $orderId);
    }

    public function showDetails($userId)
    {
        $this->selectedItem = User::find($userId);
        $this->showModal = true;
        $this->activeTab = 'profile';
    }

    public function render()
    {
        return view('livewire.user-details-modal');
    }
}
