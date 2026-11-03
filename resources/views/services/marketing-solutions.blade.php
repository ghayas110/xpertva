@extends('layouts.site')

@section('title', 'Marketing Solutions & SEO - XpertVA')
@section('meta_description', 'XpertVA digital marketing: data-driven campaigns, SEO, PPC, social media, and Amazon advertising strategies to grow your eCommerce brand.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/marketing-solutions') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Marketing Solutions | XpertVA">
<meta property="og:description" content="Search, paid social, email and marketplace advertising planned around one revenue number.">
<meta property="og:url" content="{{ url('/services/marketing-solutions') }}">
<meta property="og:image" content="{{ asset('assets/photos/retail-bags.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Digital Marketing",
  "serviceType": "Digital Marketing",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Search engine optimisation, paid search and social, email and lifecycle marketing, and marketplace advertising for eCommerce brands.",
  "url": "{{ url('/services/marketing-solutions') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Marketing solutions',
    'lede'     => 'Traffic is easy to buy and hard to make pay. We plan every channel against one number: what a customer is worth to you.',
    'photo'    => 'assets/photos/retail-bags.jpg',
    'photoAlt' => 'Retail shopping bags arranged on a dark surface.',
    'intro'    => 'Most eCommerce marketing fails because each channel is measured on its own dashboard. We work from blended acquisition cost across every channel, which is the only figure that tells you whether growth is profitable.',
    'capabilities' => [
        ['name' => 'Search engine optimisation', 'desc' => 'Technical fixes, category and product page structure, and content built around commercial intent rather than traffic for its own sake.'],
        ['name' => 'Paid search', 'desc' => 'Google and Bing shopping and search campaigns structured by margin, with feed work so Shopping actually serves your best products.'],
        ['name' => 'Paid social', 'desc' => 'Meta, TikTok and Pinterest creative testing with a clear read on what the creative did, separate from what the audience did.'],
        ['name' => 'Email and lifecycle', 'desc' => 'Welcome, browse abandon, cart, post purchase and win back flows, plus a campaign calendar you can actually staff.'],
        ['name' => 'Marketplace advertising', 'desc' => 'Amazon, Walmart Connect and eBay Promoted Listings run alongside off platform spend rather than in isolation.'],
        ['name' => 'Measurement', 'desc' => 'One monthly view of spend, revenue and blended acquisition cost, with the assumptions written down.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon PPC management', 'services.amazon.ppc-management'],
        ['Content and branding', 'services.content-branding'],
        ['Web development', 'services.web-dev'],
        ['Shopify services', 'services.shopify'],
    ],
])
@endsection
