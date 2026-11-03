@extends('layouts.site')

@section('title', 'Design & Development - XpertVA')
@section('meta_description', 'XpertVA design and development: UI/UX design, graphic design, and front-end development for modern eCommerce brands.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/design-development') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Design and Development | XpertVA">
<meta property="og:description" content="Interface design and front end build for eCommerce brands, from research through to shipped code.">
<meta property="og:url" content="{{ url('/services/design-development') }}">
<meta property="og:image" content="{{ asset('assets/photos/ux-wireframes.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Design and Front End Development",
  "serviceType": "UI and UX Design",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "User interface and experience design, design systems, graphic design and front end development for eCommerce brands.",
  "url": "{{ url('/services/design-development') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Design and development',
    'lede'     => 'Design that stops at a Figma file is a cost. We hand over the built thing.',
    'photo'    => 'assets/photos/ux-wireframes.jpg',
    'photoAlt' => 'A team sketching interface wireframes across a large sheet of paper.',
    'intro'    => 'The same people who design the interface build it. That removes the handover where half the detail usually goes missing, and it means what you approve is what ships.',
    'capabilities' => [
        ['name' => 'Interface design', 'desc' => 'Product, category, cart and checkout screens designed around the decisions a shopper actually has to make.'],
        ['name' => 'Design systems', 'desc' => 'Tokens, components and documentation so the tenth page still looks like the first one.'],
        ['name' => 'Research and testing', 'desc' => 'Session recordings, funnel analysis and moderated tests to find where people give up before they buy.'],
        ['name' => 'Front end build', 'desc' => 'Semantic, accessible HTML and CSS with the motion and interaction detail intact.'],
        ['name' => 'Brand and graphics', 'desc' => 'Identity work, marketplace creative and campaign assets that hold together across every channel.'],
        ['name' => 'Prototypes', 'desc' => 'Clickable prototypes for the flows worth validating before anyone writes production code.'],
    ],
    'proof' => [
        ['value' => '100+', 'label' => 'Digital products delivered for client brands'],
        ['value' => '98%', 'label' => 'Client satisfaction across active accounts'],
    ],
    'related' => [
        ['Web development', 'services.web-dev'],
        ['Mobile app development', 'services.mobile-app'],
        ['Content and branding', 'services.content-branding'],
        ['Amazon A+ and storefront', 'services.amazon.a-plus-storefront'],
    ],
])
@endsection
