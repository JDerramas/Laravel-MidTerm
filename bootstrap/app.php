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
        // Trust all reverse proxies (Render, Cloudflare, etc.) for HTTPS SSL termination & client IP recognition
        $middleware->trustProxies(at: '*');

        $middleware->validateCsrfTokens(except: [
            'api/*',
            'student/*',
        ]);

        // Persistent Device Session & 1-Hour Inactivity Auto-Logout
        $middleware->web(append: [
            \App\Http\Middleware\PersistentStudentDeviceSession::class,
        ]);

        // Prevent single-threaded PHP CLI server (php artisan serve) from locking up persistent sockets on Windows
        $middleware->append(\App\Http\Middleware\CloseConnectionForCliServer::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
