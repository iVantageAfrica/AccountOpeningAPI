<?php

namespace App\Http\Controllers\api\v1;

use App\Enum\ModelClassEnum;
use App\Enum\OtpPurpose;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Utility\AccountTypeResource;
use App\Services\Account\VerificationService;
use App\Services\Utility\CRUDService;
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
        return $this->successDataResponse(data:VerificationService::verifyBvn($bvn));
    }

    /**
     * @throws CustomException
     * @throws RandomException
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        ['otpCode' => $otpCode] = QueryParamValidator::getRequiredParams($request, ['otpCode']);
        $reference = $request->user()->reference;
        $code = $request->user()->code;
        return $this->successDataResponse(data:VerificationService::verifyOtpCode($otpCode, $reference, $code), message: 'OTP verified successfully');
    }

    /**
     * @throws CustomException
     * @throws RandomException
     */
    public function requestOtp(Request $request): JsonResponse
    {
        ['emailAddress' => $emailAddress, 'purpose' => $purpose] = QueryParamValidator::getRequiredParams($request, ['emailAddress', 'purpose']);
        $purpose = $purpose === 'BVN' ? OtpPurpose::BVN_VALIDATION : OtpPurpose::RESET_PASSWORD;
        $verificationToken = VerificationService::requestOTP(strtolower($emailAddress), $purpose);
        return $this->successDataResponse(data: $verificationToken);
    }

}
