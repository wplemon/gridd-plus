<?php
/**
 * Customizer options.
 *
 * @package Gridd
 */

use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

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

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
