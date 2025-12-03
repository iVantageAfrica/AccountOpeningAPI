<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthenticateRequest;
use App\Http\Resources\Account\IndividualAccountResource;
use App\Http\Resources\Account\UserResource;
use App\Services\Account\AdminService;
use App\Traits\CustomPaginationResponseTrait;
use App\Traits\JsonResponseTrait;
use App\Utils\QueryParamValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use Random\RandomException;

class AdminController extends Controller
{
    use JsonResponseTrait;
    use CustomPaginationResponseTrait;

    /**
     * @throws CustomException|RandomException
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::authenticate($data));
    }

    public function customers(Request $request): JsonResponse
    {
        $customerList = AdminService::customerList();
        return $this->customPaginationResponse($customerList, $request, UserResource::class, ['bvn', 'firstname', 'lastname', 'phone_number']);
    }

    public function customerSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::customerSummary());
    }

    public function listSavingsAccount(Request $request): JsonResponse
    {
        $savingsAccount = AdminService::individualAccount(2);
        return $this->customPaginationResponse($savingsAccount, $request, IndividualAccountResource::class, ['account_number','status']);
    }

    public function savingsAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::individualAccountSummary(2));
    }

    public function listCurrentAccount(Request $request): JsonResponse
    {
        $savingsAccount = AdminService::individualAccount(1);
        return $this->customPaginationResponse($savingsAccount, $request, IndividualAccountResource::class, ['account_number', 'status']);
    }

    public function currentAccountSummary(Request $request): JsonResponse
    {
        return $this->successDataResponse(AdminService::individualAccountSummary(1));
    }

    /**
     * @throws CustomException
     */
    public function fetchIndividualAccount(Request $request): JsonResponse
    {
        ['accountNumber' => $accountNumber] = QueryParamValidator::getRequiredParams($request, ['accountNumber']);
        return $this->successDataResponse(IndividualAccountResource::make(AdminService::fetchIndividualAccount($accountNumber), true));
    }

    /**
     * @throws JsonException
     */
    public function dataLink(): JsonResponse
    {
        AdminService::dataLink();
        return $this->successResponse();
    }
}
