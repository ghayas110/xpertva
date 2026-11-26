{{--
  "Further reading" for a service page: the blog posts that support it,
  taken from config/content.php so the post -> service link and this
  service -> post link always come as a pair.

  Optional: $route (defaults to the current route name).
--}}
@include('site.case-files', ['route' => $route ?? request()->route()?->getName()])

@php
    $route = $route ?? request()->route()?->getName();
    $slugs = array_keys(array_filter(
        config('content.post_service', []),
        fn ($target) => $target === $route
    ));

    try {
        $reading = $slugs
            ? \App\Models\Blog::listed()->whereIn('slug', $slugs)->latest()->get(['slug', 'title'])
            : collect();
    } catch (\Throwable $e) {
        // A database hiccup must never take a service page down with it.
        report($e);
        $reading = collect();
    }
@endphp

@if ($reading->isNotEmpty())
<section class="section--tight" style="padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <h2 class="h3 mb-3">Further reading</h2>
        <div class="related">
            @foreach ($reading as $post)
                <a href="{{ route('blog.show', $post->slug) }}">
                    <span>{{ $post->title }}</span>
                    @include('site.arrow')
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
