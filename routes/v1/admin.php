<?php

use App\Http\Controllers\api\v1\AdminController;

Route::controller(AdminController::class)->group(function () {
    Route::post('login', 'authenticate');
    //    Route::get('data-link', 'dataLink');

    Route::middleware('access.administrative')->group(function () {
        Route::put('profile', 'updateProfile');
        Route::put('change-password', 'changePassword');
        Route::post('assign-role', 'assignRole')->middleware('permission:assign-roles');
        Route::post('account-update-link', 'accountUpdateLink')->middleware('permission:send-account-update-link');


        Route::get('customer-summary', 'customerSummary')->middleware('permission:view-dashboard');
        Route::get('savings-account-summary', 'savingsAccountSummary')->middleware('permission:view-dashboard');
        Route::get('current-account-summary', 'currentAccountSummary')->middleware('permission:view-dashboard');
        Route::get('corporate-account-summary', 'corporateAccountSummary')->middleware('permission:view-dashboard');
        Route::get('pos-account-summary', 'POSAccountSummary')->middleware('permission:view-dashboard');
        Route::get('portal-reference-summary', 'portalReferenceSummary')->middleware('permission:view-dashboard');
        Route::get('customer-list', 'customers')->middleware('permission:view-customer-list');

        Route::get('savings-account-list', 'listSavingsAccount')->middleware('permission:view-account-lists');
        Route::get('current-account-list', 'listCurrentAccount')->middleware('permission:view-account-lists');
        Route::get('corporate-account-list', 'listCorporateAccount')->middleware('permission:view-account-lists');
        Route::get('pos-account-list', 'listPOSAccount')->middleware('permission:view-account-lists');
        Route::get('portal-reference-list', 'listPortalReferenceAccount')->middleware('permission:view-portal-references');

        Route::get('fetch-individual-account', 'fetchIndividualAccount')->middleware('permission:view-account-details');
        Route::get('fetch-corporate-account', 'fetchCorporateAccount')->middleware('permission:view-account-details');
        Route::get('debit-card-requests', 'listDebitCardRequest')->middleware('permission:view-debit-card-requests');


        Route::post('create-admin', 'createAdmin')->middleware('permission:manage-admins');
        Route::get('list-admins', 'listAdmins')->middleware('permission:manage-admins');
        Route::get('fetch-admin', 'fetchAdmin')->middleware('permission:manage-admins');
        Route::put('update-admin/{adminId}', 'updateAdmin')->middleware('permission:manage-admins');
        Route::delete('delete-admin/{adminId}', 'deleteAdmin')->middleware('permission:manage-admins');

        Route::get('audit-logs', 'listAuditLogs')->middleware('permission:manage-admins');
    });
});
