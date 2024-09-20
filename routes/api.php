<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
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
    'middleware' => ['auth:api', 'check.role:manage-roles'],
    'prefix' => 'users'
], function ($router) {
    Route::apiResource('', UserController::class);
    Route::put('is-admin/{id}', [UserController::class, 'isAdmin']);
});

Route::group([
    'middleware' => ['auth:api', 'check.role:manage-roles'],
    'prefix' => 'roles'
], function ($router) {
    Route::apiResource('', RoleController::class);
});


Route::group([
    'middleware' => ['auth:api', 'check.role:manage-roles'],
    'prefix' => 'products'
], function ($router) {
    Route::apiResource('', ProductController::class)->except(['index','show']);
    Route::put('quantity', [ProductController::class, 'updateQuantityProduct']);
});
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);


Route::group([
    'middleware' => ['auth:api', 'check.role:manage-roles'],
], function ($router) {
    Route::apiResource('product-types', ProductTypeController::class)->except(['index', 'show']);
});
Route::get('product-types', [ProductTypeController::class,'index']);
Route::get('product-types/{id}', [ProductTypeController::class, 'show']);

Route::get('carts', [CartController::class,'get'])->middleware('auth:api');









