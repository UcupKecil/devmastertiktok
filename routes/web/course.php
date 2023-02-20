<?php

use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::get('/course/{slug}', [StaticPageController::class, 'course']);


Route::group([
    'middleware'    => ['auth', 'role:Member'],
], function () {
    Route::get('/mycourse/change-video/{class_id}/{id}', [CourseVideoController::class, 'changeVideo']);
    Route::get('/mycourse/{slug}', [StaticPageController::class, 'classroom']);
});
