<?php

use App\Http\Controllers\api\v1\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::post('login', 'authenticate');
    Route::middleware('access.administrative')->group(function () {
        Route::get('customer-list', 'customers');
        Route::get('savings-account-list', 'listSavingsAccount');
        Route::get('current-account-list', 'listCurrentAccount');
        Route::get('fetch-individual-account', 'fetchIndividualAccount');

        Route::get('customer-summary', 'customerSummary');
        Route::get('savings-account-summary', 'savingsAccountSummary');
        Route::get('current-account-summary', 'currentAccountSummary');
        Route::get('data-link', 'dataLink');
    });
});
