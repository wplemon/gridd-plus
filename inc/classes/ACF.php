<?php
/**
 * Admin tweaks.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

/**
 * The Admin object.
 *
 * @since 1.0
 */
class ACF {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		if ( ! class_exists( 'acf_pro' ) ) {
			$this->include_acf();
		}
	}

	/**
	 * Include a copy of the ACF-Pro plugin.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function include_acf() {

		// ACF Path.
		add_filter(
			'acf/settings/path',
			function() {
				return GRIDD_PLUS_PATH . '/inc/acf/';
			}
		);

		// ACF URL.
		add_filter(
			'acf/settings/dir',
			function() {
				return GRIDD_PLUS_URL . '/inc/acf/';
			}
		);

		// Include the plugin file.
		include_once GRIDD_PLUS_PATH . '/inc/acf/acf.php';
	}
}
