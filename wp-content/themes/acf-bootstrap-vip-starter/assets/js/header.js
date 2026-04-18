document.addEventListener( 'DOMContentLoaded', function () {

    const toggle = document.querySelector( '.mobile-toggle' );
    const menu   = document.querySelector( '.mobile-menu' );

    /* =========================
       MOBILE MENU TOGGLE
    ========================= */
    if ( toggle && menu ) {
        toggle.addEventListener( 'click', function () {
            menu.classList.toggle( 'active' );
        } );
    }

    /* =========================
       MOBILE SUBMENU TOGGLE
    ========================= */
    const submenuParents = document.querySelectorAll( '.menu-item-has-children > a' );

    submenuParents.forEach( function ( item ) {

        item.addEventListener( 'click', function ( e ) {

            if ( window.innerWidth < 992 ) {
                e.preventDefault();

                const parent = this.parentElement;
                parent.classList.toggle( 'submenu-open' );
            }

        } );

    } );

} );