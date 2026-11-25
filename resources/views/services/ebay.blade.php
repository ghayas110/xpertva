@extends('layouts.site')

@section('title', 'eBay Store Management Services | XpertVA')
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
    'title' => 'eBay Store Management Services',
    'kicker' => 'eBay services',
    'lede'     => 'An eBay store still moves serious volume in the right categories. It just needs someone working it daily.',
    'photo'    => 'assets/photos/fulfilment-floor.jpg',
    'photoAlt' => 'A fulfilment warehouse floor stacked with outbound cartons.',
    'intro'    => 'eBay rewards listing volume, competitive shipping and a clean feedback record. All three come down to daily operational work, which is exactly what we staff.',
    'definition' => 'eBay store management is the daily running of an eBay seller account: creating and revising listings, setting Promoted Listings rates, processing orders and returns, protecting feedback and seller standards, and keeping stock in step with your other channels. XpertVA staffs that work so your eBay store earns without taking your time.',
    'process' => [
        ['name' => 'Account review', 'desc' => 'We check listings, item specifics, shipping policies, Promoted Listings and your seller standards dashboard, then write down what to fix first.'],
        ['name' => 'Clean up the catalogue', 'desc' => 'Missing item specifics, weak titles and poor variation structure are corrected so listings can surface in Best Match.'],
        ['name' => 'Daily operations', 'desc' => 'Orders, tracking, returns, cases and buyer messages are handled inside eBay service metrics every working day.'],
        ['name' => 'Grow and report', 'desc' => 'Promoted Listings rates and new listings are tuned against sales, and you get a written weekly summary.'],
    ],
    'deliverables' => [
        'A written account review with priorities',
        'Listings created and revised to eBay category rules',
        'Promoted Listings campaigns set per category',
        'Orders, returns and cases handled daily',
        'Feedback and defect rate monitoring',
        'Stock and pricing synced with your other channels',
    ],
    'fitFor' => [
        'Sellers in categories where eBay still moves real volume, such as parts, collectables and refurbished goods',
        'Brands already on Amazon who want a second marketplace without a second team',
        'Stores whose feedback or defect rate is putting Top Rated Seller status at risk',
        'Sellers with large catalogues who need listings created in bulk, properly',
    ],
    'notFitFor' => [
        'You list a handful of second-hand items occasionally',
        'You need help with an eBay account that is already permanently suspended',
        'You want listings copied from Amazon without changes',
    ],
    'faqs' => [
        ['What does an eBay store manager do?', 'They list and revise items, manage Promoted Listings, process orders and returns, answer buyers, handle cases and keep feedback and defect rates inside eBay standards. The aim is a store that ranks in Best Match and keeps Top Rated Seller status.'],
        ['Can you list items in bulk?', 'Yes. We use bulk listing tools and templates, with category specifics filled properly so items are not hidden by incomplete data.'],
        ['How do you protect our feedback score?', 'By answering buyers quickly, dispatching on time, resolving problems before they become cases, and following up on negative feedback where eBay allows a revision.'],
        ['Do you manage eBay alongside Amazon and Shopify?', 'Yes. Most of our clients sell on several channels, and we keep stock and pricing in step so you do not oversell.'],
        ['How much does eBay store management cost?', 'We quote after a free consultation, in writing, based on the channels, catalogue size and hours the work actually needs. You see the scope and the monthly figure before you commit to anything.'],
    ],
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
