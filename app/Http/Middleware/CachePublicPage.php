<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpFoundation\Response;

/**
 * Makes a public marketing page cacheable by a CDN.
 *
 * Two things were stopping Cloudflare caching anything: every response set a
 * laravel-session cookie, and every response said "no-cache, private". A
 * response carrying Set-Cookie is never cached, so every visitor paid full
 * origin latency — and with SESSION_DRIVER=database that meant a database
 * read and write to build a session no marketing page ever used.
 *
 * Routes using this middleware run without StartSession, so there is no
 * cookie to strip in the normal case. The header work below is belt and
 * braces for anything that queues a cookie anyway.
 */
class CachePublicPage
{
    /** Seconds the CDN may serve a cached copy. */
    private const SHARED_TTL = 600;

    /** Seconds the CDN may keep serving a stale copy while it revalidates. */
    private const STALE_TTL = 86400;

    public function handle(Request $request, Closure $next): Response
    {
        // $errors is normally shared by ShareErrorsFromSession, which does not
        // run here. Blade templates reference it unconditionally, so give them
        // an empty bag rather than an undefined variable.
        if (!View::shared('errors')) {
            View::share('errors', new ViewErrorBag());
        }

        $response = $next($request);

        // Only ever cache a plain successful read. HEAD counts: it is what
        // CDNs and uptime monitors send, and excluding it meant the headers
        // silently never applied to them.
        if (!in_array($request->getMethod(), ['GET', 'HEAD'], true) || $response->getStatusCode() !== 200) {
            return $response;
        }

        // A response that sets a cookie is uncacheable by every CDN worth the
        // name, so a stray cookie here would silently undo the whole change.
        $response->headers->remove('Set-Cookie');

        $response->headers->set('Cache-Control', implode(', ', [
            'public',
            'max-age=0',                              // browsers revalidate
            's-maxage=' . self::SHARED_TTL,           // the CDN holds it
            'stale-while-revalidate=' . self::STALE_TTL,
        ]));

        // The WebP rule in .htaccess varies on Accept, and responses are
        // compressed, so both must be declared or a cache can hand the wrong
        // body to the wrong client.
        $vary = $response->headers->get('Vary');
        $response->headers->set('Vary', $vary ? $vary . ', Accept-Encoding' : 'Accept-Encoding');

        return $response;
    }
}
