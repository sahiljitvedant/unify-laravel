<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthenticateCustom
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
        {
            return redirect()->route('access_denied')->withErrors(['error' => 'Unauthorized access. Please login first.']);
        }
        return $next($request);
    }
}


