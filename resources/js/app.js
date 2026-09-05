/**
 * Scroll reveal.
 *
 * Elements marked .reveal fade up once as they enter the viewport. Anything
 * already on screen at load is revealed immediately so the hero never flashes
 * empty, and the whole thing is skipped when the visitor asks for less motion.
 */
function initReveal() {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-in'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );

    items.forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', initReveal);

// Livewire swaps DOM on filter changes; re-arm the new nodes.
document.addEventListener('livewire:navigated', initReveal);
document.addEventListener('livewire:update', initReveal);

/**
 * Easter egg: press `~` for a terminal readout of the same data the page shows.
 * Developers find it; recruiters never trip over it.
 */
document.addEventListener('keydown', (event) => {
    if (event.key !== '~' || event.metaKey || event.ctrlKey || event.altKey) return;

    const tag = document.activeElement?.tagName;
    if (tag === 'INPUT' || tag === 'TEXTAREA') return;

    const panel = document.getElementById('terminal-egg');
    if (panel) panel.hidden = !panel.hidden;
});
