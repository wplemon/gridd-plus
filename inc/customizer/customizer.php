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

new \Kirki\Field\Slider(
	[
		'settings'    => 'widget_areas_number',
		'label'       => esc_attr__( 'Number of custom widget areas', 'gridd-plus' ),
		'description' => __( 'Select how many custom widget areas you want to add. Please note that you will have to save your settings and reload the customizer for the changes to take effect. Widget areas can then be added to your layout, and as soon as they are added their options become availeble.', 'gridd-plus' ),
		'section'     => 'gridd_plus',
		'default'     => 3,
		'priority'    => 30,
		'transport'   => 'postMessage',
		'choices'     => [
			'min'  => 0,
			'max'  => 15,
			'step' => 1,
		],
	]
);

$range = range( 1, apply_filters( 'gridd_max_widget_areas', 15 ), 1 );
foreach ( $range as $i ) {
	Customizer::add_field(
		[
			'type'            => 'text',
			'settings'        => "widget_area_{$i}_name",
			/* translators: The widget-area number. */
			'label'           => sprintf( esc_html__( 'Widget Area %d Name', 'gridd-plus' ), absint( $i ) ),
			'tooltip'         => esc_html__( 'Enter a custom name if you want to easier identify this widget-area. Please note that changes will only be visible after you save the Customizer options and refresh this page.', 'gridd-plus' ),
			'section'         => 'gridd_plus',
			/* translators: The widget-area number. */
			'default'         => sprintf( esc_html__( 'Widget Area %d', 'gridd-plus' ), absint( $i ) ),
			'transport'       => 'postMessage',
			'priority'        => 40,
			'active_callback' => [
				[
					'setting'  => 'widget_areas_number',
					'operator' => '>=',
					'value'    => $i,
				],
			],
		]
	);
}
