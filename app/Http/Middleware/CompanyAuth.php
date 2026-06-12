<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('company_id')) {
            return redirect()->route('company.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}
