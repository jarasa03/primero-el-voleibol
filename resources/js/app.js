const body = document.body;

const updateNavigationState = () => {
    body.dataset.navScrolled = window.scrollY > 8 ? 'true' : 'false';
};

const updateHoverState = () => {
    const supportsHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    body.dataset.hoverEnabled = window.innerWidth >= 768 && supportsHover ? 'true' : 'false';
};

const closeMobileNav = (mobileNav, mobileNavToggle) => {
    body.dataset.mobileNavOpen = 'false';

    if (mobileNavToggle instanceof HTMLButtonElement) {
        mobileNavToggle.setAttribute('aria-expanded', 'false');
        mobileNavToggle.setAttribute('aria-label', 'Abrir menú');
    }

    if (mobileNav instanceof HTMLElement) {
        mobileNav.setAttribute('aria-hidden', 'true');
    }
};

const openMobileNav = (mobileNav, mobileNavToggle) => {
    body.dataset.mobileNavOpen = 'true';

    if (mobileNavToggle instanceof HTMLButtonElement) {
        mobileNavToggle.setAttribute('aria-expanded', 'true');
        mobileNavToggle.setAttribute('aria-label', 'Cerrar menú');
    }

    if (mobileNav instanceof HTMLElement) {
        mobileNav.setAttribute('aria-hidden', 'false');
    }
};

const setupProgramAccordion = () => {
    document.querySelectorAll('[data-program-accordion]').forEach((details) => {
        const summary = details.querySelector('summary');
        const panel = details.querySelector('[data-program-panel]');

        if (!(summary instanceof HTMLElement) || !(panel instanceof HTMLElement)) {
            return;
        }

        let isClosing = false;
        let isOpening = false;

        const openDetails = () => {
            if (details.open) {
                return;
            }

            isOpening = true;
            isClosing = false;
            details.open = true;
            panel.style.overflow = 'hidden';
            panel.style.opacity = '0';
            panel.style.maxHeight = '0px';
            panel.offsetHeight;

            requestAnimationFrame(() => {
                panel.style.maxHeight = `${panel.scrollHeight}px`;
                panel.style.opacity = '1';
            });
        };

        const closeDetails = () => {
            if (!details.open) {
                return;
            }

            isClosing = true;
            isOpening = false;
            panel.style.overflow = 'hidden';
            panel.style.maxHeight = `${panel.scrollHeight}px`;
            panel.style.opacity = '1';
            panel.offsetHeight;

            requestAnimationFrame(() => {
                panel.style.maxHeight = '0px';
                panel.style.opacity = '0';
            });
        };

        summary.addEventListener('click', (event) => {
            event.preventDefault();

            if (details.open) {
                closeDetails();
                return;
            }

            openDetails();
        });

        panel.addEventListener('transitionend', (event) => {
            if (event.propertyName !== 'max-height') {
                return;
            }

            if (isOpening) {
                panel.style.maxHeight = 'none';
                panel.style.opacity = '1';
                panel.style.overflow = 'visible';
                isOpening = false;
            }

            if (isClosing) {
                details.open = false;
                panel.style.maxHeight = '0px';
                panel.style.opacity = '0';
                panel.style.overflow = 'hidden';
                isClosing = false;
            }
        });

        if (details.open) {
            panel.style.maxHeight = 'none';
            panel.style.opacity = '1';
            panel.style.overflow = 'visible';
        } else {
            panel.style.maxHeight = '0px';
            panel.style.opacity = '0';
            panel.style.overflow = 'hidden';
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const mobileNavToggle = document.querySelector('[data-nav-toggle]');
    const mobileNav = document.getElementById('mobile-navigation');

    updateNavigationState();
    updateHoverState();
    closeMobileNav(mobileNav, mobileNavToggle);
    setupProgramAccordion();

    window.addEventListener('scroll', updateNavigationState, { passive: true });

    if (mobileNavToggle instanceof HTMLButtonElement && mobileNav instanceof HTMLElement) {
        mobileNavToggle.addEventListener('click', () => {
            if (body.dataset.mobileNavOpen !== 'true') {
                openMobileNav(mobileNav, mobileNavToggle);
                return;
            }

            closeMobileNav(mobileNav, mobileNavToggle);
        });

        mobileNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                closeMobileNav(mobileNav, mobileNavToggle);
            });
        });
    }

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMobileNav(mobileNav, mobileNavToggle);
        }
    });

    window.addEventListener('resize', () => {
        updateHoverState();

        if (window.innerWidth >= 768) {
            closeMobileNav(mobileNav, mobileNavToggle);
        }
    });
});

window.addEventListener('load', updateNavigationState, { passive: true });
window.addEventListener('load', updateHoverState, { passive: true });
