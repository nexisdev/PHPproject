<?php

use App\Http\Controllers\Admin\CacheV1Controller;
use App\Http\Controllers\Admin\TokenPriceV1Controller;
use App\Http\Controllers\Admin\UserV1Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminV1Controller;
use App\Http\Controllers\Admin\PayableV1Controller;
use App\Http\Controllers\Admin\SettingsV1Controller;
use App\Http\Controllers\Admin\TransactionV1Controller;

Route::group(['prefix' => 'admin', 'middleware' => ['role:Admin|Moderator']], function() {
    Route::get('/', [AdminV1Controller::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserV1Controller::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserV1Controller::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [UserV1Controller::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserV1Controller::class, 'update'])->name('admin.users.update');
    Route::get('/users/{user}/transactions', [UserV1Controller::class, 'transactions'])->name('admin.users.transactions');

    Route::get('/transactions', [TransactionV1Controller::class, 'index'])->name('admin.transaction.index');
    // Settings
    Route::group(['prefix' => 'settings'], function () {
        Route::resource('/payable-tokens', PayableV1Controller::class);
        Route::get('/site-settings', [SettingsV1Controller::class, 'index'])->name('admin.settings');
        Route::put('/site-settings', [SettingsV1Controller::class, 'update'])->name('admin.settings.update');
        Route::get('/token-price', [TokenPriceV1Controller::class, 'index'])->name('admin.token-price.index');
        Route::put('/token-price', [TokenPriceV1Controller::class, 'update'])->name('admin.token-price.update');
        Route::get('/cache-clear', [CacheV1Controller::class, 'index'])->name('admin.cache.index');
        Route::post('/cache-clear', [CacheV1Controller::class, 'clearCache'])->name('admin.cache.clear');
    });
});
