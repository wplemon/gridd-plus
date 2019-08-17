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
		add_action( 'wp_footer', [ $this, 'the_html' ] );

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
		<div class="scrolltop-wrap">
			<a id="scrollToTop" href="#">
				<svg height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
					<path id="scrolltop-bg" d="M0 0h48v48h-48z"></path>
					<path id="scrolltop-arrow" d="M14.83 30.83l9.17-9.17 9.17 9.17 2.83-2.83-12-12-12 12z"></path>
				</svg>
			</a>
		</div>
		<?php if ( ! AMP::is_active() ) : ?>
			<script>
			document.getElementById( 'scrollToTop' ).onclick = function( e ) {
				e.preventDefault();
				window.scroll( {
					top: 0,
					behavior: 'smooth'
				} );
			}
			</script>
		<?php endif; ?>
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
		if ( 'large' === get_theme_mod( 'gridd_enable_totop', 'hidden' ) ) {
			$style->add_string( '@media only screen and (max-width:' . esc_attr( $breakpoint ) . '){.gridd-scroll-totop{display:none;}}' );
		}
		$style->the_css( 'gridd-inline-css-totop' );
	}
}
