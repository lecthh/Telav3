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
        // Validate the incoming request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token'    => 'required'
        ]);
    
        // Find the user by email and token
        $user = User::where('email', $request->email)
                    ->where('passwordToken', $request->token)
                    ->first();
    
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'Invalid or expired token.']);
        }
    
        // Update the user's password and clear the token
        $user->update([
            'password'      => Hash::make($request->password),
            'passwordToken' => null
        ]);

        Auth::login($user);
    
        // Use switch-case to handle redirection for Designer and Production Company only
        switch ($user->role_type_id) {
            case 2:
                $admin = ProductionCompany::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Production company password update - redirecting to printer dashboard', [
                    'user_id'  => $user->user_id,
                    'admin_id' => $admin ? $admin->id : null
                ]);
                return redirect()->route('printer-dashboard')->with('success', 'Your password has been set.');
                
            case 3:
                $admin = Designer::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Designer password update - redirecting to designer dashboard', [
                    'user_id'    => $user->user_id, 
                    'designer_id'=> $admin ? $admin->designer_id : null
                ]);
                return redirect('/designer-dashboard')->with('success', 'Your password has been set.');
                
            default:
                return redirect()->route('/')->with('success', 'Your password has been set.');
        }
    }
    

    public function logout()
    {
        Auth::logout();
        session()->forget('admin');
        return redirect()->route('home');
    }
}
