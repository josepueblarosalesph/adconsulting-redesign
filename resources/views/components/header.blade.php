@props(['active' => 'Inicio'])
@use('App\Support\SiteContent')
<header class="header">
    <x-brand />
    <nav aria-label="Navegación principal">
        @foreach (SiteContent::NAV_LINKS as [$name, $url])
            <a href="{{ $url }}" @if ($active === $name) aria-current="page" @endif>{{ $name }}</a>
        @endforeach
        <a href="{{ SiteContent::JOBS_URL }}" target="_blank" rel="noreferrer">Ofertas de Trabajo</a>
    </nav>
    <a class="contact-link" href="#contacto">Hablemos <x-icon name="arrow-up-right" :size="17" /></a>

    <div x-data="mobileMenu" @keydown.escape.window="close()">
        <button type="button" class="menu-button" aria-label="Abrir menú" aria-haspopup="dialog" :aria-expanded="visible" @click="show()"><x-icon name="menu" :size="24" /></button>
        <template x-teleport="body">
            <div x-show="visible" x-cloak>
                <div class="sheet-overlay" data-slot="sheet-overlay" :data-starting-style="state === 'starting' ? '' : null" :data-ending-style="state === 'ending' ? '' : null" @click="close()"></div>
                <div class="sheet-content menu-panel" data-slot="sheet-content" data-side="right" role="dialog" aria-modal="true" aria-labelledby="menu-title" :data-starting-style="state === 'starting' ? '' : null" :data-ending-style="state === 'ending' ? '' : null" x-trap.noscroll="visible">
                    <div class="menu-top">
                        <h2 class="menu-title" id="menu-title" data-slot="sheet-title">AD Consulting</h2>
                        <button type="button" aria-label="Cerrar menú" class="menu-close" @click="close()"><x-icon name="x" :size="28" /></button>
                    </div>
                    <div class="menu-links">
                        @foreach (SiteContent::mobileLinks() as $i => [$name, $url])
                            @php($external = str_starts_with($url, 'http'))
                            <a style="animation-delay:{{ $i * 50 }}ms" href="{{ $url }}" @if ($external) target="_blank" rel="noreferrer" @endif @if ($active === $name) aria-current="page" @endif @click="close()"><small>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</small>{{ $name }}<x-icon name="arrow-up-right" /></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </template>
    </div>
</header>
