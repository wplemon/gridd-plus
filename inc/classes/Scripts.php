<?php
/**
 * Scripts for Gridd Plus.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

/**
 * The Styles object.
 *
 * @since 1.0
 */
class Scripts {

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {
		add_filter( 'gridd_footer_inline_script_paths', [ $this, 'footer_inline_script_paths' ] );
	}

	/**
	 * Add additional scripts inline.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $paths An array of file paths we'll be including.
	 * @return array
	 */
	public function footer_inline_script_paths( $paths ) {
		// Header-anchor links.
		if ( get_theme_mod( 'gridd_headers_anchor_links', true ) ) {
			$paths[] = GRIDD_PLUS_PATH . '/assets/js/anchor-headers.min.js';
		}
		return $paths;
	}
}
