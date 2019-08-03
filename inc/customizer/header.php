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

Customizer::add_field(
	[
		'settings'          => 'gridd_grid_header_mobile',
		'section'           => 'gridd_grid_part_details_header',
		'type'              => 'gridd_grid',
		'grid-part'         => 'header',
		'label'             => esc_html__( 'Header Mobile Grid Settings', 'gridd-plus' ),
		'description'       => sprintf(
			/* translators: Link attributes. */
			__( 'Edit settings for the header grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
		),
		'default'           => get_theme_mod( 'gridd_header_grid', Header::get_grid_defaults() ),
		'sanitize_callback' => [ $sanitization, 'grid' ],
		'choices'           => [
			'parts'              => Header::get_header_grid_parts(),
			'duplicate'          => 'gridd_header_grid',
			'disablePartButtons' => [ 'edit' ],
		],
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
