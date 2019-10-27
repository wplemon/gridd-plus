<?php
/**
 * Customizer options.
 *
 * @package Gridd
 */

use Gridd\Customizer;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

/**
 * Add Customizer Sections.
 */
Customizer::add_section(
	'gridd_plus_offcanvas_sidebar',
	[
		'title'    => esc_html__( 'Offcanvas Sidebar', 'gridd-plus' ),
		'priority' => 27,
	]
);

new \Kirki\Field\ReactColor(
	[
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'gridd-plus' ),
		'settings'        => 'gridd_plus_offcanvas_sidebar_bg_color',
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '#ffffff',
		'priority'        => 30,
		'transport'       => 'auto',
		'output'          => [
			[
				'element'  => '#offcanvas-wrapper',
				'property' => '--bg',
			],
		],
		'choices'   => [
			'formComponent' => 'TwitterPicker',
			'colors'        => \Gridd\Theme::get_colorpicker_palette(),
		],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
	]
);

Customizer::add_field(
	[
		'type'            => 'dimension',
		'settings'        => 'gridd_pluss_offcanvas_sidebar_width',
		'label'           => esc_html__( 'Size', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '300px',
		'transport'       => 'auto',
		'output'          => [
			[
				'element'  => '#offcanvas-wrapper',
				'property' => '--sz',
			],
		],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
		'priority'        => 40,
	]
);

new \Kirki\Field\RadioButtonset(
	[
		'settings'        => 'gridd_pluss_offcanvas_sidebar_position',
		'label'           => esc_html__( 'Position', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => 'left',
		'transport'       => 'refresh',
		'choices'         => [
			'left'   => esc_html__( 'Left', 'gridd-plus' ),
			'right'  => esc_html__( 'Right', 'gridd-plus' ),
		],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
		'priority'        => 50,
	]
);

Customizer::add_field(
	[
		'type'            => 'dimension',
		'settings'        => 'gridd_pluss_offcanvas_sidebar_padding',
		'label'           => esc_html__( 'Padding', 'gridd-plus' ),
		'description'     => __( 'Inner padding for this grid-part. Use any valid CSS value. For details on how padding works, please refer to <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/padding" target="_blank" rel="nofollow">this article</a>.', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '1em',
		'transport'       => 'auto',
		'output'          => [
			[
				'element'  => '#offcanvas-wrapper',
				'property' => '--pd',
			],
		],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
		'priority'        => 60,
	]
);

new \WPLemon\Field\WCAGTextColor(
	[
		'label'             => esc_html__( 'Text Color', 'gridd-plus' ),
		'description'       => esc_html__( 'Select the color used for your menu items. Please choose a color with sufficient contrast with the selected background-color.', 'gridd-plus' ),
		'settings'          => 'gridd_plus_offcanvas_sidebar_color',
		'section'           => 'gridd_plus_offcanvas_sidebar',
		'choices'           => [
			'backgroundColor' => 'gridd_plus_offcanvas_sidebar_bg_color',
		],
		'default'           => '#000000',
		'transport'       => 'auto',
		'output'          => [
			[
				'element'  => '#offcanvas-wrapper',
				'property' => '--cl',
			],
		],
		'sanitize_callback' => [ $sanitization, 'color_hex' ],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
		'priority'        => 70,
	]
);

new \Kirki\Field\RadioButtonset(
	[
		'settings'        => 'offcanvas_sidebar_visibility',
		'label'           => esc_html__( 'Visibility', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => 'always',
		'transport'       => 'refresh',
		'choices'         => [
			'desktop' => esc_html__( 'Desktop', 'gridd-plus' ),
			'mobile'  => esc_html__( 'Mobile', 'gridd-plus' ),
			'always'  => esc_html__( 'Always', 'gridd-plus' ),
		],
		'active_callback' => function() {
			return is_active_sidebar( 'offcanvas-sidebar' );
		},
		'priority'        => 80,
	]
);

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
