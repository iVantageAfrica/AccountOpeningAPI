<?php

namespace App\Services\Utility;

use App\Helpers\EncryptionHelper;
use App\Traits\JsonResponseTrait;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Random\RandomException;

class JWTTokenService
{
    use JsonResponseTrait;
    private const COOKIE_NAME = 'auth_token';
    private const BLACKLIST_PREFIX = 'blacklisted_token:';

    /**
     * @throws RandomException
     */
    public static function generateToken(array $data): string
    {
        $token = (new self())->configureToken($data);
        Cookie::queue(
            self::COOKIE_NAME,
            $token,
            config('app.jwt_expiration') / 60,
            '/',
            null,
            true,
            true
        );
        return EncryptionHelper::secureString($token);
    }

    public static function extractToken(Request $request): ?string
    {
        return $request->cookie(self::COOKIE_NAME) ?? $request->bearerToken();
    }

    /**
     * @throws Exception
     */
    public static function decodeToken(string $token): ?array
    {
        try {
            $token = EncryptionHelper::secureString($token, 'decrypt');
            return (array) JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
        } catch (ExpiredException $e) {
            throw new \RuntimeException('Token has expired. Kindly login again.');
        } catch (Exception $e) {
            throw new \RuntimeException('Invalid token.');
        }
    }

    private function configureToken(array $data): string
    {
        $payload = [
            'isAdmin' => $data['is_admin'] ?? null,
            'lastname' => $data['lastname'] ?? null,
            'firstname' => $data['firstname'] ?? null,
            'email' => $data['email'] ?? null,
            'id' => $data['id'],
            'iat' => now()->timestamp,
            'exp' => now()->addSeconds((int) config('app.jwt_expiration'))->timestamp,
        ];

        return JWT::encode($payload, config('app.jwt_secret'), 'HS256');
    }

    private static function blacklistToken(string $token, int $expiry): void
    {
        $cacheKey = self::BLACKLIST_PREFIX . md5($token);
        Cache::put($cacheKey, true, now()->addSeconds($expiry - now()->timestamp));
    }
    public static function isTokenBlacklisted(string $token): bool
    {
        return Cache::has(self::BLACKLIST_PREFIX . md5($token));
    }

    /**
     * @throws RandomException
     * @throws Exception
     */
    public static function refreshToken(Request $request, array $data): string
    {
        $oldToken = self::extractToken($request);
        $decodedToken = self::decodeToken($oldToken);
        self::blacklistToken($oldToken, $decodedToken['exp']);
        return self::generateToken($data);
    }
}
