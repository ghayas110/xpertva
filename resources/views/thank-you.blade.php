@extends('layouts.site')

@section('title', 'Thank You | XpertVA')
@section('meta_description', 'Thanks for getting in touch with XpertVA. A member of the team will reply shortly, usually within one business day.')

@push('head')
{{-- A confirmation page has no business in search results, but it is a
     perfect conversion goal in Analytics, which is why it is a real URL. --}}
<meta name="robots" content="noindex, follow">
<link rel="canonical" href="{{ url('/thank-you') }}">
@endpush

@section('content')
<section class="section">
    <div class="wrap" style="max-width:46rem">
        <p class="eyebrow">Received</p>
        <h1 class="h1">Thank you — we have your details.</h1>
        <p class="lede">
            A member of the team will read this and reply, usually within one business day.
            If it is urgent, call <a href="tel:+17324906272">+1 (732) 490-6272</a>.
        </p>
        <p style="margin-top:2rem">
            <a class="btn btn--primary" href="{{ route('home') }}">Back to the site</a>
            <a class="btn" href="{{ route('blog.index') }}" style="margin-left:.6rem">Read the blog</a>
        </p>
    </div>
</section>
@endsection
