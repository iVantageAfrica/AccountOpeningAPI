<?php

use App\Http\Controllers\api\v1\AccountController;

Route::controller(AccountController::class)->group(function () {
    Route::post('create-individual-account', 'createIndividualAccount');
    Route::post('create-pos-account', 'createPosAccount');
    Route::post('create-corporate-account', 'createCorporateAccount');
});
