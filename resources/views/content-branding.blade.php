@extends('layouts.app')

@section('title', 'Content & Branding - XpertVA')

@section('content')
<section class="text-white bg-black pt-32 pb-20 px-4 md:px-20">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-light mb-8">Content & Branding</h1>
        <p class="text-lg text-gray-300 max-w-3xl mb-12">Building powerful brand identities through creative content and design.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">Brand Identity</h2>
                <p class="text-gray-400">Logo design, color palettes, and brand guidelines.</p>
            </div>
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">Creative Content</h2>
                <p class="text-gray-400">Compelling copy and visual content for all platforms.</p>
            </div>
        </div>
    </div>
</section>
@endsection
