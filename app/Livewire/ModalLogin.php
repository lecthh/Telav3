<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function mount()
    {
        Session::put('url.intended', URL::previous());
    }
    public function render()
    {
        return view('livewire.modal-login');
    }
}
