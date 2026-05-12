<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\Owner\VenueController as OwnerVenueController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MatchController;



// Landing page
Route::get('/', fn () => view('landing.index'))->name('home');

Route::get('/create-match', function () {
    return view('pubmatch.create');
});

Route::get('/inibaru', function () {
    return view('detail-field');
});

Route::get('/venuedetail', function () {
    return view('venue.create');
});

Route::get('/payment', function () {
    return view('booking.index');
});

Route::get('/public-match', function () {
    return view('pubmatch.list');
});

Route::get('/garino', function () {
    return view('venue.create');
});

// Daftar lapangan & detail lapangan
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

// Daftar public match & detail public match
Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show');


Route::middleware('auth')->group(function () {

    // Checkout (user yang sudah booking)
    Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

    Route::middleware('role:user')->group(function () {
        // Form create public match (hanya user yang punya booking)
        Route::get('/matches/create', [MatchController::class, 'create'])->name('matches.create');
        Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');
    });

    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        // Manajemen venue (form create venue ada di sini)
        Route::resource('venues', VenueController::class);
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

     
});
