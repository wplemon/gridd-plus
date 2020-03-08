<?php
/**
 * Gridd theme Layer-Slider grid-part
 *
 * @package Gridd Plus
 */

namespace Gridd_Plus\Grid_Part;

use Gridd\Grid_Part;
use Gridd\Theme;

/**
 * The Gridd\Grid_Part\Slider_Revolution object.
 *
 * @since 1.0
 */
class Slider_Revolution extends Grid_Part {

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
		if ( class_exists( '\RevSliderSlider' ) ) {
			$sliders = new \RevSliderSlider();
			foreach ( $sliders->getArrSliders() as $slider ) {
				$parts[] = [
					/* translators: The Layer-Slider name. */
					'label'    => sprintf( esc_html__( 'Slider: %s', 'gridd-plus' ), esc_html( $slider->getTitle() ) ),
					'color'    => [ '#d00000', '#fff' ],
					'priority' => 250,
					'id'       => 'slider-revolution-' . $slider->getAlias(),
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
		if ( 0 === strpos( $part, 'slider-revolution-' ) ) {
			$id = str_replace( 'slider-revolution-', '', $part );
			if ( class_exists( '\RevSliderSlider' ) ) {
				?>
				<div <?php Theme::print_attributes( [ 'class' => 'gridd-tp gridd-tp-slider-revolution gridd-tp-slider-revolution-' . $id ], 'wrapper-layer-slider' ); ?>>
					<?php echo do_shortcode( '[rev_slider alias="' . $id . '"]' ); ?>
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
