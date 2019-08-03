( function() {
    var headers = document.querySelectorAll( 'h1,h2,h3,h4,h5,h6' ),
    id,
    el,
    i;
for ( i = 0; i < headers.length; i++ ) {
    id = headers[ i ].getAttribute( 'id' );
    if ( id ) {
        el = document.createElement( 'a' );
        el.setAttribute( 'class', 'anchor-injected' );
        el.setAttribute( 'href', '#' + id );
        el.setAttribute( 'aria-label', 'section anchor link' );
        headers[ i ].appendChild( el );
    }
}
} () );
