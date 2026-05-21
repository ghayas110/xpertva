<article class="group">
    <a href="{{ route('blog.show', $post->slug) }}" class="block">
        <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-gray-900 mb-6">
            <img src="{{ filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : asset('assets/images/' . $post->image) }}"
                 alt="{{ $post->title }}"
                 loading="lazy"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-[900ms] ease-out"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <span class="absolute top-4 left-4 bg-black/70 backdrop-blur-sm text-white text-[10px] uppercase tracking-[0.18em] font-semibold px-3 py-1.5 rounded-full border border-white/15">{{ $post->category }}</span>
        </div>
        <div class="flex items-center gap-3 text-[10px] text-gray-500 uppercase tracking-[0.2em] mb-3 font-medium">
            <time datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->format('M j, Y') }}</time>
            <span class="w-1 h-1 rounded-full bg-gray-700"></span>
            <span>{{ max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 220)) }} min read</span>
        </div>
        <h3 class="font-serif text-2xl font-bold leading-tight mb-3 group-hover:text-indigo-300 transition-colors line-clamp-3" style="font-family: 'Playfair Display', Georgia, serif;">
            {{ $post->title }}
        </h3>
        <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">{{ $post->description }}</p>
        <span class="mt-5 inline-flex items-center gap-2 text-xs font-semibold text-white group-hover:text-indigo-300 transition-colors">
            Read article
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="group-hover:translate-x-1 transition-transform"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </span>
    </a>
</article>
