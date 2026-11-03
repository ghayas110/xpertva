@extends('layouts.site')

@section('title', 'Amazon Account Management Services | Seller Central Health & Cases | XpertVA')
@section('meta_description', 'Full-service Amazon Seller Central account management. Account health monitoring, case handling, suspension appeals, listing fixes, and FBA support from certified Amazon experts.')
@section('head_tone', 'site-head--on-dark')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon/account-management') }}">
<meta property="og:title" content="Amazon Account Management Services | XpertVA">
<meta property="og:description" content="End-to-end Amazon Seller Central management, account health, cases, suspensions, FBA, and reimbursements.">
<meta name="keywords" content="amazon account management, seller central management, amazon account health, amazon case management, amazon suspension appeal, amazon fba management, amazon reimbursement, amazon a-to-z claims">
@endpush

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "Amazon Account Management Services",
  "serviceType": "Amazon Seller Central Management",
  "provider": { "@@id": "https://xpertva.com/#organization" },
  "description": "End-to-end Amazon Seller Central management including account health monitoring, case management, listing reinstatement, suspension appeals, FBA shipment support, and FBA reimbursement claims.",
  "url": "{{ url('/services/amazon/account-management') }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    { "@@type": "Question", "name": "What does an Amazon account manager do?", "acceptedAnswer": { "@@type": "Answer", "text": "An Amazon account manager handles day-to-day Seller Central operations: monitoring Account Health metrics (ODR, late shipment rate, policy violations), opening and following up on cases, fixing suppressed and stranded listings, managing FBA shipments and reimbursements, and responding to A-to-Z Guarantee claims." } },
    { "@@type": "Question", "name": "What is Amazon Account Health?", "acceptedAnswer": { "@@type": "Answer", "text": "Amazon Account Health is a Seller Central dashboard that tracks customer service performance (Order Defect Rate under 1%), policy compliance, and shipping performance. A score below 200 or a Critical metric can lead to account suspension." } },
    { "@@type": "Question", "name": "How do you appeal an Amazon suspension?", "acceptedAnswer": { "@@type": "Answer", "text": "An Amazon suspension appeal requires a Plan of Action (POA) that identifies the root cause, the immediate corrective actions taken, and the long-term preventive measures. We draft, submit, and escalate the POA through Seller Performance and Account Health Specialists." } },
    { "@@type": "Question", "name": "Can you recover lost FBA inventory reimbursements?", "acceptedAnswer": { "@@type": "Answer", "text": "Yes. We audit FBA inventory reports and file reimbursement claims for lost, damaged, and incorrectly weighed inventory, customer return discrepancies, and FBA fee overcharges, typically recovering 1-3% of FBA revenue for sellers who have never claimed before." } },
    { "@@type": "Question", "name": "What is an A-to-Z Guarantee Claim?", "acceptedAnswer": { "@@type": "Answer", "text": "An A-to-Z Guarantee Claim is a buyer-initiated dispute Amazon files when the customer believes they did not receive the item or it differs significantly from the listing. Unresolved A-to-Z claims hurt the Order Defect Rate and need a fact-based appeal within 30 days." } }
  ]
}
</script>
@endpush

@section('content')
<section class="phead phead--photo">
    <img class="phead__bg" src="{{ asset('assets/photos/fulfilment-floor.jpg') }}" alt="A fulfilment warehouse floor stacked with outbound cartons." fetchpriority="high" decoding="async">
    <div class="wrap">
            <a class="crumb" href="{{ route('services.amazon') }}">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 3 5 8l5 5"/></svg>
            Back to Amazon Services
        </a>
            <h1 class="display display--sm mb-3">Amazon Account Management Services</h1>
            <p class="lede mb-3">
                Full-service Amazon Seller Central management, account health monitoring, case handling, suspension appeals, listing reinstatement, FBA shipment support, and reimbursement recovery.
            </p>
            <div class="callout">
                <p class="callout__label">Quick answer</p>
                <p>
                    An <strong>Amazon account manager</strong> handles day-to-day Seller Central operations: monitoring Account Health metrics (ODR &lt; 1%, late shipment rate, policy violations), opening and escalating cases, fixing suppressed listings, managing FBA shipments, and recovering reimbursements. A healthy Amazon account keeps Account Health Rating above 200 and ODR below 1%.
                </p>
            </div>
        <div class="mt-3" style="display:flex;flex-wrap:wrap;gap:.6rem">
            <button type="button" class="btn btn--primary" data-open="consult">
                Book a consultation
                @include('site.arrow')
            </button>
            <button type="button" class="btn btn--ghost" data-open="audit">Free listing audit</button>
        </div>
    </div>
</section>

    <section class="section">
        <div class="wrap">
        <h2 class="h2 mb-3" data-split-heading>What's Included in Amazon Account Management</h2>
        <div class="caps">
            @foreach([
                ['Account Health Monitoring', 'Daily dashboard checks on ODR, late shipment rate, policy violations, and Account Health Rating with same-day issue escalation.'],
                ['Case Management', 'Opening, following up, and escalating Seller Central cases with Seller Performance and Account Health Specialists.'],
                ['Suspension & Reinstatement', 'Plan of Action drafting and appeals for account, listing, and ASIN suspensions, including Section 3 violations.'],
                ['Listing Issue Resolution', 'Fixing suppressed, stranded, blocked, and search-suppressed listings caused by missing attributes or policy flags.'],
                ['A-to-Z Guarantee Claims', 'Fact-based responses to A-to-Z claims and chargebacks within Amazon\'s 30-day response window to protect ODR.'],
                ['FBA Reimbursements', 'Inventory audits and reimbursement filings for lost, damaged, mis-weighed, and customer-returned units.'],
            ] as [$title, $desc])
            <div class="caps__item" data-anim>
                <h3>{{ $title }}</h3>
                <p>{{ $desc }}</p>
            </div>
            @endforeach
        </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
        <h2 class="h2 mb-4" data-split-heading>Amazon Account Health Metrics We Watch</h2>
        <div class="tablewrap">
            <table class="dtable">
                <thead><tr><th>Metric</th><th>Target</th><th>Why It Matters</th></tr></thead>
                <tbody>
                    <tr><td>Order Defect Rate</td><td>&lt; 1%</td><td>Triggers suspension above threshold</td></tr>
                    <tr><td>Late Shipment Rate</td><td>&lt; 4%</td><td>Affects MFN feature eligibility</td></tr>
                    <tr><td>Pre-fulfillment Cancel</td><td>&lt; 2.5%</td><td>Indicates inventory accuracy</td></tr>
                    <tr><td>Valid Tracking Rate</td><td>&gt; 95%</td><td>Required for category compliance</td></tr>
                    <tr><td>Account Health Rating</td><td>&gt; 200 (Healthy)</td><td>Below 200 = at-risk; below 100 = suspension</td></tr>
                </tbody>
            </table>
        </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap" style="max-width:60rem">
        <h2 class="h2 mb-4" data-split-heading>Frequently Asked Questions</h2>
        <div class="faq">
            @foreach([
                ['What does an Amazon account manager do?', 'Monitors Account Health (ODR, late shipment rate, policy violations), opens and follows up on cases, fixes suppressed listings, manages FBA shipments and reimbursements, and responds to A-to-Z claims.'],
                ['What is Amazon Account Health?', 'A Seller Central dashboard tracking customer service, policy compliance, and shipping performance. A score below 200 or a Critical metric can lead to suspension.'],
                ['How do you appeal an Amazon suspension?', 'A Plan of Action (POA) that identifies root cause, immediate corrective actions, and long-term preventive measures. We draft, submit, and escalate it through Seller Performance.'],
                ['Can you recover lost FBA reimbursements?', 'Yes. We audit FBA inventory and file claims for lost, damaged, mis-weighed inventory, customer return discrepancies, and fee overcharges, typically recovering 1-3% of FBA revenue.'],
                ['What is an A-to-Z Guarantee Claim?', 'A buyer-initiated dispute when the customer believes they did not receive the item or it differs from the listing. Unresolved claims hurt ODR and need a fact-based appeal within 30 days.'],
            ] as [$q, $a])
            <details>
                <summary>{{ $q }}</summary>
                <p>{{ $a }}</p>
            </details>
            @endforeach
        </div>
        </div>
    </section>

    @include('site.cta', [
    'heading' => 'Protect Your Amazon Account',
    'body'    => 'Free Account Health audit and reimbursement scan from a Seller Central specialist.',
])

@endsection
