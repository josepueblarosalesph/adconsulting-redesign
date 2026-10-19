@props([
    'title',
    'description' => null,
    'label' => '',
    'image' => 0,
    'video' => null,
    'cta' => null,
    'href' => '#contenido',
    'compact' => false,
    'secondaryCta' => null,
    'secondaryHref' => '#',
    'heroLogo' => null,
    'titleLines' => null,
])
@php($photo = \App\Support\SiteContent::photo($image))
<section {{ $attributes->class(['hero', 'hero-inner' => $compact]) }}>
    @isset($visual)
        {{ $visual }}
    @elseif ($video)
        <video class="hero-video" autoplay muted loop playsinline preload="auto" aria-hidden="true"><source src="{{ $video }}" type="video/mp4"></video>
    @else
        <img class="service-photo" style="{{ \App\Support\SiteContent::photoStyle($image) }}" src="/images/{{ $photo['file'] }}" alt="{{ $photo['alt'] }}" fetchpriority="high">
    @endisset
    <div class="hero-content">
        @if ($heroLogo)
            <img class="hero-brand-logo" src="{{ $heroLogo }}" alt="AD+50 Talento Senior">
        @endif
        @if ($label)
            <p class="eyebrow">{{ $label }}</p>
        @endif
        @if ($titleLines)
            <h1 class="two-tone-title"><span class="title-accent">{{ $titleLines[0] }}</span><span>{{ $titleLines[1] }}</span></h1>
        @else
            <h1>{{ $title }}</h1>
        @endif
        @if ($description)
            <p class="hero-description">{{ $description }}</p>
        @endif
        @if ($cta)
            <div class="hero-actions">
                <x-button :href="$href">{{ $cta }}</x-button>
                @if ($secondaryCta)
                    <x-button :href="$secondaryHref">{{ $secondaryCta }}</x-button>
                @endif
            </div>
        @endif
    </div>
    <a class="hero-bottom" href="#contenido"><span>Desliza para descubrir <x-icon name="arrow-down" :size="16" /></span></a>
</section>
