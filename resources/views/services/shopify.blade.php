@extends('layouts.site')

@section('title', 'Shopify Services - XpertVA')
@section('meta_description', 'XpertVA Shopify services: store setup, theme customization, product management, app integrations, and conversion rate optimization.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/shopify') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Shopify Services | XpertVA">
<meta property="og:description" content="Shopify store builds, theme work, catalogue management and conversion optimisation from a team that runs stores every day.">
<meta property="og:url" content="{{ url('/services/shopify') }}">
<meta property="og:image" content="{{ asset('assets/photos/retail-store.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Shopify Store Management and Development",
  "serviceType": "Shopify Store Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Shopify store setup, theme customisation, catalogue and inventory management, app integration, and conversion rate optimisation for direct to consumer brands.",
  "url": "{{ url('/services/shopify') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Shopify services',
    'lede'     => 'Your own store is the one channel nobody can suspend. We build it, stock it, and keep the checkout converting.',
    'photo'    => 'assets/photos/retail-store.jpg',
    'photoAlt' => 'A merchandised retail interior with considered product display.',
    'intro'    => 'Marketplaces rent you an audience. Shopify is where you own it. We handle the build and the daily running so your own store stops being the thing you get to next quarter.',
    'capabilities' => [
        ['name' => 'Store build and migration', 'desc' => 'New builds on Shopify and Shopify Plus, or migration from WooCommerce, Magento and BigCommerce with redirects and order history intact.'],
        ['name' => 'Theme and front end work', 'desc' => 'Custom sections, Liquid templates and speed work so the storefront loads fast and looks like your brand rather than a theme demo.'],
        ['name' => 'Catalogue and inventory', 'desc' => 'Product data, variants, collections, metafields and stock sync across Shopify, Amazon and your third party logistics provider.'],
        ['name' => 'Checkout and conversion', 'desc' => 'Cart, upsell, subscription and payment flows tuned against real session recordings and funnel data, not guesswork.'],
        ['name' => 'App stack', 'desc' => 'Reviews, loyalty, email, subscriptions and search apps chosen for what they cost you monthly and what they actually return.'],
        ['name' => 'Ongoing store operations', 'desc' => 'Orders, returns, customer emails, discount codes and campaign pages handled by a named operator every working day.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '9 yrs', 'label' => 'Running eCommerce operations for founders'],
    ],
    'related' => [
        ['Web development', 'services.web-dev'],
        ['Marketing solutions', 'services.marketing'],
        ['Content and branding', 'services.content-branding'],
        ['Amazon services', 'services.amazon'],
    ],
])
@endsection
