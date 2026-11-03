@extends('layouts.site')

@section('title', 'Professional Virtual Assistance - XpertVA')
@section('meta_description', 'Hire a professional virtual assistant from XpertVA for eCommerce operations, customer support, data entry, order management, and more.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/virtual-assistant') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="eCommerce Virtual Assistants | XpertVA">
<meta property="og:description" content="Trained eCommerce virtual assistants for Seller Central, customer support, order management and catalogue work.">
<meta property="og:url" content="{{ url('/services/virtual-assistant') }}">
<meta property="og:image" content="{{ asset('assets/photos/team-table.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Virtual Assistant Services",
  "serviceType": "eCommerce Virtual Assistant",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Dedicated eCommerce virtual assistants trained on Amazon Seller Central, Shopify, Walmart and eBay for catalogue work, customer support, order management and reporting.",
  "url": "{{ url('/services/virtual-assistant') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Virtual assistants',
    'lede'     => 'A trained operator inside your account every working day, for a fraction of a local hire.',
    'photo'    => 'assets/photos/team-table.jpg',
    'photoAlt' => 'Three colleagues working through account tasks at a shared table.',
    'intro'    => 'A general virtual assistant costs you time in training. Ours arrive knowing Seller Central, Shopify admin and Walmart Seller Center, because that is all they work in.',
    'capabilities' => [
        ['name' => 'Dedicated, not shared', 'desc' => 'One named person on your account with a backup who knows it. You get their working hours, not a ticket queue.'],
        ['name' => 'Marketplace trained', 'desc' => 'Every assistant is trained on Seller Central, Shopify admin, Walmart Seller Center and eBay Seller Hub before they touch a client account.'],
        ['name' => 'Catalogue and listings', 'desc' => 'Product uploads, variation fixes, flat files, image updates and the steady maintenance a growing catalogue needs.'],
        ['name' => 'Customer support', 'desc' => 'Buyer messages, returns, A to Z claims and review follow up, answered inside marketplace response windows.'],
        ['name' => 'Order and inventory work', 'desc' => 'Order processing, stock counts, replenishment alerts, supplier chasing and third party logistics coordination.'],
        ['name' => 'Reporting you can read', 'desc' => 'A weekly written summary of what was done, what changed and what needs your decision.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon services', 'services.amazon'],
        ['Shopify services', 'services.shopify'],
        ['eBay services', 'services.ebay'],
        ['Amazon operations', 'services.amazon-ops'],
    ],
])
@endsection
