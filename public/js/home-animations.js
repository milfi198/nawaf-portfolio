document.documentElement.classList.add('js-animation');

document.addEventListener('DOMContentLoaded', () => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const animatedItems = document.querySelectorAll('[data-animate]');
    const navLinks = document.querySelectorAll('.nav-link');
    const sectionLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    const sections = [...document.querySelectorAll('section[id]')];

    const setActiveNav = (hash) => {
        navLinks.forEach((link) => {
            const isActive = link.getAttribute('href') === hash;

            link.classList.toggle('text-primary', isActive);
            link.classList.toggle('border-primary', isActive);
            link.classList.toggle('text-on-surface-variant', !isActive);
            link.classList.toggle('border-transparent', !isActive);
        });
    };

    const scrollToSection = (target) => {
        const navbarHeight = document.querySelector('nav')?.offsetHeight ?? 72;
        const targetTop = target.getBoundingClientRect().top + window.scrollY - navbarHeight;

        window.scrollTo({
            top: Math.max(targetTop, 0),
            behavior: reduceMotion ? 'auto' : 'smooth',
        });
    };

    if (!('IntersectionObserver' in window)) {
        animatedItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            });
        }, {
            threshold: 0.16,
            rootMargin: '0px 0px -64px 0px',
        });

        animatedItems.forEach((item) => revealObserver.observe(item));
    }

    sectionLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const hash = link.getAttribute('href');
            const target = hash ? document.querySelector(hash) : null;

            if (!target) return;

            event.preventDefault();
            history.pushState(null, '', hash);
            setActiveNav(hash);
            scrollToSection(target);
        });
    });

    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);

        if (target) {
            setActiveNav(window.location.hash);
            requestAnimationFrame(() => scrollToSection(target));
        }
    }

    if ('IntersectionObserver' in window && sections.length > 0) {
        const sectionObserver = new IntersectionObserver((entries) => {
            const visibleSection = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (!visibleSection) return;

            setActiveNav(`#${visibleSection.target.id}`);
        }, {
            rootMargin: '-35% 0px -50% 0px',
            threshold: [0.1, 0.35, 0.6],
        });

        sections.forEach((section) => sectionObserver.observe(section));
    }

    const tiltCard = document.querySelector('[data-tilt-card]');

    if (!tiltCard || reduceMotion) return;

    tiltCard.addEventListener('pointermove', (event) => {
        const rect = tiltCard.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width - 0.5) * 2;
        const y = ((event.clientY - rect.top) / rect.height - 0.5) * 2;

        tiltCard.style.setProperty('--tilt-x', `${x * 7}deg`);
        tiltCard.style.setProperty('--tilt-y', `${y * -7}deg`);
    });

    tiltCard.addEventListener('pointerleave', () => {
        tiltCard.style.setProperty('--tilt-x', '0deg');
        tiltCard.style.setProperty('--tilt-y', '0deg');
    });
});
