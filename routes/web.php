<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\Item\ItemController;
use App\Http\Controllers\Student\Loan\LoanController;
use App\Http\Controllers\Student\Loan\ReturnRequestController;
use App\Http\Controllers\Student\Dashboard\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth:web'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('items', ItemController::class);

    Route::resource('loans', LoanController::class);

    Route::patch('/loans/{loan}/cancel', [LoanController::class, 'cancel'])->name('loans.cancel');
    Route::patch('/loans/{loan}/edit', [LoanController::class, 'edit'])->name('loans.edit');
    Route::post('/loans/{loan}/return-request', [LoanController::class, 'requestReturn'])->name('loans.return.request');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
