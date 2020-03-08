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

new \Kirki\Field\Checkbox(
	[
		'settings' => 'footer_mobile_grid_override',
		'label'    => esc_html__( 'Override Mobile Footer Grid', 'gridd-plus' ),
		'section'  => 'footer_grid',
		'default'  => false,
		'priority' => 100,
	]
);

Customizer::add_field(
	[
		'settings'          => 'footer_mobile',
		'section'           => 'footer_grid',
		'type'              => 'gridd_grid',
		'priority'          => 100,
		'grid-part'         => 'footer',
		'label'             => esc_html__( 'Footer Mobile Grid', 'gridd-plus' ),
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
		'active_callback'   => function() {
			return get_theme_mod( 'footer_mobile_grid_override', false );
		},
		'choices'           => [
			'parts'              => Footer::get_footer_grid_parts(),
			'duplicate'          => 'footer_grid',
			'disablePartButtons' => [ 'edit' ],
		],
		'transport'         => 'postMessage',
		'partial_refresh'   => [
			'footer_grid_mobile_template' => [
				'selector'            => '.gridd-tp-footer',
				'container_inclusive' => false,
				'render_callback'     => function() {
					do_action( 'gridd_the_grid_part', 'footer' );
				},
			],
		],
	]
);

/**
 * WIP
new \Kirki\Field\Custom(
	[
		'settings'        => 'gridd_copy_footer_grid_to_mobile',
		'type'            => 'custom',
		'label'           => '',
		'section'         => 'footer_grid',
		'default'         => '<div style="margin-bottom:1em;"><button class="button-gridd-copy-grid-setting button button-primary button-large" data-from="footer_grid" data-to="footer_mobile">' . esc_html__( 'Copy footer desktop grid to mobile', 'gridd-plus' ) . '</button></div>',
		'priority'        => 110,
		'active_callback' => function() {
			return get_theme_mod( 'footer_mobile_grid_override', false );
		},
	]
);
*/
