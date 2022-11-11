<?php

use Illuminate\Support\Facades\Route;
use Zilab\KYC\Http\Controllers\KycController;

Route::group(['prefix' => 'admin', 'middleware' => ['role:Admin|Moderator']], function() {
    Route::group(['prefix' => 'kyc'], function () {
        Route::get('/', [KycController::class, 'index'])->name('kyc.index');
        Route::get('/{kyc}', [KycController::class, 'show'])->name('kyc.show');
        Route::put('/{kyc}/status', [KycController::class, 'changeStatus'])->name('kyc.status');
        Route::delete('/{kyc}', [KycController::class, 'destroy'])->name('kyc.destroy');
    });
});

Route::group(['prefix' => 'kyc', 'middleware' => ['role:Unverified|Verified']], function() {
    Route::get('/create', [KycController::class, 'create'])->name('kyc.create');
    Route::get('/thank-you', fn() => view('kyc::kyc.thank-you'))->name('kyc.thank-you');
    Route::post('/', [KycController::class, 'store'])->name('kyc.store');
});
