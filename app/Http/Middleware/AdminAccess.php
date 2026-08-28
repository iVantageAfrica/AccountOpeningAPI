<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Services\Utility\JWTTokenService;
use App\Traits\JsonResponseTrait;
use Closure;
use Exception;
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
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = JWTTokenService::extractToken($request);
        if (!$token || JWTTokenService::isTokenBlacklisted($token)) {
            return $this->errorResponse(501, 'Unauthorized - No token');
        }
        $decryptToken = JWTTokenService::decodeToken($token);
        if (!$decryptToken) {
            return $this->errorResponse(501, message: 'Unauthorized - Invalid token');
        }
        if (empty($decryptToken) || empty($decryptToken['isAdmin']) || !is_numeric($decryptToken['id'])) {
            return $this->errorResponse(501, message: 'Unauthorized - Invalid Administrative token');
        }

        $admin = Admin::find($decryptToken['id']);
        if (!$admin || !$admin->is_admin) {
            return $this->errorResponse(401, message: 'Unauthorized - Admin account not found or deactivated');
        }

        $request->setUserResolver(fn () => $admin);
        return $next($request);
    }
}
