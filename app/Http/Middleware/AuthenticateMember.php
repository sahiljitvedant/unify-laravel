<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMember
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and NOT admin
        if (!Auth::check() || Auth::user()->is_admin == 1) {
            return redirect()->route('access_denied')
                ->withErrors(['error' => 'Admins cannot access this page.']);
        }

        return $next($request);
    }
}
