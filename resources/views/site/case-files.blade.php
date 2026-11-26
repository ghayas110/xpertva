{{--
  "Amazon cases we resolved" for a service page: the case files in
  resources/data/amazon-cases.json that list this route among their
  services. Each case page links back to the same services, so the link
  always runs both ways.

  Optional: $route (defaults to the current route name).
--}}
@php
    $caseFiles = \App\Support\AmazonCases::forService($route ?? request()->route()?->getName());
@endphp

@if ($caseFiles)
<section class="section--tight" style="padding-block:clamp(3rem,6vw,5rem)">
    <div class="wrap">
        <h2 class="h3 mb-3">Amazon cases we resolved</h2>
        <div class="related">
            @foreach ($caseFiles as $caseSlug => $case)
                <a href="{{ route('work.amazon-case', $caseSlug) }}">
                    <span>{{ $case['h1'] }}</span>
                    @include('site.arrow')
                </a>
            @endforeach
        </div>
        <p class="small mt-3"><a class="tlink" href="{{ route('work.amazon-cases') }}">See every Amazon case file</a></p>
    </div>
</section>
@endif
