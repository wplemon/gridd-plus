<?php
/**
 * Add custom fields.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Grid_Parts;
$all_parts   = Grid_Parts::get_instance()->get_parts();
$parts_array = [];
foreach ( $all_parts as $part ) {
	if ( isset( $part['id'] ) ) {
		$part['label']              = isset( $part['label'] ) ? $part['label'] : $part['id'];
		$parts_array[ $part['id'] ] = $part['label'];
	}
}

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_5c976c1f62554',
			'title'                 => esc_html__( 'Gridd Plus', 'gridd-plus' ),
			'fields'                => array(
				array(
					'key'               => 'field_5c976c83f3aca',
					'label'             => esc_html__( 'Hide Title', 'gridd-plus' ),
					'name'              => 'gridd_plus_hide_title',
					'type'              => 'true_false',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'message'           => esc_html__( 'Enable this option to hide the page title', 'gridd-plus' ),
					'default_value'     => 0,
					'ui'                => 0,
					'ui_on_text'        => '',
					'ui_off_text'       => '',
				),
				array(
					'key'               => 'field_5c976e36561dd',
					'label'             => esc_html__( 'Custom Grid Column Dimensions', 'gridd-plus' ),
					'name'              => 'gridd_plus_custom_grid_column_dimensions',
					'type'              => 'text',
					'instructions'      => esc_html__( 'Enter comma-separated dimensions for the grid columns. If no values are entered in this field, values will be auto-calculated.', 'gridd-plus' ),
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_5c976e88561de',
					'label'             => esc_html__( 'Custom Grid Row Dimensions', 'gridd-plus' ),
					'name'              => 'gridd_plus_custom_grid_row_dimensions',
					'type'              => 'text',
					'instructions'      => esc_html__( 'Enter comma-separated dimensions for the grid rows. If no values are entered in this field, values will be auto-calculated.', 'gridd-plus' ),
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
					'maxlength'         => '',
				),
				array(
					'key'               => 'field_5c976ebf3c525',
					'label'             => esc_html__( 'Custom Grid', 'gridd-plus' ),
					'name'              => 'gridd_plus_custom_grid',
					'type'              => 'repeater',
					'instructions'      => esc_html__( 'Add the grid-parts this page should have, and select where these parts should be placed in your grid.', 'gridd-plus' ),
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'collapsed'         => 'field_5c976ef83c526',
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'table',
					'button_label'      => '',
					'sub_fields'        => array(
						array(
							'key'               => 'field_5c976ef83c526',
							'label'             => esc_html__( 'Grid Part', 'gridd-plus' ),
							'name'              => 'grid_part',
							'type'              => 'select',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => $parts_array,
							'default_value'     => array(),
							'allow_null'        => 0,
							'multiple'          => 0,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
						),
						array(
							'key'               => 'field_5c976f3f3c527',
							'label'             => esc_html__( 'Start Column', 'gridd-plus' ),
							'name'              => 'start_column',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => 1,
							'max'               => '',
							'step'              => 1,
						),
						array(
							'key'               => 'field_5c976f5b3c528',
							'label'             => esc_html__( 'Column Span', 'gridd-plus' ),
							'name'              => 'column_span',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => 1,
							'max'               => '',
							'step'              => 1,
						),
						array(
							'key'               => 'field_5c976f803c529',
							'label'             => esc_html__( 'Start Row', 'gridd-plus' ),
							'name'              => 'start_row',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => 1,
							'max'               => '',
							'step'              => 1,
						),
						array(
							'key'               => 'field_5c976fa53c52a',
							'label'             => esc_html__( 'Row Span', 'gridd-plus' ),
							'name'              => 'row_span',
							'type'              => 'number',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => 1,
							'max'               => '',
							'step'              => 1,
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		)
	);

endif;
