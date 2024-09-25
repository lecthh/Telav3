<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Review;
use App\Http\Controllers\Customization;
use App\Http\Controllers\GoogleAuth;
use App\Http\Controllers\PartnerRegistration;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// FRONTEND BECOME A PARTNER ROUTES
Route::get('/partner-registration', [PartnerRegistration::class, 'partnerRegistration'])->name('partner-registration');
Route::get('/partner-confirmation', [PartnerRegistration::class, 'partnerConfirmation'])->name('partner-confirmation');

//frontend partner dashboard
Route::get('/printer-dashboard', function() {
    return view('partner.printer.dashboard');
});

Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('customer.place-order.select-apparel');
Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('customer.place-order.select-production-type');
Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('customer.place-order.select-production-company');
Route::get('/customization/{apparel}/{productionType}/{company}', [Customization::class, 'customization'])->name('customer.place-order.customization');
Route::post('/customization/{apparel}/{productionType}/{company}', [Customization::class, 'storeCustomization'])->name('customer.place-order.customization-post');
Route::get('/review/{apparel}/{productionType}/{company}', [Review::class, 'review'])->name('customer.place-order.review');
Route::post('/review/{apparel}/{productionType}/{company}', [Review::class, 'storeReview'])->name('customer.place-order.review-post');
Route::get('/cart', [CartController::class, 'showCart'])->name('customer.cart');
Route::post('/cart', [CartController::class, 'checkout'])->name('customer.cart.post');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('customer.checkout');

Route::get('/confirmation', function () {
    return view('cart.confirmation');
});

// DESIGNER DASHBOARD FOLDER ROUTES
Route::get('/designer-dashboard', function () {
    return view('partner.designer.dashboard');
});

Route::get('/profile-basics', [ProfileController::class, 'showProfileDetails'])->name('customer.profile.basics');
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
