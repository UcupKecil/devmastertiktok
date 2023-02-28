<?php
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\TestiStudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\CourseSectionController;
use App\Http\Controllers\ReferralDetailController;
use App\Http\Controllers\ReferralController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware'    => ['auth', 'role:Admin'],
    'prefix'        => 'manage'
], function () {
    Route::get('/course', [CourseController::class, 'index']);
    Route::get('/course/sections/{slug}', [CourseSectionController::class, 'index']);
    Route::get('/course/sections/{slug}/{any}', [CourseSectionController::class, 'show']);
    Route::get('/referral/detail/{id}', [ReferralDetailController::class, 'index']);
    Route::get('/referral/detail/{id}/{any}', [ReferralDetailController::class, 'show']);
    Route::get('/setting', [SettingController::class, 'index']);
    Route::get('/benefit', [BenefitController::class, 'index']);
    Route::get('/qna', [QnaController::class, 'index']);
    Route::get('/refferal', [ReferralController::class, 'index']);
    Route::get('/refferal/{any}', [ReferralController::class, 'show']);
    Route::post('/refferal/{id}', [ReferralController::class, 'transfer']);
    Route::get('/testi_student', [TestiStudentController::class, 'index']);
    Route::get('/course/videos/{slug}', [CourseVideoController::class, 'index']);
    Route::get('/course/videos/{slug}/{any}', [CourseVideoController::class, 'show']);
    Route::post('/course/videos/{slug}', [CourseVideoController::class, 'store']);
    Route::get('/course/{any}', [CourseController::class, 'show']);
    Route::get('/setting/{any}', [SettingController::class, 'show']);
    Route::get('/benefit/{any}', [BenefitController::class, 'show']);
    Route::get('/qna/{any}', [QnaController::class, 'show']);
    Route::get('/testi_student/{any}', [TestiStudentController::class, 'show']);
    Route::post('/course', [CourseController::class, 'store']);
    Route::post('/benefit', [BenefitController::class, 'store']);
    Route::post('/qna', [QnaController::class, 'store']);
    Route::post('/testi_student', [TestiStudentController::class, 'store']);
    Route::post('/course/videos/{slug}/{id}', [CourseVideoController::class, 'update']);
    Route::post('/course/{id}', [CourseController::class, 'update']);
    Route::post('/course/sections/{slug}', [CourseSectionController::class, 'store']);
    Route::post('/course/sections/{slug}/{id}', [CourseSectionController::class, 'update']);
    Route::post('/setting/{id}', [SettingController::class, 'update']);
    Route::post('/benefit/{id}', [BenefitController::class, 'update']);
    Route::post('/qna/{id}', [QnaController::class, 'update']);
    Route::post('/testi_student/{id}', [TestiStudentController::class, 'update']);
    Route::delete('/course/videos/{slug}/{id}', [CourseVideoController::class, 'destroy']);
    Route::delete('/course/sections/{slug}/{id}', [CourseSectionController::class, 'destroy']);
    Route::delete('/course/{id}', [CourseController::class, 'destroy']);
    Route::delete('/setting/{id}', [SettingController::class, 'destroy']);
    Route::delete('/benefit/{id}', [BenefitController::class, 'destroy']);
    Route::delete('/qna/{id}', [QnaController::class, 'destroy']);
    Route::delete('/testi_student/{id}', [TestiStudentController::class, 'destroy']);

});
