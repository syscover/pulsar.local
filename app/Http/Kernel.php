<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
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
            'throttle:60,1',
            'bindings',
        ],

        'noCsrWeb' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        ],

        'pulsar' => [
            \Syscover\Pulsar\Middleware\Authenticate::class,
            \Syscover\Pulsar\Middleware\Locale::class,
            \Syscover\Pulsar\Middleware\Permission::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'                  => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'            => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'              => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'                   => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'                 => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'              => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'pulsar.auth'           => \Syscover\Pulsar\Middleware\Authenticate::class,
        'pulsar.locale'         => \Syscover\Pulsar\Middleware\Locale::class,
        'pulsar.permission'     => \Syscover\Pulsar\Middleware\Permission::class,
        'pulsar.https'          => \Syscover\Pulsar\Middleware\HttpsProtocol::class,
        'pulsar.navTools'       => \Syscover\NavTools\Middleware\NavTools::class,
        'pulsar.taxRule'        => \Syscover\Market\Middleware\TaxRule::class,
        'pulsar.web.auth'       => \App\Http\Middleware\Authenticate::class,
    ];
}
