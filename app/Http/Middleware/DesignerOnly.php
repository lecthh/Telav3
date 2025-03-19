<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DesignerOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('DesignerOnly middleware check', [
            'auth_check' => Auth::check(),
            'role_id' => Auth::check() ? Auth::user()->role_type_id : null,
            'session_has_admin' => session()->has('admin'),
            'request_path' => $request->path(),
            'user_id' => Auth::check() ? Auth::user()->user_id : null
        ]);

        // Check authentication and role
        if (Auth::check() && Auth::user()->role_type_id == 3) {
            // If the admin session data is missing, set it
            if (!session()->has('admin')) {
                $designer = \App\Models\Designer::where('user_id', Auth::user()->user_id)->first();
                if ($designer) {
                    session(['admin' => $designer]);
                    Log::info('Setting missing designer admin session data', [
                        'designer_id' => $designer->designer_id,
                        'user_id' => Auth::user()->user_id
                    ]);
                } else {
                    Log::error('Designer record not found for user', [
                        'user_id' => Auth::user()->user_id,
                        'user_email' => Auth::user()->email
                    ]);
                    // Continue anyway - we'll recover the session in the controller if needed
                }
            }
            return $next($request);
        }

        Log::warning('Unauthorized access attempt to designer area', [
            'auth_check' => Auth::check(),
            'role_id' => Auth::check() ? Auth::user()->role_type_id : null,
            'path' => $request->path()
        ]);
        
        return redirect()->route('login')->with('error', 'You must be logged in as a designer to access this page.');
    }
}
