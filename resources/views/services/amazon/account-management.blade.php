@extends('layouts.app')

@section('title', 'Amazon Account Management Services | Seller Central Health & Cases | XpertVA')
@section('meta_description', 'Full-service Amazon Seller Central account management. Account health monitoring, case handling, suspension appeals, listing fixes, and FBA support from certified Amazon experts.')

@push('head')
<link rel="canonical" href="{{ url('/services/amazon/account-management') }}">
<meta property="og:title" content="Amazon Account Management Services | XpertVA">
<meta property="og:description" content="End-to-end Amazon Seller Central management — account health, cases, suspensions, FBA, and reimbursements.">
<meta name="keywords" content="amazon account management, seller central management, amazon account health, amazon case management, amazon suspension appeal, amazon fba management, amazon reimbursement, amazon a-to-z claims">
@endpush

@push('schema')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": "Amazon Account Management Services",
  "serviceType": "Amazon Seller Central Management",
  "provider": { "@id": "https://xpertva.com/#organization" },
  "description": "End-to-end Amazon Seller Central management including account health monitoring, case management, listing reinstatement, suspension appeals, FBA shipment support, and FBA reimbursement claims.",
  "url": "{{ url('/services/amazon/account-management') }}"
}
</script>
@endverbatim
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    { "@type": "Question", "name": "What does an Amazon account manager do?", "acceptedAnswer": { "@type": "Answer", "text": "An Amazon account manager handles day-to-day Seller Central operations: monitoring Account Health metrics (ODR, late shipment rate, policy violations), opening and following up on cases, fixing suppressed and stranded listings, managing FBA shipments and reimbursements, and responding to A-to-Z Guarantee claims." } },
    { "@type": "Question", "name": "What is Amazon Account Health?", "acceptedAnswer": { "@type": "Answer", "text": "Amazon Account Health is a Seller Central dashboard that tracks customer service performance (Order Defect Rate under 1%), policy compliance, and shipping performance. A score below 200 or a Critical metric can lead to account suspension." } },
    { "@type": "Question", "name": "How do you appeal an Amazon suspension?", "acceptedAnswer": { "@type": "Answer", "text": "An Amazon suspension appeal requires a Plan of Action (POA) that identifies the root cause, the immediate corrective actions taken, and the long-term preventive measures. We draft, submit, and escalate the POA through Seller Performance and Account Health Specialists." } },
    { "@type": "Question", "name": "Can you recover lost FBA inventory reimbursements?", "acceptedAnswer": { "@type": "Answer", "text": "Yes. We audit FBA inventory reports and file reimbursement claims for lost, damaged, and incorrectly weighed inventory, customer return discrepancies, and FBA fee overcharges — typically recovering 1–3% of FBA revenue for sellers who have never claimed before." } },
    { "@type": "Question", "name": "What is an A-to-Z Guarantee Claim?", "acceptedAnswer": { "@type": "Answer", "text": "An A-to-Z Guarantee Claim is a buyer-initiated dispute Amazon files when the customer believes they did not receive the item or it differs significantly from the listing. Unresolved A-to-Z claims hurt the Order Defect Rate and need a fact-based appeal within 30 days." } }
  ]
}
</script>
@endverbatim
@endpush

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white">
    <section class="relative w-full pt-36 pb-20 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.15),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <a href="{{ route('services.amazon') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-orange-300 transition mb-8">← Back to Amazon Services</a>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Amazon Account Management Services</h1>
            <p class="text-gray-300 leading-relaxed max-w-3xl text-lg mb-6">
                Full-service Amazon Seller Central management — account health monitoring, case handling, suspension appeals, listing reinstatement, FBA shipment support, and reimbursement recovery.
            </p>
            <div class="bg-[#121212] border border-orange-500/20 rounded-2xl p-6 max-w-3xl">
                <p class="text-orange-300 text-sm font-semibold mb-2">Quick Answer</p>
                <p class="text-gray-200 leading-relaxed">
                    An <strong>Amazon account manager</strong> handles day-to-day Seller Central operations: monitoring Account Health metrics (ODR &lt; 1%, late shipment rate, policy violations), opening and escalating cases, fixing suppressed listings, managing FBA shipments, and recovering reimbursements. A healthy Amazon account keeps Account Health Rating above 200 and ODR below 1%.
                </p>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">What's Included in Amazon Account Management</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach([
                ['Account Health Monitoring', 'Daily dashboard checks on ODR, late shipment rate, policy violations, and Account Health Rating with same-day issue escalation.'],
                ['Case Management', 'Opening, following up, and escalating Seller Central cases with Seller Performance and Account Health Specialists.'],
                ['Suspension & Reinstatement', 'Plan of Action drafting and appeals for account, listing, and ASIN suspensions — including Section 3 violations.'],
                ['Listing Issue Resolution', 'Fixing suppressed, stranded, blocked, and search-suppressed listings caused by missing attributes or policy flags.'],
                ['A-to-Z Guarantee Claims', 'Fact-based responses to A-to-Z claims and chargebacks within Amazon\'s 30-day response window to protect ODR.'],
                ['FBA Reimbursements', 'Inventory audits and reimbursement filings for lost, damaged, mis-weighed, and customer-returned units.'],
            ] as [$title, $desc])
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-8 hover:border-orange-300 transition">
                <h3 class="text-xl font-semibold mb-3">{{ $title }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Amazon Account Health Metrics We Watch</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="border-b border-[#222]"><th class="py-3 pr-4 text-orange-300">Metric</th><th class="py-3 pr-4 text-orange-300">Target</th><th class="py-3 text-orange-300">Why It Matters</th></tr></thead>
                <tbody class="text-gray-300">
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">Order Defect Rate</td><td class="py-3 pr-4">&lt; 1%</td><td class="py-3">Triggers suspension above threshold</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">Late Shipment Rate</td><td class="py-3 pr-4">&lt; 4%</td><td class="py-3">Affects MFN feature eligibility</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">Pre-fulfillment Cancel</td><td class="py-3 pr-4">&lt; 2.5%</td><td class="py-3">Indicates inventory accuracy</td></tr>
                    <tr class="border-b border-[#1a1a1a]"><td class="py-3 pr-4 font-semibold">Valid Tracking Rate</td><td class="py-3 pr-4">&gt; 95%</td><td class="py-3">Required for category compliance</td></tr>
                    <tr><td class="py-3 pr-4 font-semibold">Account Health Rating</td><td class="py-3 pr-4">&gt; 200 (Healthy)</td><td class="py-3">Below 200 = at-risk; below 100 = suspension</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-20 border-t border-[#1f1f1f]">
        <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
        <div class="space-y-4">
            @foreach([
                ['What does an Amazon account manager do?', 'Monitors Account Health (ODR, late shipment rate, policy violations), opens and follows up on cases, fixes suppressed listings, manages FBA shipments and reimbursements, and responds to A-to-Z claims.'],
                ['What is Amazon Account Health?', 'A Seller Central dashboard tracking customer service, policy compliance, and shipping performance. A score below 200 or a Critical metric can lead to suspension.'],
                ['How do you appeal an Amazon suspension?', 'A Plan of Action (POA) that identifies root cause, immediate corrective actions, and long-term preventive measures. We draft, submit, and escalate it through Seller Performance.'],
                ['Can you recover lost FBA reimbursements?', 'Yes. We audit FBA inventory and file claims for lost, damaged, mis-weighed inventory, customer return discrepancies, and fee overcharges — typically recovering 1–3% of FBA revenue.'],
                ['What is an A-to-Z Guarantee Claim?', 'A buyer-initiated dispute when the customer believes they did not receive the item or it differs from the listing. Unresolved claims hurt ODR and need a fact-based appeal within 30 days.'],
            ] as [$q, $a])
            <details class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 group">
                <summary class="cursor-pointer text-lg font-semibold flex justify-between items-center">{{ $q }}<span class="text-orange-300 group-open:rotate-45 transition">+</span></summary>
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $a }}</p>
            </details>
            @endforeach
        </div>
    </section>

    <section class="py-24 text-center bg-gradient-to-b from-[#1a1a1a] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Protect Your Amazon Account</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-8 px-6">Free Account Health audit and reimbursement scan from a Seller Central specialist.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl">Get Free Account Audit</button>
    </section>
</div>
@endsection
