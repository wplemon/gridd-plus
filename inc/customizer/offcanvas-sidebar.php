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
		'priority'    => 10,
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
		'priority'  => 20,
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
				'element'  => '.toggle-gridd-plus-offcanvas-sidebar,.gridd-tp-offcanvas-sidebar',
				'property' => '--bg',
			],
		],
		'choices'   => [
			'formComponent' => 'TwitterPicker',
			'colors'        => [ '#FFFFFF', '#fffcea', '#F9F9F9', '#f7f6e3', '#f7f7f7', '#f4f4e1', '#1A1A1A', '#000000' ],
		],
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
		},
	]
);

Customizer::add_field(
	[
		'type'            => 'dimension',
		'settings'        => 'gridd_pluss_offcanvas_sidebar_width',
		'label'           => esc_html__( 'Width', 'gridd-plus' ),
		'section'         => 'gridd_plus_offcanvas_sidebar',
		'default'         => '300px',
		'transport'       => 'auto',
		'output'          => [
			[
				'element'  => '.toggle-gridd-plus-offcanvas-sidebar,.gridd-tp-offcanvas-sidebar',
				'property' => '--w',
			],
		],
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
		},
		'priority'        => 40,
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
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
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
				'element'  => '.toggle-gridd-plus-offcanvas-sidebar,.gridd-tp-offcanvas-sidebar',
				'property' => '--pd',
			],
		],
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
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
				'element'  => '.toggle-gridd-plus-offcanvas-sidebar,.gridd-tp-offcanvas-sidebar',
				'property' => '--cl',
			],
		],
		'sanitize_callback' => [ $sanitization, 'color_hex' ],
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
		},
		'priority'        => 70,
	]
);

/**
 * WIP - Disabled this control for design reasons.
 *
Customizer::add_field(
	[
		'type'              => 'gridd-wcag-lc',
		'label'             => esc_html__( 'Links Color', 'gridd-plus' ),
		'settings'          => 'gridd_plus_offcanvas_sidebar_links_color',
		'section'           => 'gridd_plus_offcanvas_sidebar',
		'default'           => '#0f5e97',
		'transport'         => 'postMessage',
		'output'          => [
			[
				'element'  => '.toggle-gridd-plus-offcanvas-sidebar,.gridd-tp-offcanvas-sidebar',
				'property' => '--lc',
			],
		],
		'choices'           => [
			'backgroundColor' => 'gridd_plus_offcanvas_sidebar_bg_color',
			'textColor'       => 'gridd_plus_offcanvas_sidebar_color',
		],
		'sanitize_callback' => [ $sanitization, 'color_hex' ],
		'active_callback' => function() {
			return get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable' );
		},
		'priority'        => 80,
	]
);
*/
/* Omit closing PHP tag to avoid "Headers already sent" issues. */
