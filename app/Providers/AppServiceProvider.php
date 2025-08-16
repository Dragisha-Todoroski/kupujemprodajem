<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoryService;
use App\Services\EloquentCategoryService;
use App\Contracts\AdService;
use App\Services\EloquentAdService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryService::class, EloquentCategoryService::class);
        $this->app->bind(AdService::class, EloquentAdService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
