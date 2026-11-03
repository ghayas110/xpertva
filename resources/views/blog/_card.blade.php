@php
    $cover = filter_var($post->image, FILTER_VALIDATE_URL) ? $post->image : asset('assets/images/' . $post->image);
    $minutes = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 220));
@endphp
<article class="post {{ ($lead ?? false) ? 'post--lead' : '' }}" data-anim>
    @if ($post->image)
        <div class="post__media">
            <img src="{{ $cover }}" alt="{{ $post->title }}" loading="lazy" decoding="async">
        </div>
    @endif
    <div>
        <p class="post__meta">
            {{ $post->category }} &nbsp; <time datetime="{{ $post->created_at->toIso8601String() }}">{{ $post->created_at->format('M j, Y') }}</time> &nbsp; {{ $minutes }} min
        </p>
        <h3 class="mt-1">
            {{-- The stretched link makes the whole card clickable while keeping one focus target. --}}
            <a class="post__link" href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>
        <p class="small mt-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->description ?? $post->content), 130) }}</p>
    </div>
</article>
