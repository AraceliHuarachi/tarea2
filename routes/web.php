<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
route::get('/prueba', function () {
    return 'hola';
});

Route::get('orders/orderproduct', [OrderController::class, 'orderProduct'])->name('orders.orderproduct');

Route::resource('products', ProductController::class);

Route::resource('categories', CategoryController::class);

Route::resource('clients', ClientController::class);

Route::resource('orders', OrderController::class);
