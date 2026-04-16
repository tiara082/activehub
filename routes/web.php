<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VenueController ;
use App\Http\Controllers\Owner\VenueController as OwnerVenueController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;



// Landing page
Route::get('/', fn () => view('home'))->name('home');

// Daftar lapangan & detail lapangan
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

// Daftar public match & detail public match
Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');
Route::get('/matches/{match}', [MatchController::class, 'show'])->name('matches.show');

Route::get('/venue', [VenueController::class, 'index'])->name('venue.index');
Route::get('/venue/{id}', [VenueController::class,'show'])->name('venue.show');


Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});


Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Checkout (user yang sudah booking)
    Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

  
    Route::middleware('role:user')->group(function () {
        // Form create public match (hanya user yang punya booking)
        Route::get('/matches/create', [MatchController::class, 'create'])->name('matches.create');
        Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');
    });


    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        // Dashboard owner
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

        // Manajemen venue (form create venue ada di sini)
        Route::resource('venues', VenueController::class);
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});
