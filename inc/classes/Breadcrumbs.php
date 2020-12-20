<?php
/**
 * Breadcrumbs
 *
 * @package Gridd Plus
 * @since
 */

namespace Gridd_Plus;

/**
 * Everything regarding breadcrumbs.
 */
class Breadcrumbs {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->customizer();
	}

	/**
	 * Add customizer options.
	 *
	 * @access protected
	 * @since 2.0.0
	 * @return void
	 */
	protected function customizer() {

		new \Kirki\Field\Slider(
			[
				'settings'        => 'breadcrumbs_font_size',
				'label'           => esc_html__( 'Breadcrumbs Font Size', 'gridd-plus' ),
				'description'     => esc_html__( 'Controls the font-size for your breadcrumbs, relative to the body font-size.', 'gridd-plus' ),
				'section'         => 'breadcrumbs',
				'default'         => 1,
				'transport'       => 'postMessage',
				'priority'        => 100,
				'output'          => [
					[
						'element'       => '.gridd-tp-breadcrumbs',
						'property'      => 'font-size',
						'value_pattern' => '$em',
					],
				],
				'choices'         => [
					'min'    => .5,
					'max'    => 2,
					'step'   => .01,
					'suffix' => 'em',
				],
				'active_callback' => function() {
					return \Gridd\Customizer::is_section_active_part( 'breadcrumbs' ) && get_theme_mod( 'breadcrumbs_custom_options', false );
				},
			]
		);
	}
}
