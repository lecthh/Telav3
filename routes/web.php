<?php

use App\Exports\CustomizationDetailsExport;
use App\Http\Controllers\AwaitingOrderController;
use App\Http\Controllers\BusinessAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationLinkController;
use App\Http\Controllers\ConfirmationMessageController;
use App\Http\Controllers\ConfirmBulkController;
use App\Http\Controllers\Review;
use App\Http\Controllers\Customization;
use App\Http\Controllers\CustomizationExportController;
use App\Http\Controllers\GoogleAuth;
use App\Http\Controllers\PartnerRegistration;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelectAparrelController;
use App\Http\Controllers\SelectProductionCompanyController;
use App\Http\Controllers\SelectProductionTypeController;
use App\Http\Controllers\PrinterOrderController;
use App\Http\Controllers\DesignerOrderController;
use App\Http\Controllers\DesignInProgressController;
use App\Http\Controllers\FinalizeOrderController;
use App\Http\Controllers\PendingRequestController;
use App\Http\Controllers\PrintingInProgressController;
use App\Http\Controllers\EditProducerAccountController;
use App\Http\Controllers\ReadyController;
use App\Http\Middleware\PreventBackHistory;
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

// Printer Partner Routes
Route::get('/printer-dashboard', function () {
    return view('partner.printer.dashboard');
})->name('printer-dashboard')->middleware('ProductionAdminOnly');

// Printer Partner Routes
Route::prefix('partner')->name('partner.')->middleware('ProductionAdminOnly')->group(function () {
    Route::prefix('printer')->name('printer.')->group(function () {
        Route::get('/profile/basics', function () {
            return view('partner.printer.profile.basics');
        })->name('profile.basics');

        Route::get('/profile/pricing', function () {
            return view('partner.printer.profile.pricing');
        })->name('profile.pricing');

        Route::post('/profile/update', [EditProducerAccountController::class, 'update'])->name('profile.update');

        Route::get('/orders', [PendingRequestController::class, 'index'])->name('orders');
        Route::get('/pending-x/{order_id}', [PendingRequestController::class, 'pendingOrder'])->name('pending-order-x');
        Route::post('/assign-designer/{order_id}', [PendingRequestController::class, 'assignDesigner'])->name('assign-designer');

        Route::get('/design-in-progress', [DesignInProgressController::class, 'designInProgress'])->name('design-in-progress');
        Route::get('/design-x/{order_id}', [DesignInProgressController::class, 'designOrder'])->name('design-x');

        Route::get('/finalize-order', [FinalizeOrderController::class, 'finalize'])->name('finalize-order');
        Route::get('/finalize-x/{order_id}', [FinalizeOrderController::class, 'finalizeOrder'])->name('finalize-x');
        Route::post('/finalize-x/{order_id}/post', [FinalizeOrderController::class, 'finalizeOrderPost'])->name('finalize-x-post');

        Route::get('/awaiting-printing', [AwaitingOrderController::class, 'awaitingPrinting'])->name('awaiting-printing');
        Route::get('/awaiting-x/{order_id}', [AwaitingOrderController::class, 'awaitingOrder'])->name('awaiting-x');
        Route::post('/awaiting-x/{order_id}/post', [AwaitingOrderController::class, 'awaitingOrderPost'])->name('awaiting-x-post');

        Route::get('/printing-in-progress', [PrintingInProgressController::class, 'printingInProgress'])->name('printing-in-progress');
        Route::get('/printing-x/{order_id}', [PrintingInProgressController::class, 'printingOrder'])->name('printing-x');
        Route::post('/printing-x/{order_id}/post', [PrintingInProgressController::class, 'printingOrderPost'])->name('printing-x-post');

        Route::get('/ready', [ReadyController::class, 'ready'])->name('ready');
        Route::get('/ready-x/{order_id}', [ReadyController::class, 'readyOrder'])->name('ready-x');
        Route::post('/ready-x/{order_id}/post', [ReadyController::class, 'readyOrderPost'])->name('ready-x-post');

        Route::get('/completed', [PrinterOrderController::class, 'completed'])->name('completed');
        Route::get('/completed-x/{order_id}', [PrinterOrderController::class, 'completedOrder'])->name('completed-x');

        Route::post('/cancel-order/{order_id}', [PrinterOrderController::class, 'cancelOrder'])->name('cancel-order');
    });
});

//Designer Routes
Route::get('/designer-dashboard', [DesignerOrderController::class, 'dashboard'])->name('designer-dashboard')->middleware('DesignerOnly');
Route::prefix('partner')->name('partner.')->middleware('DesignerOnly')->group(function () {
    Route::prefix('designer')->name('designer.')->group(function () {
        Route::get('/orders', [DesignerOrderController::class, 'index'])->name('orders');
        Route::get('/assigned-x/{order_id}', [DesignerOrderController::class, 'assignedOrder'])->name('assigned-x');
        Route::post('/assigned-x/{order_id}/post', [DesignerOrderController::class, 'assignedOrderPost'])->name('assigned-x-post');
        Route::get('/completed', [DesignerOrderController::class, 'complete'])->name('complete');
        Route::get('/complete-x/{order_id}', [DesignerOrderController::class, 'completeOrder'])->name('complete-x');
        Route::post('/cancel-design-assignment/{order_id}', [DesignerOrderController::class, 'cancelDesignAssignment'])->name('cancel-design-assignment');
    });
});

Route::get('/select-apparel', [SelectAparrelController::class, 'selectApparel'])->name('customer.place-order.select-apparel');
Route::get('/select-production-type/{apparel}', [SelectProductionTypeController::class, 'selectProductionType'])->name('customer.place-order.select-production-type');
Route::get('/select-production-company/{apparel}/{productionType}', [SelectProductionCompanyController::class, 'selectProductionCompany'])->name('customer.place-order.select-production-company');
Route::get('/customization/{apparel}/{productionType}/{company}', [Customization::class, 'customization'])->name('customer.place-order.customization');
Route::post('/customization/{apparel}/{productionType}/{company}', [Customization::class, 'storeCustomization'])->name('customer.place-order.customization-post');
Route::get('/review/{apparel}/{productionType}/{company}', [Review::class, 'review'])->name('customer.place-order.review');
Route::post('/review/{apparel}/{productionType}/{company}', [Review::class, 'storeReview'])->name('customer.place-order.review-post');

Route::middleware(['CustomerOnly'])->group(function () {
    Route::get('/cart', [CartController::class, 'showCart'])->name('customer.cart');
    Route::post('/cart', [CartController::class, 'checkout'])->name('customer.cart.post');
    Route::get('/cart/removeitem/{cartItemId}', [CartController::class, 'removeCartItem'])->name('customer.remove-cart-item');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('customer.checkout');
    Route::post('/checkout/create', [CheckoutController::class, 'postCheckout'])->name('customer.checkout.post');
    Route::get('/checkout/delete/{cartItemId}', [CheckoutController::class, 'deleteCartItem'])->name('customer.checkout.delete');

    Route::get('/profile-basics', [ProfileController::class, 'showProfileDetails'])->name('customer.profile.basics');
    Route::get('/profile-orders', [ProfileController::class, 'profileOrders'])->name('customer.profile.orders');
    Route::get('/profile-reviews', [ProfileController::class, 'profileReviews'])->name('customer.profile.reviews');
    Route::get('/confirmation', [ConfirmationMessageController::class, 'confirmation'])->name('customer.confirmation');

    Route::get('/inbox', function () {
        return view('customer.inbox.messages');
    })->name('customer.messages');

    Route::get('/inbox/chat', function () {
        return view('customer.inbox.chatroom');
    })->name('customer.chat');
});

Route::get('/set-password/{token}', [BusinessAuthController::class, 'showSetPasswordForm'])->name('set-password');
Route::post('/set-password/store', [BusinessAuthController::class, 'storePassword'])->name('password.store');

Route::get('/login', [BusinessAuthController::class, 'login'])->name('login');
Route::post('/login/user', [BusinessAuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [BusinessAuthController::class, 'logout'])->name('logout')->middleware(PreventBackHistory::class);

Route::get('/confirm-bulk/{token}', [ConfirmBulkController::class, 'confirmBulk'])->name('confirm-bulk');
Route::post('/confirm-bulk/post', [ConfirmBulkController::class, 'confirmBulkPost'])->name('confirm-bulk-post');

Route::get('/confirm-bulk-custom/{token}', [ConfirmationLinkController::class, 'confirmBulkCustom'])->name('confirm-bulk-custom');
Route::post('/confirm-bulk-custom/post', [ConfirmationLinkController::class, 'confirmBulkCustomPost'])->name('confirm-bulk-custom-post');

Route::get('/confirm-jerseybulk-custom/{token}', [ConfirmationLinkController::class, 'confirmJerseyBulkCustom'])->name('confirm-jerseybulk-custom');
Route::post('/confirm-jerseybulk-custom/post', [ConfirmationLinkController::class, 'confirmJerseyBulkCustomPost'])->name('confirm-jerseybulk-custom-post');

Route::get('/auth/google/redirect', [GoogleAuth::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuth::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('export-customization/{order_id}', [CustomizationExportController::class, 'exportExcel'])->name('export.customization')->withoutMiddleware(PreventBackHistory::class);
Route::get('/export/customization/{order_id}', [CustomizationExportController::class, 'export'])->name('export.customization');
