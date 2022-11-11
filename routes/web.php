<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\TransactionV1Controller;
use App\Http\Controllers\TwoFactorAuthV1Controller;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'index'])->name('index');

Route::middleware(['auth', '2fa'])->group(function () {
    /**
     * Profile routes.
     */
    require __DIR__.'/profile.php';

    /**
     * Admin Routes.
     */
    require __DIR__.'/admin.php';

    /**
     * Investor & Verified user routes.
     */
    require __DIR__.'/investor.php';

    Route::post('/api/transaction', [TransactionV1Controller::class, 'store'])->name('transaction.store');
    Route::post('/api/referral-transaction', [TransactionV1Controller::class, 'referralTransaction'])->name('referral-transaction');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor-auth', [TwoFactorAuthV1Controller::class, 'index'])->name('two-factor-auth');
    Route::post('/two-factor-auth', [TwoFactorAuthV1Controller::class, 'store'])->name('two-factor-auth.store');
});

require __DIR__.'/auth.php';
