<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    // Share customer data with all customer views
    View::composer('customer.*', function ($view) {
        if (auth()->guard('customer')->check()) {
            $view->with('customer', auth()->guard('customer')->user());
        }
    });
}
}
