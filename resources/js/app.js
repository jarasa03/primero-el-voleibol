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

const setupProgramBentoLayout = () => {
    const bento = document.querySelector('[data-program-bento]');

    if (!(bento instanceof HTMLElement)) {
        return;
    }

    const wideScreenQuery = window.matchMedia('(min-width: 1390px)');
    let scheduledFrame = null;
    let isStacked = false;

    const updateLayout = () => {
        const shouldStack = ! wideScreenQuery.matches;

        if (shouldStack === isStacked) {
            return;
        }

        isStacked = shouldStack;
        bento.classList.toggle('lg:columns-1', isStacked);
        bento.classList.toggle('lg:columns-2', ! isStacked);
    };

    const scheduleUpdate = () => {
        if (scheduledFrame !== null) {
            window.cancelAnimationFrame(scheduledFrame);
        }

        scheduledFrame = window.requestAnimationFrame(() => {
            scheduledFrame = null;
            updateLayout();
        });
    };

    window.addEventListener('resize', scheduleUpdate, { passive: true });

    if (document.fonts instanceof FontFaceSet) {
        document.fonts.ready.then(scheduleUpdate).catch(() => {});
    }

    updateLayout();
};

const setupBlogInfiniteScroll = () => {
    const feed = document.querySelector('[data-blog-feed]');

    if (!(feed instanceof HTMLElement)) {
        return;
    }

    const list = feed.querySelector('[data-blog-feed-list]');
    const sentinel = feed.querySelector('[data-blog-feed-sentinel]');
    const endStatus = feed.querySelector('[data-blog-feed-status-end]');

    if (!(list instanceof HTMLElement) || !(sentinel instanceof HTMLElement)) {
        return;
    }

    let nextUrl = feed.dataset.nextUrl ?? '';
    let isLoading = false;
    let observer;

    const createSkeletonMarkup = (count = 3) =>
        Array.from({ length: count }, (_, index) => `
            <article data-blog-feed-skeleton class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                <div class="animate-pulse">
                    <div class="aspect-[4/3] bg-slate-200"></div>
                    <div class="space-y-4 p-6">
                        <div class="h-3 w-24 rounded-full bg-slate-200"></div>
                        <div class="space-y-3">
                            <div class="h-6 w-5/6 rounded-full bg-slate-200"></div>
                            <div class="h-6 w-3/4 rounded-full bg-slate-200"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="h-4 w-full rounded-full bg-slate-200"></div>
                            <div class="h-4 w-4/5 rounded-full bg-slate-200"></div>
                        </div>
                        <div class="h-4 w-20 rounded-full bg-slate-200"></div>
                    </div>
                </div>
            </article>
        `).join('');

    const removeSkeletons = () => {
        list.querySelectorAll('[data-blog-feed-skeleton]').forEach((skeleton) => {
            skeleton.remove();
        });
    };

    const showEndButton = () => {
        if (endStatus instanceof HTMLElement) {
            endStatus.classList.remove('hidden');
        }
    };

    const loadMore = async () => {
        if (!nextUrl || isLoading) {
            return;
        }

        isLoading = true;
        feed.dataset.loading = 'true';
        list.insertAdjacentHTML('beforeend', createSkeletonMarkup());

        try {
            const response = await fetch(nextUrl, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error('Unable to load the next blog posts page.');
            }

            const payload = await response.json();
            removeSkeletons();

            if (typeof payload.html === 'string' && payload.html.trim() !== '') {
                list.insertAdjacentHTML('beforeend', payload.html);
            }

            nextUrl = typeof payload.next_url === 'string' ? payload.next_url : '';
            feed.dataset.nextUrl = nextUrl;

            if (!nextUrl) {
                observer.disconnect();
                showEndButton();
                return;
            }
        } catch (error) {
            console.error(error);
            removeSkeletons();
        } finally {
            removeSkeletons();
            isLoading = false;
            feed.dataset.loading = 'false';
        }
    };

    if (!nextUrl) {
        showEndButton();
        return;
    }

    if (!('IntersectionObserver' in window)) {
        return;
    }

    observer = new IntersectionObserver((entries) => {
        if (entries.some((entry) => entry.isIntersecting)) {
            loadMore();
        }
    }, {
        rootMargin: '800px 0px',
    });

    observer.observe(sentinel);
};

const setupParticipationForm = () => {
    const form = document.querySelector('[data-participation-form]');

    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    const identityField = form.querySelector('[data-participation-identity-field]');
    const nameInput = form.querySelector('[data-participation-name]');
    const emailInput = form.querySelector('[data-participation-email]');
    const preferenceInputs = Array.from(form.querySelectorAll('[data-response-preference]'));

    if (
        !(identityField instanceof HTMLElement)
        || !(nameInput instanceof HTMLInputElement)
        || !(emailInput instanceof HTMLInputElement)
        || preferenceInputs.length === 0
    ) {
        return;
    }

    const syncEmailField = () => {
        const selectedPreference = preferenceInputs.find((input) => input instanceof HTMLInputElement && input.checked);
        const isPrivate = selectedPreference instanceof HTMLInputElement ? selectedPreference.value === 'private' : false;

        identityField.hidden = isPrivate;
        nameInput.disabled = isPrivate;
        emailInput.disabled = isPrivate;
        nameInput.required = !isPrivate;
        emailInput.required = !isPrivate;

        if (isPrivate) {
            nameInput.value = '';
            emailInput.value = '';
        }
    };

    preferenceInputs.forEach((input) => {
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        input.addEventListener('change', syncEmailField);
    });

    syncEmailField();
};

const setupLeaderPhotoCarousels = () => {
    document.querySelectorAll('[data-leader-carousel]').forEach((carousel) => {
        if (!(carousel instanceof HTMLElement)) {
            return;
        }

        const slides = Array.from(carousel.querySelectorAll('[data-leader-slide]')).filter((slide) => slide instanceof HTMLElement);

        if (slides.length <= 1) {
            return;
        }

        const interval = Number(carousel.dataset.leaderCarouselInterval ?? 5000);
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let currentIndex = Math.max(0, slides.findIndex((slide) => slide.dataset.active === 'true'));
        let isTransitioning = false;
        let autoplayTimer = null;
        let isPaused = false;

        slides.forEach((slide, index) => {
            slide.classList.toggle('is-active', index === currentIndex);
            slide.classList.toggle('is-hidden', index !== currentIndex);
        });

        if (prefersReducedMotion) {
            return;
        }

        const stopAutoplay = () => {
            if (autoplayTimer === null) {
                return;
            }

            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        };

        const startAutoplay = () => {
            if (autoplayTimer !== null || isPaused) {
                return;
            }

            autoplayTimer = window.setInterval(showNextSlide, interval);
        };

        const pauseCarousel = () => {
            isPaused = true;
            stopAutoplay();
        };

        const resumeCarousel = () => {
            if (!isPaused) {
                return;
            }

            isPaused = false;
            startAutoplay();
        };

        const showNextSlide = () => {
            if (isTransitioning || slides.length <= 1 || isPaused) {
                return;
            }

            isTransitioning = true;

            const nextIndex = (currentIndex + 1) % slides.length;
            const currentSlide = slides[currentIndex];
            const nextSlide = slides[nextIndex];

            nextSlide.classList.remove('is-hidden');
            nextSlide.classList.add('is-entering');
            nextSlide.offsetHeight;

            requestAnimationFrame(() => {
                currentSlide.classList.add('is-exiting');
                currentSlide.classList.remove('is-active');

                nextSlide.classList.add('is-active');
                nextSlide.classList.remove('is-entering');
            });

            window.setTimeout(() => {
                currentSlide.classList.remove('is-exiting');
                currentSlide.classList.add('is-hidden');
                currentIndex = nextIndex;
                isTransitioning = false;
            }, 450);
        };

        carousel.addEventListener('mouseenter', pauseCarousel);
        carousel.addEventListener('mouseleave', resumeCarousel);
        carousel.addEventListener('focusin', pauseCarousel);
        carousel.addEventListener('focusout', resumeCarousel);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                carousel.classList.add('is-ready');
                startAutoplay();
            });
        });
    });
};

const setupInfiniteMarquees = () => {
    document.querySelectorAll('[data-marquee-speed]').forEach((viewport) => {
        if (!(viewport instanceof HTMLElement)) {
            return;
        }

        const track = viewport.querySelector('.marquee-track');
        const groups = track instanceof HTMLElement
            ? Array.from(track.querySelectorAll('.marquee-group')).filter((group) => group instanceof HTMLElement)
            : [];

        if (!(track instanceof HTMLElement) || groups.length < 2) {
            return;
        }

        const primaryGroup = groups[0];
        const secondaryGroup = groups[1];
        const shouldAutofill = viewport.dataset.marqueeAutofill === 'true';
        const autofillMultiplier = Number(viewport.dataset.marqueeAutofillMultiplier ?? 1.35);
        const baseItems = Array.from(primaryGroup.children).map((child) => child.cloneNode(true));
        let scheduledFrame = null;

        const fillGroups = () => {
            if (!shouldAutofill || baseItems.length === 0) {
                return;
            }

            primaryGroup.replaceChildren(...baseItems.map((child) => child.cloneNode(true)));

            let safetyCounter = 0;
            const minWidth = Math.max(viewport.clientWidth, window.innerWidth) * autofillMultiplier;

            while ((primaryGroup.scrollWidth < minWidth) && (safetyCounter < 20)) {
                primaryGroup.append(...baseItems.map((child) => child.cloneNode(true)));
                safetyCounter += 1;
            }

            secondaryGroup.replaceChildren(...Array.from(primaryGroup.children).map((child) => child.cloneNode(true)));
        };

        const updateDuration = () => {
            fillGroups();

            const speed = Number(viewport.dataset.marqueeSpeed ?? 50);
            const groupWidth = primaryGroup.scrollWidth || primaryGroup.getBoundingClientRect().width;

            if (groupWidth <= 0 || speed <= 0) {
                return;
            }

            const duration = Math.max(12, groupWidth / speed);
            track.style.setProperty('--marquee-duration', `${duration}s`);
        };

        const scheduleUpdate = () => {
            if (scheduledFrame !== null) {
                window.cancelAnimationFrame(scheduledFrame);
            }

            scheduledFrame = window.requestAnimationFrame(() => {
                scheduledFrame = null;
                updateDuration();
            });
        };

        scheduleUpdate();
        window.addEventListener('resize', scheduleUpdate, { passive: true });

        if (document.fonts instanceof FontFaceSet) {
            document.fonts.ready.then(scheduleUpdate).catch(() => {});
        }
    });
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

    setupProgramAccordion();

    try {
    setupProgramBentoLayout();
    } catch (error) {
        console.error(error);
    }

    setupBlogInfiniteScroll();
    setupParticipationForm();
    setupLeaderPhotoCarousels();
    setupInfiniteMarquees();
});

window.addEventListener('load', updateNavigationState, { passive: true });
window.addEventListener('load', updateHoverState, { passive: true });
