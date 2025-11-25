<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthenticateRequest;
use App\Services\Account\AdminService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use JsonException;

class AdminController extends Controller
{
    use JsonResponseTrait;

    /**
     * @throws CustomException
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->successDataResponse(AdminService::authenticate($data));
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
