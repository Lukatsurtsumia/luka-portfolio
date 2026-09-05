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
 * 3D fighter, loaded on demand.
 *
 * three.js, the FBX loader and a 1.9MB model are a lot to ask of a visitor who
 * may never scroll that far, so nothing is fetched until the section is close
 * to the viewport. Until then the mount shows a static poster frame.
 *
 * Visitors who ask for reduced motion keep the poster and never load any of it.
 */
function initBoxer3d() {
    const mount = document.querySelector('[data-boxer-3d]');
    if (!mount || mount.dataset.boxerReady === '1') return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        mount.closest('[data-boxer-stage]')?.setAttribute('data-state', 'static');
        return;
    }

    const stage = mount.closest('[data-boxer-stage]');

    const start = () => {
        stage?.setAttribute('data-state', 'loading');
        import('./boxer.js')
            .then(({ initBoxer }) => initBoxer(mount))
            .catch(() => stage?.setAttribute('data-state', 'static'));
    };

    mount.addEventListener('boxer:loaded', () => stage?.setAttribute('data-state', 'ready'));
    mount.addEventListener('boxer:failed', () => stage?.setAttribute('data-state', 'static'));

    if (!('IntersectionObserver' in window)) {
        start();
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                observer.disconnect();
                start();
            });
        },
        { rootMargin: '400px 0px' }
    );

    observer.observe(mount);
}

document.addEventListener('DOMContentLoaded', initBoxer3d);

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
