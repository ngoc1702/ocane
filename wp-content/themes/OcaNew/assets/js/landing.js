(function () {
    var root = document.querySelector('.oca-home-landing');
    var motion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (!root || motion.matches || !('IntersectionObserver' in window)) return;

    var selector = [
        '.oca-hero__copy', '.oca-hero__visual',
        '.oca-about__copy', '.oca-about__visual',
        '.oca-reasons__title', '.oca-reasons__description', '.oca-reasons__visual', '.oca-reasons__item',
        '.oca-ingredients__heading', '.oca-ingredients__center', '.oca-ingredients__node',
        '.oca-preparation__heading', '.oca-preparation__step',
        '.oca-improvement__heading', '.oca-improvement__sample',
        '.oca-faq .oca-section-title', '.oca-faq__item', '.oca-faq__visual',
        '.oca-expert__visual', '.oca-expert__copy',
        '.oca-footer__column', '.oca-footer__copyright'
    ].join(',');
    var items = Array.from(root.querySelectorAll(selector));
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.08 });

    items.forEach(function (item) {
        var box = item.getBoundingClientRect();
        // Leave the initial viewport visible and preserve existing transforms.
        if (box.bottom > 0 && box.top < window.innerHeight) return;
        var siblings = Array.from(item.parentElement.children).filter(function (child) {
            return child.matches(selector);
        });
        item.style.setProperty('--oca-reveal-delay', Math.min(siblings.indexOf(item), 3) * 65 + 'ms');
        item.classList.add('oca-reveal');
        observer.observe(item);
    });

    function revealAll() {
        observer.disconnect();
        items.forEach(function (item) { item.classList.add('is-visible'); });
    }
    motion.addEventListener('change', function (event) {
        if (event.matches) revealAll();
    });
    root.addEventListener('focusin', function (event) {
        var item = event.target.closest('.oca-reveal');
        if (item) {
            item.classList.add('is-visible');
            observer.unobserve(item);
        }
    });
    window.addEventListener('beforeprint', revealAll);
})();

document.querySelectorAll('.oca-header').forEach(function (header) {
    var toggle = header.querySelector('.oca-menu-toggle');
    var nav = header.querySelector('.oca-navigation');
    if (!toggle || !nav) return;
    toggle.hidden = false;
    header.classList.add('oca-header--interactive');

    function closeMenu(restoreFocus) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Mở menu');
        header.classList.remove('oca-header--open');
        measureHeader();
        if (restoreFocus) toggle.focus();
    }

    toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') !== 'true';
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
        header.classList.toggle('oca-header--open', open);
    });
    header.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') closeMenu(true);
    });
    document.addEventListener('click', function (event) {
        if (!header.contains(event.target)) closeMenu(false);
    });
    header.addEventListener('focusout', function (event) {
        if (!header.contains(event.relatedTarget)) closeMenu(false);
    });
    window.matchMedia('(min-width: 1281px)').addEventListener('change', function () {
        closeMenu(false);
    });

    var body = document.body;
    var headerHeight = header.getBoundingClientRect().height;
    var adminOffset = 0;
    var frame = 0;
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    var links = Array.from(nav.querySelectorAll('a[href]'));
    var sections = [];

    function anchorTarget(link) {
        var url = new URL(link.href, window.location.href);
        if (url.origin !== window.location.origin || url.pathname !== window.location.pathname || !url.hash) return null;
        try {
            return document.getElementById(decodeURIComponent(url.hash.slice(1)));
        } catch (error) {
            return null;
        }
    }

    links.forEach(function (link) {
        var target = anchorTarget(link);
        if (target) sections.push({ link: link, target: target });
    });

    function measureHeader() {
        if (!header.classList.contains('oca-header--open')) {
            headerHeight = header.getBoundingClientRect().height;
            body.style.setProperty('--oca-header-height', headerHeight + 'px');
        }
    }

    function updateActive() {
        frame = 0;
        var admin = document.getElementById('wpadminbar');
        adminOffset = admin ? Math.max(0, admin.getBoundingClientRect().bottom) : 0;
        body.style.setProperty('--oca-admin-offset', adminOffset + 'px');
        var current = null;
        var highest = -Infinity;
        sections.forEach(function (section) {
            var top = section.target.getBoundingClientRect().top;
            if (top <= headerHeight + adminOffset + 32 && top > highest) {
                current = section;
                highest = top;
            }
        });
        if (!current && sections.length) current = sections[0];
        links.forEach(function (link) {
            var active = current && link === current.link;
            link.classList.toggle('is-active', Boolean(active));
            if (active) link.setAttribute('aria-current', 'location');
            else link.removeAttribute('aria-current');
        });
    }

    function scheduleActive() {
        if (!frame) frame = window.requestAnimationFrame(updateActive);
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('a[href]');
        if (!link || link.classList.contains('oca-skip') || link.hasAttribute('download') || link.target === '_blank' || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        var target = anchorTarget(link);
        if (!target) return;
        event.preventDefault();
        closeMenu(false);
        updateActive();
        var top = Math.max(0, window.scrollY + target.getBoundingClientRect().top - headerHeight - adminOffset - 16);
        window.scrollTo({ top: top, behavior: reducedMotion.matches ? 'instant' : 'smooth' });
        if (window.location.hash !== link.hash) window.history.pushState(null, '', link.hash);
        if (!target.hasAttribute('tabindex')) target.setAttribute('tabindex', '-1');
        target.focus({ preventScroll: true });
    });

    window.addEventListener('scroll', scheduleActive, { passive: true });
    window.addEventListener('resize', function () {
        measureHeader();
        scheduleActive();
    });
    window.addEventListener('hashchange', scheduleActive);
    window.addEventListener('load', function () {
        measureHeader();
        scheduleActive();
    });
    if ('ResizeObserver' in window) {
        new ResizeObserver(function () {
            measureHeader();
            scheduleActive();
        }).observe(header);
    }
    measureHeader();
    updateActive();
});
