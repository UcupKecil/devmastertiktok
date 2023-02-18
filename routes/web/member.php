<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['guest']
], function () {
    Route::get('/member/aff/{uid}', [MemberController::class, 'setAffiliate']);
});
