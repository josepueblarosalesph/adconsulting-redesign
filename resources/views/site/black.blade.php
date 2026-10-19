@use('App\Support\SiteContent')
@php
    $data = SiteContent::source('black');
    $text = $data['text'];
    $photo = SiteContent::photo(0);
    $benefits = array_values(array_filter(array_slice($text, 10, 5), fn ($t) => ! str_starts_with($t, 'Bono de Bienvenida AD Black')));
@endphp
<x-layout title="AD Black | AD Consulting" active="AD Black" black>
    <x-hero class="black-hero" :title="$text[1]" :title-lines="['Bienvenido al', 'Círculo AD Black']" label="AD BLACK" cta="Beneficios AD Black" href="#beneficios">
        <x-slot:visual>
            <img class="service-photo black-hero-background" style="{{ SiteContent::photoStyle(0) }}" src="/images/{{ $photo['file'] }}" alt="" aria-hidden="true">
            <div class="black-card-image black-hero-card"><img src="{{ $data['images'][0]['src'] }}" alt="{{ $data['images'][0]['alt'] }}"></div>
        </x-slot:visual>
    </x-hero>

    <section class="section black-intro" id="contenido">
        <p class="eyebrow">CÍRCULO AD BLACK</p>
        <h2 class="reveal">{{ $text[7] }}</h2>
        <div class="black-columns">
            <p>{{ preg_replace('/ ,/', ',', implode(' ', array_slice($text, 2, 5)), 1) }}</p>
            <p>{{ $text[8] }}</p>
        </div>
    </section>

    <section class="black-benefits" id="beneficios">
        <div class="black-benefit-visual"><img src="{{ $data['images'][1]['src'] }}" alt="{{ $data['images'][1]['alt'] }}" loading="lazy"></div>
        <div class="black-benefit-copy">
            <h2>{{ $text[9] }}</h2>
            @foreach ($benefits as $i => $benefit)
                <article class="reveal"><span>0{{ $i + 1 }}</span><p>{{ $benefit }}</p></article>
            @endforeach
        </div>
    </section>
</x-layout>
