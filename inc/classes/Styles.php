<?php
/**
 * Styles for Gridd Plus.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

use Gridd\Style;

/**
 * The Styles object.
 *
 * @since 1.0
 */
class Styles {

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'gridd_style', [ $this, 'gridd_style' ] );
		add_action( 'wp_footer', [ $this, 'print_footer_styles' ] );
	}

	/**
	 * Print extra styles in the footer.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function print_footer_styles() {

		$style = Style::get_instance( 'gridd-plus-extra-styles' );

		// Header-anchor links.
		if ( get_theme_mod( 'gridd_headers_anchor_links', true ) ) {
			$style->add_file( GRIDD_PLUS_PATH . '/assets/css/anchor-links.min.css' );
		}
		$style->the_css( 'gridd-plus-inline-css-extra-styles' );
	}

	/**
	 * Add styles to Gridd.
	 *
	 * @access public
	 * @since 1.0
	 * @param Gridd\Style $style The style object.
	 * @return void
	 */
	public function gridd_style( $style ) {
		switch ( $style->context ) {
			case 'grid-part/breadcrumbs':
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/grid-part-breadcrumbs.min.css' );
				break;

			case 'main-styles':
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/typography.min.css' );
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/links.min.css' );
				if ( class_exists( '\WooCommerce' ) ) {
					$style->add_file( GRIDD_PLUS_PATH . '/assets/css/woocommerce.min.css' );
				}
				break;

			case 'grid-part/nav-handheld':
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nav-handheld.min.css' );
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nav-handheld-woo-cart.min.css' );
				break;

			case 'footer-late-styles':
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/posts-and-pages.min.css' );
		}
	}
}
