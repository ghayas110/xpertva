@extends('layouts.app')

@section('title', 'Privacy Policy - XpertVA')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-black via-[#0b0f17] to-black text-gray-100 mt-16">
    <header class="relative overflow-hidden border-b border-white/5">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(90,149,255,0.08),transparent_35%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_0%,rgba(147,197,114,0.08),transparent_30%)]"></div>
        <div class="max-w-6xl mx-auto px-6 py-24">
            <p class="text-sm uppercase tracking-[0.3em] text-gray-400">Privacy Policy</p>
            <h1 class="mt-4 text-4xl sm:text-5xl font-semibold leading-tight text-white">Your data, handled with clarity, care, and control.</h1>
            <p class="mt-6 max-w-3xl text-lg text-gray-300">This policy explains what we collect, why we collect it, how we use it, and the choices you have. It applies to visitors, clients, and anyone interacting with our services and website.</p>
            <div class="mt-8 flex flex-wrap items-center gap-4 text-sm text-gray-400">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 bg-white/5">Last updated: Jan 1, 2025</span>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 bg-white/5">Effective globally</span>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 pb-20">
        <section class="mt-12 grid gap-6 sm:grid-cols-2">
            <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-5 shadow-lg shadow-black/30">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-gradient-to-r from-blue-400 to-emerald-300"></span>
                    <p class="text-sm sm:text-base text-gray-200">We collect only what we need to deliver and improve our services.</p>
                </div>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-5 shadow-lg shadow-black/30">
                <div class="flex items-start gap-3">
                    <span class="mt-0.5 h-2.5 w-2.5 rounded-full bg-gradient-to-r from-blue-400 to-emerald-300"></span>
                    <p class="text-sm sm:text-base text-gray-200">Your information stays protected through layered security controls.</p>
                </div>
            </div>
        </section>

        <section class="mt-16 rounded-3xl border border-white/10 bg-white/5 p-8 shadow-xl shadow-black/30">
            <h2 class="text-2xl font-semibold text-white mb-6">Information We Collect</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="rounded-2xl border border-white/5 bg-black/30 p-5">
                    <h3 class="text-lg font-semibold text-white">Account & Contact</h3>
                    <p class="mt-2 text-sm text-gray-300">Name, email, phone, company, and role when you request a demo or engage our services.</p>
                </div>
                <div class="rounded-2xl border border-white/5 bg-black/30 p-5">
                    <h3 class="text-lg font-semibold text-white">Usage & Device</h3>
                    <p class="mt-2 text-sm text-gray-300">Log data, page views, IP address, browser type, and device identifiers to keep the platform secure and reliable.</p>
                </div>
            </div>
        </section>

        <section class="mt-12 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-xl shadow-black/30">
                <h2 class="text-2xl font-semibold text-white mb-6">How We Use Data</h2>
                <ul class="space-y-3 text-sm text-gray-200">
                    <li class="flex items-start gap-3 rounded-2xl border border-white/5 bg-black/30 px-4 py-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-blue-300"></span>
                        <span>Provide and maintain services, including onboarding, support, and feature delivery.</span>
                    </li>
                    <li class="flex items-start gap-3 rounded-2xl border border-white/5 bg-black/30 px-4 py-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-blue-300"></span>
                        <span>Personalize content and recommendations based on your activity and preferences.</span>
                    </li>
                </ul>
            </div>
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-xl shadow-black/30">
                <h2 class="text-2xl font-semibold text-white mb-6">Sharing & Disclosure</h2>
                <p class="text-gray-300 mb-6">We do not sell your data. When we share, it is limited, purposeful, and safeguarded by contracts.</p>
                <ul class="space-y-3 text-sm text-gray-200">
                    <li class="flex items-start gap-3 rounded-2xl border border-white/5 bg-black/30 px-4 py-3">
                        <span class="mt-1 h-2 w-2 rounded-full bg-emerald-300"></span>
                        <span>Infrastructure, analytics, and communication vendors that support our operations.</span>
                    </li>
                </ul>
            </div>
        </section>
    </main>
</div>
@endsection
