<?php

use App\Http\Controllers\api\v1\UtilityController;

Route::controller(UtilityController::class)->group(function () {
    Route::get('ping', 'ping');
    Route::get('list-account-type', 'listAccountTypes');
    Route::get('verify-bvn', 'verifyBvn');
    Route::get('verify-otp', 'verifyOtp')->middleware('access.token');
});
