<?php

use App\Http\Controllers\BuyTokenV1Controller;
use App\Http\Controllers\TransactionV1Controller;
use App\Http\Controllers\UserDashboardV1Controller;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => ['role:Unverified|Verified|Investor', 'verified']], function() {
    Route::get('/', [UserDashboardV1Controller::class, 'index'])->name('dashboard');

    Route::get('/buy-token', [BuyTokenV1Controller::class, 'index'])->name('buy-token.index');

    Route::get('/transaction', [TransactionV1Controller::class, 'index'])->name('transaction.index');
});
