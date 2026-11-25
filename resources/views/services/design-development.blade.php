@extends('layouts.site')

@section('title', 'UI, UX and Front-End Design Services | XpertVA')
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
    'title' => 'UI, UX and Front-End Design Services',
    'kicker' => 'Design and development',
    'lede'     => 'Design that stops at a Figma file is a cost. We hand over the built thing.',
    'photo'    => 'assets/photos/ux-wireframes.jpg',
    'photoAlt' => 'A team sketching interface wireframes across a large sheet of paper.',
    'intro'    => 'The same people who design the interface build it. That removes the handover where half the detail usually goes missing, and it means what you approve is what ships.',
    'definition' => 'UI and UX design for eCommerce is the work of shaping the screens shoppers use, from product and category pages to cart and checkout, so they can find, decide and buy with less effort. At XpertVA the same team designs and builds the front end, so what you approve in design is what ships.',
    'process' => [
        ['name' => 'Research', 'desc' => 'We look at analytics, session recordings and your funnel to find where shoppers hesitate or leave.'],
        ['name' => 'Design', 'desc' => 'Screens and components are designed around those findings and shared as clickable prototypes.'],
        ['name' => 'Build', 'desc' => 'The approved design is built in accessible, semantic HTML and CSS with the interaction detail intact.'],
        ['name' => 'Measure', 'desc' => 'After release we compare the funnel against the baseline and keep what improves it.'],
    ],
    'deliverables' => [
        'Findings from analytics and recordings',
        'Clickable prototypes for key flows',
        'A component library and design tokens',
        'Built, accessible front end code',
        'Before and after funnel comparison',
        'Documentation for your team',
    ],
    'fitFor' => [
        'Stores where analytics show shoppers dropping out at product, cart or checkout',
        'Brands that have a design file nobody ever built properly',
        'Teams who need a design system so new pages stop drifting off-brand',
        'Businesses planning a redesign who want it tested before it is coded',
    ],
    'notFitFor' => [
        'You need a logo only, which our branding service covers',
        'You want a visual refresh without changing how the store works',
        'You cannot share analytics or recordings for us to learn from',
    ],
    'faqs' => [
        ['What is the difference between UI and UX design?', 'UX design is how a flow works: what a shopper needs to see and decide at each step. UI design is how each screen looks and feels. We do both, and then build it.'],
        ['Why have the same team design and build?', 'Because the handover between a design agency and a separate developer is where detail usually gets lost. One team means what you approve is what goes live.'],
        ['Do you test designs with real users?', 'Yes, where it is worth it. We use session recordings, funnel data and moderated tests on the flows that carry the most revenue.'],
        ['Can you work with our existing developers?', 'Yes. We can deliver a design system and documented components for your team to build from, or build alongside them.'],
        ['How much does a design project cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
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
