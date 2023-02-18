<?php

use App\Http\Controllers\TripayController;
use Illuminate\Support\Facades\Route;

Route::get('/tripay/fee/{payment}/{total}', [TripayController::class, 'adminFee']);
Route::get('/tripay/instruction/{refData}', [TripayController::class, 'instruction']);
