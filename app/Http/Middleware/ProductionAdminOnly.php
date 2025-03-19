<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductionAdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role_type_id == 2) {
            // If the admin session data is missing, set it
            if (!session()->has('admin')) {
                $productionCompany = \App\Models\ProductionCompany::where('user_id', Auth::user()->user_id)->first();
                if ($productionCompany) {
                    session(['admin' => $productionCompany]);
                    \Illuminate\Support\Facades\Log::info('Setting missing production company admin session data', ['company_id' => $productionCompany->id]);
                }
            }
            return $next($request);
        }
        abort(401, 'Unauthorized Access');
    }
}
