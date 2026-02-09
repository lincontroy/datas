<?php

use App\Http\Controllers\DatascopeController;
use Illuminate\Support\Facades\Route;

// Main public routes
Route::get('/', [DatascopeController::class, 'index'])->name('home');
Route::post('/process-payment', [DatascopeController::class, 'processPayment'])->name('process.payment');
Route::post('/check-status', [DatascopeController::class, 'checkStatus'])->name('check.status');
Route::post('/verify-id', [DatascopeController::class, 'verifyID'])->name('verify.id');

// PayHero webhook callback (must be public and CSRF exempt)
Route::post('/api/payhero/callback', [DatascopeController::class, 'payheroCallback'])
    ->name('payhero.callback')
    ->withoutMiddleware(['csrf']);

// Admin dashboard (protect with auth middleware if needed)
Route::get('/dashboard', [DatascopeController::class, 'dashboard'])->name('dashboard');