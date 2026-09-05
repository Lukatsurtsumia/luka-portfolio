/**
 * Animated 3D fighter.
 *
 * Ported from the standalone pcn-fighter-3d viewer. This module is imported
 * dynamically, so three.js and the FBX loader are only fetched once a visitor
 * actually scrolls near the section - the rest of the site stays light.
 *
 * The renderer only draws while the mount is on screen.
 */
import * as THREE from 'three';
import { FBXLoader } from 'three/examples/jsm/loaders/FBXLoader.js';

export function initBoxer(mount) {
    if (mount.dataset.boxerReady === '1') return;
    mount.dataset.boxerReady = '1';

    let visible = true;
    let mixer, renderer, scene, camera, boxCenter, boxSize, frameId;
    const clock = new THREE.Clock();

    const w = Math.max(mount.clientWidth, 1);
    const h = Math.max(mount.clientHeight, 1);

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera(40, w / h, 1, 6000);

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.75));
    renderer.setSize(w, h);
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    mount.appendChild(renderer.domElement);

    scene.add(new THREE.HemisphereLight(0xffffff, 0x2a2418, 2.2));

    const key = new THREE.DirectionalLight(0xffffff, 2.4);
    key.position.set(120, 240, 180);
    scene.add(key);

    // Rim light in the site's gold rather than the original blue.
    const rim = new THREE.DirectionalLight(0xe0b64a, 1.8);
    rim.position.set(-160, 120, -140);
    scene.add(rim);

    // Reframe the whole figure for the container's current size. Called on
    // load and on any resize.
    function frame() {
        if (!boxSize || !renderer) return;
        const cw = Math.max(mount.clientWidth, 1);
        const ch = Math.max(mount.clientHeight, 1);
        const aspect = cw / ch;
        const vfov = (camera.fov * Math.PI) / 180;
        const distH = boxSize.y / 2 / Math.tan(vfov / 2);
        const distW = boxSize.x / 2 / (Math.tan(vfov / 2) * aspect);
        // Pull back further than the standalone viewer did: this stage has a
        // status line along the bottom edge, so the figure needs real margin
        // rather than filling the container to its feet.
        const dist = Math.max(distH, distW) * 1.6;
        // Aim slightly high so the head clears the top and the feet sit above
        // the caption instead of running into it.
        const ty = boxCenter.y + boxSize.y * 0.1;

        camera.aspect = aspect;
        camera.near = dist / 100;
        camera.far = dist * 100;
        camera.updateProjectionMatrix();
        camera.position.set(boxCenter.x, ty, boxCenter.z + dist);
        camera.lookAt(boxCenter.x, ty, boxCenter.z);
        renderer.setSize(cw, ch);
    }

    new ResizeObserver(frame).observe(mount);

    new FBXLoader().load(
        mount.dataset.model,
        (obj) => {
            // Tint the fighter to the site's bone/gold palette.
            obj.traverse((o) => {
                if (!o.isMesh || !o.material) return;
                const mats = Array.isArray(o.material) ? o.material : [o.material];
                mats.forEach((mt) => {
                    if (mt.color) mt.color.set(0xd8d2c6);
                    if ('emissive' in mt) mt.emissive.set(0x2a2010);
                    if ('shininess' in mt) mt.shininess = 24;
                    mt.needsUpdate = true;
                });
            });

            scene.add(obj);

            const bindBox = new THREE.Box3().setFromObject(obj);
            const bindC = bindBox.getCenter(new THREE.Vector3());
            const bindS = bindBox.getSize(new THREE.Vector3());

            if (obj.animations.length) {
                // Some Mixamo exports include an empty "Take 001" first, so
                // pick the clip with the most tracks - the real animation.
                const clip = obj.animations.reduce((a, b) =>
                    b.tracks.length > a.tracks.length ? b : a
                );
                mixer = new THREE.AnimationMixer(obj);
                mixer.clipAction(clip).play();

                // The animated pose can sit taller than the bind box, since
                // skinning is not reflected in it. Measure the real vertical
                // extent by sampling the skeleton across the clip.
                let minY = Infinity;
                let maxY = -Infinity;
                const p = new THREE.Vector3();
                for (let i = 0; i <= 5; i++) {
                    mixer.setTime((clip.duration * i) / 5);
                    obj.updateMatrixWorld(true);
                    obj.traverse((n) => {
                        if (!n.isBone) return;
                        n.getWorldPosition(p);
                        if (p.y < minY) minY = p.y;
                        if (p.y > maxY) maxY = p.y;
                    });
                }
                mixer.setTime(0);

                // Pad for the skull above the head bone and the boot below the ankle.
                const ext = maxY - minY;
                const top = maxY + ext * 0.12;
                const bottom = minY - ext * 0.05;
                boxCenter = new THREE.Vector3(bindC.x, (top + bottom) / 2, bindC.z);
                boxSize = new THREE.Vector3(bindS.x, top - bottom, bindS.z);
            } else {
                boxCenter = bindC;
                boxSize = bindS;
            }

            frame();
            mount.dataset.boxerLoaded = '1';
            mount.dispatchEvent(new CustomEvent('boxer:loaded', { bubbles: true }));
        },
        undefined,
        () => {
            // If the model cannot be fetched, leave the poster fallback in place.
            mount.dataset.boxerFailed = '1';
            mount.dispatchEvent(new CustomEvent('boxer:failed', { bubbles: true }));
        }
    );

    window.addEventListener('orientationchange', () => setTimeout(frame, 300));

    // Pause rendering whenever the fighter is off screen or the tab is hidden.
    try {
        new IntersectionObserver(
            (entries) => entries.forEach((e) => { visible = e.isIntersecting; }),
            { rootMargin: '150px' }
        ).observe(mount);
    } catch {
        /* no IntersectionObserver: just keep rendering */
    }

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) visible = false;
    });

    (function tick() {
        frameId = requestAnimationFrame(tick);
        if (!visible || !renderer) return;
        if (mixer) mixer.update(clock.getDelta());
        renderer.render(scene, camera);
    })();

    return () => cancelAnimationFrame(frameId);
}
