<?php

namespace App\Providers;

use App\Contracts\Interfaces\BukuInterface;
use App\Services\BukuService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BukuInterface::class,
            BukuService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
