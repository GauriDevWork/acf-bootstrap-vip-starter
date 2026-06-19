document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.querySelector('.mobile-toggle');
    const menu = document.querySelector('.mobile-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            menu.classList.toggle('active');
        });
    }

    // Submenu toggle click
    document.querySelectorAll('.submenu-toggle').forEach(function (btn) {

        btn.addEventListener('click', function (e) {

            e.stopPropagation();

            const parent = this.parentElement;
            parent.classList.toggle('open');

        });

    });

});