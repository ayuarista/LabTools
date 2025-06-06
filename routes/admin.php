<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    });

});
