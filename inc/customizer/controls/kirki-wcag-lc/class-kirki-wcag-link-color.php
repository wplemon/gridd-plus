<?php
/**
 * The Control class.
 *
 * @package KirkiAccessibleColorpicker
 * @since 1.0
 */

/**
 * The main control class.
 *
 * @since 1.0
 */
class Kirki_WCAG_Link_Color extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-wcag-lc';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = [];

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Option name (if using options).
	 *
	 * @access public
	 * @var string
	 */
	public $option_name = false;

	/**
	 * The kirki_config we're using for this control
	 *
	 * @access public
	 * @var string
	 */
	public $kirki_config = 'global';

	/**
	 * Whitelisting the "required" argument.
	 *
	 * @since 3.0.17
	 * @access public
	 * @var array
	 */
	public $required = [];

	/**
	 * Whitelisting the "preset" argument.
	 *
	 * @since 3.0.26
	 * @access public
	 * @var array
	 */
	public $preset = [];

	/**
	 * Whitelisting the "css_vars" argument.
	 *
	 * @since 3.0.28
	 * @access public
	 * @var string
	 */
	public $css_vars = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		$url = str_replace( ABSPATH, trailingslashit( home_url() ), __DIR__ ); // phpcs:ignore PHPCompatibility.Keywords
		wp_enqueue_script( 'wcag_colors', apply_filters( 'kirki_wcag_link_color_url', $url ) . '/wcagColors.js', [], '1.0', false );
		wp_enqueue_script( 'kirki_wcag_link_color', apply_filters( 'kirki_wcag_link_color_url', $url ) . '/script.js', [ 'jquery', 'customize-base', 'customize-controls', 'wp-color-picker', 'wcag_colors' ], '1.0', false );
		wp_enqueue_style( 'kirki_wcag_link_color', apply_filters( 'kirki_wcag_link_color_url', $url ) . '/styles.css', [ 'wp-color-picker' ], '1.0' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {

		// Get the basics from the parent class.
		parent::to_json();

		// Default value.
		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		// Required.
		$this->json['required'] = $this->required;

		// Output.
		$this->json['output'] = $this->output;

		// Value.
		$this->json['value'] = $this->value();

		// Choices.
		$this->json['choices'] = $this->choices;

		// The link.
		$this->json['link'] = $this->get_link();

		// The ID.
		$this->json['id'] = $this->id;

		// The kirki-config.
		$this->json['kirkiConfig'] = $this->kirki_config;

		// The option-type.
		$this->json['kirkiOptionType'] = $this->option_type;

		// The option-name.
		$this->json['kirkiOptionName'] = $this->option_name;

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<label><span class="customize-control-title">{{{ data.label }}}</span></label>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="tab-headers">
			<button class="button trigger-auto"><?php esc_html_e( 'Auto', 'gridd-plus' ); ?></button>
			<button class="button trigger-custom"><?php esc_html_e( 'Custom', 'gridd-plus' ); ?></button>
		</div>

		<div class="tabs">
			<div class="kirki-input-container auto">

				<!-- Color input. The actual input gets added via JS from the script. -->
				<div class="color-hue-container"></div>

				<!-- Wrapper for the color selectors. -->
				<div class="color-selector">
					<a href="#" class="expand-selectors">
						<?php esc_html_e( 'Click for more options.', 'gridd-plus' ); ?>
						<span class="indicator">
							<span class="current-color"></span>
							<span class="current-rating"></span>
						</span>
					</a>

					<div class="rating-containers-wrapper hidden">

						<!-- AAA colors. -->
						<div class="rating-container rating-container-AAA hidden">
							<p><?php esc_html_e( 'Rating: AAA', 'gridd-plus' ); ?></p>
							<div class="colors-container"></div>
						</div>

						<!-- AA colors. -->
						<div class="rating-container rating-container-AA hidden">
							<p><?php esc_html_e( 'Rating: AA', 'gridd-plus' ); ?></p>
							<div class="colors-container"></div>
						</div>

						<!-- A colors. -->
						<div class="rating-container rating-container-A hidden">
							<p><?php esc_html_e( 'Rating: A', 'gridd-plus' ); ?></p>
							<div class="colors-container"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="kirki-input-container custom">
				<!-- Color input. The actual input gets added via JS from the script.-->
				<div class="color-hex-container"></div>
			</div>
		</div>
		<!-- Hidden input. -->
		<input class="hidden-value-hex" type="hidden" value="{{ data.value }}" {{{ data.link }}} />

		<?php
	}

	/**
	 * Adding an empty function here prevents PHP errors from to_json() in the parent class.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function render_content() {}
}
