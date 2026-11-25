@extends('layouts.site')

@section('title', 'Shopify Store Management Services | XpertVA')
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
    'title' => 'Shopify Store Management Services',
    'kicker' => 'Shopify services',
    'lede'     => 'Your own store is the one channel nobody can suspend. We build it, stock it, and keep the checkout converting.',
    'photo'    => 'assets/photos/retail-store.jpg',
    'photoAlt' => 'A merchandised retail interior with considered product display.',
    'intro'    => 'Marketplaces rent you an audience. Shopify is where you own it. We handle the build and the daily running so your own store stops being the thing you get to next quarter.',
    'definition' => 'Shopify store management is the ongoing work of running a Shopify store after launch: product and inventory updates, theme and app maintenance, checkout and conversion fixes, order and customer email handling, and the campaign pages that go live each month. XpertVA does that work for you, every working day, with one named operator.',
    'process' => [
        ['name' => 'Store audit', 'desc' => 'We go through the theme, apps, checkout, catalogue and analytics and write down what is costing you sales or money, in order of impact.'],
        ['name' => 'Fix the foundations', 'desc' => 'Broken tracking, slow pages, untidy collections and app bloat are dealt with first, because everything after depends on them.'],
        ['name' => 'Run the store daily', 'desc' => 'Your operator handles products, stock, orders, returns and customer email inside agreed response times.'],
        ['name' => 'Improve and report', 'desc' => 'Each week you get a written note of what changed, what it did to conversion and what we plan next.'],
    ],
    'deliverables' => [
        'A written store audit with fixes ranked by impact',
        'Theme, app and checkout changes made and tested',
        'Catalogue, collections and metafields kept accurate',
        'Inventory synced with Amazon and your logistics provider',
        'Orders, returns and customer email handled daily',
        'A weekly plain language report',
    ],
    'fitFor' => [
        'Brands doing steady revenue on Shopify who have outgrown doing store admin themselves',
        'Sellers moving from a marketplace-only business to owning their customer list',
        'Stores with a working theme that converts below what their traffic should deliver',
        'Teams migrating from WooCommerce, Magento or BigCommerce who cannot risk losing rankings',
    ],
    'notFitFor' => [
        'You have not launched yet and only need a one-off theme install',
        'You want daily posting on social media rather than store operations',
        'You are looking for the cheapest possible hourly help with no reporting',
    ],
    'faqs' => [
        ['What does a Shopify store manager do?', 'They run the store day to day: updating products and stock, handling orders, returns and customer emails, maintaining the theme and apps, publishing campaign pages and watching conversion. It is the operational work that keeps a store selling after the build is finished.'],
        ['Do you work on Shopify Plus?', 'Yes. We work on standard Shopify and Shopify Plus, including checkout extensions and wholesale or B2B setups on Plus.'],
        ['Can you migrate us from WooCommerce or Magento?', 'Yes. We move products, customers and order history, and map every old URL to its new one with redirects so search rankings carry over.'],
        ['Will you need full staff access to our store?', 'Your operator gets a named staff account with only the permissions the work needs. You can see and revoke it at any time from your Shopify admin.'],
        ['How much does Shopify store management cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
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
