<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cart', function () {
    return view('cart.cart');
});

Route::get('/checkout', function () {
    return view('cart.checkout');
});
