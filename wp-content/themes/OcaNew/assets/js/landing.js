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
    nav.addEventListener('click', function (event) {
        if (event.target.closest('a')) closeMenu(false);
    });
    document.addEventListener('click', function (event) {
        if (!header.contains(event.target)) closeMenu(false);
    });
    header.addEventListener('focusout', function (event) {
        if (!header.contains(event.relatedTarget)) closeMenu(false);
    });
    window.matchMedia('(min-width: 1101px)').addEventListener('change', function () {
        closeMenu(false);
    });
});
