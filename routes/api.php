<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatascopeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// PayHero webhook callback (must be public and CSRF exempt)
Route::post('/callback', [DatascopeController::class, 'checkStatus'])
    ->name('callback');

