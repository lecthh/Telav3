<?php

use App\Http\Controllers\BusinessAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationMessageController;
use App\Http\Controllers\Review;
use App\Http\Controllers\Customization;
use App\Http\Controllers\GoogleAuth;
use App\Http\Controllers\PartnerRegistration;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use App\Http\Controllers\PrinterOrderController;
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

//frontend printer partner dashboard
Route::get('/printer-dashboard', function () {
    return view('partner.printer.dashboard');
})->name('printer-dashboard');
// Printer Partner Routes
Route::prefix('partner')->name('partner.')->group(function () {
    Route::prefix('printer')->name('printer.')->group(function () {
        Route::get('/orders', [PrinterOrderController::class, 'index'])->name('orders');
        Route::get('/pending-x', [PrinterOrderController::class, 'pendingOrder'])->name('pending-order-x');
        Route::get('/design-in-progress', [PrinterOrderController::class, 'designInProgress'])->name('design-in-progress');
        Route::get('/design-x', [PrinterOrderController::class, 'designOrder'])->name('design-x');
        Route::get('/finalize-order', [PrinterOrderController::class, 'finalize'])->name('finalize-order');
        Route::get('/finalize-x', [PrinterOrderController::class, 'finalizeOrder'])->name('finalize-x');
        Route::get('/awaiting-printing', [PrinterOrderController::class, 'awaitingPrinting'])->name('awaiting-printing');
        Route::get('/awaiting-x', [PrinterOrderController::class, 'awaitingOrder'])->name('awaiting-x');
        Route::get('/printing-in-progress', [PrinterOrderController::class, 'printingInProgress'])->name('printing-in-progress');
        Route::get('/printing-x', [PrinterOrderController::class, 'printingOrder'])->name('printing-x');
        Route::get('/ready', [PrinterOrderController::class, 'ready'])->name('ready');
        Route::get('/ready-x', [PrinterOrderController::class, 'readyOrder'])->name('ready-x');
        Route::get('/completed', [PrinterOrderController::class, 'completed'])->name('completed');
        Route::get('/completed-x', [PrinterOrderController::class, 'completedOrder'])->name('completed-x');
    });
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
Route::get('/cart/removeitem/{cartItemId}', [CartController::class, 'removeCartItem'])->name('customer.remove-cart-item');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('customer.checkout');
Route::post('/checkout/create', [CheckoutController::class, 'postCheckout'])->name('customer.checkout.post');
Route::get('/checkout/delete/{cartItemId}', [CheckoutController::class, 'deleteCartItem'])->name('customer.checkout.delete');

Route::get('/confirmation', [ConfirmationMessageController::class, 'confirmation'])->name('customer.confirmation');

Route::get('/set-password/{token}', [BusinessAuthController::class, 'showSetPasswordForm'])->name('set-password');
Route::post('/set-password/store', [BusinessAuthController::class, 'storePassword'])->name('password.store');

Route::get('/login', [BusinessAuthController::class, 'login'])->name('login');
Route::post('/login/user', [BusinessAuthController::class, 'loginPost'])->name('login.post');


//order confirmation
Route::get('/confirm-bulk', function () {
    return view('customer.order-confirmation.standard-bulk');
});
Route::get('/confirm-bulk-custom', function () {
    return view('customer.order-confirmation.bulk-customized');
});
Route::get('/confirm-jerseybulk-custom', function () {
    return view('customer.order-confirmation.jersey-bulk-customized');
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
