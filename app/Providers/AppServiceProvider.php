<?php

namespace App\Providers;

use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IAttributeValueRepository;
use App\Repositories\Interfaces\ICartItemRepository;
use App\Repositories\Interfaces\ICartRepository;
use App\Repositories\Interfaces\IProductAttributeRepository;
use App\Repositories\Interfaces\IOrderDetailRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IPaymentRepository;
use App\Repositories\Interfaces\IPermissionRepository;
use App\Repositories\Interfaces\IProductCombinationRepository;
use App\Repositories\Interfaces\IProductImageRepository;
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
use App\Repositories\ProductCombinationRepository;
use App\Repositories\ProductImageRepository;
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
        $this->app->bind(IProductImageRepository::class, ProductImageRepository::class);
        $this->app->bind(IAttributeValueRepository::class, AttributeValueRepository::class);
        $this->app->bind(IProductAttributeRepository::class, ProductAttributeRepository::class);
        $this->app->bind(IAttributeRepository::class, AttributeRepository::class);
        $this->app->bind(IProductCombinationRepository::class, ProductCombinationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
