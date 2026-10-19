{{-- Al llegar con /servicios#servicio-N (o al cambiar el hash) se abre ese servicio. --}}
<section class="services-explorer" id="contenido"
    style="--service-image:url(&quot;{{ $service['image'] }}&quot;);--service-position:{{ $service['imagePosition'] }}"
    x-data="{ sync() { const match = location.hash.match(/^#servicio-(\d+)$/); if (match) $wire.select(Number(match[1]) - 1) } }"
    x-init="sync()" @hashchange.window="sync()">
    <div class="services-explorer-list" role="tablist" aria-label="Servicios disponibles">
        @foreach ($services as $index => $item)
            <button wire:key="service-tab-{{ $index }}" id="servicio-{{ $index + 1 }}" type="button" role="tab"
                aria-selected="{{ $active === $index ? 'true' : 'false' }}" @class(['active' => $active === $index])
                wire:click="select({{ $index }})">
                <span class="services-explorer-number">0{{ $index + 1 }}</span>
                <span class="services-explorer-name">{{ $item['title'] }}</span>
                <x-icon name="plus" :size="22" />
            </button>
        @endforeach
    </div>

    <article class="services-explorer-detail" role="tabpanel" aria-labelledby="servicio-{{ $active + 1 }}">
        <div class="services-explorer-copy">
            <p class="eyebrow">SERVICIOS</p>
            <h2>{{ $service['title'] }}</h2>
            <p class="services-explorer-summary">{{ $service['summary'] }}</p>
            @foreach ($service['paragraphs'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
            @if ($service['logo'])
                <div class="service-partner"><img class="service-partner-logo" src="/images/{{ $service['logo']['file'] }}" alt="{{ $service['logo']['alt'] }}"></div>
            @endif
            @if ($service['video'])
                <a href="{{ $service['video'] }}" target="_blank" rel="noreferrer" class="text-link">Si quieres saber más, ve este video <x-icon name="arrow-up-right" :size="20" /></a>
            @endif
        </div>
        <div class="services-explorer-image" aria-hidden="true"><img src="{{ $service['image'] }}" alt=""></div>
    </article>
</section>
