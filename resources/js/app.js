document.addEventListener('alpine:init', () => {
    Alpine.data('tiltCard', () => ({
        rotateX: 0,
        rotateY: 0,

        handleMove(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            this.rotateY = ((event.clientX - rect.left - centerX) / centerX) * 8;
            this.rotateX = -((event.clientY - rect.top - centerY) / centerY) * 8;
        },

        reset() {
            this.rotateX = 0;
            this.rotateY = 0;
        },
    }));

    Alpine.data('terminalToggle', () => ({
        view: 'profile',

        show(view) {
            this.view = view;
        },
    }));
});
