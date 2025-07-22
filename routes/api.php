<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\TransactionController;
use App\Enums\Transactions\TypeEnum;

Route::post('/login', [AuthController::class, 'login']);

Route::controller(KycController::class)->group(function () {
     Route::post('kyc', 'identifyClient');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::controller(TransactionController::class)->group(function () {
        Route::post('/transactions/{transaction_type}', 'simulate')
               ->whereIn('transaction_type', TypeEnum::values());
    });
});
