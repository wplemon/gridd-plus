document.getElementById( 'offcanvas-wrapper' ).addEventListener( 'focusout', function( e ) {
    if (
        ! document.getElementById( 'offcanvas-wrapper' ).contains( e.relatedTarget ) &&
        document.querySelector( '.toggle-gridd-plus-offcanvas-sidebar' ).classList.contains( 'toggled-on' )
    ) {
        document.querySelector( '.toggle-gridd-plus-offcanvas-sidebar' ).click();
    }
});