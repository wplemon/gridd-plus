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
		add_action( 'after_setup_theme', [ $this, 'include_acf_fields' ] );
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
				return GRIDD_PLUS_PATH . '/inc/acf/plugin/';
			}
		);

		// ACF URL.
		add_filter(
			'acf/settings/dir',
			function() {
				return GRIDD_PLUS_URL . '/inc/acf/plugin/';
			}
		);

		// Include the plugin file.
		include_once GRIDD_PLUS_PATH . '/inc/acf/plugin/acf.php';
	}

	/**
	 * Includes the ACD fields in after_setup_theme.
	 *
	 * @access public
	 * @since 1.0.2
	 * @return void
	 */
	public function include_acf_fields() {
		require_once GRIDD_PLUS_PATH . '/inc/acf/fields.php';
	}
}
