<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\ProductRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductTypeRepository::class, ProductTypeRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
