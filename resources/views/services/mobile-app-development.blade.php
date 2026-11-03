@extends('layouts.site')

@section('title', 'Mobile App Development - XpertVA')
@section('meta_description', 'XpertVA mobile app development: iOS and Android apps, PWAs, and cross-platform mobile solutions designed for eCommerce and business growth.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/mobile-app-development') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Mobile App Development | XpertVA">
<meta property="og:description" content="iOS, Android and progressive web apps for eCommerce brands, built and shipped to the stores.">
<meta property="og:url" content="{{ url('/services/mobile-app-development') }}">
<meta property="og:image" content="{{ asset('assets/photos/desk-devices.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Mobile App Development",
  "serviceType": "Mobile App Development",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Native and cross platform mobile app development for iOS and Android, plus progressive web apps, with store submission and release management included.",
  "url": "{{ url('/services/mobile-app-development') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Mobile app development',
    'lede'     => 'Worth building when repeat purchase is your business. Not worth building because a competitor has one.',
    'photo'    => 'assets/photos/desk-devices.jpg',
    'photoAlt' => 'Laptops, tablets and phones laid out across a shared work surface.',
    'intro'    => 'We will tell you honestly whether an app earns its keep for your catalogue. When it does, we build it, ship it to both stores, and stay on for the releases that follow.',
    'capabilities' => [
        ['name' => 'Native iOS and Android', 'desc' => 'Swift and Kotlin where performance, offline behaviour or device hardware genuinely matter.'],
        ['name' => 'Cross platform', 'desc' => 'React Native and Flutter when one team and one codebase serve the roadmap better than two.'],
        ['name' => 'Progressive web apps', 'desc' => 'Installable, offline capable web apps when the app store adds cost without adding reach.'],
        ['name' => 'Commerce features', 'desc' => 'Catalogue, cart, saved payment, push driven reorder and loyalty, wired to your existing commerce backend.'],
        ['name' => 'Store submission', 'desc' => 'App Store and Play Console setup, review preparation, privacy labels and phased rollout.'],
        ['name' => 'After launch', 'desc' => 'Crash monitoring, OS version support and a release cadence, because an unmaintained app stops working within a year.'],
    ],
    'proof' => [
        ['value' => '100+', 'label' => 'Digital products delivered for client brands'],
        ['value' => '9 yrs', 'label' => 'Building software for eCommerce operators'],
    ],
    'related' => [
        ['Web development', 'services.web-dev'],
        ['Design and development', 'services.design'],
        ['Shopify services', 'services.shopify'],
        ['Marketing solutions', 'services.marketing'],
    ],
])
@endsection
