@extends('layouts.site')

@section('title', 'Content & Branding - XpertVA')
@section('meta_description', 'XpertVA content and branding services: product copywriting, brand identity, graphic design, and content strategy for eCommerce businesses.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/content-branding') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Content and Branding | XpertVA">
<meta property="og:description" content="Product photography, copywriting, marketplace creative and brand identity for eCommerce catalogues.">
<meta property="og:url" content="{{ url('/services/content-branding') }}">
<meta property="og:image" content="{{ asset('assets/photos/packaging-kraft.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "eCommerce Content and Branding",
  "serviceType": "Content and Brand Design",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Product photography, infographics, copywriting, video, and brand identity work produced for eCommerce catalogues and marketplace listings.",
  "url": "{{ url('/services/content-branding') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Content and branding',
    'lede'     => 'On a marketplace, your images are the shop, the salesperson and the packaging. They are worth doing properly.',
    'photo'    => 'assets/photos/packaging-kraft.jpg',
    'photoAlt' => 'Kraft product packaging laid out ready for catalogue photography.',
    'intro'    => 'Nine images decide most marketplace purchases. We produce the photography, infographics, copy and video for a whole catalogue, to each channel specification, in one pass.',
    'capabilities' => [
        ['name' => 'Product photography', 'desc' => 'Pure white hero shots to marketplace specification, plus lifestyle and scale imagery shot to match.'],
        ['name' => 'Infographics', 'desc' => 'Feature, dimension and comparison graphics that answer the questions buyers ask in reviews.'],
        ['name' => 'Copywriting', 'desc' => 'Titles, bullets and descriptions written for the channel, with keyword coverage built in rather than bolted on.'],
        ['name' => 'Video', 'desc' => 'Short product and lifestyle video for listings, storefronts, paid social and your own store.'],
        ['name' => 'Brand identity', 'desc' => 'Logo, palette, type and packaging direction, with usage rules so it survives contact with a marketplace.'],
        ['name' => 'Catalogue rollout', 'desc' => 'Whole ranges produced to one standard, so listing one hundred and listing five look like the same brand.'],
    ],
    'proof' => [
        ['value' => '500+', 'label' => 'Brands supported since we opened in 2017'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Amazon A+ and storefront', 'services.amazon.a-plus-storefront'],
        ['Design and development', 'services.design'],
        ['Marketing solutions', 'services.marketing'],
        ['Amazon listing optimization', 'services.amazon.listing-optimization'],
    ],
])
@endsection
