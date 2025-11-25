<?php

namespace App\Providers;

use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public const HOME = '/home';
    protected $namespace = null;


    public function boot(): void
    {
        RateLimiter::for(
            'api',
            function (Request $request) {
                return Limit::perMinute(100)->by($request->user()?->id ?: $request->ip());
            }
        );

        Route::middleware([ApiKeyMiddleware::class])
            ->group(
                function () {
                    $this->utilityRoutes();
                    $this->accountRoutes();
                    $this->adminRoutes();
                }
            );
    }

    public function utilityRoutes(): void
    {
        Route::prefix('api/v1/utility/')
            ->namespace($this->namespace)
            ->group(function () {
                include base_path('routes/v1/utility.php');
            });
    }

    public function accountRoutes(): void
    {
        Route::prefix('api/v1/account/')
            ->namespace($this->namespace)
            ->group(function () {
                include base_path('routes/v1/account.php');
            });
    }

    public function adminRoutes(): void
    {
        Route::prefix('api/v1/admin/')
            ->namespace($this->namespace)
            ->group(function () {
                include base_path('routes/v1/admin.php');
            });
    }

}
