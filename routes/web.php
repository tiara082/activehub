<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VenueController ;
use App\Http\Controllers\Owner\VenueController as OwnerVenueController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;



Route::get('/', fn () => view('landing.index'))->name('home');

// MATCH
Route::get('/matches', fn () => view('pubmatch.list'))->name('matches.index');
Route::get('/matches/create', fn () => view('pubmatch.create'))->name('matches.create');

// FIELD
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

// VENUE
Route::get('/venues/create', fn () => view('venue.create'))->name('venues.create');

// PAYMENT
Route::get('/payment', fn () => view('booking.index'))->name('payment.index');

// Temporary: auth/role middleware dimatikan agar halaman bisa dicek tanpa login.
// Aktifkan lagi setelah review desain selesai.

Route::middleware('auth')->group(function () {

// Checkout
Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

// Owner area
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('venues', OwnerVenueController::class);
});

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

     
});
