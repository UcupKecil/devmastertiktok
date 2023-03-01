<?php

use App\Http\Controllers\TripayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/gateway-tripay', [TripayController::class, 'callback']);
