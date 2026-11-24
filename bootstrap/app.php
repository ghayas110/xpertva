<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'         => \App\Http\Middleware\CheckRole::class,
            'agent.token'  => \App\Http\Middleware\AgentToken::class,
            'cache.public' => \App\Http\Middleware\CachePublicPage::class,
        ]);

        /*
         | The two public lead forms post from pages that are cached by the
         | CDN, so their HTML cannot carry a per-visitor CSRF token — a cached
         | token would be shared between visitors and reject almost everyone.
         |
         | Dropping CSRF here is safe in a way it would not be on an
         | authenticated route: there is no signed-in action to forge. The
         | worst a forged request achieves is creating a lead. Spam is handled
         | instead by the rate limit on the route, a honeypot field, and a
         | same-origin check in PublicLeadController.
        */
        $middleware->validateCsrfTokens(except: [
            'contact/submit',
            'audit/submit',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
