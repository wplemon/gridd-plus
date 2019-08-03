<?php
/**
 * Gridd theme Nested_Grid grid-part
 *
 * @package Gridd Plus
 */

namespace Gridd_Plus\Grid_Part;

use Gridd\Grid;
use Gridd\Grid_Part;
use Gridd\Style;

/**
 * The Gridd\Grid_Part\Nested_Grid object.
 *
 * @since 1.0
 */
class Nested_Grid extends Grid_Part {

	/**
	 * The path to this directory..
	 *
	 * @access protected
	 * @since 1.0
	 * @var string
	 */
	protected $dir = __DIR__;

	/**
	 * Returns the grid-part definition.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_part() {}

	/**
	 * Hooks & extra operations.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function init() {
		add_action( 'gridd_the_grid_part', [ $this, 'render' ] );
	}

	/**
	 * Adds the grid-part to the array of grid-parts.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $parts The existing grid-parts.
	 * @return array
	 */
	public function add_template_part( $parts ) {
		$number = self::get_number_of_nested_grids();
		for ( $i = 1; $i <= $number; $i++ ) {
			$parts[] = [
				/* translators: Number of a nested-grid. */
				'label'    => sprintf( esc_html__( 'Nested Grid %d', 'gridd-plus' ), absint( $i ) ),
				'color'    => [ '#607d8b', '#fff' ],
				'priority' => 250,
				'id'       => "nested-grid-{$i}",
				'grid'     => "gridd_nested_grid_{$i}",
			];
		}
		return $parts;
	}

	/**
	 * Render this grid-part.
	 *
	 * @access public
	 * @since 1.0
	 * @param string $part The grid-part ID.
	 * @return void
	 */
	public function render( $part ) {
		if ( 0 === strpos( $part, 'nested-grid-' ) && is_numeric( str_replace( 'nested-grid-', '', $part ) ) ) {
			$id = (int) str_replace( 'nested-grid-', '', $part );
			/**
			 * We use include( get_theme_file_path() ) here
			 * because we need to pass the $sidebar_id var to the template.
			 */
			include GRIDD_PLUS_PATH . '/inc/templates/nested-grid.php';
		}
	}

	/**
	 * Gets the number of navigation menus.
	 * Returns the object's $number property.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 */
	public static function get_number_of_nested_grids() {
		return apply_filters( 'gridd_get_number_of_nested_grids', 3 );
	}
}
