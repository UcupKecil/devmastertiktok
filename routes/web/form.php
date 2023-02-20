<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'    => ['auth', 'role:Admin'],
], function () {
    Route::get('/manage/course/create', [FormController::class, 'courseCreateForm']);
    Route::get('/manage/benefit/create', [FormController::class, 'benefitCreateForm']);
    Route::get('/manage/qna/create', [FormController::class, 'qnaCreateForm']);
    Route::get('/manage/testi_student/create', [FormController::class, 'testistudentCreateForm']);
    Route::get('/manage/course/create-video/{slug}', [FormController::class, 'courseVideoCreateForm']);
    Route::get('/manage/course/edit-video/{id}', [FormController::class, 'courseVideoEditForm']);
    Route::get('/manage/course/edit/{id}', [FormController::class, 'courseEditForm']);
    Route::get('/manage/benefit/edit/{id}', [FormController::class, 'benefitEditForm']);
    Route::get('/manage/qna/edit/{id}', [FormController::class, 'qnaEditForm']);
    Route::get('/manage/testi_student/edit/{id}', [FormController::class, 'testistudentEditForm']);
    Route::get('/manage/setting/edit/{id}', [FormController::class, 'settingEditForm']);
});
