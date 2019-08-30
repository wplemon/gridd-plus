<?php
/**
 * Customizer options.
 *
 * @package Gridd
 */

use Gridd\Customizer;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

Customizer::add_field(
	[
		'type'        => 'slider',
		'settings'    => 'gridd_grid_breadcrumbs_font_size',
		'label'       => esc_html__( 'Font Size', 'gridd' ),
		'description' => Customizer::get_control_description(
			[
				'short'   => '',
				'details' => esc_html__( 'Controls the font-size for your breadcrumbs. This value is relative to the body font-size, so a value of 1em will have the same size as your content.', 'gridd' ),
			]
		),
		'section'     => 'gridd_grid_part_details_breadcrumbs',
		'default'     => 1,
		'transport'   => 'postMessage',
		'css_vars'    => '--brd-fs',
		'choices'     => [
			'min'    => .5,
			'max'    => 2,
			'step'   => .01,
			'suffix' => 'em',
		],
	]
);

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
