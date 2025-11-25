<?php

namespace App\Http\Middleware;

use App\Helpers\EncryptionHelper;
use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    use JsonResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws RandomException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return $this->errorResponse(401, 'Unauthorized - No token');
        }
        $decryptToken = EncryptionHelper::secureString($token, 'decrypt');
        if (empty($decryptToken) || empty($decryptToken['is_admin']) || !is_numeric($decryptToken['id'])) {
            return $this->errorResponse(401, message: 'Unauthorized - Invalid Administrative token');
        }
        $request->setUserResolver(fn () => (object) $decryptToken);
        return $next($request);
    }
}
