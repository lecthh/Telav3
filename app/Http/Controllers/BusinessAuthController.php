<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BusinessAuthController extends Controller
{
    public function showSetPasswordForm(Request $request, $token)
    {
        $user = User::where('email', $request->email)
            ->where('passwordToken', $token)
            ->first();
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid or expired token.']);
        }
        return view('auth.create_password', ['token' => $token, 'email' => $request->email]);
    }

    public function storePassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        $user = User::where('email', $request->email)
            ->where('passwordToken', $request->token)
            ->first();
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid or expired token.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'passwordToken' => null
        ]);

        return redirect()->route('login')->with('success', 'Your password has been set.');
    }

    public function login()
    {
        return view('auth.login_business');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->with('success', 'Logged in successfully');
        } else {
            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }
    }
}