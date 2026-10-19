@props(['href'])
<a class="button" href="{{ $href }}">{{ $slot }}<x-icon name="arrow-up-right" :size="22" /></a>
