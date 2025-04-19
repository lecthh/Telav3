<?php

namespace App\Livewire;

use Livewire\Component;

class BlockedBanner extends Component
{
    public $contactEmail;

    public function mount($contactEmail = 'telaprinthub@gmail.com')
    {
        $this->contactEmail = $contactEmail;
    }

    public function render()
    {
        return view('livewire.blocked-banner');
    }
}
