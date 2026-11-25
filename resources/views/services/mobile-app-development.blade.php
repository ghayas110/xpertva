@extends('layouts.site')

@section('title', 'Mobile App Development Services | XpertVA')
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
    'title' => 'Mobile App Development Services',
    'kicker' => 'Mobile app development',
    'lede'     => 'Worth building when repeat purchase is your business. Not worth building because a competitor has one.',
    'photo'    => 'assets/photos/desk-devices.jpg',
    'photoAlt' => 'Laptops, tablets and phones laid out across a shared work surface.',
    'intro'    => 'We will tell you honestly whether an app earns its keep for your catalogue. When it does, we build it, ship it to both stores, and stay on for the releases that follow.',
    'definition' => 'Mobile app development for eCommerce means building iOS and Android apps, or installable web apps, that let customers browse, buy and reorder from their phone. XpertVA builds native, cross platform and progressive web apps connected to your existing store, and tells you first whether an app will pay for itself.',
    'process' => [
        ['name' => 'Decide if it pays', 'desc' => 'We look at repeat purchase rates and mobile traffic and tell you honestly whether an app is worth building.'],
        ['name' => 'Choose the approach', 'desc' => 'Native, cross platform or progressive web app, picked for your roadmap and budget, written into the scope.'],
        ['name' => 'Build and submit', 'desc' => 'We build, test on real devices and handle App Store and Google Play submission.'],
        ['name' => 'Maintain', 'desc' => 'Crash monitoring, OS updates and a regular release schedule after launch.'],
    ],
    'deliverables' => [
        'A written recommendation on whether to build',
        'A scoped build plan and platform choice',
        'Tested iOS and Android builds or a PWA',
        'App Store and Play Console submission',
        'Crash and performance monitoring',
        'A release schedule after launch',
    ],
    'fitFor' => [
        'Brands where repeat purchase drives revenue, such as consumables and subscriptions',
        'Stores with most traffic on mobile and a loyal customer base',
        'Businesses that want push notifications for reorders and loyalty',
        'Teams with an existing app that needs rescuing or a reliable release schedule',
    ],
    'notFitFor' => [
        'You want an app mainly because a competitor has one',
        'Your customers buy from you once a year',
        'You have no budget for maintenance after launch',
    ],
    'faqs' => [
        ['Does my store need a mobile app?', 'Usually only if repeat purchase drives your business, such as consumables or subscriptions. If not, a fast mobile site or a progressive web app often does the job for less.'],
        ['Native or cross platform?', 'Native suits apps that need top performance or device hardware. Cross platform frameworks such as React Native and Flutter let one team serve both stores. We recommend one in the scope.'],
        ['What is a progressive web app?', 'A website that can be installed on a phone and works offline, without going through the app stores. It suits stores that want an app-like experience without store fees and reviews.'],
        ['Will the app connect to our Shopify or custom store?', 'Yes. The app uses your existing catalogue, cart and customer data rather than a separate system.'],
        ['How much does a mobile app cost?', 'It depends on the platforms, features and integrations. We give a fixed quote in the written scope after a free consultation.'],
    ],
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
