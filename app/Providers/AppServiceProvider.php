<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AuthenticateCustom;
use App\Http\Middleware\SessionTimeout;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\AboutPage;
use Illuminate\Support\Facades\View;
use App\Models\SubHeader;
use App\Models\Header;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS for all URLs in non-local environments
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Route::aliasMiddleware('auth.custom', AuthenticateCustom::class);
        Route::aliasMiddleware('session.timeout', SessionTimeout::class);

        // Share About Pages globally
        view()->composer('*', function ($view) {
            $products = AboutPage::where('status', 1)->get();
            $view->with('products', $products);
        });

        // Prevent issues during migration
        if (!Schema::hasTable('tbl_theme_settings')) {
            return;
        }

        // Load theme settings from DB
        $theme = DB::table('tbl_theme_settings')->first();

        if ($theme) {
            config()->set('app.theme_color', $theme->theme_color);
            config()->set('app.sidebar_color', $theme->sidebar_color);
            config()->set('app.sidebar_light', $theme->sidebar_light);
            config()->set('app.other_color_fff', $theme->other_color_fff);
            config()->set('app.black_color', $theme->black_color);
            config()->set('app.font_size', $theme->font_size);
            config()->set('app.font_size_10px', $theme->font_size_10px);
            config()->set('app.front_font_size', $theme->front_font_size);
        }

        View::composer('*', function ($view) {

            // All active headers
            $headers = Header::where('status', 1)
                ->where('is_deleted', 0)
                ->orderBy('sequence_no')
                ->get();
            
            $view->with('headers', $headers);
            
            $menus = [];
    
            foreach ($headers as $header) {
    
                $pages = AboutPage::where('header_id', $header->id)
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->get();
    
                if ($pages->isEmpty()) continue;
    
                $subheaders = SubHeader::where('header_id', $header->id)
                    ->where('status', 1)
                    ->where('is_deleted', 0)
                    ->get()
                    ->keyBy('id');
    
                foreach ($pages as $page) {
                    if ($page->subheader_id && isset($subheaders[$page->subheader_id])) {
    
                        $menus[$header->id]['title'] = $header->title;
    
                        $menus[$header->id]['with_subheader'][$page->subheader_id]['name']
                            = $subheaders[$page->subheader_id]->name;
    
                        $menus[$header->id]['with_subheader'][$page->subheader_id]['pages'][] = $page;
    
                    } else {
    
                        $menus[$header->id]['title'] = $header->title;
                        $menus[$header->id]['without_subheader'][] = $page;
                    }
                }
            }
    
            $view->with('menus', $menus);
        });
    }
}
