<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and is admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('access_denied')
                ->withErrors(['error' => 'You must be an admin to access this page.']);
        }

        return $next($request);
    }
}
