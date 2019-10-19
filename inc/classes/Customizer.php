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

		add_filter( 'gridd_field_args', [ $this, 'field_args' ] );

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
		require_once GRIDD_PLUS_PATH . '/inc/customizer/breadcrumbs.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/features.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/footer.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/grid.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/header.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/layer-slider.php';
		require_once GRIDD_PLUS_PATH . '/inc/customizer/nav-handheld.php';
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
	 * @param array $args The field arguments.
	 * @return array
	 */
	public function field_args( $args ) {
		switch ( $args['settings'] ) {
			case 'gridd_header_grid':
				$args['choices']['duplicate'] = 'gridd_grid_header_mobile';
				break;

			case 'gridd_footer_grid':
				$args['choices']['duplicate'] = 'gridd_grid_footer_mobile';
				break;

			case 'gridd_grid_nav-handheld_parts':
				$args['choices']['widget-area'] = esc_html__( 'Widget Area', 'gridd-plus' );
				// If WooCommerce is installed, add another item for the Cart.
				if ( class_exists( 'WooCommerce' ) ) {
					$args['choices']['woo-cart'] = esc_html__( 'Cart', 'gridd-plus' );
				}
				break;

			case 'gridd_type_scale':
				$args['type']        = 'slider';
				$args['label']       = '';
				$args['description'] = '';
				$args['choices']     = [
					'min'  => 1,
					'max'  => 2.5,
					'step' => 0.001,
				];
				break;

			case 'gridd_featured_image_mode_singular':
				$args['choices']['fixed'] = esc_html__( 'Fixed', 'gridd-plus' );
				break;
		}

		switch ( $args['type'] ) {
			case 'gridd-wcag-lc':
				$args['type'] = 'kirki-wcag-lc';
				break;
		}

		return $args;
	}

	/**
	 * Add extra styles for the customizer.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function customize_controls_print_styles() {
		wp_enqueue_style( 'gridd-plus-customizer', GRIDD_PLUS_URL . '/assets/css/customizer.css', array(), GRIDD_PLUS_VERSION );
	}
}
