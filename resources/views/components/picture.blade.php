@props(['index', 'alt' => null])
@php($photo = \App\Support\SiteContent::photo($index))
<img src="/images/{{ $photo['file'] }}" alt="{{ $alt ?? $photo['alt'] }}" loading="lazy" {{ $attributes->class('service-photo') }} style="{{ \App\Support\SiteContent::photoStyle($index) }}">
