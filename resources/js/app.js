const body = document.body;

const updateNavigationState = () => {
    body.dataset.navScrolled = window.scrollY > 8 ? 'true' : 'false';
};

document.addEventListener('DOMContentLoaded', () => {
    updateNavigationState();
    window.addEventListener('scroll', updateNavigationState, { passive: true });
});

window.addEventListener('load', updateNavigationState, { passive: true });
