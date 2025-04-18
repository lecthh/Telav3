<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
        Log::debug('Google user info received', [
            'id' => $googleUser->id,
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'avatar' => $googleUser->avatar ?? null,
        ]);

        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            Log::info('User not found. Creating new user.');

            try {
                $user = User::create([
                    'user_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt('random_password'),
                    'email_verified_at' => now(),
                    'avatar' => $googleUser->avatar ?? null,
                    'role_type_id' => 1,
                ]);
            } catch (\Exception $e) {
                Log::error('User creation failed: ' . $e->getMessage());
            }


            Log::info('New user registered via Google', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'role_type_id' => $user->role_type_id
            ]);
        } else {
            Log::info('Existing user found', [
                'user_id' => $user->user_id,
                'email' => $user->email,
                'role_type_id' => $user->role_type_id
            ]);
        }

        Auth::login($user);
        Log::info('User logged in', [
            'user_id' => $user->user_id,
            'role_type_id' => $user->role_type_id
        ]);

        if ($user->role_type_id == 2) {
            Log::debug('Redirecting Production Company User');
            $admin = \App\Models\ProductionCompany::where('user_id', $user->user_id)->first();
            if ($admin) {
                Log::debug('ProductionCompany found', ['company_id' => $admin->id]);
                session(['admin' => $admin]);
                return redirect()->route('printer-dashboard')->with('success', 'Logged in successfully');
            } else {
                Log::warning('ProductionCompany not found for user_id: ' . $user->user_id);
            }
        } else if ($user->role_type_id == 3) {
            Log::debug('Redirecting Designer User');
            $admin = \App\Models\Designer::where('user_id', $user->user_id)->first();
            if ($admin) {
                Log::debug('Designer found', ['designer_id' => $admin->id]);
                session(['admin' => $admin]);
                return redirect()->route('designer-dashboard')->with('success', 'Logged in successfully');
            } else {
                Log::warning('Designer not found for user_id: ' . $user->user_id);
            }
        }

        Log::debug('Redirecting to home (customer or fallback)');
        return redirect()->route('home')->with('success', 'Logged in successfully');
    }
}
