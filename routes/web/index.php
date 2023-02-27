<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StaticPageController::class, 'index']);
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/paid', [OrderController::class, 'pay']);

Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('/dashboard', [StaticPageController::class, 'dashboard']);
});
