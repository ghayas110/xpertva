@extends('layouts.app')

@section('title', 'Marketing Solutions & SEO - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-36 pb-40 bg-gradient-to-br from-[#0d0d0d] via-[#111] to-[#0c0c0c] overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,140,0,0.18),transparent_60%)]"></div>
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <p class="inline-flex items-center gap-2 text-sm uppercase tracking-[0.2em] text-orange-300/80 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="m3 11 18-5v12L3 14v-3z"></path><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"></path></svg>
                    Marketing Solutions & SEO
                </p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Get Found Everywhere Your Customers Search</h1>
                <p class="text-gray-300 leading-relaxed mb-4 max-w-xl">Like every online and physical business, you want customers to be able to find you anywhere on the internet. XpertVA, your dedicated marketing and SEO partner, optimizes your website and content so you rank higher on Google and turn clicks into customers.</p>
                <p class="text-gray-400 leading-relaxed mb-8 max-w-xl">From search engine optimization to digital marketing strategy, e-commerce growth, social media, and email campaigns, we handle the details so your brand stands out and scales profitably.</p>
                <div class="flex flex-wrap gap-4">
                    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="inline-block bg-orange-300 text-black px-8 py-4 rounded-xl text-lg font-semibold hover:opacity-85 transition shadow-lg">Schedule Consultation</button>
                    <a href="#services" class="inline-block border border-[#333] text-gray-200 px-7 py-3 rounded-xl text-sm font-medium hover:border-orange-300/80 hover:text-orange-300 transition">Explore Services</a>
                </div>
            </div>
            <div id="contact" class="bg-[#141414] border border-[#222] rounded-2xl p-8 shadow-xl">
                <h3 class="text-xl font-semibold mb-2">Schedule a Consultation Call</h3>
                <p class="text-sm text-gray-400 mb-5">Tell us about your business and goals — our team will review and propose a tailored marketing & SEO plan.</p>
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

    <!-- Content Sections -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <h2 class="text-3xl font-bold mb-4">Strategic SEO & Marketing Foundations</h2>
        <p class="text-gray-400 max-w-3xl mb-4">SEO is the strategy of optimizing your content so it shows higher in search results. Our SEO experts at XpertVA build your website on platforms that support easy customization and content updates, and give you the tools required to optimize every segment of your website.</p>
        <p class="text-gray-400 max-w-3xl mb-4">Once the foundations are in place, we take care of critical details such as internal linking structures, metadata, and on-page elements — all aligned with SEO best practices and Google guidelines — to steadily improve your rankings through organic, non-paid traffic.</p>
        <p class="text-gray-400 max-w-3xl">Because Google wants to deliver the best possible information to its users, our focus is to ensure search engines recognize your content as the most relevant answer to specific search queries, especially for your e-commerce and online business niche.</p>
    </section>

    <section id="services" class="max-w-7xl mx-auto px-6 pb-24 pt-4 border-t border-[#151515]">
        <h2 class="text-3xl font-bold mb-3">Core Marketing & SEO Services</h2>
        <p class="text-gray-400 max-w-3xl mb-10">Our e-commerce professional team combines keyword targeting, technical SEO, content creation, and performance marketing to help you generate more traffic, leads, and sales.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $marketingServices = [
                ['title' => 'Keyword Targeting & Implementation', 'icon' => 'target', 'desc' => 'We research, identify, and implement SEO-friendly keywords in your product listings, pages, and descriptions to generate more leads and make it easier for shoppers to find your offers.'],
                ['title' => 'Content Creation', 'icon' => 'file-text', 'desc' => 'Clear product descriptions, engaging visuals, and rich content (including A+ content / EBC) help customers understand your products and make confident purchase decisions.'],
                ['title' => 'Link Building', 'icon' => 'link-2', 'desc' => 'High-quality, relevant link building drives organic traffic and strengthens your authority, improving rankings and visibility across competitive search terms.'],
                ['title' => 'Social Media Marketing', 'icon' => 'share-2', 'desc' => 'We promote your products and listings across social platforms to boost sales volume, conversions, and brand awareness, especially for marketplaces and e-commerce stores.'],
                ['title' => 'Page Speed Optimization', 'icon' => 'gauge', 'desc' => 'We optimize hosting, assets, cache, and redirects to improve page load time — delivering better user experience, higher engagement, and stronger search visibility.'],
                ['title' => 'Email Marketing', 'icon' => 'mail', 'desc' => 'Strategic email campaigns help nurture relationships, build your brand, and generate higher ROI from both new and existing customers.']
            ];
            @endphp

            @foreach($marketingServices as $service)
            <div class="bg-[#121212] border border-[#1f1f1f] rounded-2xl p-6 hover:border-orange-300 transition group">
                <div class="text-orange-300 mb-4 group-hover:scale-110 transition">
                    @if($service['icon'] === 'target')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                    @elseif($service['icon'] === 'file-text')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                    @elseif($service['icon'] === 'link-2')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 17H7A5 5 0 0 1 7 7h2"></path><path d="M15 7h2a5 5 0 1 1 0 10h-2"></path><line x1="8" x2="16" y1="12" y2="12"></line></svg>
                    @elseif($service['icon'] === 'share-2')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg>
                    @elseif($service['icon'] === 'gauge')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg>
                    @elseif($service['icon'] === 'mail')
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                    @endif
                </div>
                <h3 class="text-lg font-semibold mb-2">{{ $service['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-[#101010] border-t border-[#222]">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold mb-10">Frequently Asked Questions</h2>
            <div class="space-y-6">
                <div class="p-6 bg-[#161616] border border-[#222] rounded-xl">
                    <h4 class="text-lg font-semibold mb-2 text-orange-300">What types of businesses can XpertVA help?</h4>
                    <p class="text-gray-300 leading-relaxed">We work with e-commerce brands, service businesses, online stores, and physical businesses that want to strengthen their online presence, improve rankings, and generate more leads and sales.</p>
                </div>
                <!-- ... additional FAQs based on the original content ... -->
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="py-20 text-center bg-gradient-to-b from-[#151515] to-[#0b0b0b] border-t border-[#222]">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Let XpertVA Build Your Growth Engine</h2>
        <p class="text-gray-400 max-w-2xl mx-auto mb-6">From SEO and content to social media, email, and full-funnel strategy, our team is ready to help you grow faster and smarter.</p>
        <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-orange-300 text-black px-10 py-4 rounded-xl text-lg font-semibold hover:opacity-80 transition shadow-xl inline-block">Book Your Consultation</button>
    </section>
</div>
@endsection
