<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Mail\VerificationCodeMail;
use App\Traits\Toastable;

class ModalLogin extends ModalComponent
{
    use Toastable;

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

    public function goBack()
    {
        $this->isSignup = false;
        $this->isForgotPassword = false;
        $this->signupStep = 1;
        $this->resetFields();
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
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $this->rememberMe)) {
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
        $this->signupStep = 1;
        $this->resetFields();
    }

    public function toggleModal()
    {
        $this->closeModal();
    }

    public function showForgotPassword()
    {
        $this->isForgotPassword = true;
        $this->isSignup = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->rememberMe = false;
        $this->passwordResetStatus = null;
        $this->userEnteredVerificationCode = '';
        $this->generatedVerificationCode = '';

        $this->resetValidation();
    }

    public function sendEmailVerificationCode()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $this->generatedVerificationCode = mt_rand(100000, 999999);
        session(['email_verification_code' => $this->generatedVerificationCode]);
        session(['email_for_verification' => $this->email]);

        try {
            Mail::to($this->email)->send(new VerificationCodeMail($this->generatedVerificationCode));
            Log::info('Verification code sent to email', ['email' => $this->email, 'code' => $this->generatedVerificationCode]);
            $this->signupStep = 2;
        } catch (\Exception $e) {
            Log::error('Error sending verification code', ['message' => $e->getMessage()]);
            $this->addError('email', 'Unable to send verification code. Please try again later.');
        }
    }

    public function verifyEmailCode()
    {
        // Validate that each box has one digit (you can adjust rules as needed)
        $this->validate([
            'code1' => 'required|numeric',
            'code2' => 'required|numeric',
            'code3' => 'required|numeric',
            'code4' => 'required|numeric',
            'code5' => 'required|numeric',
            'code6' => 'required|numeric',
        ]);

        $userEnteredVerificationCode = $this->code1 . $this->code2 . $this->code3 . $this->code4 . $this->code5 . $this->code6;
        $storedCode = session('email_verification_code');

        if ($userEnteredVerificationCode == $storedCode) {
            // Verification successful; proceed to the next signup step.
            $this->signupStep = 3;
            session()->forget('email_verification_code');
            Log::info('Email verification successful', ['email' => $this->email]);
        } else {
            $this->addError('verification_code', 'The verification code is invalid.');
            Log::warning('Invalid verification code attempt', [
                'entered' => $userEnteredVerificationCode,
                'expected' => $storedCode,
            ]);
        }
    }


    public function resendEmailVerificationCode()
    {
        $this->sendEmailVerificationCode();
        $this->toast('A new verification code has been sent to your email.', 'success');
    }

    public function register()
    {
        if ($this->signupStep !== 3) {
            $this->addError('registration', 'Please complete email verification first.');
            return;
        }

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
                'password' => 'required|min:8|confirmed',
            ]);
            Log::info('Validation successful', $validatedData);

            $user = User::create([
                'user_id' => uniqid(),
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_type_id' => 1,
                'email_verified_at' => now(),
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            Auth::login($user);
            Log::info('User logged in successfully');
            $this->toast('Registration Succesful! Welcome to Tel-A!', 'success');
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
