@extends('layouts.site')

@section('title', 'Website & eCommerce Development - XpertVA')
@section('meta_description', 'XpertVA web development services: custom eCommerce websites, Shopify, WooCommerce, WordPress, and PWA builds optimized for conversion and performance.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/web-development') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Web Development | XpertVA">
<meta property="og:description" content="Fast, accessible eCommerce sites on Shopify, WooCommerce and custom stacks, built for conversion.">
<meta property="og:url" content="{{ url('/services/web-development') }}">
<meta property="og:image" content="{{ asset('assets/photos/dev-screen.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Web Development",
  "serviceType": "Web Development",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Custom eCommerce website development on Shopify, WooCommerce, WordPress and headless stacks, with performance, accessibility and conversion work included.",
  "url": "{{ url('/services/web-development') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Web development',
    'lede'     => 'A store that loads in one second and works on a five year old phone will out earn a prettier one every time.',
    'photo'    => 'assets/photos/dev-screen.jpg',
    'photoAlt' => 'A developer working on a web interface at a large monitor.',
    'intro'    => 'We build eCommerce sites that hold up under real traffic on real devices. Performance, accessibility and analytics are part of the build, not a phase two nobody funds.',
    'capabilities' => [
        ['name' => 'Shopify and Shopify Plus', 'desc' => 'Custom themes and sections, checkout extensions, and B2B or wholesale setups on Plus.'],
        ['name' => 'WooCommerce and WordPress', 'desc' => 'Builds and rescues, including the hosting and caching decisions that keep a WooCommerce store fast.'],
        ['name' => 'Headless and custom', 'desc' => 'Next.js, Laravel and headless commerce when the catalogue or the integrations outgrow a hosted platform.'],
        ['name' => 'Performance', 'desc' => 'Core Web Vitals work on real device data. Image pipelines, script budgets and font loading rather than a plugin.'],
        ['name' => 'Accessibility', 'desc' => 'Keyboard paths, contrast, focus states and screen reader labelling checked against WCAG 2.2 AA.'],
        ['name' => 'Integrations', 'desc' => 'ERP, third party logistics, subscription, tax and CRM connections built to survive their next API change.'],
    ],
    'proof' => [
        ['value' => '100+', 'label' => 'Websites delivered for client brands'],
        ['value' => '9 yrs', 'label' => 'Building and running eCommerce systems'],
    ],
    'related' => [
        ['Mobile app development', 'services.mobile-app'],
        ['Design and development', 'services.design'],
        ['Shopify services', 'services.shopify'],
        ['Marketing solutions', 'services.marketing'],
    ],
])
@endsection
