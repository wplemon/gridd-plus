<?php
/**
 * Extra settings for the header grid-part.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

if ( ! class_exists( '\LS_Sliders' ) ) {
	return;
}
$sliders = \LS_Sliders::find();
foreach ( $sliders as $slider ) {
	Customizer::add_section(
		"gridd_grid_part_details_layer-slider-{$slider['id']}",
		[
			'title'   => sprintf(
				/* translators: The grid-part label. */
				esc_attr__( '%s Options', 'gridd-plus' ),
				/* translators: The Layer-Slider name. */
				sprintf( esc_html__( 'Layer Slider %s', 'gridd-plus' ), esc_html( $slider['name'] ) )
			),
			'section' => 'gridd_grid',
		]
	);

	Customizer::add_field(
		[
			'type'        => 'custom',
			'settings'    => "gridd_layer_slider_no_settings_notice_{$slider['id']}",
			'label'       => '',
			'description' => '',
			'section'     => "gridd_grid_part_details_layer-slider-{$slider['id']}",
			'default'     => esc_html__( "Layer Slider parts don't have any settings. If you want to modify your slider please use the LayerSlider plugin.", 'gridd-plus' ),
		]
	);
}
