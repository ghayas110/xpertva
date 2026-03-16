@extends('layouts.app')

@section('title', 'Mobile App Development - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.18),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.2em] text-orange-300/80 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path></svg>
                    Mobile App Development
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Build Mobile Apps Users Love to Use Daily</h1>
                <p class="text-gray-300 leading-relaxed mb-4 max-w-xl">XpertVA designs and develops mobile apps that are fast, stable, and easy to use — combining clean UI, robust architecture, and real-world business logic for iOS and Android.</p>
                <p class="text-gray-400 leading-relaxed mb-8 max-w-xl">From MVPs to full-scale products, we handle product discovery, UX flows, development, API integrations, testing, and store deployment so your app is ready for real users and growth.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Schedule Consultation</button>
                    <a href="#services" class="inline-block border border-[#333] text-gray-200 px-7 py-3 rounded-xl text-sm font-medium hover:border-orange-300/80 hover:text-orange-300 transition">Explore Services</a>
                </div>
            </div>
            <div class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-2">Get Your App Idea Reviewed</h3>
                <p class="text-sm text-gray-400 mb-5">Share your app concept, features, or existing prototype — we’ll review and suggest a practical roadmap and tech stack.</p>
                <form class="flex flex-col gap-4">
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Name"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Email"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Phone"/>
                    <textarea class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none min-h-[96px] placeholder:text-gray-600" placeholder="Briefly describe your app idea / requirements"></textarea>
                    <button type="submit" class="bg-orange-300 text-black font-semibold py-3 rounded-lg hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Detailed Sections -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">From Concept to App Store-Ready Product</h2>
        <p class="text-gray-400 max-w-3xl mb-4">We don’t just code screens — we design complete mobile experiences. That means clear user flows, intuitive navigation, strong performance, and stable integrations with your backend and third-party services.</p>
        <p class="text-gray-400 max-w-3xl">Whether you're building a customer-facing app, internal tool, marketplace, or SaaS companion app, XpertVA supports you across strategy, design, engineering, and long-term maintenance.</p>
    </section>

    <section id="services" class="max-w-7xl mx-auto px-6 pb-24 pt-4 border-t border-[#151515]">
        <h2 class="text-3xl font-bold mb-3">Mobile App Development Services</h2>
        <p class="text-gray-400 max-w-3xl mb-10">Strategy, design, development, integrations, and lifecycle support — everything you need to launch and grow a mobile product.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $mobileServices = [
                ['title' => 'Product Strategy & Discovery', 'icon' => 'rocket', 'desc' => 'We clarify goals, define user personas, prioritize features, and shape an MVP or phase-based roadmap that fits your budget.'],
                ['title' => 'UI/UX Design for Mobile', 'icon' => 'app-window', 'desc' => 'Wireframes, user flows, and high-fidelity designs that feel natural on mobile — with attention to typography, spacing, and usability.'],
                ['title' => 'iOS & Android Development', 'icon' => 'smartphone', 'desc' => 'Native and cross-platform development with clean, maintainable code and architecture that’s ready to scale.'],
                ['title' => 'Backend & API Development', 'icon' => 'cpu', 'desc' => 'Secure, well-structured APIs, admin panels, and databases that power your app and integrate with your existing systems.'],
                ['title' => '3rd-Party Integrations', 'icon' => 'cloud', 'desc' => 'Payments, push notifications, analytics, maps, chat, and more — integrated cleanly and safely into your app.'],
                ['title' => 'Testing, QA & Optimization', 'icon' => 'gauge', 'desc' => 'Manual and automated testing, performance profiling, and optimization to keep your app responsive and reliable.']
            ];
            @endphp

            @foreach($mobileServices as $service)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($service['icon'] === 'rocket')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path></svg>
                    @elseif($service['icon'] === 'app-window')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M10 4v4"></path><path d="M2 8h20"></path><path d="M6 4v4"></path></svg>
                    @elseif($service['icon'] === 'smartphone')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect><path d="M12 18h.01"></path></svg>
                    @elseif($service['icon'] === 'cpu')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v2"></path><path d="M12 2v2"></path><path d="M17 20v2"></path><path d="M17 2v2"></path><path d="M2 12h2"></path><path d="M2 17h2"></path><path d="M2 7h2"></path><path d="M20 12h2"></path><path d="M20 17h2"></path><path d="M20 7h2"></path><path d="M7 20v2"></path><path d="M7 2v2"></path><rect x="4" y="4" width="16" height="16" rx="2"></rect><rect x="8" y="8" width="8" height="8" rx="1"></rect></svg>
                    @elseif($service['icon'] === 'cloud')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"></path></svg>
                    @elseif($service['icon'] === 'gauge')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $service['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Action Banner -->
    <section class="py-20 text-center bg-gradient-to-b from-[#151515] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Launch Your Mobile App with XpertVA?</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">Let’s turn your idea into a real, usable app — with solid UX, reliable engineering, and a roadmap for growth.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Book Your Strategy Call</button>
    </section>
</div>
@endsection
