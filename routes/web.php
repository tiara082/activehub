<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\Owner\VenueController as OwnerVenueController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// ==========================
// PUBLIC
// ==========================
Route::get('/', fn () => view('landing.index'))->name('home');
Route::get('/profil', fn () => view('profile'))->name('profile');

// ==========================
// AUTH
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================
// MATCH
// ==========================
Route::get('/matches', fn () => view('pubmatch.list'))->name('matches.index');
Route::get('/matches/create', fn () => view('pubmatch.create'))->name('matches.create');

// ==========================
// FIELD
// ==========================
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
Route::get('/fields/{field}', [FieldController::class, 'show'])->name('fields.show');

// ==========================
// VENUE
// ==========================
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');

Route::get('/venues/{id}', [VenueController::class, 'show'])->name('venues.show');

// ==========================
// FIELD BY VENUE
// ==========================
Route::get('/venues/{id}/fields', function ($id) {
    return view('field.index', compact('id'));
})->name('venues.fields');

Route::get('/fields/{id}', function ($id) {
    return view('field.detail', compact('id'));
})->name('fields.detail');

// ==========================
// CHECKOUT
// ==========================
Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{booking}/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');

// ==========================
// PAYMENT
// ==========================
Route::get('/payment', fn () => view('booking.index'))->name('payment.index');

// ==========================
// USER AREA
// ==========================
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/discover', fn () => view('user.discover'))->name('discover');
    Route::get('/my-match', fn () => view('user.my-match'))->name('my-match');
    Route::get('/bookings', fn () => view('user.bookings'))->name('bookings');
    Route::get('/profile', fn () => view('user.profile'))->name('profile');
});

// ==========================
// OWNER AREA
// // ==========================
// Route::prefix('owner')->name('owner.')->middleware('auth')->group(function () {
    

//     Route::get('/dashboard', fn () => redirect()->route('owner.venue'))->name('dashboard');

//     Route::get('/bookings', fn () => view('owner.bookings'))->name('bookings');
//     Route::get('/calendar', fn () => view('owner.calendar'))->name('calendar');
//     Route::get('/earnings', fn () => view('owner.earnings'))->name('earnings');
//     Route::get('/venue', [OwnerVenueController::class, 'index'])->name('venue');
//     Route::get('/profile', fn () => view('owner.profile'))->name('profile');

//     Route::resource('venues', OwnerVenueController::class);
// });

Route::middleware(['auth'])->prefix('owner')->name('owner.')->group(function () {


    Route::get('/venue/create', [OwnerVenueController::class, 'create'])->name('venue.create');
    Route::get('/venue/{venue}/edit', [OwnerVenueController::class, 'edit'])->name('venue.edit');

    // Venue
    Route::get   ('/venue',                   [OwnerVenueController::class, 'index'])        ->name('venue');
    Route::post  ('/venue',                   [OwnerVenueController::class, 'storeVenue'])   ->name('venue.store');
    Route::put   ('/venue/{venue}',           [OwnerVenueController::class, 'updateVenue'])  ->name('venue.update');
    Route::delete('/venue/{venue}',           [OwnerVenueController::class, 'destroyVenue']) ->name('venue.destroy');

    // Field (nested under venue)
    Route::post  ('/venue/{venue}/field',           [OwnerVenueController::class, 'storeField'])   ->name('venue.field.store');
    Route::put   ('/venue/{venue}/field/{field}',   [OwnerVenueController::class, 'updateField'])  ->name('venue.field.update');
    Route::delete('/venue/{venue}/field/{field}',   [OwnerVenueController::class, 'destroyField']) ->name('venue.field.destroy');

    Route::get('/dashboard', fn () => redirect()->route('owner.venue'))->name('dashboard');

    Route::get('/bookings', [\App\Http\Controllers\Owner\BookingController::class, 'index'])->name('bookings');
    Route::get('/calendar', [\App\Http\Controllers\Owner\CalendarController::class, 'index'])->name('calendar');
    Route::post('/calendar/block', [\App\Http\Controllers\Owner\CalendarController::class, 'blockFullDay'])->name('calendar.block');
    Route::post('/calendar/unblock', [\App\Http\Controllers\Owner\CalendarController::class, 'unblockFullDay'])->name('calendar.unblock');
    Route::post('/calendar/booking', [\App\Http\Controllers\Owner\CalendarController::class, 'storeOfflineBooking'])->name('calendar.booking');
    Route::get('/earnings', fn () => view('owner.earnings'))->name('earnings');
    Route::get('/profile', fn () => view('owner.profile'))->name('profile');
});


// ==========================
// ADMIN AREA
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});