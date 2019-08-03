<?php
/**
 * Gridd theme Layer-Slider grid-part
 *
 * @package Gridd Plus
 */

namespace Gridd_Plus\Grid_Part;

use Gridd\Grid;
use Gridd\Grid_Part;
use Gridd\Theme;

/**
 * The Gridd\Grid_Part\Layer_Slider object.
 *
 * @since 1.0
 */
class Layer_Slider extends Grid_Part {

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
		if ( class_exists( 'LS_Sliders' ) ) {
			$sliders = \LS_Sliders::find();
			foreach ( $sliders as $slider ) {
				$parts[] = [
					/* translators: The Layer-Slider name. */
					'label'    => sprintf( esc_html__( 'Slider: %s', 'gridd-plus' ), esc_html( $slider['name'] ) ),
					'color'    => [ '#32aafa', '#fff' ],
					'priority' => 250,
					'id'       => "layer-slider-{$slider['id']}",
				];
			}
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
		if ( 0 === strpos( $part, 'layer-slider-' ) && is_numeric( str_replace( 'layer-slider-', '', $part ) ) ) {
			$id = absint( str_replace( 'layer-slider-', '', $part ) );
			if ( function_exists( 'layerslider' ) ) {
				?>
				<div <?php Theme::print_attributes( [ 'class' => 'gridd-tp gridd-tp-layer-slider gridd-tp-layer-slider-' . $id ], 'wrapper-layer-slider' ); ?>>
					<?php layerslider( $id ); ?>
				</div>
				<?php
			}
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
