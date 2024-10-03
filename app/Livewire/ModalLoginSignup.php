<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

use LivewireUI\Modal\ModalComponent;

class ModalLoginSignup extends ModalComponent
{
    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function mount()
    {
        Session::put('url.intended', URL::previous());
        dd(Session::get('url.intended'));
    }
    public function render()
    {
        return view('livewire.modal-login-signup');
    }
}
