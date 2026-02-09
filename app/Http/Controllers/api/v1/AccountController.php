<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountReferenceSubmissionData;
use App\Http\Requests\Account\BankAccountReferenceData;
use App\Http\Requests\Account\CompanyDocumentData;
use App\Http\Requests\Account\CorporateAccountData;
use App\Http\Requests\Account\IndividualAccountData;
use App\Http\Requests\Account\POSMerchantAccountData;
use App\Http\Requests\Account\UpdateBankAccountReferenceData;
use App\Http\Requests\Account\UpdateDirectorySignatoryData;
use App\Services\Account\AccountService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Random\RandomException;
use Throwable;

class AccountController extends Controller
{
    use JsonResponseTrait;

    /**
     * @throws Throwable
     */
    public function createIndividualAccount(IndividualAccountData $request): JsonResponse
    {
        $data = $request->validated();
        $accountNumber = AccountService::createIndividualAccount($data);
        return $this->successDataResponse(data: ['accountNumber' => $accountNumber], message: 'Individual account created successfully.');
    }

    /**
     * @throws Throwable
     * @throws CustomException
     */
    public function createPosAccount(POSMerchantAccountData $request): JsonResponse
    {
        $data = $request->validated();
        $accountNumber = AccountService::posMerchantAccount($data);
        return $this->successDataResponse(data: ['accountNumber' => $accountNumber], message: 'Merchant account created successfully.');
    }

    /**
     * @throws Throwable
     * @throws CustomException
     */
    public function createCorporateAccount(CorporateAccountData $request): JsonResponse
    {
        $data = $request->validated();
        $accountNumber = AccountService::corporateAccount($data);
        return $this->successDataResponse(data: ['accountNumber' => $accountNumber], message: 'Corporate account created successfully.');
    }

    /**
     * @throws RandomException
     */
    public function submitBankAccountReference(BankAccountReferenceData $request): JsonResponse
    {
        $data = $request->validated();
        AccountService::addBankAccountReference($data);
        return $this->successResponse(message: 'Bank account reference submitted successfully.');
    }

    public function updateBankAccountReference(UpdateBankAccountReferenceData $request): JsonResponse
    {
        $data = $request->validated();
        AccountService::updateBankAccountReference($data);
        return $this->successResponse(message: 'Bank account reference updated successfully.');
    }

    public function createBankAccountReference(AccountReferenceSubmissionData $request): JsonResponse
    {
        $data = $request->validated();
        AccountService::createBankAccountReference($data);
        return $this->successResponse(message: 'Bank account reference submitted successfully.');
    }

    /**
     * @throws RandomException
     */
    public function submitCorporateAccountCompanyDocument(CompanyDocumentData $request): JsonResponse
    {
        $data = $request->validated();
        AccountService::updateCorporateAccountCompanyDocument($data);
        return $this->successResponse(message: 'Company documents submitted successfully.');
    }

    public function updateDirectorySignatoryInformation(UpdateDirectorySignatoryData $request): JsonResponse
    {
        $data = $request->validated();
        AccountService::updateDirectorySignatory($data);
        return $this->successResponse(message: 'Documents updated successfully.');
    }
}
