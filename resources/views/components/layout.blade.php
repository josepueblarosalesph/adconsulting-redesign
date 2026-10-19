@props([
    'title' => 'AD Consulting | Seleccionamos y potenciamos el talento',
    'description' => 'Más de 15 años de experiencia en gestión de talento, Head Hunting, selección, capacitación y coaching ejecutivo.',
    'active' => 'Inicio',
    'black' => false,
])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="icon" href="/favicon.ico">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <a class="skip-link" href="#main">Saltar al contenido</a>
    <x-header :active="$active" />
    <main id="main" @class(['black-page' => $black])>
        {{ $slot }}
        <livewire:contact-form />
    </main>
    <x-footer />
    <a class="whatsapp-float" href="{{ config('site.whatsapp_url') }}" target="_blank" rel="noreferrer" aria-label="Contactar por WhatsApp"><svg class="whatsapp-icon" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M20.52 3.48A11.91 11.91 0 0 0 12.04 0C5.44 0 .07 5.37.06 11.97c0 2.11.55 4.17 1.6 5.99L0 24l6.2-1.63a11.99 11.99 0 0 0 5.83 1.49h.01c6.6 0 11.97-5.37 11.98-11.97a11.9 11.9 0 0 0-3.5-8.41ZM12.04 21.84a9.94 9.94 0 0 1-5.06-1.39l-.36-.21-3.68.96.98-3.58-.24-.37a9.9 9.9 0 0 1-1.52-5.28c0-5.49 4.47-9.96 9.96-9.96a9.9 9.9 0 0 1 7.05 2.92 9.9 9.9 0 0 1 2.92 7.05c0 5.49-4.47 9.96-9.95 9.96Zm5.46-7.46c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.1 3.21 5.09 4.5.71.3 1.27.48 1.7.61.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.34Z"/></svg></a>
    @livewireScriptConfig
</body>
</html>
