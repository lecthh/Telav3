<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

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
            return $this->_registerOrLoginUser($googleUser);
        } catch (\Exception $e) {
            return redirect()->route('home')->withErrors('Error logging in with Google.');
        }
    }


    private function _registerOrLoginUser($googleUser)
    {
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = User::create([
                'user_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt('random_password'),
                'email_verified_at' => now(),
                'avatar' => $googleUser->avatar ?? null,
                'role_type_id' => 1, // Default to customer role
            ]);
        }

        Auth::login($user);

        // Redirect based on user role
        if ($user->role_type_id == 2) {
            // Production company
            $admin = \App\Models\ProductionCompany::where('user_id', $user->user_id)->first();
            if ($admin) {
                session(['admin' => $admin]);
                return redirect()->route('printer-dashboard')->with('success', 'Logged in successfully');
            }
        } else if ($user->role_type_id == 3) {
            // Designer
            $admin = \App\Models\Designer::where('user_id', $user->user_id)->first();
            if ($admin) {
                session(['admin' => $admin]);
                return redirect()->route('designer-dashboard')->with('success', 'Logged in successfully');
            }
        }

        // Default redirect to home for customers or if admin object not found
        return redirect()->route('home')->with('success', 'Logged in successfully');
    }
}
