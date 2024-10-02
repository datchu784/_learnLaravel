<?php

use App\Http\Controllers\AttributeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('product-variants/filter', [ProductVariantController::class, 'filter']);

Route::group([
    'middleware' => ['auth:api']
], function ($router) {
    Route::get('carts', [CartController::class, 'get']);
    Route::apiResource('cart-items', CartItemController::class)->except('show');
    Route::get('users/self', [UserController::class, 'getSelf']);
    Route::get('orders/index',[OrderController::class, 'indexAuthenticated']);
    Route::get('orders/show/{id}', [OrderController::class, 'showAuthenticated']);
    Route::delete('orders/{id}', [OrderController::class, 'destroyAuthenticated']);
    Route::post('payments', [PaymentController::class, 'store']);
    Route:: put('users/self',[UserController:: class, 'updateBySelf']);

});

Route::group(['middleware' => 'auth:api', 'check.role:manage-roles'], function ($router) {
    // Routes chỉ cho manage-system
    Route::group(['middleware' => ['check.permission:manage-system']], function ($router) {
        Route::put('users/is-admin/{id}', [UserController::class, 'isAdmin']);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::apiResource('user-permissions', UserPermissionController::class);
        Route::put('products/quantity', [ProductController::class, 'updateQuantityProduct']);
        Route::apiResource('products', ProductController::class)->except(['index', 'show']);
        Route::apiResource('product-types', ProductTypeController::class)->except(['index', 'show']);
        Route::apiResource('orders', OrderController::class)->except(['store', 'update', 'destroy']);
        Route::put('product-images/main/{id}', [ProductImageController::class, 'changeMain']);
        Route::post('product-images/{id}', [ProductImageController::class, 'updateImage']);
        Route::apiResource('product-images', ProductImageController::class)->except(['show', 'index', 'update']);
        Route::apiResource('sizes', SizeController::class)->except('index');
        Route::apiResource('colors', ColorController::class)->except('index');
        Route::apiResource('attributes', AttributeController::class)->except('index');
        Route::apiResource('product-attributes', ProductAttributeController::class)->except('index');
        Route::apiResource('product-variants', ProductVariantController::class)->except('index');
    });

    // Routes cho  manage-system hoặc manage-users
    Route::group(['middleware' => ['check.permission:manage-system,manage-users']], function ($router) {
        Route::apiResource('users', UserController::class);
    });
});

Route::get('products', [ProductController::class, 'index'])->middleware('ddos','csrf');
Route::get('products/search', [ProductController::class, 'search']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::get('product-types', [ProductTypeController::class, 'index']);
Route::get('product-types/{id}', [ProductTypeController::class, 'show']);

Route::get('product-images', [ProductImageController::class, 'index']);

Route::get('sizes', [SizeController::class,'index']);
Route::get('colors', [ColorController::class,'index']);
Route::get('attributes', [AttributeController::class,'index']);
Route::get('product-attributes', [ProductAttributeController::class,'index']);






