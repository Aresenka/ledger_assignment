<?php

use App\Http\Controllers\ApiV1Controller;
use Illuminate\Support\Facades\Route;

//Auth is not required, so anyone can do anything. Use middleware to implement the Auth system
Route::prefix('v1')->group(function () {
    Route::get('account/{id}/info', [ApiV1Controller::class, 'getAccountInfo']);
    Route::get('account/{id}/transactions', [ApiV1Controller::class, 'getAccountTransactions']);

    Route::post('transaction/new', [ApiV1Controller::class, 'initTransaction']);
});
