@extends('layouts.site')

@section('title', 'Walmart Services - XpertVA')
@section('meta_description', 'XpertVA Walmart Marketplace: account setup, listing optimization, inventory management, and advertising to grow your Walmart seller account.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/walmart') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Walmart Marketplace Services | XpertVA">
<meta property="og:description" content="Walmart Marketplace setup, item optimisation, WFS and Connect advertising managed end to end.">
<meta property="og:url" content="{{ url('/services/walmart') }}">
<meta property="og:image" content="{{ asset('assets/photos/pos-counter.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Walmart Marketplace Management",
  "serviceType": "Walmart Marketplace Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Walmart Marketplace account setup, item content optimisation, Walmart Fulfilment Services, Connect advertising and Buy Box recovery.",
  "url": "{{ url('/services/walmart') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Walmart Marketplace',
    'lede'     => 'Less crowded than Amazon and still growing. The sellers who set it up properly early are the ones taking the Buy Box now.',
    'photo'    => 'assets/photos/pos-counter.jpg',
    'photoAlt' => 'A shop counter with a tablet point of sale system in use.',
    'intro'    => 'Walmart rewards clean item data and punishes the sellers who copied their Amazon listings across. We set the catalogue up to Walmart specification and run it against Walmart metrics, not Amazon ones.',
    'capabilities' => [
        ['name' => 'Account and item setup', 'desc' => 'Seller onboarding, taxonomy mapping, bulk item feeds and the spec sheet work that stops items sitting unpublished for weeks.'],
        ['name' => 'Content optimisation', 'desc' => 'Titles, key features, descriptions and rich media written to Walmart Listing Quality Score, which scores differently from Amazon.'],
        ['name' => 'Buy Box and pricing', 'desc' => 'Repricing strategy, shipping settings and offer quality work aimed at winning and holding the Buy Box.'],
        ['name' => 'Walmart Fulfilment Services', 'desc' => 'WFS enrolment, inbound planning, inventory forecasting and the storage decisions that keep fees down.'],
        ['name' => 'Walmart Connect advertising', 'desc' => 'Sponsored Products and Search Brand Amplifier campaigns built and bid against a target ad spend ratio.'],
        ['name' => 'Performance standards', 'desc' => 'Order defect rate, on time delivery and cancellation monitoring, with the fixes made before Walmart flags them.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon services', 'services.amazon'],
        ['eBay services', 'services.ebay'],
        ['Shopify services', 'services.shopify'],
        ['Marketing solutions', 'services.marketing'],
    ],
])
@endsection
