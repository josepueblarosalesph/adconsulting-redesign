import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

/* Menú lateral móvil */
Alpine.data('mobileMenu', () => ({
    visible: false,
    state: null,
    timer: null,
    show() {
        clearTimeout(this.timer);
        this.visible = true;
        this.state = 'starting';
        requestAnimationFrame(() => requestAnimationFrame(() => (this.state = null)));
    },
    close() {
        if (!this.visible || this.state === 'ending') return;
        this.state = 'ending';
        this.timer = setTimeout(() => {
            this.visible = false;
            this.state = null;
        }, 650);
    },
}));

/* Video de portada con sonido (si el navegador lo permite) */
Alpine.data('heroVideo', () => ({
    muted: false,
    init() {
        const video = this.$refs.video;
        if (!video) return;
        video.muted = false;
        video.volume = 1;
        video.play().catch(() => {
            video.muted = true;
            this.muted = true;
            video.play().catch(() => {});
        });
        setTimeout(() => this.$root.classList.add('hero-copy-hidden'), 7000);
    },
    toggleSound() {
        const video = this.$refs.video;
        video.muted = !video.muted;
        this.muted = video.muted;
        video.play().catch(() => {});
    },
}));

/* Modal de perfiles del equipo */
Alpine.data('teamGrid', (members) => ({
    members,
    selected: null,
    open(index) {
        this.selected = this.members[index];
        document.body.style.overflow = 'hidden';
    },
    close() {
        this.selected = null;
        document.body.style.overflow = '';
    },
}));

/* Animación de aparición al hacer scroll */
const revealObserver = new IntersectionObserver(
    (entries) =>
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        }),
    { threshold: 0.08 },
);

const observeReveals = (root) => {
    if (!(root instanceof Element)) return;
    if (root.matches('.reveal:not(.visible)')) revealObserver.observe(root);
    root.querySelectorAll('.reveal:not(.visible)').forEach((el) => revealObserver.observe(el));
};

document.addEventListener('DOMContentLoaded', () => observeReveals(document.body));

// Livewire re-renderiza desde el servidor: conserva los elementos ya revelados
// y observa los nuevos (por ejemplo, al cargar más Experiencias).
Livewire.hook('morph.updating', ({ el, toEl }) => {
    if (el instanceof Element && toEl instanceof Element && el.classList.contains('visible')) {
        toEl.classList.add('visible');
    }
});
Livewire.hook('morph.added', ({ el }) => observeReveals(el));

Livewire.start();
