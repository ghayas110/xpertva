{{--
  BreadcrumbList schema. Pass $trail as [[name, url], ...] from the top level
  down; Home is added first and the current page last ($current, the H1).
  Pushed to the layout's schema stack, so it can be included anywhere.
--}}
@php
    $items = array_merge([['Home', url('/')]], $trail ?? [], [[$current, url()->current()]]);
@endphp
@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_map(fn ($item, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $item[0],
        'item' => $item[1],
    ], $items, array_keys($items)),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
