<?php
/**
 * Extra features.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

Customizer::add_field(
	[
		'type'            => 'dimension',
		'settings'        => 'gridd_featured_image_fixed_singular_height',
		'label'           => esc_attr__( 'Fixed container maximum height', 'gridd-plus' ),
		'description'     => esc_html__( 'Select how featured images will be displayed in single post-types (Applies to all post-types).', 'gridd-plus' ),
		'section'         => 'gridd_features_single_post',
		'default'         => '60vh',
		'priority'        => 25,
		'transport'       => 'refresh',
		'output'      => [
			[
				'element'  => ':root',
				'property' => '--fimg-fh',
			],
		],
		'transport'       => 'postMessage',
		'active_callback' => [
			[
				'setting' => 'gridd_featured_image_mode_singular',
				'value'   => 'fixed',
				'operator' => '===',
			],
		],
	]
);

Customizer::add_field(
	[
		'type'        => 'switch',
		'settings'    => 'gridd_headers_anchor_links',
		'label'       => esc_attr__( 'Enable anchor links in headers', 'gridd-plus' ),
		'description' => esc_html__( 'If a header block has an anchor defined, this will add a link icon at the end of the headers when they are hovered so that users can easier link to sections of your pages.', 'gridd-plus' ),
		'section'     => 'gridd_features_single_post',
		'default'     => true,
		'priority'    => 70,
		'transport'   => 'refresh',
	]
);

Customizer::add_field(
	[
		'type'        => 'radio',
		'settings'    => 'gridd_enable_totop',
		'label'       => esc_attr__( 'Enable scroll-to-top button.', 'gridd-plus' ),
		'description' => esc_html__( 'When on a long page shows a "Scroll-to-top" button on the bottom-right corner of the screen. Select "Desktop" to only show the button on large screens, "Show" to show the button on both large and small screens, or "Hidden" to disable the button.', 'gridd-plus' ),
		'section'     => 'gridd_features_global',
		'default'     => 'hidden',
		'priority'    => 80,
		'transport'   => 'refresh',
		'choices'     => [
			'hidden' => esc_attr__( 'Hidden', 'gridd-plus' ),
			'large'  => esc_attr__( 'Desktop Only', 'gridd-plus' ),
			'all'    => esc_attr__( 'Show', 'gridd-plus' ),
		],
	]
);

Customizer::add_field(
	[
		'type'        => 'slider',
		'settings'    => 'gridd_grid_widget_areas_number',
		'label'       => esc_attr__( 'Number of custom widget areas', 'gridd-plus' ),
		'description' => __( 'Select how many custom widget areas you want to add. Please note that you will have to save your settings and reload the customizer for the changes to take effect. Widget areas can then be added to your layout, and as soon as they are added their options become availeble.', 'gridd-plus' ),
		'section'     => 'gridd_features_global',
		'default'     => 3,
		'priority'    => 100,
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
			'settings'        => "gridd_grid_widget_area_{$i}_name",
			/* translators: The widget-area number. */
			'label'           => sprintf( esc_html__( 'Widget Area %d Name', 'gridd-plus' ), absint( $i ) ),
			'tooltip'         => esc_html__( 'Enter a custom name if you want to easier identify this widget-area. Please note that changes will only be visible after you save the Customizer options and refresh this page.', 'gridd-plus' ),
			'section'         => 'gridd_features_global',
			/* translators: The widget-area number. */
			'default'         => sprintf( esc_html__( 'Widget Area %d', 'gridd-plus' ), absint( $i ) ),
			'transport'       => 'postMessage',
			'priority'        => 101,
			'active_callback' => [
				[
					'setting'  => 'gridd_grid_widget_areas_number',
					'operator' => '>=',
					'value'    => $i,
				],
			],
		]
	);
}
