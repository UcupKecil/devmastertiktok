<?php
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'    => ['auth', 'role:Admin'],
    'prefix'        => 'manage'
], function () {
    Route::get('/course', [CourseController::class, 'index']);
    Route::get('/setting', [SettingController::class, 'index']);
    Route::get('/course/videos/{slug}', [CourseVideoController::class, 'index']);
    Route::get('/course/videos/{slug}/{any}', [CourseVideoController::class, 'show']);
    Route::post('/course/videos/{slug}', [CourseVideoController::class, 'store']);
    Route::get('/course/{any}', [CourseController::class, 'show']);
    Route::get('/setting/{any}', [SettingController::class, 'show']);
    Route::post('/course', [CourseController::class, 'store']);
    Route::post('/course/videos/{slug}/{id}', [CourseVideoController::class, 'update']);
    Route::post('/course/{id}', [CourseController::class, 'update']);
    Route::post('/setting/{id}', [SettingController::class, 'update']);
    Route::delete('/course/videos/{slug}/{id}', [CourseVideoController::class, 'destroy']);
    Route::delete('/course/{id}', [CourseController::class, 'destroy']);
    Route::delete('/setting/{id}', [SettingController::class, 'destroy']);

});
