@use('App\Support\SiteContent')
@php
    $text = SiteContent::source('home')['text'];
    $partners = collect(SiteContent::source('home')['images'])
        ->reject(fn ($image) => in_array($image['alt'], ['Codify', 'Equipo AD Consulting'], true))
        ->take(5);
    $servicesText = SiteContent::source('servicios')['text'];
@endphp
<x-layout active="Inicio">
    <x-hero class="home-hero" x-data="heroVideo" :title="$text[1]" description="Más de 15 años de experiencia en procesos de Head Hunting, Reclutamiento, Selección de Talentos, Outplacement, Capacitación y Coaching Ejecutivo">
        <x-slot:visual>
            <video x-ref="video" class="hero-video" autoplay loop playsinline preload="auto"><source src="/images/home-hero.mp4" type="video/mp4"></video>
            <button type="button" class="hero-sound-toggle" @click="toggleSound()" :aria-label="muted ? 'Activar sonido' : 'Silenciar video'">
                <x-icon name="volume-x" :size="21" x-show="muted" x-cloak /><x-icon name="volume-2" :size="21" x-show="!muted" />
                <span x-text="muted ? 'Activar sonido' : 'Silenciar'">Silenciar</span>
            </button>
        </x-slot:visual>
    </x-hero>

    <section class="partners" aria-label="Nuestros partners">
        <p>Nuestros partners</p>
        <div>
            @foreach ($partners as $image)
                <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy">
            @endforeach
        </div>
    </section>

    <section class="section impact" id="contenido">
        <h2 class="why-title">¿Por qué elegirnos?</h2>
        <div class="benefits-grid">
            @foreach ([11, 13, 15] as $i => $n)
                <article class="reveal"><span class="index">0{{ $i + 1 }}</span><h3>{{ $text[$n] }}</h3><p>{{ $text[$n + 1] }}</p></article>
            @endforeach
        </div>
    </section>

    <section class="split-feature home-services-feature">
        <div class="image-wrap"><x-picture :index="2" /></div>
        <div class="feature-copy reveal">
            <h2>Soluciones a tu medida</h2>
            <div class="service-links">
                @foreach (SiteContent::SERVICE_INDICES as $i => $n)
                    <a href="/servicios#servicio-{{ $i + 1 }}">{{ $servicesText[$n] }}<x-icon name="arrow-up-right" /></a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="client-logos" aria-label="Empresas impactadas">
        <h2>Confían en nosotros</h2>
        <div class="client-marquee">
            <div class="client-track">
                @foreach ([0, 1] as $copy)
                    <div class="client-group" @if ($copy === 1) aria-hidden="true" @endif>
                        @foreach (SiteContent::CLIENT_LOGOS as $file)
                            <img src="/images/client-{{ $file }}" alt="Empresa cliente de AD Consulting" loading="lazy">
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>
