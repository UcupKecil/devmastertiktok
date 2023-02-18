<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StaticPageController::class, 'index']);
Route::get('/paid', [OrderController::class, 'pay']);

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', [StaticPageController::class, 'dashboard']);
});
