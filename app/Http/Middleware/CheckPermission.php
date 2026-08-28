<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    use JsonResponseTrait;

    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            return $this->errorResponse(401, 'Unauthorized');
        }

        foreach ($permissions as $permission) {
            if (!$user->hasPermissionTo($permission)) {
                return $this->errorResponse(403, 'Forbidden - Insufficient permissions');
            }
        }

        return $next($request);
    }
}
