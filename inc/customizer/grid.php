<?php
/**
 * Extra settings for the grid section.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Grid;
use Gridd\Grid_Parts;
use Gridd\Customizer;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

Customizer::add_field(
	[
		'settings' => 'gridd_custom_mobile_grid',
		'section'  => 'gridd_grid',
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Enable custom grid for small viewports', 'gridd-plus' ),
		'tooltip'  => esc_html__( 'If you want to customize the way your grid will be shown in mobile and small devices, you can enable this option and create a separate grid for mobile.', 'gridd-plus' ),
		'default'  => false,
		'priority' => 21,
		'choices'  => [
			'default' => esc_attr__( 'Default', 'gridd-plus' ),
			'custom'  => esc_attr__( 'Custom', 'gridd-plus' ),
		],
	]
);

Customizer::add_field(
	[
		'settings'          => 'gridd_grid_mobile',
		'section'           => 'gridd_grid',
		'type'              => 'gridd_grid',
		'grid-part'         => false,
		'priority'          => 23,
		'label'             => esc_html__( 'Mobile Grid Settings', 'gridd-plus' ),
		'description'       => sprintf(
			/* translators: Link attributes. */
			__( 'Edit settings for the grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
		),
		'default'           => Grid::get_grid_default_value(),
		'sanitize_callback' => [ $sanitization, 'grid' ],
		'choices'           => [
			'parts'              => Grid_Parts::get_instance()->get_parts(),
			'duplicate'          => 'gridd_grid',
			'disablePartButtons' => [ 'edit' ],
		],
		'active_callback'   => function() {
			return get_theme_mod( 'gridd_custom_mobile_grid' );
		},
	]
);
