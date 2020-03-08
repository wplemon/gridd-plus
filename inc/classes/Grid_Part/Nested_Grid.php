<?php
/**
 * Gridd theme Nested_Grid grid-part
 *
 * @package Gridd Plus
 */

namespace Gridd_Plus\Grid_Part;

use Gridd\Grid_Part;

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

			$settings = \Gridd\Grid::get_options( "gridd_nested_grid_$id" );
			$classes  = [
				'gridd-tp',
				"gridd-tp-nested-grid-$id",
			];
			if ( get_theme_mod( "gridd_nested_grid_{$id}_sticky", false ) ) {
				$classes[] = 'gridd-sticky';
			}

			$style = \Gridd\Style::get_instance( "grid-part/nested-grid-$id" );
			$style->add_string(
				\Gridd\Grid::get_styles_responsive(
					[
						'context'    => "nested-grid-$id",
						'large'      => $settings,
						'small'      => false,
						'breakpoint' => get_theme_mod( 'gridd_mobile_breakpoint', '800px' ),
						'selector'   => '.gridd-tp-nested-grid-1 > .inner',
						'prefix'     => true,
					]
				)
			);
			$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nested-grid-default.min.css' );

			// Add styles for large screens.
			$style->add_string( '@media only screen and (min-width:' . get_theme_mod( 'gridd_mobile_breakpoint', '800px' ) . '){' );
			$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nested-grid-large.min.css' );
			$style->add_string( '}' );

			// Generate grid styles for parts.
			$style->add_string( \Gridd\Grid::get_styles( $settings, "gridd-tp-nested-grid-$id > .inner", true ) );
			$style->replace( 'ID', $id );
			$style->add_vars(
				[
					"gridd-nested-grid-$id-background" => get_theme_mod( "gridd_nested_grid_{$id}_background_color", '#ffffff' ),
					"gridd-nested-grid-$id-padding"    => get_theme_mod( "gridd_nested_grid_{$id}_padding", 0 ),
					"gridd-nested-grid-$id-box-shadow" => get_theme_mod( "gridd_nested_grid_{$id}_box_shadow", 'none' ),
					"gridd-nested-grid-$id-max-width"  => get_theme_mod( "gridd_nested_grid_{$id}_max_width", '' ),
					"gridd-nested-grid-$id-grid-gap"   => get_theme_mod( "gridd_nested_grid_{$id}_gap", 0 ),
				]
			);
			?>
			<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
				<?php
				/**
				 * Print styles.
				 */
				$style->the_css( 'gridd-inline-css-nested-grid-' . $id );
				?>
				<div class="inner">
					<?php if ( isset( $settings['areas'] ) ) : ?>
						<?php foreach ( array_keys( $settings['areas'] ) as $part ) : ?>
							<?php do_action( 'gridd_the_grid_part', $part ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php
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
