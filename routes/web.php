<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $user = \App\Models\User::query()->with('cartItems.product')->first();
    $finalPrice = 0;
    foreach ($user->cartItems as $cartItem) {
        $finalPrice += $cartItem->product->price;
    }
    return  $finalPrice;
    return $user;
});
