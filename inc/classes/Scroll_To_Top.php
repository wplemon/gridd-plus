<?php
/**
 * CSS-Only Scroll-To-Top button.
 *
 * @package Gridd Plus
 */

namespace Gridd_Plus;

use Gridd\Style;
use Gridd\AMP;

/**
 * Implements the Scroll-To-Top button.
 *
 * @since 1.0
 */
class Scroll_To_Top {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {

		// Early exit if we don't want the button.
		if ( 'hidden' === get_theme_mod( 'gridd_enable_totop', 'hidden' ) ) {
			return;
		}

		// Add the HTML in the footer.
		add_action( 'wp_footer', [ $this, 'the_html' ], 999 );

		// Add the CSS in the footer.
		add_action( 'wp_footer', [ $this, 'the_css' ] );
	}

	/**
	 * Generate the HTML for the scroll-to-top-button.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function the_html() {
		?>
		<div class="scrolltop-wrap" aria-hidden="true">
			<a id="scrollToTop" href="#">⌵</a>
		</div>
		<script>
		window.addEventListener( 'scroll', function() {
			let showScroll = ( window.scrollY > 1.5 * screen.height );

			setTimeout( function() {
				if ( ! showScroll ) {
					document.body.classList.remove( 'gridd-scroll-to-top' );
				} else {
					document.body.classList.add( 'gridd-scroll-to-top' )
				}
			}, 50 );
		} );
		document.getElementById( 'scrollToTop' ).onclick = function( e ) {
			e.preventDefault();
			window.scroll( { top: 0, behavior: 'smooth' } );
		}
		</script>
		<?php
	}

	/**
	 * Add the CSS for the scroll-to-top-button.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function the_css() {
		$breakpoint = get_theme_mod( 'gridd_mobile_breakpoint', '800px' );

		$style = Style::get_instance( 'scroll-to-top' );
		$style->add_file( GRIDD_PLUS_PATH . '/assets/css/totop.min.css' );
		$style->add_string( '@media only screen and (max-width:' . esc_attr( $breakpoint ) . '){.scrolltop-wrap{display:none;}}' );
		$style->the_css( 'gridd-inline-css-totop' );
	}
}
