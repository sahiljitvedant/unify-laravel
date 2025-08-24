<?php
namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // dd(1);
        if (!session()->has('lastActivityTime'))
        {
            session(['lastActivityTime' => now()]);
        }


        $inactiveTime = now()->diffInMinutes(session('lastActivityTime'));
        // dd($inactiveTime);

        if ($inactiveTime >= 120)
        {
            Auth::logout();
            session()->flush();
            return redirect()->route('login_get')->with('error', 'Session expired due to inactivity.');
        }


        session(['lastActivityTime' => now()]);
        return $next($request);
    }
}
