<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Redirect based on user type
            if (Auth::user()->is_admin == 1) {
                return redirect()->route('list_dashboard');
            } else {
                return redirect()->route('member_dashboard');
            }
        }

        return $next($request);
    }
}
