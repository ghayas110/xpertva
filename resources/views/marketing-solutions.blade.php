@extends('layouts.app')

@section('title', 'Marketing Solutions - XpertVA')

@section('content')
<section class="text-white bg-black pt-32 pb-20 px-4 md:px-20">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-light mb-8">Marketing Solutions</h1>
        <p class="text-lg text-gray-300 max-w-3xl mb-12">Growth-oriented marketing strategies to help your brand stand out and scale.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">SEO Optimization</h2>
                <p class="text-gray-400">Improve your search rankings and drive organic traffic.</p>
            </div>
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">PPC Management</h2>
                <p class="text-gray-400">Data-driven ad campaigns that maximize ROI.</p>
            </div>
        </div>
    </div>
</section>
@endsection
