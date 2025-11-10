<?php

namespace App\Http\Controllers\api\v1;

use App\Enum\ModelClassEnum;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Utility\AccountTypeResource;
use App\Services\Utility\CRUDService;
use App\Services\Utility\UtilityService;
use App\Traits\JsonResponseTrait;
use App\Utils\QueryParamValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Random\RandomException;

class UtilityController extends Controller
{
    use JsonResponseTrait;

    public function ping(): JsonResponse
    {
        return $this->successResponse(message: 'API is working well');
    }

    public function listAccountTypes(): JsonResponse
    {
        $accountTypes = CRUDService::get(ModelClassEnum::ACCOUNT_TYPE);
        return $this->successDataResponse(data: AccountTypeResource::collection($accountTypes));
    }

    /**
     * @throws CustomException
     * @throws RandomException
     */
    public function verifyBvn(Request $request): JsonResponse
    {
        ['bvn' => $bvn] = QueryParamValidator::getRequiredParams($request, ['bvn']);
        return $this->defaultResponse(UtilityService::verifyBvn($bvn), 200);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        ['otpCode' => $otpCode] = QueryParamValidator::getRequiredParams($request, ['otpCode']);
        $reference = $request->user()->reference;
        $code = $request->user()->code;
        UtilityService::verifyOtpCode($otpCode, $reference, $code);
        return $this->successResponse(message: 'OTP verified successfully');
    }
}
