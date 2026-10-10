<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'api/*',
            'student/*',
        ]);

        // Prevent single-threaded PHP CLI server (php artisan serve) from locking up persistent sockets on Windows
        $middleware->append(\App\Http\Middleware\CloseConnectionForCliServer::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
