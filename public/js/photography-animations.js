document.documentElement.classList.add('js-photo-animation');

document.addEventListener('DOMContentLoaded', () => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealItems = document.querySelectorAll('[data-photo-reveal]');
    const tiltCards = document.querySelectorAll('[data-photo-tilt]');

    if (!('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            });
        }, {
            threshold: 0.14,
            rootMargin: '0px 0px -72px 0px',
        });

        revealItems.forEach((item, index) => {
            if (!item.style.getPropertyValue('--photo-delay')) {
                item.style.setProperty('--photo-delay', `${Math.min(index * 55, 420)}ms`);
            }

            revealObserver.observe(item);
        });
    }

    if (reduceMotion || window.matchMedia('(pointer: coarse)').matches) return;

    tiltCards.forEach((card) => {
        card.addEventListener('pointermove', (event) => {
            const rect = card.getBoundingClientRect();
            const x = ((event.clientX - rect.left) / rect.width - 0.5) * 2;
            const y = ((event.clientY - rect.top) / rect.height - 0.5) * 2;

            card.style.setProperty('--photo-tilt-x', `${x * 3.5}deg`);
            card.style.setProperty('--photo-tilt-y', `${y * -3.5}deg`);
        });

        card.addEventListener('pointerleave', () => {
            card.style.setProperty('--photo-tilt-x', '0deg');
            card.style.setProperty('--photo-tilt-y', '0deg');
        });
    });
});
