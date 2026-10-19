@use('App\Support\SiteContent')
@php($data = SiteContent::source('servicios'))
<x-layout title="Servicios | AD Consulting" active="Servicios">
    <livewire:service-explorer />

    <section class="section service-cert">
        <h2>{{ $data['text'][20] }}</h2>
        <div class="cert-row">
            @foreach (array_slice($data['images'], 8, 4) as $image)
                <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy">
            @endforeach
        </div>
    </section>
</x-layout>
