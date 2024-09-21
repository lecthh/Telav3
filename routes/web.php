<?php

use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
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

Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('select-apparel');
Route::post('/select-apparel', [SelectAparrelController::class, 'selectApparelPost'])->name('select-apparel-post');

Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('select-production-type');
Route::post('/select-production-type', [SelectProductionTypeController::class, 'selectProductionTypePost'])->name('select-production-type-post');

Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('select-production-company');
Route::post('/select-production-company', [SelectProductionCompanyController::class, 'selectProductionCompanyPost'])->name('select-production-company-post');

Route::get('cuztomization/{apparel}/{productionType}/{productionCompany}', [CustomizationController::class, 'customization'])->name('customization');
Route::post('cuztomization', [CustomizationController::class, 'customizationPost'])->name('customization-post');
