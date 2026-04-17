<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Tenant\BookingController as TenantBooking;
use App\Http\Controllers\Owner\BookingController as OwnerBooking;
use App\Http\Controllers\Owner\PropertyController as OwnerPropertyController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return redirect()->route('properties.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('properties.index');
})->middleware(['auth'])->name('dashboard');

// Properties (public)
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
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
    Route::patch('/properties/{property}/toggle', [OwnerPropertyController::class, 'toggleAvailability'])->name('properties.toggle'); // ← semicolon was missing here
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/extra', [ProfileController::class, 'updateExtra'])->name('profile.update.extra');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';