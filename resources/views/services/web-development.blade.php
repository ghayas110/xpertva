@extends('layouts.app')

@section('title', 'Website & eCommerce Development - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.18),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.2em] text-orange-300/80 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M18 8V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8"></path><path d="M10 19v-3.96 3.15"></path><path d="M7 19h5"></path><rect width="6" height="10" x="16" y="12" rx="2"></rect></svg>
                    Website & eCommerce Development
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Conversion-Driven Web & eCommerce Experiences</h1>
                <p class="text-gray-300 leading-relaxed mb-4 max-w-xl">XpertVA’s eCommerce website design and development services help you create exciting online experiences that attract demanding modern customers. Our developers specialize in conversion-focused UIs and high-efficiency eCommerce architectures.</p>
                <p class="text-gray-400 leading-relaxed mb-8 max-w-xl">As a dependable and well-known web development partner, XpertVA combines deep technical intelligence with creative expertise. We work across eCommerce platforms, custom architectures, and modern WordPress ecosystems to build fast, secure, and scalable digital products.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Schedule Consultation</button>
                    <a href="#services" class="inline-block border border-[#333] text-gray-200 px-7 py-3 rounded-xl text-sm font-medium hover:border-orange-300/80 hover:text-orange-300 transition">Explore Services</a>
                </div>
            </div>
            <div class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-2">Schedule a Consultation Call</h3>
                <p class="text-sm text-gray-400 mb-5">Share your eCommerce, website, or app idea — our team will review your requirements and suggest the most suitable architecture and tech stack.</p>
                <form class="flex flex-col gap-4">
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Name"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Email"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Phone"/>
                    <textarea class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none min-h-[96px] placeholder:text-gray-600" placeholder="Describe your requirement"></textarea>
                    <button type="submit" class="bg-orange-300 text-black font-semibold py-3 rounded-lg hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Expertise Section -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-2xl font-bold mb-4">Specialized eCommerce & Web Development Expertise</h2>
        <p class="text-gray-400 max-w-3xl mb-4">XpertVA’s web design and development team is highly proficient in specialized eCommerce development. We work with modern platforms, headless setups, and flexible architectures to support different eCommerce business models and growth strategies.</p>
        <p class="text-gray-400 max-w-3xl">Whether you are launching a new store, evolving from a niche eCommerce setup, or rebuilding an existing solution, we design scalable architectures and conversion-optimized experiences around your customers, products, and operations.</p>
    </section>

    <!-- Detailed Expertise Grid -->
    <section id="services" class="max-w-7xl mx-auto px-6 pb-24 pt-4 border-t border-[#151515]">
        <h2 class="text-2xl font-bold mb-3">XpertVA’s Areas of Expertise in Web Development</h2>
        <p class="text-gray-400 max-w-3xl mb-10">From B2C and B2B eCommerce to marketplaces, headless commerce, microservices, and PWAs, we architect solutions that perform, scale, and convert.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $webExpertise = [
                ['title' => 'B2C eCommerce', 'icon' => 'shopping-bag', 'desc' => 'Attractive UI and smart personalization based on customer journeys, traffic patterns, buying doubts, and acquisition channels — all designed for high conversion.'],
                ['title' => 'B2B eCommerce', 'icon' => 'users', 'desc' => 'Solutions designed for rational buyers and complex decision cycles with customized experiences, negotiation workflows, and role-based access.'],
                ['title' => 'Online Marketplaces', 'icon' => 'network', 'desc' => 'Multi-vendor platforms built around balanced workflows for admins, sellers, and end customers, keeping operations transparent and manageable.'],
                ['title' => 'Microservices-based eCommerce', 'icon' => 'layers', 'desc' => 'Component-based architectures for independent scaling, fault isolation, and high resilience — ideal for fast-growing and complex businesses.'],
                ['title' => 'Headless Commerce', 'icon' => 'panels-top-left', 'desc' => 'Decoupled front-ends for web, mobile, AR/VR, and smart devices, powered by APIs that connect flexible UIs to robust back-end operations.'],
                ['title' => 'Progressive Web Applications (PWA)', 'icon' => 'radar', 'desc' => 'Single codebase for web and mobile experiences with responsive layouts, offline support, and app-like performance using modern PWA tooling.'],
                ['title' => 'Online Multistore', 'icon' => 'grid-3x3', 'desc' => 'Multi-storefront setups with carefully planned catalogs, languages, and configurations to support new regions, brands, and segments.'],
                ['title' => 'Web Portals', 'icon' => 'layout-template', 'desc' => 'Vendor, customer, and partner portals designed around clear objectives, tailored workflows, and scalable components for retail and service businesses.']
            ];
            @endphp

            @foreach($webExpertise as $item)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($item['icon'] === 'shopping-bag')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    @elseif($item['icon'] === 'users')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><path d="M16 3.128a4 4 0 0 1 0 7.744"></path><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    @elseif($item['icon'] === 'network')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="16" y="16" width="6" height="6" rx="1"></rect><rect x="2" y="16" width="6" height="6" rx="1"></rect><rect x="9" y="2" width="6" height="6" rx="1"></rect><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"></path><path d="M12 12V8"></path></svg>
                    @elseif($item['icon'] === 'layers')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                    @elseif($item['icon'] === 'panels-top-left')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M9 21V9"></path></svg>
                    @elseif($item['icon'] === 'radar')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19.07 4.93A10 10 0 0 0 6.99 3.34"></path><path d="M4 6h.01"></path><path d="M2.29 9.62A10 10 0 1 0 21.31 8.35"></path><path d="M16.24 7.76A6 6 0 1 0 8.23 16.67"></path><path d="M12 18h.01"></path><path d="M17.99 11.66A6 6 0 0 1 15.77 16.67"></path><circle cx="12" cy="12" r="2"></circle><path d="m13.41 10.59 5.66-5.66"></path></svg>
                    @elseif($item['icon'] === 'grid-3x3')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M3 15h18"></path><path d="M9 3v18"></path><path d="M15 3v18"></path></svg>
                    @elseif($item['icon'] === 'layout-template')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="7" x="3" y="3" rx="1"></rect><rect width="9" height="7" x="3" y="14" rx="1"></rect><rect width="5" height="7" x="16" y="14" rx="1"></rect></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $item['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- WordPress Section -->
    <section class="max-w-7xl mx-auto px-6 pb-24 border-t border-[#151515]">
        <h2 class="text-2xl font-bold mb-3">WordPress Website Design & Development Services</h2>
        <p class="text-gray-400 max-w-3xl mb-8">With a talented team of WordPress specialists, XpertVA delivers strong digital solutions and engaging experiences. We offer SEO-smart, secure, and scalable WordPress builds.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $wpServices = [
                ['title' => 'Custom WordPress Development', 'icon' => 'file-code-2', 'desc' => 'Years of expertise building clear, responsive, and high-quality WordPress sites.'],
                ['title' => 'Theme Customization', 'icon' => 'layout-template', 'desc' => 'Enterprise-grade, optimized themes and one-of-a-kind designs for your brand.'],
                ['title' => 'WooCommerce Development', 'icon' => 'shopping-bag', 'desc' => 'Growth-oriented WooCommerce stores and migrations for full eCommerce power.'],
                ['title' => 'Plugin Integration', 'icon' => 'plug-zap', 'desc' => 'Custom and third-party plugins integrated using best practices for scale.'],
                ['title' => 'Blog Experiences', 'icon' => 'file-code-2', 'desc' => 'Manageable, engaging blog layouts crafted for readability and SEO.'],
                ['title' => 'API Integrations', 'icon' => 'server-cog', 'desc' => 'Mobile app connections and API integrations extending your WordPress capabilities.']
            ];
            @endphp
            @foreach($wpServices as $service)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <h3 class="text-lg font-semibold mb-2">{{ $service['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-20 text-center bg-gradient-to-b from-[#151515] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-2xl md:text-4xl font-bold mb-4">Build Your Next Website, Store, or App with XpertVA</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">From eCommerce and WordPress to custom apps and modern web platforms, our team is ready to design and develop your next digital experience.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Start Your Project</button>
    </section>
</div>
@endsection
