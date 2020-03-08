<?php
/**
 * Extra settings for the typography section.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

new \WPLemon\Field\WCAGTextColor(
	[
		'settings'        => 'gridd_headers_color',
		'label'           => esc_attr__( 'Headers Color', 'gridd-plus' ),
		'section'         => 'content',
		'default'         => '#000000',
		'output'          => [
			[
				'element'  => ':root',
				'property' => '--hdcl',
			],
		],
		'transport'       => 'postMessage',
		'priority'        => 45,
		'choices'         => [
			'backgroundColor' => 'content_background_color',
		],
		'active_callback' => function() {
			return get_theme_mod( 'content_custom_options', false );
		},
	]
);

/**
 * Type Scale
 */
new \Kirki\Field\Slider(
	[
		'settings'          => 'gridd_type_scale',
		'label'             => esc_attr__( 'Typography Scale', 'gridd-plus' ),
		'description'       => esc_attr__( 'Controls the size relations between your headers and your main typography font-size.', 'gridd-plus' ),
		'section'           => 'gridd_typography',
		'default'           => '1.26',
		'transport'         => 'postMessage',
		'output'            => [
			[
				'element'  => ':root',
				'property' => '--gridd-typo-scale',
			],
			get_theme_mod( 'disable_editor_styles' ) ? [] : [
				'element'  => '.edit-post-visual-editor.editor-styles-wrapper',
				'property' => '--gridd-typo-scale',
				'context'  => [ 'editor' ],
			],
		],
		'priority'          => 80,
		'choices'           => [
			'min'  => 1,
			'max'  => 2.5,
			'step' => 0.001,
		],
		'priority'          => 80,
		'sanitize_callback' => function( $value ) {
			return is_numeric( $value ) ? $value : '1.26';
		},
	]
);
