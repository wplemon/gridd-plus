<?php
/**
 * Color Deficiencies Simulator.
 *
 * @package Gridd Plus
 * @since   1.0
 */

namespace Gridd_Plus;

/**
 * A base for controls.
 */
class Color_Deficiencies_Simulator {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_controls_print_footer_scripts', [ $this, 'the_html' ], 5 );
		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
	}

	/**
	 * Enqueue related scripts & styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'gridd-color-deficiencies-simulator', GRIDD_PLUS_URL . '/assets/js/color-deficiencies-simulator.js', [ 'jquery', 'customize-base', 'gridd-set-setting-value' ], GRIDD_PLUS_VERSION, false );
		wp_enqueue_style( 'gridd-color-deficiencies-simulator', GRIDD_PLUS_URL . '/assets/css/color-deficiencies-simulator.css', [], GRIDD_PLUS_VERSION );
	}

	/**
	 * Adds the toolbar.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function the_html() {
		?>
		<div id="gridd-a11y-colorblindness-sim" style="display:none;">
			<a id="gridd-color-deficiencies-simulator-trigger" href="#" title="<?php esc_html_e( 'Color Deficiencies Simulator', 'gridd-plus' ); ?>"><span class="dashicons dashicons-universal-access-alt"></span></a>
			<div id="gridd-color-deficiencies-sim-wrapper" aria-expanded="false">
				<h3><?php esc_html_e( 'Color Vision Deficiencies Simulator', 'gridd-plus' ); ?></h3>
				<span class="description">
					<p><strong><?php esc_html_e( 'Important Note: This feature currently only works in Firefox due to a browser bug in Safari and Chrome', 'gridd-plus' ); ?></strong></p>
					<?php esc_html_e( 'Simulates how people with a different perception of colors will see your website. Please note that this option does not get saved, it is merely a simulation.', 'gridd-plus' ); ?>
				</span>

				<div class="options">
					<label><input type="radio" name=gridd-accecss-selector" value="" checked=""><?php esc_html_e( 'No simulation', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="protanopia"><?php esc_html_e( 'Protanopia', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="protanomaly"><?php esc_html_e( 'Protanomaly', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="deuteranopia"><?php esc_html_e( 'Deuteranopia', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="deuteranomaly"><?php esc_html_e( 'Deuteranomaly', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="tritanopia"><?php esc_html_e( 'Tritanopia', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="tritanomaly"><?php esc_html_e( 'Tritanomaly', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="achromatopsia"><?php esc_html_e( 'Achromatopsia', 'gridd-plus' ); ?></label>
					<label><input type="radio" name=gridd-accecss-selector" value="achromatomaly"><?php esc_html_e( 'Achromatomaly', 'gridd-plus' ); ?></label>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Enqueue additional scripts.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function scripts() {

		// Color-blindness simulator when in the customizer.
		if ( is_customize_preview() ) {
			wp_enqueue_style( 'gridd-accecss', GRIDD_PLUS_URL . '/assets/css/gridd-accecss.css', [], GRIDD_PLUS_VERSION );
		}
	}
}
