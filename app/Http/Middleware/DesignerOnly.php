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
            'session_has_admin' => session()->has('admin')
        ]);

        if (Auth::check() && Auth::user()->role_type_id == 3 && session()->has('admin')) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'You must be logged in as a designer to access this page.');
    }
}
