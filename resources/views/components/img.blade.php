@props(['src', 'alt' => '', 'sizes' => null])
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
     |
     | Two more jobs, both from the Nov 2026 SEO audit:
     |
     | - width and height. An image without them reserves no space, so the
     |   page jumps as it loads (CLS). When the caller gives neither, they are
     |   read from the file; when it gives one, the other follows the file's
     |   aspect ratio.
     |
     | - srcset. Smaller WebP copies named name-w640.webp, name-w1024.webp
     |   (made by scripts/make-image-variants.sh) are offered alongside the
     |   full-size WebP, so a phone downloads a phone-sized file. Pass sizes
     |   when the image is narrower than the viewport; it defaults to 100vw.
    */
    $path = parse_url($src, PHP_URL_PATH) ?: $src;
    $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $path);

    static $exists = [];                       // one stat per file per request
    static $dims = [];
    static $variants = [];

    $local = fn ($p) => public_path(ltrim($p, '/'));

    if ($webp === $path) {
        $hasWebp = false;                      // not a convertible format
    } else {
        if (!array_key_exists($webp, $exists)) {
            $exists[$webp] = is_file($local($webp));
        }
        $hasWebp = $exists[$webp];
    }

    // Intrinsic size of the original file, cached for the request.
    if (!array_key_exists($path, $dims)) {
        $size = is_file($local($path)) ? @getimagesize($local($path)) : false;
        $dims[$path] = $size ? [$size[0], $size[1]] : null;
    }
    $w = $attributes->get('width');
    $h = $attributes->get('height');
    if ($dims[$path] && (!$w || !$h)) {
        [$iw, $ih] = $dims[$path];
        if (!$w && !$h) {
            [$w, $h] = [$iw, $ih];
        } elseif ($w) {
            $h = (int) round($w * $ih / $iw);
        } else {
            $w = (int) round($h * $iw / $ih);
        }
    }
    $attributes = $attributes->merge(array_filter(['width' => $w, 'height' => $h]));

    // Responsive WebP set: the -wNNN copies plus the full-size twin.
    $srcset = null;
    if ($hasWebp) {
        if (!array_key_exists($webp, $variants)) {
            $base = preg_replace('/\.webp$/', '', $webp);
            $found = [];
            foreach (glob($local($base) . '-w*.webp') ?: [] as $file) {
                if (preg_match('/-w(\d+)\.webp$/', $file, $m)) {
                    $found[(int) $m[1]] = $base . '-w' . $m[1] . '.webp';
                }
            }
            ksort($found);
            $variants[$webp] = $found;
        }
        if ($variants[$webp]) {
            $full = is_file($local($webp)) ? (@getimagesize($local($webp))[0] ?? null) : null;
            $set = array_map(fn ($url, $width) => "$url {$width}w", $variants[$webp], array_keys($variants[$webp]));
            if ($full) {
                $set[] = "$webp {$full}w";
            }
            $srcset = implode(', ', $set);
        }
    }
@endphp
@if ($hasWebp)
<picture>
    <source srcset="{{ $srcset ?? $webp }}" type="image/webp" @if ($srcset) sizes="{{ $sizes ?? '100vw' }}" @endif>
    <img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>
</picture>
@else
<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>
@endif
