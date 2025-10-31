<?php

use App\Http\Controllers\api\v1\UtilityController;

Route::controller(UtilityController::class)->group(function () {
    Route::get('ping', 'ping');
});
