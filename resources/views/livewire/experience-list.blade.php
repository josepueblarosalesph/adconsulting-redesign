<section class="section news-editorial-list" id="contenido">
    <div class="experiences-list">
        @foreach ($experiences as $article)
            <a href="{{ $article->url }}" target="_blank" rel="noreferrer" class="experience-row reveal" wire:key="experience-{{ $article->id }}">
                <time class="experience-date experience-date-desktop">{{ $article->displayDate() }}</time>
                <div>
                    <p class="eyebrow">{{ $article->source }}</p>
                    <h3>{{ $article->title }}</h3>
                    <time class="experience-date experience-date-mobile">{{ $article->displayDate() }}</time>
                    <p class="experience-summary">{{ $article->summary }}</p>
                    <span class="experience-link">Leer experiencia <x-icon name="arrow-up-right" :size="20" /></span>
                </div>
            </a>
        @endforeach
    </div>

    @if ($hasMore)
        <div class="experiences-more">
            <button type="button" class="button" wire:click="loadMore" wire:loading.attr="disabled">
                Ver más experiencias <x-icon name="arrow-down" :size="22" />
            </button>
        </div>
    @endif
</section>
