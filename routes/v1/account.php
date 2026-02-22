<?php

use App\Http\Controllers\api\v1\AccountController;

Route::controller(AccountController::class)->group(function () {
    Route::post('create-individual-account', 'createIndividualAccount');
    Route::post('create-corporate-account', 'createCorporateAccount');

    Route::post('add-bank-account-reference', 'submitBankAccountReference');
    Route::post('create-bank-account-reference', 'createBankAccountReference');
    Route::post('update-bank-account-reference', 'updateBankAccountReference');

    Route::post('submit-corporate-account-document', 'submitCorporateAccountCompanyDocument');
    Route::post('update-directory-signatory-information', 'updateDirectorySignatoryInformation');
});
