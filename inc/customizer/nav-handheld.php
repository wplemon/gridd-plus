<?php
/**
 * Extra settings for the nav-handheld grid-part.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Customizer;

Customizer::add_field(
	[
		'type'            => 'text',
		'settings'        => 'gridd_grid_nav-handheld_widget_area_label',
		'label'           => esc_html__( 'Widget Area Button Label', 'gridd-plus' ),
		'description'     => esc_html__( 'Please add a label for the widget area.', 'gridd-plus' ),
		'section'         => 'gridd_mobile',
		'default'         => esc_html__( 'Settings', 'gridd-plus' ),
		'transport'       => 'postMessage',
		'partial_refresh' => [
			'gridd_grid_nav-handheld_widget_area_label_template' => [
				'selector'            => '.gridd-tp-nav-handheld',
				'container_inclusive' => true,
				'render_callback'     => function() {
					do_action( 'gridd_the_grid_part', 'nav-handheld' );
				},
			],
		],
		'active_callback' => [
			[
				'setting'  => 'gridd_grid_nav-handheld_enable',
				'operator' => '===',
				'value'    => true,
			],
			[
				'setting'  => 'gridd_grid_nav-handheld_parts',
				'operator' => 'contains',
				'value'    => 'widget-area',
			],
		],
	]
);

Customizer::add_field(
	[
		'type'              => 'textarea',
		'settings'          => 'gridd_grid_nav-handheld_widget_area_icon',
		'label'             => esc_html__( 'Widget Area Button SVG Icon', 'gridd-plus' ),
		'description'       => __( 'Paste SVG code for the icon you want to use. You can find a great collection of icons on the <a href="https://iconmonstr.com/" target="_blank" rel="noopener noreferrer nofollow">iconmonstr website</a> or add your custom icon.', 'gridd-plus' ),
		'section'           => 'gridd_mobile',
		'default'           => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"/></svg>',
		'transport'         => 'postMessage',
		'sanitize_callback' => function( $value ) {
			return $value;
		},
		'partial_refresh'   => [
			'grid_part_handheld_widget_area_icon' => [
				'selector'            => '.gridd-tp-nav-handheld',
				'container_inclusive' => true,
				'render_callback'     => function() {
					do_action( 'gridd_the_grid_part', 'nav-handheld' );
				},
			],
		],
		'active_callback'   => [
			[
				'setting'  => 'gridd_grid_nav-handheld_parts',
				'operator' => 'contains',
				'value'    => 'widget-area',
			],
			[
				'setting'  => 'gridd_grid_nav-handheld_enable',
				'operator' => '===',
				'value'    => true,
			],
		],
	]
);
