<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('search', 'search');

    Route::middleware('auth:api')->group(function () {
        Route::post('', 'store');
        Route::delete('{id}', 'delete')->whereNumber('id');
    });
});

Route::prefix('cart')->controller(CartItemController::class)->middleware('auth:api')->group(function () {
    Route::get('{product_id}', 'store');
    Route::delete('{id}', 'delete')->whereNumber('id');
});

Route::prefix('order')->controller(OrderController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('', 'store');
    Route::delete('{id}', 'delete')->whereNumber('id');
});

