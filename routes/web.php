<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

// homepage
Route::get('/', function () {
    return view('welcome');
});

// detail match
Route::get('/match/{id}', [MatchController::class, 'show'])
    ->name('match.detail');

// join match
Route::post('/match/{id}/join', [MatchController::class, 'join'])
    ->name('match.join');