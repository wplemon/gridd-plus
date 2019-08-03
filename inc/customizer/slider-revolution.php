<?php
/**
 * Extra settings for the header grid-part.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

if ( ! class_exists( '\RevSliderSlider' ) ) {
	return;
}
$sliders = new \RevSliderSlider();
foreach ( $sliders->getArrSliders() as $slider ) {
	Customizer::add_section(
		'gridd_grid_part_details_slider-revolution-' . $slider->getAlias(),
		[
			'title'   => sprintf(
				/* translators: The grid-part label. */
				esc_attr__( '%s Options', 'gridd-plus' ),
				/* translators: The slider-revolution name. */
				sprintf( esc_html__( 'Layer Slider %s', 'gridd-plus' ), esc_html( $slider->getTitle() ) )
			),
			'section' => 'gridd_grid',
		]
	);

	Customizer::add_field(
		[
			'type'        => 'custom',
			'settings'    => 'gridd_grid_part_details_slider-revolution-no-options-notice' . $slider->getAlias(),
			'label'       => '',
			'description' => '',
			'section'     => 'gridd_grid_part_details_slider-revolution-' . $slider->getAlias(),
			'default'     => esc_html__( "Slider Revolution parts don't have any settings. If you want to modify your slider please use the Slider Revolution plugin.", 'gridd-plus' ),
		]
	);
}
