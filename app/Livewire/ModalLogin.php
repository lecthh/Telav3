<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalLogin extends ModalComponent
{
    public $isSignup = false;
    public $isForgotPassword = false;
    public $name, $email, $password, $password_confirmation;
    public $rememberMe = false;
    public $passwordResetStatus = null;


    protected $rules = [
        'email' => 'required|email',
    ];

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function mount()
    {
        Session::put('url.intended', URL::previous());
    }

    public function goBack()
    {
        $this->isSignup = false;
        $this->isForgotPassword = false;
    }


    public function login()
    {
        try {
            Log::info('Login function called', [
                'email' => $this->email,
                'password' => $this->password,
                'remember_me' => $this->rememberMe,
            ]);

            $validatedData = $this->validate([
                'password' => 'required|min:8',
            ]);

            Log::info('Login validation successful', $validatedData);


            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->rememberMe)) {
                Log::info('User logged in successfully', ['email' => $this->email]);

                return redirect()->to(Session::get('url.intended', '/'));
            }
            Log::warning('Login failed for email', ['email' => $this->email]);
            $this->addError('login_error', 'Invalid email or password.');
        } catch (\Exception $e) {
            Log::error('Error in login function', ['message' => $e->getMessage()]);
        }
    }


    public function toggleSignup()
    {
        $this->isSignup = !$this->isSignup;
        $this->isForgotPassword = false;
        $this->resetValidation();
    }

    public function toggleModal()
    {
        $this->closeModal();
    }

    public function showForgotPassword()
    {
        $this->isForgotPassword = true;
        $this->isSignup = false;
        $this->resetValidation();
    }

    public function register()
    {
        try {
            Log::info('Register function called', [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            $validatedData = $this->validate([
                'name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
            ]);
            Log::info('Validation successful', $validatedData);

            $user = User::create([
                'user_id' => uniqid(),
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_type_id' => 1,
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            Auth::login($user);
            Log::info('User logged in successfully');

            return redirect()->to('/');
        } catch (\Exception $e) {
            Log::error('Error in register function', ['message' => $e->getMessage()]);
            session()->flash('error', 'Registration failed. Please check logs.');
        }
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
