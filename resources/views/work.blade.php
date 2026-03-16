@extends('layouts.app')

@section('title', 'Work - XpertVA')

@section('content')
<section class="text-white overflow-hidden bg-black min-h-screen relative">
    <!-- Background Image -->
    <div class="absolute top-0 inset-0 z-0 h-[60vh]">
        <img alt="Work Background" class="opacity-80 w-full h-full object-cover" src="{{ asset('assets/images/bg-work.jpg') }}"/>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black"></div>
    </div>

    <div class="relative z-10 px-4 md:px-10 pt-36 pb-20 max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="mb-12 pt-16 md:pt-32 px-4 md:px-12 text-left max-w-full">
            <h1 class="text-4xl md:text-7xl font-bold mb-6 text-white">Work</h1>
            <p class="text-lg md:text-2xl text-gray-200 max-w-4xl leading-relaxed">
                We follow a creative step-by-step process to transform your vision into reality by creating a digital identity that integrates diverse marketing elements to resonate with your target audience. Explore our work by clicking on a case study below.
            </p>
        </div>

        <!-- Category Filter -->
        <div class="relative mb-16 px-4 md:px-12">
            <div id="category-bar" class="flex gap-4 overflow-x-auto pb-4 border-b border-white/10 no-scrollbar">
                @php
                $categories = [
                    'All', 'Keyword Research', 'Infographics', 'Listing Optimization', 
                    'MAP Enforcement', 'A to Z Claim', 'Amazon Cases', 'Account health', 
                    'Listing Issues', 'A+ Premium', 'Storefront Creation', 
                    'Amazon PPC Optimization', 'Coupon/promotion Management', 
                    'Infringements/Hijacker Removal', 'Daily On-going Tasks'
                ];
                @endphp
                
                @foreach($categories as $index => $cat)
                <button class="category-btn text-sm font-medium whitespace-nowrap px-4 py-2 border-b-2 transition-all duration-300 {{ $index === 0 ? 'border-indigo-500 text-white' : 'border-transparent text-gray-400 hover:text-white' }}" data-category="{{ $cat }}">
                    {{ $cat }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 gap-8 px-4 md:px-12">
            @php
            $portfolio = [
                ['title' => 'Collins smart Ceiling fan', 'cat' => 'Infographics', 'img' => 'fan.jpg', 'desc' => 'An e-commerce platform for handmade crafts.'],
                ['title' => 'Rechargeable table lamps', 'cat' => 'Infographics', 'img' => 'lightning-lamp.jpg', 'desc' => 'Lighting solutions for modern living.'],
                ['title' => 'Legrand - 15a Self Test Outlet', 'cat' => 'Infographics', 'img' => 'self-test-outlet.jpg', 'desc' => 'An e-commerce platform for handmade crafts.'],
                ['title' => 'BUBRITE:Traverse LED', 'cat' => 'Infographics', 'img' => 'Transverse-led.jpg', 'desc' => 'An e-commerce platform for handmade crafts.'],
                ['title' => 'BULBRITE:LED Filament T9 Light Bulb', 'cat' => 'Infographics', 'img' => 'T9-Light-BulBulb.png', 'desc' => 'An e-commerce platform for handmade crafts.'],
                ['title' => 'Chandelier Lift System', 'cat' => 'Infographics', 'img' => 'chandelier-lift-system.jpg', 'desc' => 'An e-commerce platform for handmade crafts.'],
                ['title' => 'A to Z Claim Management', 'cat' => 'A to Z Claim', 'img' => 'a-z-claim/1.jpg', 'desc' => 'Amazon A to Z claim management'],
                ['title' => 'A to Z Claim Management', 'cat' => 'A to Z Claim', 'img' => 'a-z-claim/2.jpg', 'desc' => 'Amazon A to Z claim management'],
                ['title' => 'A to Z Claim Management', 'cat' => 'A to Z Claim', 'img' => 'a-z-claim/3.jpg', 'desc' => 'Amazon A to Z claim management'],
                ['title' => 'A to Z Claim Management', 'cat' => 'A to Z Claim', 'img' => 'a-z-claim/4.jpg', 'desc' => 'Amazon A to Z claim management'],
                ['title' => 'A to Z Claim Management', 'cat' => 'A to Z Claim', 'img' => 'a-z-claim/5.jpg', 'desc' => 'Amazon A to Z claim management'],
                ['title' => 'Account Health Management', 'cat' => 'Account health', 'img' => 'account-health/1.jpg', 'desc' => 'Amazon account health management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/1.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/2.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/3.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/4.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/5.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/6.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/8.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/9.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Amazon Cases Management', 'cat' => 'Amazon Cases', 'img' => 'amazon-cases/10.jpg', 'desc' => 'Amazon cases management'],
                ['title' => 'Keyword Research Project', 'cat' => 'Keyword Research', 'img' => 'keyword-research/1.jpg', 'desc' => 'Amazon keyword research project'],
                ['title' => 'Listing Optimization Project', 'cat' => 'Listing Optimization', 'img' => 'listing-optimization/1.jpg', 'desc' => 'Amazon listing optimization project'],
                ['title' => 'Listing Issues Project', 'cat' => 'Listing Issues', 'img' => 'listing-issues/1.jpg', 'desc' => 'Amazon listing issues project'],
                ['title' => 'Listing Issues Project', 'cat' => 'Listing Issues', 'img' => 'listing-issues/2.jpg', 'desc' => 'Amazon listing issues project'],
                ['title' => 'Listing Issues Project', 'cat' => 'Listing Issues', 'img' => 'listing-issues/3.jpg', 'desc' => 'Amazon listing issues project'],
                ['title' => 'Listing Issues Project', 'cat' => 'Listing Issues', 'img' => 'listing-issues/4.jpg', 'desc' => 'Amazon listing issues project'],
                ['title' => 'Map Enforcement Project', 'cat' => 'MAP Enforcement', 'img' => 'map-enforcement/1.png', 'desc' => 'Amazon map enforcement project']
            ];
            @endphp

            @foreach($portfolio as $item)
            <div class="portfolio-item relative rounded-2xl overflow-hidden group cursor-pointer bg-[#111] border border-white/5 hover:border-indigo-500/50 transition-all duration-500" data-category="{{ $item['cat'] }}">
                <div class="aspect-[4/3] overflow-hidden">
                    <img alt="{{ $item['title'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ asset('assets/images/' . $item['img']) }}"/>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-100 group-hover:via-black/40 transition-all duration-500"></div>
                <div class="absolute bottom-8 left-8 right-8 text-white z-10 transition-transform duration-500 group-hover:-translate-y-2">
                    <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-3 block">{{ $item['cat'] }}</span>
                    <h3 class="text-2xl font-bold mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.category-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');

            // Update button styles
            filterButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-white');
                btn.classList.add('border-transparent', 'text-gray-400');
            });
            button.classList.add('border-indigo-500', 'text-white');
            button.classList.remove('border-transparent', 'text-gray-400');

            // Filter items
            portfolioItems.forEach(item => {
                if (category === 'All' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
});
</script>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection
