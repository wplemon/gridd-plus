<?php
/**
 * Customizer options.
 *
 * @package Gridd Plus
 */

use Gridd_Plus\Grid_Part\Nested_Grid;
use Gridd\Grid_Parts;
use Gridd\Customizer;
use Gridd\customizer\Sanitize;

/**
 * Add the nested-grid options.
 *
 * @since 1.0
 * @param int $id The nested-grid ID.
 */
function gridd_add_nested_grid_options( $id ) {

	$sanitization = new Sanitize();
	new \Kirki\Section(
		"nested-grid-{$id}",
		[
			/* translators: Number of a nested-grid. */
			'title'           => sprintf( esc_html__( 'Nested Grid %d', 'gridd-plus' ), $id ),
			'description'     => '<a href="https://wplemon.com/documentation/gridd/grid-parts/nested-grid/" target="_blank" rel="noopener noreferrer nofollow">' . esc_html__( 'Learn more about these settings', 'gridd-plus' ),
			'section'         => 'theme_options',
			'type'            => 'kirki-expanded',
			'active_callback' => function() use ( $id ) {
				return \Gridd\Customizer::is_section_active_part( "nested-grid-$id" );
			},
		]
	);

	$parts = Grid_Parts::get_instance()->get_parts();

	// Remove parts that are not valid in this sub-grid.
	foreach ( $parts as $key => $part ) {

		if ( isset( $part['id'] ) ) {

			// Remove content.
			if ( 'content' === $part['id'] ) {
				unset( $parts[ $key ] );
			}

			if ( "nested-grid-$id" === $part['id'] ) {
				unset( $parts[ $key ] );
			}
		}
	}

	Customizer::add_field(
		[
			'settings'          => "gridd_nested_grid_$id",
			'section'           => "nested-grid-$id",
			'type'              => 'gridd_grid',
			'grid-part'         => "nested-grid-$id",
			'label'             => esc_html__( 'Grid Settings', 'gridd-plus' ),
			'description'       => sprintf(
				/* translators: Link attributes. */
				__( 'Edit settings for the grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
			),
			'default'           => [
				'rows'         => 1,
				'columns'      => 2,
				'areas'        => [],
				'gridTemplate' => [
					'rows'    => [],
					'columns' => [],
				],
			],
			'choices'           => [
				'parts' => $parts,
			],
			'sanitize_callback' => [ $sanitization, 'grid' ],
			'transport'         => 'postMessage',
			'partial_refresh'   => [
				"gridd_nested_grid_{$id}_template" => [
					'selector'            => ".gridd-tp-nested-grid-{$id}",
					'container_inclusive' => true,
					'render_callback'     => function() use ( $id ) {
						do_action( 'gridd_the_grid_part', "nested-grid-{$id}" );
					},
				],
			],
		]
	);

	Customizer::add_field(
		[
			'type'      => 'dimension',
			'settings'  => "gridd_nested_grid_{$id}_gap",
			'label'     => esc_attr__( 'Grid Container Gap', 'gridd-plus' ),
			'tooltip'   => esc_html__( 'If you have a background-color defined for this grid, then that color will be visible through these gaps which creates a unique appearance since each grid-part looks separate.', 'gridd-plus' ),
			'section'   => "nested-grid-$id",
			'default'   => '0',
			'transport' => 'postMessage',
			'transport' => 'auto',
			'output'    => [
				[
					'element'  => ".gridd-tp-nested-grid-$id",
					'property' => '--gg',
				],
			],
		]
	);

	Customizer::add_field(
		[
			'type'        => 'dimension',
			'settings'    => "gridd_nested_grid_{$id}_max_width",
			'label'       => esc_attr__( 'Grid Container max-width', 'gridd-plus' ),
			'description' => esc_html__( 'The maximum width for this grid.', 'gridd-plus' ),
			'tooltip'     => esc_html__( 'By setting the max-width to something other than 100% you get a boxed layout.', 'gridd-plus' ),
			'section'     => "nested-grid-$id",
			'default'     => '',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => ".gridd-tp-nested-grid-$id",
					'property' => '--mw',
				],
			],
		]
	);

	new \Kirki\Field\ReactColor(
		[
			'settings'    => "gridd_nested_grid_{$id}_background_color",
			'label'       => esc_attr__( 'Grid Container background-color', 'gridd-plus' ),
			'description' => '',
			'section'     => "nested-grid-$id",
			'default'     => '#ffffff',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => ".gridd-tp-nested-grid-$id",
					'property' => '--bg',
				],
			],
			'choices'     => [
				'formComponent' => 'ChromePicker',
			],
		]
	);

	Customizer::add_field(
		[
			'type'        => 'radio',
			'settings'    => "gridd_nested_grid_{$id}_box_shadow",
			'label'       => esc_html__( 'Drop Shadow Intensity', 'gridd-plus' ),
			'description' => esc_html__( 'Set to "None" if you want to disable the shadow for this grid-part, or increase the intensity for a more dramatic effect.', 'gridd-plus' ),
			'section'     => "nested-grid-$id",
			'default'     => 'none',
			'transport'   => 'auto',
			'output'      => [
				[
					'element'  => ".gridd-tp-nested-grid-$id",
					'property' => '--bs',
				],
			],
			'priority'    => 200,
			'choices'     => [
				'none' => esc_html__( 'None', 'gridd-plus' ),
				'0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)' => esc_html__( 'Extra Light', 'gridd-plus' ),
				'0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23)' => esc_html__( 'Light', 'gridd-plus' ),
				'0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23)' => esc_html__( 'Medium', 'gridd-plus' ),
				'0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)' => esc_html__( 'Heavy', 'gridd-plus' ),
				'0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22)' => esc_html__( 'Extra Heavy', 'gridd-plus' ),
			],
		]
	);

	Customizer::add_field(
		[
			'type'      => 'switch',
			'settings'  => "gridd_nested_grid_{$id}_sticky",
			'label'     => esc_attr__( 'Sticky', 'gridd-plus' ),
			'section'   => "nested-grid-$id",
			'default'   => false,
			'transport' => 'auto',
			'priority'  => 300,
		]
	);
}

$number = Nested_Grid::get_number_of_nested_grids();
for ( $i = 1; $i <= $number; $i++ ) {
	gridd_add_nested_grid_options( $i );
}
