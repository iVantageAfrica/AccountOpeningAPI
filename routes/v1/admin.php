<?php

use App\Http\Controllers\api\v1\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::post('login', 'authenticate');
    Route::get('data-link', 'dataLink');

    Route::middleware('access.administrative')->group(function () {
        Route::get('customer-list', 'customers');
        Route::get('savings-account-list', 'listSavingsAccount');
        Route::get('current-account-list', 'listCurrentAccount');
        Route::get('corporate-account-list', 'listCorporateAccount');
        Route::get('pos-account-list', 'listPOSAccount');


        Route::get('fetch-individual-account', 'fetchIndividualAccount');
        Route::get('fetch-corporate-account', 'fetchCorporateAccount');

        Route::get('customer-summary', 'customerSummary');
        Route::get('savings-account-summary', 'savingsAccountSummary');
        Route::get('current-account-summary', 'currentAccountSummary');
        Route::get('corporate-account-summary', 'corporateAccountSummary');
        Route::get('pos-account-summary', 'POSAccountSummary');

        Route::get('debit-card-requests', 'listDebitCardRequest');
    });
});
