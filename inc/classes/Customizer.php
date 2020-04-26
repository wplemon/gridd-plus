<?php
/**
 * Customizer mods.
 *
 * @package Gridd Plus
 * @since   1.0
 */

namespace Gridd_Plus;

/**
 * A base for controls.
 */
class Customizer {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'include_files' ] );

		add_action( 'customize_register', [ $this, 'customize_register' ], 999999999 );

		add_action( 'customize_controls_print_styles', [ $this, 'customize_controls_print_styles' ] );
	}

	/**
	 * Includes customizer files.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function include_files() {
		require_once GRIDD_PLUS_PATH . '/inc/customizer/customizer.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/navigation.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/nested-grid.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/offcanvas-sidebar.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/sidebar.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/slider-revolution.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/typography.php';
	}

	/**
	 * Modify field arguments.
	 *
	 * @access public
	 * @since 1.0
	 * @param WP_Customize_Manager $wp_customize The customizer object.
	 * @return void
	 */
	public function customize_register( $wp_customize ) {

		if ( class_exists( 'WooCommerce' ) ) {
			$wp_customize->get_control( 'nav-handheld_parts' )->choices['woo-cart'] = esc_html__( 'Cart', 'gridd-plus' );
		}
	}

	/**
	 * Add extra styles for the customizer.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function customize_controls_print_styles() {
		wp_enqueue_style( 'gridd-plus-customizer', GRIDD_PLUS_URL . '/assets/css/customizer.css', [], GRIDD_PLUS_VERSION );
	}
}
