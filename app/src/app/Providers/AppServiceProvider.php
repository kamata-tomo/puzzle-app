<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrapFive();


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // bootメソッド内にこの3行を追加
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
