<?php
/**
 * Extra settings for the header grid-part.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;
use Gridd\Grid_Part\Header;
use Gridd\customizer\Sanitize;

$sanitization = new Sanitize();

new \Kirki\Field\Checkbox(
	[
		'settings' => 'header_mobile_override',
		'section'  => 'header_grid',
		'default'  => true,
		'label'    => esc_html__( 'Enable Separate Grid for Mobile', 'gridd-plus' ),
	]
);

Customizer::add_field(
	[
		'settings'          => 'header_mobile',
		'section'           => 'header_grid',
		'type'              => 'gridd_grid',
		'grid-part'         => 'header',
		'label'             => esc_html__( 'Header Mobile Grid Settings', 'gridd-plus' ),
		'description'       => sprintf(
			/* translators: Link attributes. */
			__( 'Edit settings for the header grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
		),
		'default'           => get_theme_mod( 'header_grid', Header::get_grid_defaults() ),
		'sanitize_callback' => [ $sanitization, 'grid' ],
		'choices'           => [
			'parts'              => Header::get_header_grid_parts(),
			'duplicate'          => 'header_grid',
			'disablePartButtons' => [ 'edit' ],
		],
		'active_callback'   => function() {
			return get_theme_mod( 'header_mobile_override', true );
		},
		'transport'         => 'postMessage',
		'priority'          => 15,
		'partial_refresh'   => [
			'gridd_header_mobile_grid_part_renderer' => [
				'selector'            => '.gridd-tp.gridd-tp-header',
				'container_inclusive' => true,
				'render_callback'     => function() {
					do_action( 'gridd_the_grid_part', 'header' );
				},
			],
		],
	]
);
