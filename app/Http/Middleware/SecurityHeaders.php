<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline security headers on every Laravel response.
 *
 * HSTS is deliberately not here: it is switched on in Cloudflare (SSL/TLS ->
 * Edge Certificates), which also covers static files Apache serves without
 * touching Laravel, and sending it from both places would duplicate it.
 *
 * The Content-Security-Policy only restricts framing, <base> and plugins.
 * A script-src policy would have to list Google Tag Manager, the inline
 * dataLayer snippet, the chat widget and every portal page's inline
 * scripts; getting one wrong silently breaks a page, so that is a separate
 * job to roll out in Report-Only mode first.
 */
class SecurityHeaders
{
    private const HEADERS = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options'        => 'SAMEORIGIN',
        'Referrer-Policy'        => 'strict-origin-when-cross-origin',
        'Permissions-Policy'     => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
        'Content-Security-Policy' => "frame-ancestors 'self'; base-uri 'self'; object-src 'none'",
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach (self::HEADERS as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        return $response;
    }
}
