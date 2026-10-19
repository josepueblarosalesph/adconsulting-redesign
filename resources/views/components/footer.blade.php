<footer class="footer">
    <div class="footer-statement"><h2>El éxito en una empresa radica en <em>seleccionar y potenciar</em> a las personas adecuadas para cada desafío.</h2></div>
    <div class="footer-directory">
        <div class="footer-intro">
            <x-brand />
            <p>Seleccionamos y potenciamos el talento de las organizaciones en todo Chile.</p>
            <a href="mailto:{{ config('site.contact_email') }}">{{ config('site.contact_email') }}</a>
        </div>
        <nav aria-label="Empresa">
            <h3>Empresa</h3>
            <a href="/">Inicio</a>
            <a href="/nosotros">Nosotros</a>
            <a href="/black">AD Black</a>
            <a href="/ad50">AD+50</a>
            <a href="/noticias">Actualidad</a>
        </nav>
        <nav aria-label="Servicios">
            <h3>Servicios</h3>
            <a href="/servicios#servicio-1">Head Hunting</a>
            <a href="/servicios#servicio-2">Reclutamiento y Selección</a>
            <a href="/servicios#servicio-3">Coaching y Desarrollo de habilidades de Liderazgo</a>
            <a href="/servicios#servicio-4">Outplacement</a>
            <a href="/servicios#servicio-5">Capacitaciones</a>
        </nav>
        <nav aria-label="Recursos">
            <h3>Recursos</h3>
            <a href="{{ \App\Support\SiteContent::JOBS_URL }}">Ofertas de Trabajo</a>
            <a href="https://www.linkedin.com/in/ariela-dymensztain-ad/">LinkedIn</a>
            <a href="/#contacto">Contacto</a>
        </nav>
    </div>
    <div class="footer-legal"><p>© {{ date('Y') }} AD Consulting · Chile</p></div>
</footer>
