<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function (): void {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(__DIR__.'/../routes/api_v1.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'throttle' => ThrottleRequests::class,
        ]);

        $middleware->throttleWithRedis();
        $middleware->api(append: ['throttle:api']);

        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
