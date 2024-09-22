<?php

use App\Http\Controllers\Review;
use App\Http\Controllers\Customization;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// FRONTEND BECOME A PARTNER ROUTES

Route::get('/partner-production', function () {
    return view('partner.partner-production');
});


Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('customer.place-order.select-apparel');
Route::get('/select-production-type', [SelectProductionTypeController::class, 'selectProductionType'])->name('customer.place-order.select-production-type');
Route::get('/select-production-company', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('customer.place-order.select-production-company');
Route::get('/customization', [Customization::class, 'customization'])->name('customer.place-order.customization');
Route::get('/review', [Review::class, 'review'])->name('customer.place-order.review');

// FRONTEND CART FOLDER ROUTES
Route::get('/cart', function () {
    return view('cart.cart');
});

Route::get('/checkout', function () {
    return view('cart.checkout');
});

Route::get('/confirmation', function () {
    return view('cart.confirmation');
});

// FRONTEND CUSTOMER PROFILE FOLDER ROUTES
Route::get('/profile-basics', function () {
    return view('customer.profile-basics');
});

Route::get('/profile-orders', function () {
    return view('customer.profile-orders');
});

Route::get('/profile-reviews', function () {
    return view('customer.profile-reviews');
});


// Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('select-apparel');
// Route::post('/select-apparel', [SelectAparrelController::class, 'selectApparelPost'])->name('select-apparel-post');

// Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('select-production-type');
// Route::post('/select-production-type', [SelectProductionTypeController::class, 'selectProductionTypePost'])->name('select-production-type-post');

// Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('select-production-company');
// Route::post('/select-production-company', [SelectProductionCompanyController::class, 'selectProductionCompanyPost'])->name('select-production-company-post');
