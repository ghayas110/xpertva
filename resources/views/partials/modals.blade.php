<!-- Menu Modal -->
<div id="menu-modal" class="hidden fixed inset-0 z-50 bg-black text-white flex flex-col px-6 md:px-12 py-10 animate-fadeInRight">
    <button class="modal-close absolute top-6 right-6 text-sm text-white flex items-center gap-1">
        Close 
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 18 18"/></svg>
    </button>
    <div class="flex-1 flex flex-col items-start justify-center md:items-center">
        <div class="md:flex md:flex-row md:justify-center md:gap-24 w-full md:max-w-4xl">
            <div class="space-y-8">
                <a href="{{ route('home') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">01</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Home</span></div></a>
                <a href="{{ route('work') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">02</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Work</span></div></a>
                <a href="{{ route('services.index') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">03</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Services</span></div></a>
            </div>
            <div class="space-y-8 md:space-y-1">
                <a href="{{ route('team') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">04</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Team</span></div></a>
                <a href="{{ route('blog.index') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">05</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Blog</span></div></a>
                <a href="{{ route('contact') }}" class="modal-close block"><div class="flex items-center gap-4 group"><span class="text-gray-500 font-mono text-lg">06</span><span class="text-2xl md:text-5xl font-light group-hover:underline">Contact</span></div></a>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div id="contact-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-start z-50">
    <div class="relative w-full max-w-xl xl:mx-50 md:mx-20 mx-8 bg-transparent py-12 text-white">
        <button class="modal-close fixed top-5 right-5 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 18 18"/></svg>
        </button>
        <div class="text-left">
            <h2 class="text-5xl font-bold mb-2">Let’s talk!</h2>
            <p class="text-xl text-white mb-8">Fill out the following to get your project started</p>
            <form action="{{ route('contact.submit') }}" method="post" class="space-y-6">
                @csrf
                <input name="fullName" placeholder="Your full name*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="email" type="email" placeholder="Your email address*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="phone" placeholder="Your phone number*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="message" placeholder="Your message*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 w-20 h-20 rounded-full flex items-center justify-center transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Audit Modal -->
<div id="audit-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-start z-50">
    <div class="relative w-full max-w-xl xl:mx-50 md:mx-20 mx-8 bg-transparent py-12 text-white">
        <button class="modal-close fixed top-5 right-5 text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 18 18"/></svg>
        </button>
        <div class="text-left">
            <h2 class="text-5xl font-bold mb-2">Request Free Audit</h2>
            <p class="text-xl text-white mb-8">Fill out the following to get your project started</p>
            <form action="{{ route('audit.submit') }}" method="post" class="space-y-6">
                @csrf
                <input name="fullName" placeholder="Your full name*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="email" type="email" placeholder="Your email address*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="phone" placeholder="Your phone number*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="storeLink" placeholder="Store Link*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="preferredAsin" placeholder="Preferred ASIN*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <input name="message" placeholder="Your message*" required class="w-full bg-transparent border-b border-white text-white py-2 px-1 placeholder-white focus:outline-none">
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 w-20 h-20 rounded-full flex items-center justify-center transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Floating Action Buttons -->
<div class="fixed bottom-4 left-4 z-50 hidden md:block">
    <button onclick="document.getElementById('contact-modal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full flex items-center gap-2 shadow-lg">
        Get in touch <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
    </button>
</div>
<div class="fixed bottom-4 right-4 z-50 hidden md:block">
    <button onclick="document.getElementById('audit-modal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-full flex items-center gap-2 shadow-lg">
        Request Free Audit <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
    </button>
</div>
