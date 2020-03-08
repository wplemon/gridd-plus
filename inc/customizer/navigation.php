<?php
/**
 * Customizer options.
 *
 * @package Gridd
 */

use Gridd\Customizer;
use Gridd\Grid_Part\Navigation;

add_action(
	'after_setup_theme',
	/**
	 * Register the menus.
	 *
	 * @since 1.0
	 * @return void
	 */
	function() {
		$number = Navigation::get_number_of_nav_menus();
		for ( $i = 1; $i <= $number; $i++ ) {
			gridd_plus_nav_customizer_options( $i );
		}
	},
	20
);

/**
 * This function creates all options for a navigation.
 * We use a parameter since we'll allow multiple navigations.
 *
 * @since 1.0
 * @param int $id The number of this navigation.
 * @return void
 */
function gridd_plus_nav_customizer_options( $id ) {
	new \Kirki\Field\Slider(
		[
			'settings'        => "nav_{$id}_font_size",
			'label'           => esc_html__( 'Menu Font Size', 'gridd-plus' ),
			'description'     => esc_html__( 'The font-size for this menu. This value is relevant to your body font-size, so a value of 1em will be the same size as you content.', 'gridd-plus' ),
			'section'         => "nav_$id",
			'default'         => 1,
			'transport'       => 'auto',
			'output'          => [
				[
					'element'       => ".gridd-tp-nav_$id",
					'property'      => '--fs',
					'value_pattern' => '$em',
				],
			],
			'choices'         => [
				'min'    => 0.5,
				'max'    => 2.5,
				'step'   => 0.01,
				'suffix' => 'em',
			],
			'active_callback' => function() use ( $id ) {
				return get_theme_mod( "nav_{$id}_custom_options", false );
			},
		]
	);

	new \Kirki\Field\Slider(
		[
			'settings'        => "nav_{$id}_items_padding",
			'label'           => esc_html__( 'Items Padding', 'gridd-plus' ),
			'description'     => esc_html__( 'The inner padding for menu items. This setting affects the spacing between your menu items.', 'gridd-plus' ),
			'section'         => "nav_$id",
			'default'         => 1,
			'transport'       => 'postMessage',
			'output'          => [
				[
					'element'       => ".gridd-tp-nav_$id",
					'property'      => '--ipd',
					'value_pattern' => '$em',
				],
			],
			'choices'         => [
				'min'    => 0.2,
				'max'    => 3,
				'step'   => 0.01,
				'suffix' => 'em',
			],
			'active_callback' => function() use ( $id ) {
				return get_theme_mod( "nav_{$id}_custom_options", false );
			},
		]
	);

	Customizer::add_field(
		[
			'type'            => 'slider',
			'settings'        => "nav_{$id}_collapse_icon_size",
			'label'           => esc_html__( 'Collapse Icon Size', 'gridd-plus' ),
			'section'         => "nav_$id",
			'default'         => 1,
			'transport'       => 'postMessage',
			'choices'         => [
				'min'    => .75,
				'max'    => 3,
				'step'   => .01,
				'suffix' => 'em',
			],
			'output'          => [
				[
					'element'       => ".gridd-tp-nav_$id",
					'property'      => '--cis',
					'value_pattern' => '$em',
				],
			],
			'active_callback' => function() use ( $id ) {
				$responsive = get_theme_mod( "nav_{$id}_responsive_behavior" );
				if ( 'desktop-normal mobile-normal' === $responsive || 'desktop-normal mobile-hidden' === $responsive ) {
					return false;
				}

				return get_theme_mod( "nav_{$id}_custom_options", false );
			},
		]
	);

	if ( class_exists( 'WooCommerce' ) ) {
		new \Kirki\Field\Checkbox_Switch(
			[
				'type'            => 'switch',
				'settings'        => "nav_{$id}_woo_cart",
				'label'           => esc_html__( 'Show WooCommerce Cart', 'gridd-plus' ),
				'description'     => __( 'If enabled, the cart will be added as a dropdown at the end of the menu.', 'gridd-plus' ),
				'section'         => "nav_$id",
				'default'         => 1 === $id,
				'transport'       => 'auto',
				'transport'       => 'postMessage',
				'partial_refresh' => [
					"nav_{$id}_woo_cart_template" => [
						'selector'            => ".gridd-tp-nav_{$id}",
						'container_inclusive' => true,
						'render_callback'     => function() use ( $id ) {
							/**
							 * We use include( get_theme_file_path() ) here
							 * because we need to pass the $id var to the template.
							 */
							include get_theme_file_path( 'grid-parts/templates/navigation.php' );
						},
					],
				],
			]
		);
	}
}
