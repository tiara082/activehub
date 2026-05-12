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

Route::get('/profile/edit', [AuthController::class, 'editProfile'])
    ->name('profile.edit');

Route::put('/profile/update', [AuthController::class, 'updateProfile'])
    ->name('profile.update');

 Route::put('/profile/password', [AuthController::class, 'updatePassword'])
        ->name('profile.password');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================
// MATCH
// ==========================
// LIST (PUBLIC)
Route::get('/matches', [MatchController::class, 'index'])
    ->name('matches.index');

// CREATE HARUS DI ATAS {match}
Route::middleware('auth')->group(function () {

    Route::get('/matches/create', function () {

        $bookingId = request('booking');

        $booking = \App\Models\Booking::with([
            'field',
            'field.venue',
            'field.sport'
        ])->find($bookingId);

        return view('pubmatch.create', compact('booking'));

    })->name('matches.create');

    Route::post('/matches', [MatchController::class, 'store'])
        ->name('matches.store');
});

// DETAIL (WAJIB PALING BAWAH)
Route::get('/matches/{match}', [MatchController::class, 'show'])
    ->name('matches.show');

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

Route::middleware('auth')->group(function () {
    Route::get('/venues/create', fn () => view('venue.create'))->name('venues.create');
    Route::post('/venues', fn () => 'store')->name('venues.store');
});

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
Route::get('/payment/qr', fn () => view('booking.qr'))
    ->name('payment.qr');
Route::get('/payment/success', fn () => view('booking.success'))
    ->name('payment.success');

Route::post('/matches/{id}/join',[MatchController::class, 'join']
)->name('match.join');

// ==========================
// USER AREA
// ==========================
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/discover', [\App\Http\Controllers\User\DiscoverController::class, 'index'])
        ->name('discover');
    Route::get('/my-match', fn () => view('user.my-match'))->name('my-match');
    Route::get('/bookings', [\App\Http\Controllers\User\BookingController::class, 'index'])
        ->name('bookings');
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

// ==========================
// CHART
// ==========================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');