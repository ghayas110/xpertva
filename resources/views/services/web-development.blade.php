@extends('layouts.site')

@section('title', 'eCommerce Web Development Services | XpertVA')
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
    'title' => 'eCommerce Web Development Services',
    'kicker' => 'Web development',
    'lede'     => 'A store that loads in one second and works on a five year old phone will out earn a prettier one every time.',
    'photo'    => 'assets/photos/dev-screen.jpg',
    'photoAlt' => 'A developer working on a web interface at a large monitor.',
    'intro'    => 'We build eCommerce sites that hold up under real traffic on real devices. Performance, accessibility and analytics are part of the build, not a phase two nobody funds.',
    'definition' => 'eCommerce web development is building and maintaining the website where you sell: storefront design, product and checkout pages, integrations with logistics, tax and CRM systems, and the performance and accessibility work that keeps it converting. XpertVA builds on Shopify, WooCommerce and custom stacks such as Laravel and Next.js.',
    'process' => [
        ['name' => 'Scope in writing', 'desc' => 'We agree pages, features, integrations and the platform choice in a written scope before any build starts.'],
        ['name' => 'Design and prototype', 'desc' => 'Key templates are designed and approved as working prototypes, so there are no surprises at launch.'],
        ['name' => 'Build and test', 'desc' => 'The site is built, tested on real devices and checked for speed, accessibility and tracking.'],
        ['name' => 'Launch and support', 'desc' => 'We launch with redirects in place, monitor the first weeks closely and stay on for fixes and improvements.'],
    ],
    'deliverables' => [
        'A written scope and platform recommendation',
        'Approved designs for key templates',
        'A tested build on your chosen platform',
        'Redirects from any old URLs',
        'Speed, accessibility and tracking checks',
        'Post-launch support',
    ],
    'fitFor' => [
        'Brands rebuilding a slow or hard to manage store',
        'Sellers launching their own store alongside Amazon or Walmart',
        'Businesses connecting their store to ERP, logistics or subscription systems',
        'Teams who want speed, accessibility and tracking built in from day one',
    ],
    'notFitFor' => [
        'You need a brochure site with no selling',
        'You want a template installed with no changes in a few days',
        'You already have an in-house team and only need a single bug fixed',
    ],
    'faqs' => [
        ['Which platform should we build on?', 'Shopify suits most stores that want low maintenance. WooCommerce fits teams already on WordPress. A custom or headless build makes sense when the catalogue or integrations outgrow a hosted platform. We recommend one in the scope and explain why.'],
        ['Will our search rankings survive a redesign?', 'They should, if old URLs are redirected and content is carried over. We map every existing URL before launch and check for errors afterwards.'],
        ['Do you make sites fast on mobile?', 'Yes. We work to Core Web Vitals using real device data, with image, script and font loading handled in the build rather than added later by a plugin.'],
        ['Can you connect our site to our ERP or logistics provider?', 'Yes. We build integrations with ERP, third party logistics, subscription, tax and CRM systems.'],
        ['How much does an eCommerce website cost?', 'It depends on the platform, number of templates and integrations. We quote a fixed figure in the written scope after a free consultation, so you know the cost before work starts.'],
    ],
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
