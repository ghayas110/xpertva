@extends('layouts.app')

@section('title', 'Content & Branding - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.18),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.2em] text-orange-300/80 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M12 22a1 1 0 0 1 0-20 10 9 0 0 1 10 9 5 5 0 0 1-5 5h-2.25a1.75 1.75 0 0 0-1.4 2.8l.3.4a1.75 1.75 0 0 1-1.4 2.8z"></path><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"></circle><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"></circle><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"></circle><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"></circle></svg>
                    Content & Branding
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Brand Identity, Creative Content & Visual Storytelling</h1>
                <p class="text-gray-300 leading-relaxed mb-4 max-w-xl">XpertVA helps you build a consistent, memorable brand with strategic identity design, creative graphics, video content, and product photography that actually sells — not just looks pretty.</p>
                <p class="text-gray-400 leading-relaxed mb-8 max-w-xl">From logos and visual systems to social media content, ads, product visuals, and editing, we create content experiences that match your positioning and speak clearly to your ideal customers.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Schedule Consultation</button>
                    <a href="#services" class="inline-block border border-[#333] text-gray-200 px-7 py-3 rounded-xl text-sm font-medium hover:border-orange-300/80 hover:text-orange-300 transition">Explore Services</a>
                </div>
            </div>
            <div class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-2">Get a Content & Branding Brief Review</h3>
                <p class="text-sm text-gray-400 mb-5">Share your brand, links, and goals — we'll review your visuals and suggest a practical roadmap for upgrades.</p>
                <form class="flex flex-col gap-4">
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Name"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Email"/>
                    <input class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none placeholder:text-gray-600" placeholder="Phone"/>
                    <textarea class="bg-black border border-[#333] rounded-lg px-4 py-3 text-sm focus:border-orange-300 outline-none min-h-[96px] placeholder:text-gray-600" placeholder="Share your website / socials / requirements"></textarea>
                    <button type="submit" class="bg-orange-300 text-black font-semibold py-3 rounded-lg hover:opacity-90 transition">Submit</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Detailed Sections -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">Content & Branding That Feels Cohesive Everywhere</h2>
        <p class="text-gray-400 max-w-3xl mb-4">Your customers experience your brand in pieces — a social post, an ad, a reel, a website section, a product image. Our job is to make all of those pieces feel like they clearly belong to you and move your audience towards action.</p>
        <p class="text-gray-400 max-w-3xl">We combine strategy, design, and production to build brand systems: identity, visual language, content formats, and assets that can be reused, scaled, and adapted to multiple platforms without losing consistency.</p>
    </section>

    <section id="services" class="max-w-7xl mx-auto px-6 pb-24 pt-4 border-t border-[#151515]">
        <h2 class="text-3xl font-bold mb-3">Content & Branding Services</h2>
        <p class="text-gray-400 max-w-3xl mb-10">Brand identity, creative graphics, video editing, and product photography — built around your positioning and target audience.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $brandingServices = [
                ['title' => 'Brand Identity Design', 'icon' => 'pen-tool', 'desc' => 'Logo, color palette, typography, and visual language that reflect your positioning and work across digital platforms.'],
                ['title' => 'Creative Graphics & Social Content', 'icon' => 'image', 'desc' => 'Feed posts, carousels, stories, banners, and ad creatives designed for scroll-stopping impact and clarity.'],
                ['title' => 'Video Editing & Short-Form Content', 'icon' => 'video', 'desc' => 'Edited reels, shorts, explainers, and product videos with pacing, captions, and hooks optimized for retention.'],
                ['title' => 'Product Photography', 'icon' => 'camera', 'desc' => 'Clean product shots, lifestyle compositions, and ad-ready images that highlight your product’s value and details.'],
                ['title' => 'Brand Systems & Content Kits', 'icon' => 'layers', 'desc' => 'Reusable templates, design systems, and content kits so your team can keep publishing on-brand, even at scale.'],
                ['title' => 'Campaign Creative Direction', 'icon' => 'sparkles', 'desc' => 'Concepts, moodboards, and asset directions for launches, promos, and seasonal campaigns across platforms.']
            ];
            @endphp

            @foreach($brandingServices as $service)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($service['icon'] === 'pen-tool')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle></svg>
                    @elseif($service['icon'] === 'image')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                    @elseif($service['icon'] === 'video')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
                    @elseif($service['icon'] === 'camera')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"></path><circle cx="12" cy="13" r="3"></circle></svg>
                    @elseif($service['icon'] === 'layers')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"></path><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"></path><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"></path></svg>
                    @elseif($service['icon'] === 'sparkles')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path><path d="M20 3v4"></path><path d="M22 5h-4"></path><path d="M4 17v2"></path><path d="M5 18H3"></path></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $service['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-20 text-center bg-gradient-to-b from-[#151515] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Turn Your Brand into a Visual Experience</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">Let XpertVA handle your brand identity, creative graphics, video editing, and product photography — so every touchpoint feels consistent, premium, and on-message.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Start Your Content & Branding Project</button>
    </section>
</div>
@endsection
