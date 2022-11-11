<?php

use App\Http\Controllers\ProfileV1Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileV1Controller::class, 'index'])->name('profile.index');
    Route::put('/', [ProfileV1Controller::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileV1Controller::class, 'showChangePassword'])->name('profile.change-password');
    Route::put('/change-password', [ProfileV1Controller::class, 'updateChangePassword'])->name('profile.change-password.update');
    Route::get('/enable-2fa', [ProfileV1Controller::class, 'enable2FA'])->name('profile.enable-2fa');
    Route::post('/enable-2fa', [ProfileV1Controller::class, 'confirmEnable2FA'])->name('profile.enable-2fa.store');
    Route::post('/disable-2fa', [ProfileV1Controller::class, 'disable2FA'])->name('profile.disable-2fa.store');
});
