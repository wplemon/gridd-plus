/**
 * Color-deficiencies simulator.
 *
 * @since 1.0
 */
( function() {
	wp.customize.bind( 'ready', function() {
		jQuery( '#gridd-a11y-colorblindness-sim' ).appendTo( '#customize-footer-actions' );
		jQuery( '#gridd-a11y-colorblindness-sim' ).show();
		jQuery( '#gridd-color-deficiencies-simulator-trigger' ).on( 'click', function( e ) {
			var wrapper  = jQuery( '#gridd-color-deficiencies-sim-wrapper' ),
				expanded = wrapper.attr( 'aria-expanded' );
			e.preventDefault();
			if ( true === expanded || 'true' === expanded ) {
				wrapper.attr( 'aria-expanded', false );
				jQuery( '#gridd-color-deficiencies-simulator-trigger' ).removeClass( 'active' );
			} else {
				wrapper.attr( 'aria-expanded', true );
				jQuery( '#gridd-color-deficiencies-simulator-trigger' ).addClass( 'active' );
			}
		});
		jQuery( '#gridd-a11y-colorblindness-sim input' ).on( 'change click', function() {
			frames[0].jQuery( 'body' ).removeClass( 'accecss-protanopia accecss-protanomaly accecss-deuteranopia accecss-deuteranomaly accecss-tritanopia accecss-tritanomaly accecss-achromatopsia accecss-achromatomaly' );
			frames[0].jQuery( 'body' ).addClass( 'accecss-' + jQuery( '#gridd-a11y-colorblindness-sim input:checked' ).val() );
		});
	});
} () );
