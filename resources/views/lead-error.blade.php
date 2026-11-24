@extends('layouts.site')

@section('title', 'Check your details | XpertVA')

@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<section class="section">
    <div class="wrap" style="max-width:46rem">
        <p class="eyebrow">Not sent</p>
        <h1 class="h1">A couple of details need fixing.</h1>
        <p class="lede">Nothing was submitted. Go back and correct the following, then send again.</p>
        <ul style="margin-top:1.5rem">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <p style="margin-top:2rem">
            <a class="btn btn--primary" href="{{ $form === 'contact' ? route('contact') : route('home') }}">Go back</a>
        </p>
    </div>
</section>
@endsection
