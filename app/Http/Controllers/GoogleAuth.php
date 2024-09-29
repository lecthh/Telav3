<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuth extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($googleUser);
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            return redirect()->route('home')->withErrors('Error logging in with Google.');
        }
    }


    private function _registerOrLoginUser($googleUser)
    {
        $user = User::where('user_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::create([
                'user_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt('random_password'),
                'email_verified_at' => now(),
            ]);
        }
        Auth::login($user);

        return redirect()->route('home');
    }
}
