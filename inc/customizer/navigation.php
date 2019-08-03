<?php
/**
 * Customizer options.
 *
 * @package Gridd
 */

use Gridd\Customizer;
use Gridd\Grid_Part\Navigation;

/**
 * Register the menus.
 *
 * @since 1.0
 * @return void
 */
function gridd_plus_add_nav_parts() {
	$number = Navigation::get_number_of_nav_menus();
	for ( $i = 1; $i <= $number; $i++ ) {
		gridd_plus_nav_customizer_options( $i );
	}
}
add_action( 'after_setup_theme', 'gridd_plus_add_nav_parts', 20 );

/**
 * This function creates all options for a navigation.
 * We use a parameter since we'll allow multiple navigations.
 *
 * @since 1.0
 * @param int $id The number of this navigation.
 * @return void
 */
function gridd_plus_nav_customizer_options( $id ) {
	Customizer::add_field(
		[
			'type'        => 'slider',
			'settings'    => "gridd_grid_nav_{$id}_font_size",
			'label'       => esc_html__( 'Menu Font Size', 'gridd-plus' ),
			'description' => esc_html__( 'The font-size for this menu. This value is relevant to your body font-size, so a value of 1em will be the same size as you content.', 'gridd-plus' ),
			'section'     => "gridd_grid_part_details_nav_$id",
			'default'     => 1,
			'transport'   => 'postMessage',
			'css_vars'    => [ "--gridd-nav-$id-font-size", '$em' ],
			'choices'     => [
				'min'    => 0.5,
				'max'    => 2.5,
				'step'   => 0.01,
				'suffix' => 'em',
			],
		]
	);

	Customizer::add_field(
		[
			'type'        => 'slider',
			'settings'    => "gridd_grid_nav_{$id}_items_padding",
			'label'       => esc_html__( 'Items Padding', 'gridd-plus' ),
			'description' => esc_html__( 'The inner padding for menu items. This setting affects the spacing between your menu items.', 'gridd-plus' ),
			'section'     => "gridd_grid_part_details_nav_$id",
			'default'     => 1,
			'transport'   => 'postMessage',
			'css_vars'    => [ "--gridd-nav-$id-items-padding", '$em' ],
			'choices'     => [
				'min'    => 0.2,
				'max'    => 3,
				'step'   => 0.01,
				'suffix' => 'em',
			],
		]
	);

	Customizer::add_field(
		[
			'type'            => 'slider',
			'settings'        => "gridd_grid_nav_{$id}_collapse_icon_size",
			'label'           => esc_html__( 'Collapse Icon Size', 'gridd-plus' ),
			'section'         => "gridd_grid_part_details_nav_$id",
			'default'         => 1,
			'transport'       => 'postMessage',
			'choices'         => [
				'min'    => .75,
				'max'    => 3,
				'step'   => .01,
				'suffix' => 'em',
			],
			'css_vars'        => [ "--gridd-nav-$id-collapsed-icon-size", '$em' ],
			'active_callback' => [
				[
					'setting'  => "gridd_grid_nav_{$id}_responsive_behavior",
					'value'    => 'desktop-normal mobile-normal',
					'operator' => '!==',
				],
				[
					'setting'  => "gridd_grid_nav_{$id}_responsive_behavior",
					'value'    => 'desktop-normal mobile-hidden',
					'operator' => '!==',
				],
			],
		]
	);

	if ( class_exists( 'WooCommerce' ) ) {
		Customizer::add_field(
			[
				'type'            => 'switch',
				'settings'        => "gridd_grid_nav_{$id}_woo_cart",
				'label'           => esc_html__( 'Show WooCommerce Cart', 'gridd-plus' ),
				'description'     => __( 'If enabled, the cart will be added as a dropdown at the end of the menu.', 'gridd-plus' ),
				'section'         => "gridd_grid_part_details_nav_$id",
				'default'         => 1 === $id,
				'transport'       => 'auto',
				'transport'       => 'postMessage',
				'partial_refresh' => [
					"gridd_grid_nav_{$id}_woo_cart_template" => [
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
