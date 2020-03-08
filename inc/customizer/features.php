<?php
/**
 * Extra features.
 *
 * @package Gridd Plus
 * @since 1.0
 */

new \Kirki\Field\Dimension(
	[
		'settings'        => 'gridd_featured_image_fixed_singular_height',
		'label'           => esc_attr__( 'Fixed container maximum height', 'gridd-plus' ),
		'description'     => esc_html__( 'Select how featured images will be displayed in single post-types (Applies to all post-types).', 'gridd-plus' ),
		'section'         => 'gridd_features_single_post',
		'default'         => '60vh',
		'priority'        => 25,
		'transport'       => 'refresh',
		'output'          => [
			[
				'element'  => ':root',
				'property' => '--fimg-fh',
			],
		],
		'transport'       => 'postMessage',
		'active_callback' => [
			[
				'setting'  => 'gridd_featured_image_mode_singular',
				'value'    => 'fixed',
				'operator' => '===',
			],
		],
	]
);
