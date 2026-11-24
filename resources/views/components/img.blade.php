@props(['src', 'alt' => ''])
@php
    /*
     | Emits <picture> with a WebP source when a .webp twin exists on disk,
     | and a plain <img> when it does not.
     |
     | This replaces the Accept-header negotiation that used to live in
     | .htaccess. That approach was wrong behind Cloudflare: Cloudflare
     | honours only "Vary: Accept-Encoding" and ignores "Vary: Accept", so
     | whichever variant reached the edge cache first was then served to
     | everyone — including WebP to browsers that cannot read it.
     |
     | Here the two formats have different URLs, so the cache key separates
     | them and the browser, not the cache, decides which to fetch.
    */
    $path = parse_url($src, PHP_URL_PATH) ?: $src;
    $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);

    static $exists = [];                       // one stat per file per request
    if ($webp === $path) {
        $hasWebp = false;                      // not a convertible format
    } else {
        if (!array_key_exists($webp, $exists)) {
            $exists[$webp] = is_file(public_path(ltrim($webp, '/')));
        }
        $hasWebp = $exists[$webp];
    }
@endphp
@if ($hasWebp)
<picture>
    <source srcset="{{ $webp }}" type="image/webp">
    <img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>
</picture>
@else
<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>
@endif
