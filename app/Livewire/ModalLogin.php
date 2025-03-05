<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public $isSignup = false;
    public $first_name, $last_name, $email, $password, $password_confirmation;

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function mount()
    {
        Session::put('url.intended', URL::previous());
    }

    public function toggleSignup()
    {
        $this->isSignup = !$this->isSignup;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.modal-login');
    }
}
