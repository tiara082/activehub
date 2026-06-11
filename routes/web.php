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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingPaymentController;

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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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

        if (!$bookingId) {
            return redirect()->route('matches.index')->with('error', 'Silakan pilih booking untuk membuat permainan');
        }

        $booking = \App\Models\Booking::with([
            'field',
            'field.venue',
            'timeSlot',
        ])->find($bookingId);

        if (!$booking) {
            return redirect()->route('matches.index')->with('error', 'Booking tidak ditemukan');
        }

        return view('pubmatch.create', compact('booking'));

    })->name('matches.create');

    Route::get('/matches/{id}/edit', [MatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{id}', [MatchController::class, 'update'])->name('matches.update');
    Route::post('/matches', [MatchController::class, 'store'])->name('matches.store');
});

// ==========================
// PUBLIC MATCH
// ==========================
Route::get('/matches/nearby', [MatchController::class, 'nearbyAjax'])->name('matches.nearby');
Route::get('/matches/{match}', [MatchController::class, 'show'])
    ->name('matches.show');

// ==========================
// FIELD
// ==========================
Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');

// ==========================
// VENUE
// ==========================
Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/nearby', [VenueController::class, 'nearbyAjax'])->name('venues.nearby');
Route::get('/venues/{id}', [VenueController::class, 'show'])->name('venues.show');

Route::middleware('auth')->group(function () {
    Route::get('/venues/create', fn () => view('venue.create'))->name('venues.create');
    Route::post('/venues', [\App\Http\Controllers\VenueController::class, 'store'])->name('venues.store');
    Route::get('/venues/{id}/edit', [\App\Http\Controllers\VenueController::class, 'edit'])->name('venues.edit');
    Route::put('/venues/{id}', [\App\Http\Controllers\VenueController::class, 'update'])->name('venues.update');
    Route::delete('/venues/{id}', [\App\Http\Controllers\VenueController::class, 'destroy'])->name('venues.destroy');
});

// ==========================
// FIELD BY VENUE
// ==========================
Route::get('/venues/{id}/fields', function ($id) {
    return view('field.index', compact('id'));
})->name('venues.fields');

// Booking dari venue — buat booking pending lalu arahkan ke payment
Route::post('/venues/book', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'time_slot_id' => ['required', 'exists:time_slots,id'],
    ]);

    $slot = \App\Models\TimeSlot::with('field')->findOrFail($request->time_slot_id);

    $booking = \App\Models\Booking::create([
        'user_id'         => auth()->id(),
        'field_id'        => $slot->field_id,
        'time_slot_id'    => $slot->id,
        'total_price'     => $slot->field->price_per_hour,
        'status'          => 'pending',
        'is_public_match' => 0,
    ]);

    return redirect()->route('payment.show', $booking->id);
})->name('venues.book')->middleware('auth');

// ==========================
// PAYMENT — Booking Flow
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/payment/{booking}',         [BookingPaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{booking}/snap',   [BookingPaymentController::class, 'createSnap'])->name('payment.snap');
    Route::post('/payment/{booking}/qris',   [BookingPaymentController::class, 'createQris'])->name('payment.qris');
    Route::get('/payment/{booking}/qr',      [BookingPaymentController::class, 'qr'])->name('payment.qr');
    Route::get('/payment/{booking}/status',  [BookingPaymentController::class, 'checkStatus'])->name('payment.status');
    Route::get('/payment/{booking}/success', [BookingPaymentController::class, 'success'])->name('payment.success');
});

// Midtrans payment routes (Match)
Route::post('/payment/match', [PaymentController::class, 'createMatchPayment'])
    ->name('payment.match.create');
Route::post('/payment/match/finish', [PaymentController::class, 'matchFinish'])
    ->name('payment.match.finish');
Route::post('/payment/match/join', [PaymentController::class, 'joinMatch'])
    ->name('payment.match.join');
Route::post('/payment/notification', [PaymentController::class, 'notification'])
    ->name('payment.notification');

Route::post('/matches/{id}/join',[MatchController::class, 'join']
)->name('match.join')->middleware('auth');

// ==========================
// USER AREA
// ==========================
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])
        ->name('dashboard');


    Route::get('/my-match', [MatchController::class, 'myMatches'])
    ->name('my-match');
    Route::get('/bookings', [\App\Http\Controllers\User\BookingController::class, 'index'])
        ->name('bookings');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\User\BookingController::class, 'show'])
        ->name('bookings.show');
    Route::get('/bookings/{booking}/receipt', [\App\Http\Controllers\User\BookingController::class, 'receipt'])
        ->name('bookings.receipt');
    Route::post('/reviews', [\App\Http\Controllers\User\ReviewController::class, 'store'])
        ->name('reviews.store');
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
    Route::post('/venue/switch', [OwnerVenueController::class, 'switchVenue'])->name('venue.switch');
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
    Route::get('/bookings/export', [\App\Http\Controllers\Owner\BookingController::class, 'export'])->name('bookings.export');
    Route::get('/calendar', [\App\Http\Controllers\Owner\CalendarController::class, 'index'])->name('calendar');
    Route::post('/calendar/block', [\App\Http\Controllers\Owner\CalendarController::class, 'blockFullDay'])->name('calendar.block');
    Route::post('/calendar/unblock', [\App\Http\Controllers\Owner\CalendarController::class, 'unblockFullDay'])->name('calendar.unblock');
    Route::post('/calendar/booking', [\App\Http\Controllers\Owner\CalendarController::class, 'storeOfflineBooking'])->name('calendar.booking');
    Route::get('/earnings', [\App\Http\Controllers\Owner\EarningsController::class, 'index'])->name('earnings');
    Route::get('/profile', fn () => view('owner.profile'))->name('profile');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Owner\ReviewController::class, 'index'])->name('reviews');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Owner\ReviewController::class, 'destroy'])->name('reviews.destroy');
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