@use('App\Support\SiteContent')
@php($text = SiteContent::source('nosotros')['text'])
<x-layout title="Nosotros | AD Consulting" active="Nosotros">
    <x-hero class="about-hero" :title="$text[1]" :title-lines="['En AD queremos ser tu mejor aliado', 'para enfrentar los desafíos a la hora de elegir y potenciar tu talento']" :image="15" compact />

    <section class="section team-section">
        <div class="section-heading"><h2>{{ $text[3] }}</h2><p>{{ $text[4] }}</p></div>

        <div x-data="teamGrid(@js(SiteContent::teamMembers()))">
            <div class="team-grid">
                @foreach (SiteContent::teamMembers() as $i => $member)
                    <button type="button" class="person reveal" @click="open({{ $i }})" aria-label="Ver perfil de {{ $member['name'] }}">
                        <div class="person-image"><img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" loading="lazy"></div>
                        <h3>{{ $member['name'] }}</h3>
                        <p>{{ $member['role'] }}</p>
                    </button>
                @endforeach
            </div>

            <template x-if="selected">
                <div class="team-modal-backdrop" role="presentation" @mousedown.self="close()" @keydown.escape.window="close()">
                    <div class="team-modal" role="dialog" aria-modal="true" aria-labelledby="team-modal-name" x-trap="selected">
                        <button type="button" class="team-modal-close" @click="close()" aria-label="Cerrar perfil"><x-icon name="x" :size="28" /></button>
                        <div class="team-modal-image"><img :src="selected.image" :alt="selected.name"></div>
                        <div class="team-modal-copy">
                            <div class="team-modal-heading">
                                <div><h2 id="team-modal-name" x-text="selected.name"></h2><h3 x-text="selected.role"></h3></div>
                                <a x-show="selected.linkedin" :href="selected.linkedin" target="_blank" rel="noreferrer" :aria-label="'LinkedIn de ' + selected.name" class="linkedin-badge">in</a>
                            </div>
                            <p class="team-modal-bio" x-text="selected.bio"></p>
                            <p class="team-modal-specialties" x-text="selected.specialties"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </section>
</x-layout>
