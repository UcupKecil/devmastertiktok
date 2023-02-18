<?php

use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

Route::get('/course/{slug}', [StaticPageController::class, 'course']);
