<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Tenant\BookingController as TenantBooking;
use App\Http\Controllers\Owner\BookingController as OwnerBooking;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\ReviewController;
use App\Http\Controllers\Tenant\PaymentController;

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

    Route::get('/properties/create', [\App\Http\Controllers\Owner\PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [\App\Http\Controllers\Owner\PropertyController::class, 'store'])->name('properties.store');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/extra', [ProfileController::class, 'updateExtra'])->name('profile.update.extra');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';