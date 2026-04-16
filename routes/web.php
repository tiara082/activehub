<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================
// HOME
// ==========================
Route::get('/', function () {
    return view('home'); // resources/views/home.blade.php
});

Route::get('/home', function () {
    return view('home');
});

// ==========================
// AUTH (SLICING DULU)
// ==========================
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// ==========================
// VENUE
// ==========================

// LIST VENUE
Route::get('/venues', function () {
    return view('venue.index');
});

// CREATE VENUE (punya kamu)
Route::get('/venue/create', function () {
    return view('venue.create');
});

// DETAIL VENUE
Route::get('/venues/{id}', function ($id) {
    return view('venue.detail', compact('id'));
});

// ==========================
// FIELD (LAPANGAN)
// ==========================

// LIST FIELD DARI VENUE
Route::get('/venues/{id}/fields', function ($id) {
    return view('field.index', compact('id'));
});

// DETAIL FIELD
Route::get('/fields/{id}', function ($id) {
    return view('field.detail', compact('id'));
});

// ==========================
// CHECKOUT
// ==========================

// HALAMAN CHECKOUT
Route::get('/checkout/{booking}', function ($booking) {
    return view('checkout.index', compact('booking'));
});

// ==========================
// OWNER (SLICING)
// ==========================
Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
});

Route::get('/owner/venues', function () {
    return view('owner.venues');
});

// ==========================
// ADMIN (SLICING)
// ==========================
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});