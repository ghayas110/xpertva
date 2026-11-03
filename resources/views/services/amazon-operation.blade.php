@extends('layouts.site')

@section('title', 'Amazon E-Commerce Operations - XpertVA')
@section('meta_description', 'XpertVA Amazon operations management: full-service Amazon account management, case management, brand registry, and marketplace optimization.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon-operations') }}">
<meta property="og:type" content="website">
<meta property="og:title" content="Amazon Operations | XpertVA">
<meta property="og:description" content="The daily running of a Seller Central account: inventory, cases, pricing, reimbursements and reporting.">
<meta property="og:url" content="{{ url('/services/amazon-operations') }}">
<meta property="og:image" content="{{ asset('assets/photos/fulfilment-floor.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Amazon Operations Management",
  "serviceType": "Amazon Operations Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "areaServed": "Worldwide",
  "description": "Day to day Amazon Seller Central operations including inventory planning, FBA shipments, case management, pricing, reimbursement recovery and reporting.",
  "url": "{{ url('/services/amazon-operations') }}",
  "offers": { "@@type": "Offer", "priceCurrency": "USD", "availability": "https://schema.org/InStock" }
}
</script>
@endpush

@section('content')
@include('site.service', [
    'title'    => 'Amazon operations',
    'lede'     => 'The unglamorous daily work that decides whether a good catalogue actually earns.',
    'photo'    => 'assets/photos/fulfilment-floor.jpg',
    'photoAlt' => 'A fulfilment warehouse floor stacked with outbound cartons.',
    'intro'    => 'Listings and advertising get the attention. Stockouts, stranded inventory, unresolved cases and unclaimed reimbursements are what quietly take the margin. This is the service that covers all of it.',
    'capabilities' => [
        ['name' => 'Inventory planning', 'desc' => 'Replenishment forecasting, restock limits, ageing stock and removal orders so you neither run out nor pay long term storage.'],
        ['name' => 'FBA shipment management', 'desc' => 'Shipment creation, box content, carrier booking, and chasing the receipts that never quite check in.'],
        ['name' => 'Case management', 'desc' => 'Seller Support cases opened, escalated and followed until they close, with a written record of each one.'],
        ['name' => 'Reimbursement recovery', 'desc' => 'Lost, damaged, and fee overcharge claims audited and filed inside the claim window.'],
        ['name' => 'Pricing and Buy Box', 'desc' => 'Repricing rules, Buy Box monitoring and the margin floor logic that stops a race to the bottom.'],
        ['name' => 'Reporting', 'desc' => 'A weekly written summary and a monthly profit view that accounts for fees, ads, returns and storage.'],
    ],
    'proof' => [
        ['value' => '$9.2M', 'label' => 'Ordered product sales on one managed account over 14 months'],
        ['value' => '54,039', 'label' => 'Orders processed on that same account'],
    ],
    'related' => [
        ['Account management', 'services.amazon.account-management'],
        ['Brand protection', 'services.amazon.brand-protection'],
        ['Amazon PPC management', 'services.amazon.ppc-management'],
        ['Virtual assistants', 'services.va'],
    ],
])
@endsection
