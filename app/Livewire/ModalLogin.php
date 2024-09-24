<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render()
    {
        return view('livewire.modal-login');
    }
}
