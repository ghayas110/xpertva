@extends('layouts.app')

@section('title', isset($blog) ? $blog->title . ' - XpertVA Blog' : 'Blog - XpertVA')
@section('meta_description', isset($blog) ? \Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 155) : 'XpertVA Blog - Expert insights on eCommerce, Amazon, Shopify, and virtual assistant services.')

@push('schema')
@if(isset($blog))
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": {{ json_encode($blog->title) }},
  "description": {{ json_encode(\Illuminate\Support\Str::limit(strip_tags($blog->description ?? $blog->content), 155)) }},
  "image": "{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}",
  "datePublished": "{{ $blog->created_at->toIso8601String() }}",
  "dateModified": "{{ $blog->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Organization",
    "name": "XpertVA",
    "url": "https://xpertva.com"
  },
  "publisher": {
    "@type": "Organization",
    "name": "XpertVA",
    "logo": {
      "@type": "ImageObject",
      "url": "https://xpertva.com/assets/images/logo-xpertva.png"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  }
}
</script>
@endverbatim
@endif
@endpush

@section('content')
<div class="bg-black text-white min-h-screen pt-32 pb-20">
    <article class="max-w-4xl mx-auto px-6">
        @if($blog)
            <div class="mb-12">
                <a href="{{ route('blog.index') }}" class="text-indigo-400 hover:underline mb-8 inline-block">← Back to Blog</a>
                <div class="flex items-center gap-4 text-sm text-gray-400 mb-6 uppercase tracking-widest">
                    <span class="bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded-full">{{ $blog->category }}</span>
                    <span>•</span>
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-8">{{ $blog->title }}</h1>
                
                <div class="rounded-3xl overflow-hidden mb-12 border border-gray-800">
                    <img src="{{ filter_var($blog->image, FILTER_VALIDATE_URL) ? $blog->image : asset('assets/images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-auto object-cover"/>
                </div>

                <!-- Author byline -->
                <div class="flex items-center gap-4 mb-10 py-4 border-y border-gray-800">
                    <div class="w-10 h-10 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">XpertVA Editorial Team</p>
                        <p class="text-xs text-gray-500">Published {{ $blog->created_at->format('F j, Y') }}@if($blog->updated_at->ne($blog->created_at)) &middot; Updated {{ $blog->updated_at->format('F j, Y') }}@endif &middot; {{ $blog->category }}</p>
                    </div>
                </div>

                <div class="prose prose-invert prose-indigo max-w-none text-gray-300 text-lg leading-relaxed">
                    {!! nl2br(e($blog->content)) !!}
                </div>
                
                @if($blog->tags)
                <div class="mt-12 pt-8 border-t border-gray-800">
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->tags) as $tag)
                        <span class="px-3 py-1 bg-gray-900 border border-gray-800 rounded-full text-sm text-gray-400">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-20">
                <h1 class="text-4xl font-bold mb-4">Blog Post Not Found</h1>
                <a href="{{ route('blog.index') }}" class="text-indigo-400 hover:underline">Return to Blog</a>
            </div>
        @endif
    </article>
</div>
@endsection
