<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         | TLS is terminated by the platform's reverse proxy (Traefik, under
         | Coolify), which forwards plain HTTP to the container along with
         | X-Forwarded-Proto: https.
         |
         | Without trusting it, Laravel considers the request insecure and
         | asset() generates http:// URLs on an https:// page - which browsers
         | block as mixed content, leaving the site with no CSS, no JS and no
         | images.
         |
         | '*' is correct here because the container is only reachable through
         | that proxy on the internal Docker network; it is never exposed
         | directly, so there is no untrusted client able to spoof the headers.
         */
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [SetLocale::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
