@extends('layouts.site')

@section('title', 'Ebay Services - XpertVA')
@section('meta_description', 'XpertVA eBay services: professional listing creation, store management, feedback management, order processing, and growth strategies.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/ebay') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="eBay Services | XpertVA">
<meta property="og:description" content="eBay store design, listing templates, Promoted Listings and daily order handling.">
<meta property="og:url" content="{{ url('/services/ebay') }}">
<meta property="og:image" content="{{ asset('assets/photos/fulfilment-floor.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eBay Store Management",
  "serviceType": "eBay Store Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "eBay store design, listing creation and templates, Promoted Listings advertising, feedback and returns management, and order processing.",
  "url": "{{ url('/services/ebay') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'eBay services',
    'lede'     => 'An eBay store still moves serious volume in the right categories. It just needs someone working it daily.',
    'photo'    => 'assets/photos/fulfilment-floor.jpg',
    'photoAlt' => 'A fulfilment warehouse floor stacked with outbound cartons.',
    'intro'    => 'eBay rewards listing volume, competitive shipping and a clean feedback record. All three come down to daily operational work, which is exactly what we staff.',
    'capabilities' => [
        ['name' => 'Listing creation at volume', 'desc' => 'Bulk listing, variation listings and category specifics filled properly so items surface in Best Match.'],
        ['name' => 'Store design and templates', 'desc' => 'Branded store front, category pages and reusable listing templates that stay compliant with eBay active content rules.'],
        ['name' => 'Promoted Listings', 'desc' => 'Standard and Advanced campaigns with ad rate strategy set per category rather than one blanket percentage.'],
        ['name' => 'Order and returns handling', 'desc' => 'Daily order processing, dispatch tracking upload, returns and case handling inside eBay service metrics.'],
        ['name' => 'Feedback and seller standards', 'desc' => 'Feedback recovery, defect monitoring and the work needed to hold Top Rated Seller status.'],
        ['name' => 'Cross channel sync', 'desc' => 'Stock and pricing kept in step with Amazon, Walmart and Shopify so you do not oversell.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '9 yrs', 'label' => 'Running marketplace accounts for sellers'],
    ],
    'related' => [
        ['Amazon services', 'services.amazon'],
        ['Walmart Marketplace', 'services.walmart'],
        ['Virtual assistants', 'services.va'],
        ['Content and branding', 'services.content-branding'],
    ],
])
@endsection
