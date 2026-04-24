<?php
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\Tenant\BookingController as TenantBooking;
use App\Http\Controllers\Owner\BookingController as OwnerBooking;
use App\Http\Controllers\Owner\PropertyController as OwnerPropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\ReviewController;
use App\Http\Controllers\Tenant\PaymentController;
use App\Http\Controllers\NotificationController;
// Home
Route::get('/', function () {
    return redirect()->route('properties.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('properties.index');
})->middleware(['auth'])->name('dashboard');

// Properties
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');

// Compare
Route::get('/properties/compare', [CompareController::class, 'index'])->name('properties.compare');
Route::post('/properties/compare/{property}', [CompareController::class, 'add'])->name('properties.compare.add');
Route::delete('/properties/compare/{property}', [CompareController::class, 'remove'])->name('properties.compare.remove');
Route::delete('/properties/compare', [CompareController::class, 'clear'])->name('properties.compare.clear');

Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Tenant routes
Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/bookings', [TenantBooking::class, 'index'])->name('bookings.index');
    Route::get('/properties/{property}/book', [TenantBooking::class, 'create'])->name('bookings.create');
    Route::post('/properties/{property}/book', [TenantBooking::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [TenantBooking::class, 'cancel'])->name('bookings.cancel');

    // Review routes
    Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Payment routes for logged-in tenant
    Route::get('/bookings/{booking}/pay', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/bookings/{booking}/pay', [PaymentController::class, 'store'])->name('payments.store');
});

// SSLCommerz callback routes - MUST stay outside auth
Route::match(['get', 'post'], '/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');

// Owner routes
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/bookings', [OwnerBooking::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/approve', [OwnerBooking::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [OwnerBooking::class, 'reject'])->name('bookings.reject');

    // Property management
    Route::get('/properties', [OwnerPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [OwnerPropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [OwnerPropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [OwnerPropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [OwnerPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [OwnerPropertyController::class, 'destroy'])->name('properties.destroy');
    Route::patch('/properties/{property}/toggle', [OwnerPropertyController::class, 'toggleAvailability'])->name('properties.toggle');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/{booking}/agreements/create', [AgreementController::class, 'create'])
        ->name('agreements.create');

    Route::post('/bookings/{booking}/agreements', [AgreementController::class, 'store'])
        ->name('agreements.store');

    Route::get('/agreements/{agreement}', [AgreementController::class, 'show'])
        ->name('agreements.show');
    Route::get('/agreements/{agreement}/download', [AgreementController::class, 'download'])
    ->name('agreements.download');
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

});
// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/extra', [ProfileController::class, 'updateExtra'])->name('profile.update.extra');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';