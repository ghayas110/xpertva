@extends('layouts.site')

@section('title', 'eCommerce Content and Branding | XpertVA')
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
    'title' => 'eCommerce Content and Branding Services',
    'kicker' => 'Content and branding',
    'lede'     => 'On a marketplace, your images are the shop, the salesperson and the packaging. They are worth doing properly.',
    'photo'    => 'assets/photos/packaging-kraft.jpg',
    'photoAlt' => 'Kraft product packaging laid out ready for catalogue photography.',
    'intro'    => 'Nine images decide most marketplace purchases. We produce the photography, infographics, copy and video for a whole catalogue, to each channel specification, in one pass.',
    'definition' => 'eCommerce content and branding services create the images, video, copy and brand identity that sell your products online. That covers listing images and infographics, A+ and storefront assets, product video, titles and bullets, and the logo, palette and packaging rules that keep a whole catalogue looking like one brand.',
    'process' => [
        ['name' => 'Brief', 'desc' => 'We collect your products, brand assets, competitors and the questions buyers ask in reviews.'],
        ['name' => 'Concepts', 'desc' => 'You see layouts and copy direction for a first product before we produce the range.'],
        ['name' => 'Production', 'desc' => 'Images, video and copy are produced to each channel\'s specification and your brand rules.'],
        ['name' => 'Rollout', 'desc' => 'Approved assets are uploaded or handed over, and the standard is applied to the rest of the catalogue.'],
    ],
    'deliverables' => [
        'A written creative brief',
        'Concepts for approval before production',
        'Listing images and infographics to channel specs',
        'Product video for listings and social',
        'Titles, bullets and descriptions',
        'Brand usage rules for future work',
    ],
    'fitFor' => [
        'Sellers whose listings get traffic but convert below their category',
        'Brands launching a new range that needs to look consistent from day one',
        'Marketplace sellers who need A+ and storefront assets to Amazon specifications',
        'Founders who have outgrown a logo made in a weekend',
    ],
    'notFitFor' => [
        'You need a single stock photo edited',
        'You want creative with no brief or brand direction at all',
        'You are looking for print advertising or outdoor media',
    ],
    'faqs' => [
        ['What makes a good Amazon listing image?', 'A clean main image that meets Amazon\'s rules, then secondary images that answer buyer questions: size, use, materials, what is in the box and how the product compares.'],
        ['Do you write listing copy too?', 'Yes. Titles, bullets and descriptions are written for each channel with keyword coverage built in.'],
        ['Can you redo a whole catalogue to one standard?', 'Yes. We set the standard on a first product, then roll it out across the range so every listing looks like the same brand.'],
        ['Do you design logos and packaging?', 'Yes. Brand identity covers logo, palette, type and packaging direction, with usage rules so it holds up on marketplaces.'],
        ['How much does product content cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
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
