<?php
/**
 * The main plugin class.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

use Gridd\Grid_Parts;

/**
 * The Gridd_Plus object.
 * Takes care of initializing the plugin and doing what must be done.
 *
 * @since 1.0
 */
class Grid {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_filter( 'gridd_get_options_defaults', [ $this, 'options_defaults' ], 10, 2 );
		add_filter( 'gridd_styles_responsive_args', [ $this, 'styles_responsive_args' ] );
		add_filter( 'gridd_active_grid_parts', [ $this, 'active_grid_parts' ] );
		add_filter( 'gridd_get_options', [ $this, 'grid_from_post_meta' ], 20, 2 );
	}

	/**
	 * Modify the array of active grid-parts.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $grid_parts An array of active grid-parts.
	 * @return array
	 */
	public function active_grid_parts( $grid_parts ) {
		// Get all grid-parts.
		$all_parts = Grid_Parts::get_instance()->get_parts();

		foreach ( $all_parts as $part ) {

			// Check if we've got a custom grid for mobile.
			if ( get_theme_mod( 'gridd_custom_mobile_grid', false ) ) {

				// Add mobile grid parts.
				if ( Grid_Parts::is_grid_part_active( $part['id'], 'gridd_grid_mobile' ) && ! in_array( $part['id'], $grid_parts, true ) ) {
					$grid_parts[] = $part['id'];
				}
			}
		}
		return $grid_parts;
	}

	/**
	 * Add grid options for small viewports.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $args The existing arguments.
	 * @return array      Modified arguments.
	 */
	public function styles_responsive_args( $args ) {
		switch ( $args['context'] ) {
			case 'main':
				if ( get_theme_mod( 'gridd_custom_mobile_grid', false ) ) {
					$args['small'] = \Gridd\Grid::get_options( 'gridd_grid_mobile' );
				}
				break;

			case 'header':
				$args['small'] = \Gridd\Grid::get_options( 'gridd_grid_header_mobile' );
				break;

			case 'footer':
				$args['small'] = \Gridd\Grid::get_options( 'gridd_grid_footer_mobile' );
				break;

		}
		return $args;
	}

	/**
	 * Modify default values for controls.
	 * We're using this in the theme for grid values.
	 *
	 * @access public
	 * @since 1.0
	 * @param mixed  $defaults  The default value.
	 * @param string $theme_mod The theme-mod we're getting.
	 * @return mixed
	 */
	public function options_defaults( $defaults, $theme_mod ) {
		switch ( $theme_mod ) {
			case 'gridd_grid_mobile':
				return [
					'rows'         => 5,
					'columns'      => 1,
					'areas'        => [
						'header'      => [
							'cells' => [ [ 1, 1 ] ],
						],
						'breadcrumbs' => [
							'cells' => [ [ 2, 1 ] ],
						],
						'content'     => [
							'cells' => [ [ 3, 1 ] ],
						],
						'sidebar_1'   => [
							'cells' => [ [ 4, 1 ] ],
						],
						'footer'      => [
							'cells' => [ [ 5, 1 ] ],
						],
					],
					'gridTemplate' => [
						'rows'    => [ 'auto', 'auto', 'auto', 'auto', 'auto' ],
						'columns' => [ 'auto' ],
					],
				];

			case 'gridd_grid_header_mobile':
				return get_theme_mod(
					'gridd_header_grid',
					[
						'rows'         => 1,
						'columns'      => 1,
						'areas'        => [
							'header_branding' => [
								'cells' => [ [ 1, 1 ] ],
							],
						],
						'gridTemplate' => [
							'rows'    => [ 'auto' ],
							'columns' => [ 'auto' ],
						],
					]
				);

			case 'gridd_grid_footer_mobile':
				return get_theme_mod(
					'gridd_footer_grid',
					[
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
					]
				);

			default:
				return $defaults;
		}
	}

	/**
	 * Applies custom Grids from post-meta.
	 *
	 * @access public
	 * @since 1.0
	 * @param mixed  $value     The theme-mod value.
	 * @param string $theme_mod The theme-mod.
	 * @return array            Modified grid - or the original value if we don't want custom grid.
	 */
	public function grid_from_post_meta( $value, $theme_mod ) {
		if ( 'gridd_grid' === $theme_mod ) {
			$custom_grid                = get_field( 'gridd_plus_custom_grid' );
			$custom_grid_row_dimensions = get_field( 'gridd_plus_custom_grid_row_dimensions' );
			$custom_grid_col_dimensions = get_field( 'gridd_plus_custom_grid_column_dimensions' );
			$max_col                    = 1;
			$max_row                    = 1;
			if ( $custom_grid ) {
				$areas = [];
				foreach ( $custom_grid as $part ) {
					$areas[ $part['grid_part'] ] = [
						'cells' => [],
					];

					// Get properties.
					$start_col = (int) $part['start_column'];
					$span_col  = (int) $part['column_span'];
					$start_row = (int) $part['start_row'];
					$span_row  = (int) $part['row_span'];

					for ( $col = $start_col; $col < $start_col + $span_col; $col++ ) {
						if ( $col > $max_col ) {
							$max_col = $col;
						}
						for ( $row = $start_row; $row < $start_row + $span_row; $row++ ) {
							if ( $row > $max_row ) {
								$max_row = $row;
							}
							$areas[ $part['grid_part'] ]['cells'][] = [ $row, $col ];
						}
					}
				}
				$value['rows']    = $max_row;
				$value['columns'] = $max_col;
				$value['areas']   = $areas;
			}

			// Add custom column dimensions.
			$max_cols = max( $max_col, $value['columns'], count( $value['gridTemplate']['columns'] ) );
			if ( $custom_grid_col_dimensions ) {
				$custom_grid_col_dimensions = explode( ',', $custom_grid_col_dimensions );
				foreach ( $custom_grid_col_dimensions as $key => $dimension ) {
					$value['gridTemplate']['columns'][ $key ] = esc_attr( trim( $dimension ) );
				}
			}

			// Fill-in the blanks with "auto" values.
			if ( $value['columns'] < $max_cols ) {
				for ( $i = 0; $i < $max_cols - $value['columns']; $i++ ) {
					$value['gridTemplate']['columns'][] = 'auto';
				}
			}

			// Add custom row dimensions.
			$max_rows = max( $max_row, $value['rows'], count( $value['gridTemplate']['rows'] ) );
			if ( $custom_grid_row_dimensions ) {
				$custom_grid_row_dimensions = explode( ',', $custom_grid_row_dimensions );
				foreach ( $custom_grid_row_dimensions as $key => $dimension ) {
					$value['gridTemplate']['rows'][ $key ] = esc_attr( trim( $dimension ) );
				}
			}

			// Fill-in the blanks with "auto" values.
			if ( $value['rows'] < $max_rows ) {
				for ( $i = 0; $i < $max_rows - $value['rows']; $i++ ) {
					$value['gridTemplate']['rows'][] = 'auto';
				}
			}
		}
		return $value;
	}
}
