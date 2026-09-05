/**
 * Scroll reveal.
 *
 * Elements marked .reveal fade up once as they enter the viewport. Anything
 * already on screen at load is revealed immediately so the hero never flashes
 * empty, and the whole thing is skipped when the visitor asks for less motion.
 */
let revealObserver = null;

function revealAll() {
    document.querySelectorAll('.reveal').forEach((el) => el.classList.add('is-in'));
}

/**
 * Arm every .reveal element that is not yet revealed.
 *
 * Livewire re-renders the project list on each filter change and morphs the
 * existing <article> in place, syncing its class attribute from the server
 * markup - which does not contain `is-in`. The element is stripped back to
 * opacity 0 without ever moving, so no new intersection event fires for it.
 *
 * So anything already within the viewport is revealed directly here, and only
 * genuinely off-screen elements are handed to the observer. Re-observing an
 * element the observer already watches is a no-op, so this is safe to call as
 * often as the DOM changes.
 */
function scanReveal() {
    if (!revealObserver) return;
    const vh = window.innerHeight || document.documentElement.clientHeight;

    document.querySelectorAll('.reveal:not(.is-in)').forEach((el) => {
        const rect = el.getBoundingClientRect();
        const onScreen = rect.top < vh * 0.92 && rect.bottom > 0;

        if (onScreen) {
            el.classList.add('is-in');
            revealObserver.unobserve(el);
            return;
        }

        revealObserver.observe(el);
    });
}

function initReveal() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced || !('IntersectionObserver' in window)) {
        revealAll();
        // Anything Livewire inserts later must be visible too.
        new MutationObserver(revealAll).observe(document.body, { childList: true, subtree: true });
        return;
    }

    revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-in');
                revealObserver.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );

    scanReveal();

    let queued = false;
    new MutationObserver(() => {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => {
            queued = false;
            scanReveal();
        });
    }).observe(document.body, {
        childList: true,
        subtree: true,
        // Class changes matter as much as inserted nodes: when a filter returns
        // the same number of cards, Livewire morphs them in place and only the
        // class attribute changes - stripping `is-in` without touching the DOM
        // tree. Watching childList alone misses exactly that case.
        attributes: true,
        attributeFilter: ['class'],
    });
}

document.addEventListener('DOMContentLoaded', initReveal);
document.addEventListener('livewire:navigated', scanReveal);

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
