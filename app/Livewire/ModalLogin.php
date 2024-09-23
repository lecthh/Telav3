<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public function render()
    {
        return view('livewire.modal-login');
    }
}
