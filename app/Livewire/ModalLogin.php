<?php

namespace App\Livewire;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public $isSignup = false;
    public $isForgotPassword = false;
    public $first_name, $last_name, $email, $password, $password_confirmation;
    public $rememberMe = false;
    public $passwordResetStatus = null;

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
        $this->isForgotPassword = false;
        $this->resetValidation();
    }

    public function showForgotPassword()
    {
        $this->isForgotPassword = true;
        $this->isSignup = false;
        $this->resetValidation();
    }

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->passwordResetStatus = 'We sent a password reset link to your email. Please check your inbox and follow the guidelines.';
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.modal-login');
    }
}
