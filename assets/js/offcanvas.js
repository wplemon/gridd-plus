var griddOffConvasWrapper = document.getElementById( 'offcanvas-wrapper' );
var griddOffCanvasTrigger = document.querySelector( '.toggle-gridd-plus-offcanvas-sidebar' );
griddOffConvasWrapper.addEventListener( 'focusout', function( e ) {
    if ( ! griddOffConvasWrapper.contains( e.relatedTarget ) && griddOffCanvasTrigger.classList.contains( 'toggled-on' ) ) {
        griddOffCanvasTrigger.click();
    }
});