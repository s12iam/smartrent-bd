<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Tenant\BookingController as TenantBooking;
use App\Http\Controllers\Owner\BookingController as OwnerBooking;
use Illuminate\Support\Facades\Route;

// Home redirects to properties
Route::get('/', function () {
    return redirect()->route('properties.index');
});
Route::get('/dashboard', function () {
    return redirect()->route('properties.index');
})->middleware(['auth'])->name('dashboard');

// Properties (public)
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Tenant routes
Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/bookings', [TenantBooking::class, 'index'])->name('bookings.index');
    Route::get('/properties/{property}/book', [TenantBooking::class, 'create'])->name('bookings.create');
    Route::post('/properties/{property}/book', [TenantBooking::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [TenantBooking::class, 'cancel'])->name('bookings.cancel');
});

// Owner routes
Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/bookings', [OwnerBooking::class, 'index'])->name('owner.bookings.index');
    Route::patch('/bookings/{booking}/approve', [OwnerBooking::class, 'approve'])->name('owner.bookings.approve');
    Route::patch('/bookings/{booking}/reject', [OwnerBooking::class, 'reject'])->name('owner.bookings.reject');
});

// Breeze auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';