@extends('layouts.app')

@section('title', 'Mobile App Development - XpertVA')

@section('content')
<section class="text-white bg-black pt-32 pb-20 px-4 md:px-20">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-light mb-8">Mobile App Development</h1>
        <p class="text-lg text-gray-300 max-w-3xl mb-12">Building high-performance mobile applications for iOS and Android.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">iOS Development</h2>
                <p class="text-gray-400">Native Swift and SwiftUI applications.</p>
            </div>
            <div class="bg-[#111] p-8 rounded-2xl border border-neutral-800">
                <h2 class="text-2xl font-semibold mb-4">Android Development</h2>
                <p class="text-gray-400">Native Kotlin applications.</p>
            </div>
        </div>
    </div>
</section>
@endsection
