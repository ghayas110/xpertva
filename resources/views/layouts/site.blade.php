<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}?v=8">

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
            "streetAddress": "EnglishTown",
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

    <script src="{{ asset('assets/js/vendor/gsap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/ScrollTrigger.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/lenis.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/site.js') }}?v=8" defer></script>
    @stack('scripts')
</body>
</html>
