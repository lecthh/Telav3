<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

use LivewireUI\Modal\ModalComponent;

class ModalLoginSignup extends ModalComponent
{
    public $isSignup = false;
    public $isForgotPassword = false;
    public $signupStep = 1;
    public $name, $email, $password, $password_confirmation;
    public $rememberMe = false;
    public $passwordResetStatus = null;
    public $userEnteredVerificationCode;
    public $generatedVerificationCode;
    public $code1, $code2, $code3, $code4, $code5, $code6;

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
