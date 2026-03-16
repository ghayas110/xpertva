@extends('layouts.app')

@section('title', 'Contact Us - XpertVA')

@section('content')
<div class="min-h-screen bg-[#0b0b0b] text-white flex items-center justify-center px-4 sm:px-6 py-12 sm:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(99,102,241,0.05),transparent_70%)]"></div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 max-w-6xl w-full relative z-10">
        <div class="mt-16 sm:mt-0">
            <h1 class="text-4xl sm:text-6xl font-bold mb-4">Let's Talk!</h1>
            <p class="text-lg text-gray-400 mb-10">Fill out the form below to get your project started. Our team will get back to you within 24 hours.</p>
            
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-8 w-full max-w-md">
                @csrf
                <div class="group">
                    <input name="name" type="text" placeholder="Your name*" required class="w-full bg-transparent border-b border-gray-700 focus:border-indigo-500 transition-colors outline-none py-4 placeholder-gray-500 text-lg">
                </div>
                <div class="group">
                    <input name="email" type="email" placeholder="Email address*" required class="w-full bg-transparent border-b border-gray-700 focus:border-indigo-500 transition-colors outline-none py-4 placeholder-gray-500 text-lg">
                </div>
                <div class="group">
                    <textarea name="message" rows="4" placeholder="Tell us about your project or requirements*" required class="w-full bg-transparent border-b border-gray-700 focus:border-indigo-500 transition-colors outline-none py-4 placeholder-gray-500 text-lg resize-none"></textarea>
                </div>
                <button type="submit" class="inline-flex items-center gap-3 bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-5 rounded-full font-semibold transition-all transform hover:scale-105 shadow-xl">
                    Submit Request
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                </button>
            </form>
        </div>

        <div class="space-y-10 lg:pl-10">
            <div class="bg-[#141414] border border-[#222] p-10 rounded-3xl shadow-2xl">
                <h3 class="text-2xl font-semibold mb-8">Contact Information</h3>
                
                <div class="space-y-8">
                    <div class="flex items-start gap-5">
                        <div class="bg-indigo-500/10 p-3 rounded-xl text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Our Location</p>
                            <p class="text-gray-200">XpertVA, EnglishTown, New Jersey 07726, USA</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="bg-indigo-500/10 p-3 rounded-xl text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Email Address</p>
                            <p class="text-gray-200">hello@xpertva.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="bg-indigo-500/10 p-3 rounded-xl text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Call / WhatsApp</p>
                            <p class="text-gray-200">+1 732 490 6272</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="flex gap-4">
                <a href="#" class="bg-[#141414] border border-[#222] p-4 rounded-2xl hover:bg-gray-800 transition shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                <a href="#" class="bg-[#141414] border border-[#222] p-4 rounded-2xl hover:bg-gray-800 transition shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg></a>
                <a href="#" class="bg-[#141414] border border-[#222] p-4 rounded-2xl hover:bg-gray-800 transition shadow-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect width="4" height="12" x="2" y="9"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
            </div>
        </div>
    </div>
</div>
@endsection
