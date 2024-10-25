<?php

use App\Http\Controllers\API\UrlShortenController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->except(['store', 'update', 'destroy'])->middleware('auth:sanctum');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::apiResource('shorten', UrlShortenController::class)->except(['show', 'update', 'destroy'])->middleware('auth:sanctum');
});
