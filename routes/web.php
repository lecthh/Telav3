<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\BusinessAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationLinkController;
use App\Http\Controllers\ConfirmationMessageController;
use App\Http\Controllers\ConfirmBulkController;
use App\Http\Controllers\CustomizationExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DesignerOrderController;
use App\Http\Controllers\DesignerProfileController;
use App\Http\Controllers\PrinterDashboardController;
use App\Http\Controllers\EditProducerAccountController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\PartnerRegistration;
use App\Http\Controllers\Auth\GoogleAuth;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProduceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Middleware\PreventBackHistory;
use App\Models\Designer;
use App\Models\ProductionCompany;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

require base_path('routes/channels.php');
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role_type_id) {
            case 2:
                $admin = ProductionCompany::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Production company login - redirecting to printer dashboard', [
                    'user_id'  => $user->user_id,
                    'admin_id' => $admin ? $admin->id : null
                ]);
                return redirect()->route('printer-dashboard')->with('success', 'Logged in successfully');

            case 3:
                $admin = Designer::where('user_id', $user->user_id)->first();
                session(['admin' => $admin]);
                Log::info('Designer login - redirecting to designer dashboard', [
                    'user_id'     => $user->user_id,
                    'designer_id' => $admin ? $admin->designer_id : null
                ]);
                return redirect('/designer-dashboard')->with('success', 'Logged in successfully');

            case 4:
                Log::info('Super admin login - redirecting to super admin dashboard', [
                    'user_id' => $user->user_id
                ]);
                return redirect()->route('superadmin.users')->with('success', 'Logged in successfully');

            case 1:
            default:
                // Customers or any other role fall back to the welcome page
                break;
        }
    }
    return view('welcome');
})->name('home');


Route::get('/production-services', [App\Http\Controllers\ProductionCompanyController::class, 'index'])->name('production.services');
Route::get('/production-company/{id}', [App\Http\Controllers\ProductionCompanyController::class, 'show'])->name('production.company.show');
Route::get('/order/details/{productionCompany}', [App\Http\Controllers\OrderController::class, 'details'])->name('order.details');

// FRONTEND BECOME A PARTNER ROUTES
Route::get('/partner-registration', [PartnerRegistration::class, 'partnerRegistrationForm'])->name('partner-registration');
Route::get('/partner-confirmation', [PartnerRegistration::class, 'partnerConfirmation'])->name('partner-confirmation');

// Printer Partner Routes
Route::get('/printer-dashboard', [PrinterDashboardController::class, 'index'])
    ->name('printer-dashboard')->middleware('ProductionAdminOnly');

// Printer Partner Routes
Route::prefix('partner')->name('partner.')->middleware('ProductionAdminOnly')->group(function () {
    // Printer Routes
    Route::prefix('printer')->name('printer.')->group(function () {

        // Profile Management
        Route::get('/profile/basics', function () {
            return view('partner.printer.profile.basics');
        })->name('profile.basics');

        Route::get('/profile/pricing', [EditProducerAccountController::class, 'index'])->name('profile.pricing');
        Route::get('/profile/reviews', [PrinterDashboardController::class, 'reviews'])->name('profile.reviews');
        Route::get('/profile/transactions', [PrinterDashboardController::class, 'transactions'])->name('profile.transactions');
        Route::post('/profile/upload-receipt/{order_id}', [PrinterDashboardController::class, 'uploadBalanceReceipt'])->name('profile.upload-receipt');
        Route::post('/profile/update', [EditProducerAccountController::class, 'update'])->name('profile.update');
        Route::post('/profile/pricing/update', [EditProducerAccountController::class, 'updatePricing'])->name('profile.pricing.update');
        Route::get('/profile/notifications', [PrinterDashboardController::class, 'notifications'])->name('profile.notifications');
        Route::post('/profile/notifications/{id}/mark-read', [PrinterDashboardController::class, 'markNotificationAsRead'])->name('profile.notifications.mark-read');
        Route::post('/profile/notifications/mark-all-read', [PrinterDashboardController::class, 'markAllNotificationsAsRead'])->name('profile.notifications.mark-all-read');

        // Order Management
        Route::get('/orders', [OrderProduceController::class, 'pending'])->name('orders');
        Route::get('/pending-x/{order_id}', [OrderProduceController::class, 'pendingOrder'])->name('pending-order-x');
        Route::post('/assign-designer/{order_id}', [OrderProduceController::class, 'assignDesigner'])->name('assign-designer');

        // Design Management
        Route::get('/design-in-progress', [OrderProduceController::class, 'designInProgress'])->name('design-in-progress');
        Route::get('/design-x/{order_id}', [OrderProduceController::class, 'designOrder'])->name('design-x');

        // Finalization
        Route::get('/finalize-order', [OrderProduceController::class, 'finalize'])->name('finalize-order');
        Route::get('/finalize-x/{order_id}', [OrderProduceController::class, 'finalizeOrder'])->name('finalize-x');
        Route::post('/finalize-x/{order_id}/post', [OrderProduceController::class, 'finalizeOrderPost'])->name('finalize-x-post');

        // Printing Management
        Route::get('/awaiting-printing', [OrderProduceController::class, 'awaitingPrinting'])->name('awaiting-printing');
        Route::get('/awaiting-x/{order_id}', [OrderProduceController::class, 'awaitingOrder'])->name('awaiting-x');
        Route::post('/awaiting-x/{order_id}/post', [OrderProduceController::class, 'awaitingOrderPost'])->name('awaiting-x-post');

        Route::get('/printing-in-progress', [OrderProduceController::class, 'printingInProgress'])->name('printing-in-progress');
        Route::get('/printing-x/{order_id}', [OrderProduceController::class, 'printingOrder'])->name('printing-x');
        Route::post('/printing-x/{order_id}/post', [OrderProduceController::class, 'printingOrderPost'])->name('printing-x-post');

        // Order Status Management
        Route::get('/ready', [OrderProduceController::class, 'ready'])->name('ready');
        Route::get('/ready-x/{order_id}', [OrderProduceController::class, 'readyOrder'])->name('ready-x');
        Route::post('/ready-x/{order_id}/post', [OrderProduceController::class, 'readyOrderPost'])->name('ready-x-post');

        Route::get('/completed', [OrderProduceController::class, 'completed'])->name('completed');
        Route::get('/completed-x/{order_id}', [OrderProduceController::class, 'completedOrder'])->name('completed-x');

        // Order Cancellation
        Route::post('/cancel-order/{order_id}', [OrderProduceController::class, 'cancelOrder'])->name('cancel-order');
    });
});

//Designer Routes
Route::get('/designer-dashboard', [DesignerOrderController::class, 'dashboard'])
    ->name('designer-dashboard')->middleware('DesignerOnly');
Route::prefix('partner')->name('partner.')->middleware('DesignerOnly')->group(function () {
    Route::prefix('designer')->name('designer.')->group(function () {
        Route::get('/orders', [DesignerOrderController::class, 'index'])->name('orders');
        Route::get('/assigned-x/{order_id}', [DesignerOrderController::class, 'assignedOrder'])->name('assigned-x');
        Route::post('/assigned-x/{order_id}/post', [DesignerOrderController::class, 'assignedOrderPost'])->name('assigned-x-post');
        Route::get('/completed', [DesignerOrderController::class, 'complete'])->name('complete');
        Route::get('/complete-x/{order_id}', [DesignerOrderController::class, 'completeOrder'])->name('complete-x');
        Route::post('/cancel-design-assignment/{order_id}', [DesignerOrderController::class, 'cancelDesignAssignment'])->name('cancel-design-assignment');

        // Designer Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/basics', [DesignerProfileController::class, 'basics'])->name('basics');
            Route::post('/update', [DesignerProfileController::class, 'update'])->name('update');
            Route::get('/reviews', [DesignerProfileController::class, 'reviews'])->name('reviews');
            Route::get('/notifications', [DesignerOrderController::class, 'notifications'])->name('notifications');
            Route::post('/notifications/{id}/mark-read', [DesignerOrderController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
            Route::post('/notifications/mark-all-read', [DesignerOrderController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
        });
    });
});

Route::prefix('customer/place-order')->name('customer.place-order.')->group(function () {
    // Apparel Selection
    Route::get('/select-apparel', [OrderController::class, 'selectApparel'])->name('select-apparel');

    // Production Type Selection
    Route::get('/select-production-type/{apparel}', [OrderController::class, 'selectProductionType'])->name('select-production-type');

    // Production Company Selection
    Route::get('/select-production-company/{apparel}/{productionType}', [OrderController::class, 'selectProductionCompany'])->name('select-production-company');

    // Customization
    Route::get('/customization/{apparel}/{productionType}/{company}', [OrderController::class, 'customization'])->name('customization');
    Route::post('/customization/{apparel}/{productionType}/{company}', [OrderController::class, 'storeCustomization'])->name('customization-post');

    // Review
    Route::get('/review/{apparel}/{productionType}/{company}', [OrderController::class, 'review'])->name('review');
    Route::post('/review/{apparel}/{productionType}/{company}', [OrderController::class, 'storeReview'])->name('review-post');
});

// Receipt confirmation route - accessible by both customers and printers when order_id is provided
Route::get('/order-receipt', [ConfirmationMessageController::class, 'confirmation'])->name('order.receipt');

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

    // Review routes
    Route::get('/review/{order_id}', [ReviewController::class, 'showReviewForm'])->name('customer.review.form');
    Route::post('/review', [ReviewController::class, 'storeReview'])->name('customer.review.store');

    Route::get('/inbox', function () {
        return view('customer.inbox.messages');
    })->name('customer.messages');

    Route::get('/inbox/chat', function () {
        return view('customer.inbox.chatroom');
    })->name('customer.chat');
});

//Password Routes
Route::get('/set-password/{token}', [BusinessAuthController::class, 'showSetPasswordForm'])->name('set-password');
Route::post('/set-password/store', [BusinessAuthController::class, 'storePassword'])->name('password.store');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/logout', [BusinessAuthController::class, 'logout'])->name('logout')->middleware(PreventBackHistory::class);

// Bulk order confirmation routes
Route::get('/confirm-bulk/{token}', [ConfirmBulkController::class, 'confirmBulk'])->name('confirm-bulk');
Route::post('/confirm-bulk/post', [ConfirmBulkController::class, 'confirmBulkPost'])->name('confirm-bulk-post');

Route::get('/confirm-bulk-custom/{token}', [ConfirmationLinkController::class, 'confirmBulkCustom'])->name('confirm-bulk-custom');
Route::post('/confirm-bulk-custom/post', [ConfirmationLinkController::class, 'confirmBulkCustomPost'])->name('confirm-bulk-custom-post');

Route::get('/confirm-jerseybulk-custom/{token}', [ConfirmationLinkController::class, 'confirmJerseyBulkCustom'])->name('confirm-jerseybulk-custom');
Route::post('/confirm-jerseybulk-custom/post', [ConfirmationLinkController::class, 'confirmJerseyBulkCustomPost'])->name('confirm-jerseybulk-custom-post');

// Excel import routes
Route::post('/excel-import/standard-bulk', [App\Http\Controllers\ExcelImportController::class, 'importStandardBulk'])->name('excel.import.standard-bulk');
Route::post('/excel-import/jersey-bulk', [App\Http\Controllers\ExcelImportController::class, 'importJerseyBulk'])->name('excel.import.jersey-bulk');
Route::post('/excel-import/bulk-customized', [App\Http\Controllers\ExcelImportController::class, 'importBulkCustomized'])->name('excel.import.bulk-customized');
Route::get('/excel-template/{type}', [App\Http\Controllers\ExcelImportController::class, 'generateTemplate'])->name('excel.template');

// Single order confirmation routes
Route::get('/confirm-single/{token}', [ConfirmBulkController::class, 'confirmSingle'])->name('confirm-single');
Route::post('/confirm-single/post', [ConfirmBulkController::class, 'confirmSinglePost'])->name('confirm-single-post');

Route::get('/confirm-single-custom/{token}', [ConfirmationLinkController::class, 'confirmSingleCustom'])->name('confirm-single-custom');
Route::post('/confirm-single-custom/post', [ConfirmationLinkController::class, 'confirmSingleCustomPost'])->name('confirm-single-custom-post');

Route::get('export-customization/{order_id}', [CustomizationExportController::class, 'exportExcel'])->name('export.customization')->withoutMiddleware(PreventBackHistory::class);
Route::get('/export/customization/{order_id}', [CustomizationExportController::class, 'export'])->name('export.customization');

// Google Auth Routes
Route::get('/auth/google/redirect', [GoogleAuth::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuth::class, 'handleGoogleCallback'])->name('google.callback');

// chat Routes
Route::patch('/chat/mark-as-seen/{id}', [ChatController::class, 'markAsSeen']);
Route::get('/chat/users', [ChatController::class, 'fetchChatUsers']);
Route::get('/chat/messages/{user_id}', [ChatController::class, 'fetchMessages']);
Route::post('/chat/send/message', [ChatController::class, 'sendMessage']);

// For Chat Auth
Route::middleware(['auth'])->post('/broadcasting/auth', function (Request $request) {
    Log::info('Broadcasting auth request', [
        'user' => Auth::user(),
        'request_payload' => $request->all(),
        'headers' => $request->headers->all(),
    ]);
    return Broadcast::auth($request);
});

//Super admin Routes
Route::middleware(['SuperAdminOnly'])->group(function () {
    Route::get('/super-admin/users', [SuperAdminController::class, 'userManagement'])->name('superadmin.users');
    Route::get('/super-admin/production-companies', [SuperAdminController::class, 'productionCompanies'])->name('superadmin.production');
    Route::get('/super-admin/production-companies/approve', [SuperAdminController::class, 'approveProductionCompanies'])->name('superadmin.production.approve');
    Route::get('/super-admin/designer-companies', [SuperAdminController::class, 'designerManagement'])->name('superadmin.designers');
    Route::get('/super-admin/designer-companies/approve', [SuperAdminController::class, 'approveDesigners'])->name('superadmin.designers.approve');
    Route::get('/super-admin/reports', [SuperAdminController::class, 'reports'])->name('superadmin.reports');
});

Route::get('/order/additional-payment/{order_id}', [App\Http\Controllers\AdditionalPaymentController::class, 'showPaymentDetails'])
    ->name('order.additional-payment')
    ->middleware('CustomerOnly');

Route::post('/order/process-additional-payment/{order_id}', [App\Http\Controllers\AdditionalPaymentController::class, 'processPayment'])
    ->name('order.process-additional-payment')
    ->middleware('CustomerOnly');
