<?php

namespace App\Http\Middleware;

use App\Helpers\EncryptionHelper;
use App\Traits\JsonResponseTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessToken
{
    use JsonResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return $this->errorResponse(401, 'Unauthorized - No token');
        }
        $decryptToken = EncryptionHelper::secureString($token, 'decrypt');
        if (empty($decryptToken) || empty($decryptToken['reference']) || !is_numeric($decryptToken['code'])) {
            return $this->errorResponse(401, message: 'Unauthorized - Invalid authorization token');
        }
        $request->setUserResolver(fn () => (object) $decryptToken);
        return $next($request);
    }
}
