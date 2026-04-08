<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPackageRequestController;

/*
|--------------------------------------------------------------------------
| WELCOME PAGE (PUBLIC HOME PAGE)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test-route', function() {
    return "Test route works!";
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)->name('dashboard');
    Route::get('/administration', function () {return view('administration');})->name('administration');

    Route::resource('/packages', \App\Http\Controllers\PackageController::class);
    Route::resource('/users', \App\Http\Controllers\UserController::class);
    Route::resource('/billing', \App\Http\Controllers\BillingController::class);
    Route::resource('/payment', \App\Http\Controllers\PaymentController::class)->only(['index', 'store']);
    Route::resource('/ticket', \App\Http\Controllers\TicketController::class);
    Route::resource('/router', \App\Http\Controllers\RouterController::class);
    
    // Customer management routes
    Route::get('/customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
    Route::patch('/customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
    Route::patch('/customer-disable/{customer}', [\App\Http\Controllers\CustomerController::class, 'disable'])->name('customer.disable');
    Route::patch('/customer-enable/{customer}', [\App\Http\Controllers\CustomerController::class, 'enable'])->name('customer.enable');
    
    // Package Requests Management
    Route::get('/package-requests', [AdminPackageRequestController::class, 'index'])->name('package-requests.index');
    Route::get('/package-requests/{packageRequest}', [AdminPackageRequestController::class, 'show'])->name('package-requests.show');
    Route::post('/package-requests/{packageRequest}/approve', [AdminPackageRequestController::class, 'approve'])->name('package-requests.approve');
    Route::post('/package-requests/{packageRequest}/reject', [AdminPackageRequestController::class, 'reject'])->name('package-requests.reject');

    Route::get('/payment/create/{param}', [\App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');

    Route::get('/isp', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('company.edit');
    Route::patch('/isp', [\App\Http\Controllers\CompanyController::class, 'update'])->name('company.update');

    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'edit'])->name('settings.edit');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/change-package/{user}/edit', [\App\Http\Controllers\ChangePackageController::class, 'edit'])->name('package-change');
    Route::patch('/change-package/{user}', [\App\Http\Controllers\ChangePackageController::class, 'update'])->name('package-update');

    Route::patch('/user-disable/{user}', \App\Http\Controllers\UserDisable::class)->name('user.disable');
    Route::patch('/user-enable/{user}', \App\Http\Controllers\UserEnable::class)->name('user.enable');

    Route::post('/due-user-disable', \App\Http\Controllers\DisableDueUser::class)->name('due.user.disable');

    Route::get('/log/{param}', \App\Http\Controllers\Log::class)->name('log');

    Route::post('/open-ticket/{ticket}', \App\Http\Controllers\OpenTicket::class)->name('open.ticket');
    Route::post('/close-ticket/{ticket}', \App\Http\Controllers\CloseTicket::class)->name('close.ticket');
    Route::post('/add-comment', \App\Http\Controllers\AddComment::class)->name('add.comment');

    Route::get('/user-download', \App\Http\Controllers\UserDownload::class)->name('user.download');
    Route::get('/billing-download', \App\Http\Controllers\BillingDownload::class)->name('billing.download');
    Route::get('/payment-download', \App\Http\Controllers\PaymentDownload::class)->name('payment.download');
    Route::get('/single-download/{user}', \App\Http\Controllers\ShowUser::class)->name('single.download');
    Route::get('/invoice-download/{row}', \App\Http\Controllers\InvoiceDownload::class)->name('invoice.download');

    // bKash Routes
    Route::group(['middleware' => ['web']], function () {
        Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class,'index']);
        Route::get('/bkash/create-payment/{param}', [App\Http\Controllers\BkashTokenizePaymentController::class,'createPayment'])->name('bkash-create-payment');
        Route::get('/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class,'callBack'])->name('bkash-callBack');
        Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class,'searchTnx'])->name('bkash-serach');
        Route::get('/bkash/refund', [App\Http\Controllers\BkashTokenizePaymentController::class,'refund'])->name('bkash-refund');
        Route::get('/bkash/refund/status', [App\Http\Controllers\BkashTokenizePaymentController::class,'refundStatus'])->name('bkash-refund-status');
    });
});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| CUSTOMER PANEL ROUTES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Customer\CustomerLoginController;
use App\Http\Controllers\Customer\CustomerRegisterController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerSubscriptionController;
use App\Http\Controllers\Customer\CustomerInvoiceController;
use App\Http\Controllers\Customer\CustomerPaymentController;
use App\Http\Controllers\Customer\CustomerTicketController;
use App\Http\Controllers\Customer\CustomerPackageRequestController;

Route::prefix('customer')->name('customer.')->group(function () {
    
    // Guest routes (Login & Register)
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [CustomerLoginController::class, 'show'])->name('login');
        Route::post('/login', [CustomerLoginController::class, 'login'])->name('login.submit');
        Route::get('/register', [CustomerRegisterController::class, 'show'])->name('register');
        Route::post('/register', [CustomerRegisterController::class, 'register'])->name('register.submit');
    });

    // Authenticated routes
    Route::middleware('auth:customer')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Management
        Route::get('/profile', [CustomerProfileController::class, 'index'])->name('profile');
        Route::patch('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');
        Route::patch('/profile/notifications', [CustomerProfileController::class, 'updateNotifications'])->name('profile.notifications');
        
        // Subscriptions
        Route::get('/subscriptions', [CustomerSubscriptionController::class, 'index'])->name('subscriptions');
        Route::get('/packages', [CustomerSubscriptionController::class, 'packages'])->name('packages.index');
        Route::post('/subscribe/{package}', [CustomerSubscriptionController::class, 'subscribe'])->name('subscribe');
        Route::post('/subscription/upgrade/{package}', [CustomerSubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
        Route::post('/subscription/renew', [CustomerSubscriptionController::class, 'renew'])->name('subscription.renew');
        Route::patch('/subscription/auto-renew', [CustomerSubscriptionController::class, 'toggleAutoRenew'])->name('subscription.auto-renew');
        Route::get('/subscription/history', [CustomerSubscriptionController::class, 'history'])->name('subscription.history');
        
        // Package Requests
        Route::get('/package-requests', [CustomerPackageRequestController::class, 'index'])->name('package-requests.index');
        Route::get('/package-requests/create', [CustomerPackageRequestController::class, 'create'])->name('package-requests.create');
        Route::post('/package-requests', [CustomerPackageRequestController::class, 'store'])->name('package-requests.store');
        Route::get('/package-requests/{packageRequest}', [CustomerPackageRequestController::class, 'show'])->name('package-requests.show');
        
        // Invoices
        Route::get('/invoices', [CustomerInvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/{invoice}', [CustomerInvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/invoices/{invoice}/download', [CustomerInvoiceController::class, 'download'])->name('invoices.download');
        
        // Payment Portal
        Route::get('/payments', [CustomerPaymentController::class, 'index'])->name('payments');
        Route::post('/payment/verify', [CustomerPaymentController::class, 'verify'])->name('payment.verify');
        Route::post('/payment/process', [CustomerPaymentController::class, 'process'])->name('payment.process');
        Route::get('/payment/success', [CustomerPaymentController::class, 'success'])->name('payment.success');
        
        // bKash Payment
        Route::get('/payment/bkash/{billing}', [CustomerPaymentController::class, 'bkashPayment'])->name('payment.bkash');
        Route::get('/payment/bkash/callback', [CustomerPaymentController::class, 'bkashCallback'])->name('payment.bkash.callback');
        
        // Support Tickets
        Route::get('/support', [CustomerTicketController::class, 'index'])->name('support');
        Route::get('/tickets', [CustomerTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [CustomerTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [CustomerTicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [CustomerTicketController::class, 'show'])->name('tickets.show');

        // Logout
        Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');
        Route::get('/logout', [CustomerLoginController::class, 'logout']);
    
    });
});