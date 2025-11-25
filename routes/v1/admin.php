<?php

use App\Http\Controllers\api\v1\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::post('login', 'authenticate');
    Route::get('data-link', 'dataLink');
});
