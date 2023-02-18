<?php

use App\Http\Controllers\BankController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'    => ['auth', 'role:Admin'],
    'prefix'        => 'master-data'
], function () {
    Route::get('/bank', [BankController::class, 'index']);
    Route::get('/bank/{any}', [BankController::class, 'show']);
    Route::post('/bank', [BankController::class, 'store']);
    Route::post('/bank/{id}', [BankController::class, 'update']);
    Route::delete('/bank/{id}', [BankController::class, 'destroy']);
});
