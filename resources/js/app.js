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

document.addEventListener('DOMContentLoaded', () => {
    const mobileNavToggle = document.querySelector('[data-nav-toggle]');
    const mobileNav = document.getElementById('mobile-navigation');

    updateNavigationState();
    updateHoverState();
    closeMobileNav(mobileNav, mobileNavToggle);

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
