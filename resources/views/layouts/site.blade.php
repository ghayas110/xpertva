<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- No CSRF meta here on purpose: these pages are CDN-cached, so a
         token baked into the HTML would be shared between visitors and
         rejected for almost all of them. chat.js fetches a live token
         from /chat/token, which is never cached. --}}
    <title>@yield('title', 'XpertVA - eCommerce operations for Amazon, Shopify, Walmart and eBay brands')</title>
    <meta name="description" content="@yield('meta_description', 'XpertVA runs marketplace operations for eCommerce brands. Listings, advertising, account health and creative on Amazon, Shopify, Walmart and eBay. Founded 2017.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#FAF9F6">

    <link rel="preload" as="font" type="font/woff2" href="{{ asset('assets/fonts/bricolage.woff2') }}" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="{{ asset('assets/fonts/geist.woff2') }}" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}?v=9">

    @if ($gaId = config('services.google_analytics.id'))
        {{-- Google tag, exactly as Google issued it for this property.
             Loading gtm.js with a G- measurement ID serves a container that
             already carries the GA4 config, so it fires page_view on its own
             and also brings enhanced measurement (scroll, outbound clicks)
             with it. Adding gtag('config', ...) here as well would register
             the ID a second time and risk a duplicate page_view, so it is
             deliberately absent.

             Placed after the font and CSS preloads so it never competes with
             them for the first connections; async means it does not block
             rendering either way. --}}
        <link rel="preconnect" href="https://www.googletagmanager.com">
        <script async src="https://www.googletagmanager.com/gtm.js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
        </script>
    @endif

    @stack('head')

    @verbatim
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": ["Organization", "LocalBusiness"],
          "@id": "https://xpertva.com/#organization",
          "name": "XpertVA",
          "url": "https://xpertva.com",
          "logo": {
            "@type": "ImageObject",
            "url": "https://xpertva.com/assets/images/logo-xpertva.png"
          },
          "foundingDate": "2017",
          "description": "Professional virtual assistant services for eCommerce sellers on Amazon, eBay, Shopify, and Walmart. Founded 2017.",
          "address": {
            "@type": "PostalAddress",
            {{-- streetAddress removed: it held "EnglishTown", which is the
                 city, not a street. A wrong street address is worse than
                 none — Google cross-checks it against the Business Profile.
                 Put the real one back here once it matches GBP exactly. --}}
            "addressLocality": "Englishtown",
            "addressRegion": "NJ",
            "postalCode": "07726",
            "addressCountry": "US"
          },
          "telephone": "+17324906272",
          "email": "hello@xpertva.com",
          "sameAs": [
            "https://www.facebook.com/xpertva",
            "https://www.instagram.com/xpertva/",
            "https://www.linkedin.com/company/xpertva"
          ],
          "areaServed": "Worldwide",
          "priceRange": "$$",
          "openingHours": "Mo-Fr 09:00-18:00"
        }
      ]
    }
    </script>
    @endverbatim
    @stack('schema')
</head>
<body>
    <a class="skip" href="#main">Skip to content</a>

    @include('site.nav', ['headTone' => trim($__env->yieldContent('head_tone'))])

    <main id="main">
        @if (session('success'))
            <div class="wrap" style="padding-top:6.5rem">
                <p class="flash" role="status">{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    @include('site.footer')
    @include('site.modals')
    @include('site.chat')

    <script src="{{ asset('assets/js/vendor/gsap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/ScrollTrigger.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/lenis.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/site.js') }}?v=9" defer></script>
    <script src="{{ asset('assets/js/chat.js') }}?v=2" defer></script>
    @stack('scripts')
</body>
</html>
