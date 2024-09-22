<?php

use App\Http\Controllers\Review;
use App\Http\Controllers\Customization;
use App\Http\Controllers\GoogleAuth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// FRONTEND BECOME A PARTNER ROUTES

Route::get('/partner-registration', function () {
    return view('partner.partner-registration');
});

Route::get('/partner-confirmation', function () {
    return view('partner.partner-confirmation');
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

Route::get('/profile-basics', [ProfileController::class, 'profileBasics'])->name('customer.profile.basics');
Route::get('/profile-orders', [ProfileController::class, 'profileOrders'])->name('customer.profile.orders');
Route::get('/profile-reviews', [ProfileController::class, 'profileReviews'])->name('customer.profile.reviews');

Route::get('/auth/google/redirect', [GoogleAuth::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuth::class, 'handleGoogleCallback'])->name('google.callback');


// Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('select-apparel');
// Route::post('/select-apparel', [SelectAparrelController::class, 'selectApparelPost'])->name('select-apparel-post');

// Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('select-production-type');
// Route::post('/select-production-type', [SelectProductionTypeController::class, 'selectProductionTypePost'])->name('select-production-type-post');

// Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('select-production-company');
// Route::post('/select-production-company', [SelectProductionCompanyController::class, 'selectProductionCompanyPost'])->name('select-production-company-post');
