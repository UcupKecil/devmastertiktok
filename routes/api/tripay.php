<?php

use App\Http\Controllers\TripayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/gateway-tripay', [TripayControlle::class, 'callback']);
