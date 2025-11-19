<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CorporateAccountData;
use App\Http\Requests\Account\IndividualAccountData;
use App\Http\Requests\Account\POSMerchantAccountData;
use App\Services\Account\AccountService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
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
}
