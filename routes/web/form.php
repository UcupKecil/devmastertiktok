<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'    => ['auth', 'role:Admin'],
], function () {
    Route::get('/manage/course/create', [FormController::class, 'courseCreateForm']);
    Route::get('/manage/course/create-video/{slug}', [FormController::class, 'courseVideoCreateForm']);
    Route::get('/manage/course/edit-video/{id}', [FormController::class, 'courseVideoEditForm']);
    Route::get('/manage/course/edit/{id}', [FormController::class, 'courseEditForm']);
    Route::get('/manage/setting/edit/{id}', [FormController::class, 'settingEditForm']);
});
