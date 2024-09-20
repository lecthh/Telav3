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

Route::get('/confirmation', function () {
    return view('cart.confirmation');
});

Route::get('/profile-basics', function () {
    return view('customer.profile-basics');
});

Route::get('/profile-orders', function () {
    return view('customer.profile-orders');
});

Route::get('/profile-reviews', function () {
    return view('customer.profile-reviews');
});
