<?php

namespace App\Http;

use App\Http\Middleware\AdminAccess;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * This middleware is run during every request to your application.
     */
    protected $middleware = [
        // Add global middleware here, e.g.:
    ];

    /**
     * The application's route middleware groups.
     *
     * These middleware groups may be assigned to groups in your routes/web.php file.
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used to conveniently assign middleware to routes.
     */
    protected $middlewareAliases = [
        'access.token' => \App\Http\Middleware\AccessToken::class,
        'access.administrative' => AdminAccess::class,
    ];
}
