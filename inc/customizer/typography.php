<?php
/**
 * Extra settings for the typography section.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

Customizer::add_field(
	[
		'type'      => 'kirki-wcag-tc',
		'settings'  => 'gridd_headers_color',
		'label'     => esc_attr__( 'Headers Color', 'gridd-plus' ),
		'section'   => 'grid_part_details_content',
		'default'   => '#000000',
		'css_vars'  => '--hdcl',
		'transport' => 'postMessage',
		'priority'  => 45,
		'choices'   => [
			'setting' => 'gridd_grid_content_background_color',
		],
	]
);

/**
 * Type Scale
 */
$scales = [
	/* Translators: Numeric representation of the scale. */
	'1.067'  => sprintf( esc_attr__( '%s - Minor Second', 'gridd-plus' ), '1.067' ),
	/* Translators: Numeric representation of the scale. */
	'1.125'  => sprintf( esc_attr__( '%s - Major Second', 'gridd-plus' ), '1.125' ),
	/* Translators: Numeric representation of the scale. */
	'1.149'  => sprintf( esc_attr__( '%s - Musical Pentatonic (classic)', 'gridd-plus' ), '1.149' ),
	/* Translators: Numeric representation of the scale. */
	'1.189'  => sprintf( esc_attr__( '%s - Musical Tetratonic', 'gridd-plus' ), '1.189' ),
	/* Translators: Numeric representation of the scale. */
	'1.25'   => sprintf( esc_attr__( '%s - Major Third', 'gridd-plus' ), '1.25' ),
	/* Translators: Numeric representation of the scale. */
	'1.26'   => sprintf( esc_attr__( '%s - Musical Tritonic', 'gridd-plus' ), '1.26' ),
	/* Translators: Numeric representation of the scale. */
	'1.272'  => sprintf( esc_attr__( '%s - Golden Ditonic', 'gridd-plus' ), '1.272' ),
	/* Translators: Numeric representation of the scale. */
	'1.333'  => sprintf( esc_attr__( '%s - Perfect Fourth', 'gridd-plus' ), '1.333' ),
	/* Translators: Numeric representation of the scale. */
	'1.444'  => sprintf( esc_attr__( '%s - Augmented Fourth', 'gridd-plus' ), '1.444' ),
	/* Translators: Numeric representation of the scale. */
	'1.5'    => sprintf( esc_attr__( '%s - Perfect Fifth', 'gridd-plus' ), '1.5' ),
	/* Translators: Numeric representation of the scale. */
	'1.618'  => sprintf( esc_attr__( '%s - Golden Ratio', 'gridd-plus' ), '1.618' ),
	// Custom.
	'custom' => 'custom',
];

$scales_presets = [];
foreach ( array_keys( $scales ) as $scale ) {
	$scales_presets[ $scale ] = [
		'settings' => [
			'gridd_type_scale' => (float) $scale,
		],
	];
}
Customizer::add_field(
	[
		'settings'    => 'gridd_type_scale_preset',
		'type'        => 'radio',
		'label'       => esc_attr__( 'Headers Size Scale', 'gridd-plus' ),
		'description' => esc_attr__( 'Controls the size relations between your headers and your main typography font-size.', 'gridd-plus' ),
		'section'     => 'gridd_typography',
		'default'     => '1.26',
		'choices'     => $scales,
		'transport'   => 'postMessage',
		'priority'    => 79,
		'preset'      => $scales_presets,
	]
);

Customizer::add_field(
	[
		'settings'    => 'remove_links_decoration',
		'type'        => 'checkbox',
		'label'       => esc_attr__( 'Do not underline links', 'gridd-plus' ),
		'section'     => 'gridd_typography',
		'default'     => false,
		'priority'    => 110,
	]
);

add_filter( 'gridd_style_css', function( $css, $context ) {
	if ( 'main-styles' === $context ) {
		if ( get_theme_mod( 'remove_links_decoration' ) ) {
			$css .= 'a{text-decoration:none !important;';
		}
	}
	return $css;
}, 10, 2 );
