<?php

namespace App\Providers;

use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\Interfaces\ICartItemRepository;
use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IOrderDetailRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IPaymentRepository;
use App\Repositories\Interfaces\IPermissionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IProductTypeRepository;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\IUserPermissionRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\ProductTypeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserPermissionRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductTypeRepository::class, ProductTypeRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(ICartRepository::class, CartRepository::class);
        $this->app->bind(ICartItemRepository::class, CartItemRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
        $this->app->bind(IOrderDetailRepository::class, OrderDetailRepository::class);
        $this->app->bind(IPaymentRepository::class, PaymentRepository::class);
        $this->app->bind(IPermissionRepository::class, PermissionRepository::class);
        $this->app->bind(IUserPermissionRepository::class, UserPermissionRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
