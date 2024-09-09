<?php

namespace App\Providers;

use App\Models\ProductType;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductTypeRepositoryInterface;
use App\Repositories\ProductTypeRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Services\ProductTypeService;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductTypeRepositoryInterface:: class,ProductTypeRepository:: class);
        $this->app->bind(ProductRepositoryInterface:: class,ProductRepository:: class);
        // $this->app->bind(ProductService:: class,ProductService:: class);
        // $this->app->bind(ProductTypeService:: class,ProductTypeService:: class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
