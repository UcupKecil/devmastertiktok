<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'    => 'auth',
    'middleware' => ['guest']
], function () {
    Route::get('/login', [StaticPageController::class, 'login']);
    Route::get('/register', [StaticPageController::class, 'register']);
    
    Route::get('/register/{slug}', [AuthController::class, 'setCourse']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'prefix'    => 'auth',
    'middleware' => ['auth']
], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});
