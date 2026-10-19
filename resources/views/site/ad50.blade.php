@use('App\Support\SiteContent')
@php
    $d = SiteContent::source('ad50')['text'];
    $images = SiteContent::source('ad50')['images'];
@endphp
<x-layout title="AD+50 | AD Consulting" active="AD+50">
    <x-hero class="ad50-hero" title="El futuro del trabajo se construye con experiencia" :title-lines="['El futuro del trabajo', 'se construye con experiencia']" :image="3" hero-logo="/images/ad50-logo-hero.png" cta="Registrarme como empresa" href="https://ad50.adconsulting.cl/registro?tipo=empresa" secondary-cta="Registrarme como persona" secondary-href="https://ad50.adconsulting.cl/registro?tipo=postulante" />

    <section class="section senior-intro" id="contenido">
        <div class="reveal">
            <p class="eyebrow">AD+50</p>
            <h2><span class="black-line">El talento ya no es el mismo y</span><span class="accent-line">las empresas no están gestionando ese cambio.</span></h2>
        </div>
        <div class="three-statements">
            @foreach ([8, 11, 14] as $n)
                <div><h3>{{ $d[$n] }} {{ $d[$n + 1] }}</h3></div>
            @endforeach
        </div>
        <div class="platform-link">
            <p>Conoce más sobre <em>AD+50</em> en nuestra plataforma</p>
            <a href="https://ad50.adconsulting.cl" class="text-link">{{ $d[17] }} <x-icon name="arrow-up-right" /></a>
        </div>
    </section>

    <section class="split-feature senior-feature">
        <div class="image-wrap"><x-picture :index="12" /></div>
        <div class="feature-copy reveal">
            <img class="senior-feature-logo" src="/images/ad50-logo-hero.png" alt="AD+50 Talento Senior">
            <p>El nuevo servicio de AD Consulting busca instalar una mirada estratégica sobre el talento senior. Y la manera de hacerlo es abordando de manera integral el reclutamiento especializado, el entrenamiento continuo, la actualización de competencias y la consultoría orientada a una equilibrada convivencia intergeneracional en las organizaciones.</p>
        </div>
    </section>

    <section class="section problem-section">
        <p class="eyebrow problem-eyebrow">{{ $d[22] }}</p>
        <h2 class="section-title reveal">Un fenómeno que se repite y que no es sobre bienestar</h2>
        <p class="lead">Es perder productividad, continuidad operacional y acceso al talento crítico.</p>
        <div class="loss-grid">
            @foreach (SiteContent::LOSS_CARDS as $card)
                <article class="reveal">
                    <h3>{{ $card['title'] }}</h3>
                    <p>{{ $card['summary'] }}</p>
                    <ul>
                        @foreach ($card['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section approach">
        <p class="eyebrow">{{ $d[42] }}</p>
        <h2 class="section-title reveal">{{ $d[43] }}<br><em>{{ $d[44] }}</em></h2>
        <p class="lead">{{ $d[45] }}</p>
        <div class="comparison">
            @foreach (SiteContent::COMPARISON_CARDS as $card)
                <article>
                    <h3>{{ $card['title'] }}</h3>
                    <ul>
                        @foreach ($card['items'] as $item)
                            <li><span>↗</span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section action-section">
        <p class="eyebrow">{{ $d[56] }}</p>
        <h2 class="section-title">{{ $d[57] }} <em>{{ $d[58] }}</em></h2>
        <p class="lead">{{ $d[59] }}</p>
        <div class="action-lines">
            @foreach ([60, 63, 66, 69, 72] as $n)
                <article class="reveal"><span>{{ $d[$n] }}</span><h3>{{ $d[$n + 1] }}</h3><p>{{ $d[$n + 2] }}</p></article>
            @endforeach
        </div>
    </section>

    <section class="section senior-team">
        <h2>{{ $d[76] }}</h2>
        <p class="lead">{{ $d[77] }}</p>
        <div class="team-grid">
            @foreach ([78, 81, 84, 87] as $i => $n)
                <article class="person reveal">
                    <div class="person-image"><img src="{{ $images[6 + $i]['src'] }}" alt="{{ $images[6 + $i]['alt'] }}" loading="lazy"></div>
                    <h3>{{ $d[$n] }}</h3>
                    <p>{{ $d[$n + 1] }}</p>
                    <p>{{ $d[$n + 2] }}</p>
                </article>
            @endforeach
        </div>
    </section>
</x-layout>
