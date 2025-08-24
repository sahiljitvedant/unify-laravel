<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AuthenticateCustom;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // Force HTTPS for all URLs in non-local environments
         if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
        Route::aliasMiddleware('auth.custom', AuthenticateCustom::class);
        Route::aliasMiddleware('session.timeout', SessionTimeout::class);
    }
}
