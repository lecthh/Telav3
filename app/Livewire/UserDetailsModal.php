<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserDetailsModal extends Component
{
    public $showModal = false;
    public $selectedItem = null;
    
    // For Livewire 3:
    protected function getListeners()
    {
        return [
            'showUserDetails' => 'showDetails',
        ];
    }
    
    // Or alternatively:
    // #[On('showUserDetails')]
    public function showDetails($userId)
    {
        $this->selectedItem = \App\Models\User::find($userId);
        $this->showModal = true;
    }
    
    public function render()
    {
        return view('livewire.user-details-modal');
    }
}