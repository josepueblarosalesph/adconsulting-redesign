<section class="section contact" id="contacto">
    <div class="reveal">
        <p class="eyebrow">CONECTEMOS</p>
        <h2>Hablemos<span class="dot">.</span></h2>
        <p>Déjanos tus datos y te contactaremos lo antes posible</p>
        <p class="contact-email">{{ config('site.contact_email') }}</p>
    </div>
    <form wire:submit="submit" novalidate>
        <div class="form-grid">
            @foreach ($fields as [$property, $label, $type, $autocomplete])
                <label wire:key="contact-{{ $property }}">{{ $label }}
                    <input wire:model="{{ $property }}" name="{{ $label }}" type="{{ $type }}" autocomplete="{{ $autocomplete }}" placeholder="Ingresa tu {{ mb_strtolower($label) }}" required maxlength="150" @error($property) aria-invalid="true" @enderror>
                    @error($property)<small class="form-error">{{ $message }}</small>@enderror
                </label>
            @endforeach
            <label class="hp-field" aria-hidden="true">Sitio web<input wire:model="website" type="text" tabindex="-1" autocomplete="off"></label>
        </div>
        <div class="form-bottom">
            <button type="submit" class="button" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">¡Conectemos!</span><span wire:loading wire:target="submit">Enviando…</span>
                <x-icon name="arrow-up-right" :size="22" />
            </button>
        </div>
        @if ($status === 'sent')
            <p class="form-status" role="status">¡Gracias! Recibimos tus datos y te contactaremos lo antes posible.</p>
        @elseif ($status === 'throttled')
            <p class="form-status" role="status">Recibimos varios mensajes seguidos. Inténtalo de nuevo en unos minutos o escríbenos a <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.</p>
        @elseif ($status === 'error')
            <p class="form-status" role="status">No pudimos enviar tu mensaje. Escríbenos directamente a <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>.</p>
        @endif
    </form>
</section>
