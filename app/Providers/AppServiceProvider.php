<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function register()
{
    $this->app->singleton(NotificationService::class, function ($app) {
        return new NotificationService();
    });
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          Schema::defaultStringLength(191);
    }
}
