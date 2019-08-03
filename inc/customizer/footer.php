<?php
/**
 * Extra settings for the footer grid-part.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;
use Gridd\Grid_Part\Footer;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

/**
 * Global toggle for mobile/desktop grid.
 */
Customizer::add_field(
	[
		'settings'          => 'gridd_footer_grid_toggle',
		'type'              => 'radio-buttonset',
		'label'             => esc_html__( 'Toggle between desktop & mobile grids.', 'gridd-plus' ),
		'section'           => 'gridd_grid_part_details_footer',
		'default'           => 'desktop',
		'priority'          => -10,
		'transport'         => 'postMessage',
		'choices'           => [
			'desktop' => esc_html__( 'Desktop', 'gridd-plus' ),
			'mobile'  => esc_html__( 'Mobile', 'gridd-plus' ),
		],
		'sanitize_callback' => function() {
			return 'desktop';
		},
	]
);

Customizer::add_field(
	[
		'settings'        => 'gridd_copy_footer_grid_to_mobile',
		'type'            => 'custom',
		'label'           => esc_html__( 'Copy desktop grid setings to mobile grid', 'gridd-plus' ),
		'section'         => 'gridd_grid_part_details_footer',
		'default'         => '<div style="margin-bottom:1em;"><button class="button-gridd-copy-grid-setting button button-primary button-large" data-from="gridd_footer_grid" data-to="gridd_grid_footer_mobile">' . esc_html__( 'Click here to copy settings from desktop grid', 'gridd-plus' ) . '</button></div>',
		'active_callback' => [
			[
				'setting'  => 'gridd_footer_grid_toggle',
				'operator' => '===',
				'value'    => 'mobile',
			],
		],
	]
);

Customizer::add_field(
	[
		'settings'          => 'gridd_grid_footer_mobile',
		'section'           => 'gridd_grid_part_details_footer',
		'type'              => 'gridd_grid',
		'grid-part'         => 'footer',
		'label'             => esc_html__( 'Footer Mobile Grid Settings', 'gridd-plus' ),
		'description'       => sprintf(
			/* translators: Link attributes. */
			__( 'Edit settings for the footer grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
		),
		'default'           => [
			'rows'         => 2,
			'columns'      => 2,
			'areas'        => [
				'footer_sidebar_1' => [
					'cells' => [ [ 1, 1 ] ],
				],
				'footer_sidebar_2' => [
					'cells' => [ [ 1, 2 ] ],
				],
				'footer_copyright' => [
					'cells' => [ [ 2, 1 ], [ 2, 2 ] ],
				],
			],
			'gridTemplate' => [
				'rows'    => [ 'auto', 'auto' ],
				'columns' => [ '1fr', '1fr', '1fr', '1fr' ],
			],
		],
		'sanitize_callback' => [ $sanitization, 'grid' ],
		'choices'           => [
			'parts'              => Footer::get_footer_grid_parts(),
			'duplicate'          => 'gridd_footer_grid',
			'disablePartButtons' => [ 'edit' ],
		],
		'transport'         => 'postMessage',
		'partial_refresh'   => [
			'gridd_footer_grid_mobile_template' => [
				'selector'            => '.gridd-tp-footer',
				'container_inclusive' => false,
				'render_callback'     => function() {
					do_action( 'gridd_the_grid_part', 'footer' );
				},
			],
		],
	]
);
