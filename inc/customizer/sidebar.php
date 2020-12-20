<?php
/**
 * Customizer options.
 *
 * @package Gridd Plus
 */

use Gridd\Customizer;
use Gridd\Grid_Part\Sidebar;
use Gridd\AMP;

$number = Sidebar::get_number_of_sidebars();
for ( $i = 1; $i <= $number; $i++ ) {
	gridd_plus_sidebar_customizer_options( $i );
}

/**
 * This function creates all options for a sidebar.
 * We use a parameter since we'll allow multiple sidebars.
 *
 * @since 1.0
 * @param int $id The number of this sidebar.
 * @return void
 */
function gridd_plus_sidebar_customizer_options( $id ) {
	Customizer::add_field(
		[
			'type'        => 'slider',
			'settings'    => "sidebar_{$id}_font_size",
			'label'       => esc_attr__( 'Font Size', 'gridd-plus' ),
			'description' => '',
			'section'     => "sidebar_$id",
			'priority'    => 47,
			'default'     => 1,
			'choices'     => [
				'min'  => 0.5,
				'max'  => 3,
				'step' => 0.01,
			],
			'transport'   => 'auto',
			'output'      => [
				[
					'element'       => ".gridd-tp-sidebar_{$id}",
					'property'      => 'font-size',
					'value_pattern' => '$em',
				],
			],
		]
	);

	Customizer::add_field(
		[
			'type'        => 'text',
			'settings'    => "sidebar_{$id}_visibility_post_id",
			'label'       => esc_attr__( 'Visibility: Post-IDs', 'gridd-plus' ),
			'description' => esc_html__( 'If you only want to show this grid-part in a specific page, enter its post-ID here. If you want to add multiple posts separate them with a comma.', 'gridd-plus' ),
			'section'     => "sidebar_$id",
			'priority'    => 300,
			'default'     => '',
		]
	);

	Customizer::add_field(
		[
			'type'        => 'text',
			'settings'    => "sidebar_{$id}_visibility_term_id",
			'label'       => esc_attr__( 'Visibility: Term-IDs', 'gridd-plus' ),
			'description' => esc_html__( 'If you only want to show this grid-part in a specific category, tag etc, enter the term-ID here. If you want to add multiple terms separate them with a comma.', 'gridd-plus' ),
			'section'     => "sidebar_$id",
			'priority'    => 301,
			'default'     => '',
		]
	);
}
