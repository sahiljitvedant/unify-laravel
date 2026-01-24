<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Header;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $headers = Header::where('status', 1)
                ->where('is_deleted', 0)
                ->with('subheaders')
                ->orderBy('sequence_no')
                ->get();

            $view->with('menuHeaders', $headers);
        });
    }
}
