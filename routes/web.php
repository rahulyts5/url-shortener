<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;

// Guest routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

// Auth routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Short URL routes - only admin and member can create
Route::middleware(['auth', 'role:admin,member'])->group(function () {
    Route::get('/urls/create', [ShortUrlController::class, 'create']);
    Route::post('/urls', [ShortUrlController::class, 'store']);
});

// View urls
Route::middleware(['auth'])->group(function () {
    Route::get('/urls', [ShortUrlController::class, 'index']);
});

// Publicly resolvable short URLs
Route::get('/r/{code}', [ShortUrlController::class, 'resolve']);


// Invitation routes - superadmin and admin can invite
Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::get('/invitations/create', [InvitationController::class, 'create']);
    Route::post('/invitations', [InvitationController::class, 'store']);
});

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});
