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

// Temporary: auth/role middleware dimatikan agar halaman bisa dicek tanpa login.
// Aktifkan lagi setelah review desain selesai.

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Checkout
Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

// Form create public match
Route::get('/matches/create', [MatchController::class, 'create'])->name('matches.create');
Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');

// Owner area
Route::prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('venues', OwnerVenueController::class);
});

// Admin area
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});
