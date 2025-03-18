<?php

namespace App\Http\Controllers\Auth;

use App\Models\Designer;
use App\Models\ProductionCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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
            'email' => 'required|e mail',
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

    public function logout()
    {
        Auth::logout();
        session()->forget('admin');
        return redirect()->route('home');
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
        $user = User::where('email', $request->email)->first();
        if (!$user || $user->role_type_id == 1) {
            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            Log::info('User login attempt', [
                'user_id' => $user->user_id,
                'role_type_id' => $user->role_type_id,
                'is_designer' => $user->role_type_id == 3
            ]);

            if ($user->role_type_id == 2) {
                $admin = ProductionCompany::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Production company login - redirecting to printer dashboard', [
                    'user_id' => $user->user_id,
                    'admin_id' => $admin ? $admin->id : null
                ]);
                return redirect()->route('printer-dashboard')->with('success', 'Logged in successfully');
            } else if ($user->role_type_id == 3) {
                $admin = Designer::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Designer login - redirecting to designer dashboard', [
                    'user_id' => $user->user_id, 
                    'designer_id' => $admin ? $admin->designer_id : null
                ]);
                // Directly use the URL, don't use the route helper or intended
                return redirect('/designer-dashboard')->with('success', 'Logged in successfully');
            }
        } else {
            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }
    }
}
