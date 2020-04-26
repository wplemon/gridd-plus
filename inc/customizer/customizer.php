<?php
/**
 * Gridd-Plus Customizer settings.
 *
 * @package Gridd Plus
 * @since 3.0.0
 */

use Gridd\Customizer;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

new \Kirki\Section(
	'gridd_plus',
	[
		'title'       => esc_html__( 'Gridd Plus', 'gridd-plus' ),
		'description' => esc_html__( 'Includes generic options for gridd-plus. Options specific to a grid-part can be found in that grid-part\'s settings.', 'gridd-plus' ),
	]
);

new \Kirki\Field\RadioButtonset(
	[
		'type'        => 'radio',
		'settings'    => 'gridd_enable_totop',
		'label'       => esc_attr__( 'Enable scroll-to-top button.', 'gridd-plus' ),
		'description' => esc_html__( 'Shows a "Scroll-to-top" button on the bottom-right corner of the screen. Select "Hidden" to disable the button.', 'gridd-plus' ),
		'section'     => 'gridd_plus',
		'default'     => 'hidden',
		'priority'    => 10,
		'transport'   => 'refresh',
		'choices'     => [
			'hidden' => esc_attr__( 'Hidden', 'gridd-plus' ),
			'large'  => esc_attr__( 'Large Screen Only', 'gridd-plus' ),
		],
	]
);

new \Kirki\Field\Checkbox_Switch(
	[
		'settings'    => 'gridd_headers_anchor_links',
		'label'       => esc_attr__( 'Enable anchor links in headers', 'gridd-plus' ),
		'description' => esc_html__( 'Add a link icon next to headers that have an anchor defined.', 'gridd-plus' ),
		'section'     => 'gridd_plus',
		'default'     => true,
		'priority'    => 20,
		'transport'   => 'refresh',
	]
);
