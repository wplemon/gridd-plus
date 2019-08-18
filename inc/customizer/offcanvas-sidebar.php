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
		'panel'    => 'gridd_options',
	]
);

Customizer::add_field(
	[
		'type'        => 'custom',
		'settings'    => 'gridd_plus_offcanvas_sidebar_important_note',
		'label'       => esc_html__( 'Important Note', 'gridd-plus' ),
		'description' => esc_html__( 'You will need to assign some widgets to the "Offcanvas Sidebar" widget-area in order for the area to be visible.', 'gridd-plus' ),
		'section'     => 'gridd_plus_offcanvas_sidebar',
		'default'     => false,
		'transport'   => 'refresh',
	]
);

Customizer::add_field(
	[
		'type'      => 'checkbox',
		'settings'  => 'gridd_pluss_offcanvas_sidebar_enable',
		'label'     => esc_html__( 'Enable Off-Canvas Sidebar', 'gridd-plus' ),
		'section'   => 'gridd_plus_offcanvas_sidebar',
		'default'   => false,
		'transport' => 'refresh',
	]
);

Customizer::add_field(
	[
		'type'            => 'dimension',
		'settings'        => 'gridd_pluss_offcanvas_sidebar_width',
		'label'           => esc_html__( 'Width', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '300px',
		'transport'       => 'postMessage',
		'css_vars'        => '--gridd-offcanvas-sidebar-width',
		'active_callback' => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);

Customizer::add_field(
	[
		'type'            => 'radio-buttonset',
		'settings'        => 'gridd_pluss_offcanvas_sidebar_position',
		'label'           => esc_html__( 'Position', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => 'left',
		'transport'       => 'refresh',
		'choices'         => [
			'left'  => esc_html__( 'Left', 'gridd-plus' ),
			'right' => esc_html__( 'Right', 'gridd-plus' ),
		],
		'active_callback' => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
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
		'transport'       => 'postMessage',
		'css_vars'        => '--gridd-offcanvas-sidebar-padding',
		'active_callback' => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);

Customizer::add_field(
	[
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'gridd-plus' ),
		'settings'        => 'gridd_plus_offcanvas_sidebar_bg_color',
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '#ffffff',
		'transport'       => 'postMessage',
		'css_vars'        => '--gridd-offcanvas-sidebar-bg',
		'choices'         => [
			'alpha' => true,
		],
		'active_callback' => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);

Customizer::add_field(
	[
		'type'              => 'gridd-wcag-tc',
		'label'             => esc_html__( 'Text Color', 'gridd-plus' ),
		'description'       => esc_html__( 'Select the color used for your menu items. Please choose a color with sufficient contrast with the selected background-color.', 'gridd-plus' ),
		'settings'          => 'gridd_plus_offcanvas_sidebar_color',
		'section'           => 'gridd_plus_offcanvas_sidebar',
		'choices'           => [
			'setting' => 'gridd_plus_offcanvas_sidebar_bg_color',
		],
		'default'           => '#000000',
		'transport'         => 'postMessage',
		'css_vars'          => '--gridd-offcanvas-sidebar-color',
		'sanitize_callback' => [ $sanitization, 'color_hex' ],
		'active_callback'   => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);

Customizer::add_field(
	[
		'type'              => 'gridd-wcag-lc',
		'label'             => esc_html__( 'Links Color', 'gridd-plus' ),
		'settings'          => 'gridd_plus_offcanvas_sidebar_links_color',
		'section'           => 'gridd_plus_offcanvas_sidebar',
		'default'           => '#0f5e97',
		'transport'         => 'postMessage',
		'css_vars'          => '--gridd-offcanvas-sidebar-links-color',
		'choices'           => [
			'backgroundColor' => 'gridd_plus_offcanvas_sidebar_bg_color',
			'textColor'       => 'gridd_plus_offcanvas_sidebar_color',
		],
		'sanitize_callback' => [ $sanitization, 'color_hex' ],
		'active_callback'   => [
			[
				'setting'  => 'gridd_pluss_offcanvas_sidebar_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
