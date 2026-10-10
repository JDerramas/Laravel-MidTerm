<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CloseConnectionForCliServer
{
    /**
     * Handle an incoming request.
     *
     * Prevents single-threaded PHP CLI built-in web server (php artisan serve)
     * on Windows from locking up persistent HTTP/1.1 keep-alive sockets.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (php_sapi_name() === 'cli-server') {
            $response->headers->set('Connection', 'close');
        }

        return $response;
    }
}
