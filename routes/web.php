<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\Owner\VenueController as OwnerVenueController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', fn () => view('landing.index'))->name('home');
Route::get('/profil', fn () => view('profile'))->name('profile');

// MATCH
Route::get('/matches', fn () => view('pubmatch.list'))->name('matches.index');
Route::get('/matches/create', fn () => view('pubmatch.create'))->name('matches.create');

// FIELD
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

// VENUE
Route::get('/venues/create', fn () => view('venue.create'))->name('venues.create');
Route::get('/venuesdetail', fn () => view('venue.detail-venue'))->name('detail.venue');
Route::get('/venue', [VenueController::class, 'index'])->name('venue.index');
Route::get('/venue/{id}', [VenueController::class,'show'])->name('venue.show');

// PAYMENT
Route::get('/payment', fn () => view('booking.index'))->name('payment.index');


// ==========================
// OWNER (WITH AUTH)
// ==========================
Route::prefix('owner')->name('owner.')->middleware('owner')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', fn () => view('owner.bookings'))->name('bookings');
    Route::get('/calendar', fn () => view('owner.calendar'))->name('calendar');
    Route::get('/earnings', fn () => view('owner.earnings'))->name('earnings');
    Route::get('/venue', fn () => view('owner.venue'))->name('venue');

    Route::resource('venues', OwnerVenueController::class);
});


// ==========================
// AUTH AREA (KEEP)
// ==========================
Route::middleware('auth')->group(function () {

    Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

});