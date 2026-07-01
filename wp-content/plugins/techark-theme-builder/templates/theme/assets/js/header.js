document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.querySelector('.mobile-toggle');
    const menu   = document.querySelector('.mobile-menu');

    if (toggle && menu) {

        // Set initial ARIA state
        if (!menu.id) {
            menu.id = 'mobile-menu';
        }
        toggle.setAttribute('aria-controls', menu.id);
        toggle.setAttribute('aria-expanded', 'false');

        if (!toggle.getAttribute('aria-label')) {
            toggle.setAttribute('aria-label', 'Toggle navigation menu');
        }

        toggle.addEventListener('click', function () {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!isExpanded));
            menu.classList.toggle('active');
        });
    }

    // Submenu toggle
    document.querySelectorAll('.submenu-toggle').forEach(function (btn) {

        // Set initial ARIA
        const submenu = btn.nextElementSibling;
        if (submenu) {
            if (!submenu.id) {
                submenu.id = 'submenu-' + Math.random().toString(36).substr(2, 6);
            }
            btn.setAttribute('aria-controls', submenu.id);
            btn.setAttribute('aria-expanded', 'false');
            btn.setAttribute('aria-label', 'Toggle submenu');
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!isExpanded));
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });

    });

});