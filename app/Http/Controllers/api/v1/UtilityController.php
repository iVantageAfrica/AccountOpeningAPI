<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;

class UtilityController extends Controller
{
    use JsonResponseTrait;

    public function ping(): JsonResponse
    {
        return $this->successResponse(message: 'API is working well');
    }
}
