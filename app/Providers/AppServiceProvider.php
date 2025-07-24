<?php

namespace App\Providers;

use App\Contracts\Interfaces\AuthorInterface;
use App\Contracts\Interfaces\BukuInterface;
use App\Models\Author;
use App\Models\Buku;
use App\Observers\AuthorObserver;
use App\Observers\BukuObserver;
use App\Services\AuthorService;
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
            BukuService::class,
            AuthorInterface::class,
            AuthorService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Buku::observe(BukuObserver::class);
        Author::observe(AuthorObserver::class);
    }
}
