<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => ['auth:api', 'check.role:manage-roles']
], function ($router) {
    Route::get('users/self', [UserController::class, 'getSelf']);
    Route::put('users/is-admin/{id}', [UserController::class, 'isAdmin']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::put('products/quantity', [ProductController::class, 'updateQuantityProduct']);
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('product-types', ProductTypeController::class)->except(['index', 'show']);
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/search', [ProductController::class, 'search']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::get('product-types', [ProductTypeController::class, 'index']);
Route::get('product-types/{id}', [ProductTypeController::class, 'show']);

Route::get('carts', [CartController::class, 'get'])->middleware('auth:api');
Route::get('cart-items', [CartItemController::class, 'get'])->middleware('auth:api');
