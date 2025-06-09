<?php

use App\Http\Controllers\Admin\Loan\LoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Item\ItemController;
use App\Http\Controllers\Admin\Management\StudentController;
use App\Http\Controllers\Admin\ReturnItem\ReturnItemController;
use App\Http\Controllers\Admin\ReturnItem\HistoryReturnController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'index'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::resource('item', ItemController::class);
        Route::resource('loans', LoanController::class);
        Route::resource('students', StudentController::class);
        Route::get('/history-item', [HistoryReturnController::class, 'index'])->name('history-item.index');
        Route::get('/return-item', [ReturnItemController::class, 'index'])->name('return-item.index');
        Route::get('/return-item/{loan}/create', [ReturnItemController::class, 'create'])->name('return-item.create');
        Route::post('/return-item/{loan}', [ReturnItemController::class, 'store'])->name('return-item.store');
    });
});
