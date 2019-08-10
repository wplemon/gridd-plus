<?php
/**
 * Content Options.
 *
 * @package Gridd Plus
 * @since 1.1
 */

use Gridd\Grid;
use Gridd\Theme;
use Gridd\Customizer;
use Gridd\Grid_Parts;
use Gridd\Customizer\Sanitize;

$sanitization = new Sanitize();

$custom_parts_nr = apply_filters( 'gridd_plus_content_grid_custom_parts_number', 5 );

/**
 * Build the array of grid-parts.
 * This will be used by the grid control.
 *
 * @since 1.1
 */
$grid_parts = [
	[
		'id'       => 'single_post_title',
		'label'    => esc_html__( 'Title', 'gridd-plus' ),
		'color'    => [ '#512DA8', '#fff' ],
		'priority' => 0,
	],
	[
		'id'       => 'single_post_featured_image',
		'label'    => esc_html__( 'Featured Image', 'gridd-plus' ),
		'color'    => [ '#80DEEA', '#000' ],
		'priority' => 1,
	],
	[
		'id'       => 'single_post_content',
		'label'    => esc_html__( 'Content', 'gridd-plus' ),
		'color'    => [ '#D4E157', '#000' ],
		'priority' => 2,
	],
];

for ( $i = 1; $i <= $custom_parts_nr; $i++ ) {
	$grid_parts[] = [
		'id'       => 'single_post_custom_content_' . $i,
		/* Translators: Number. */
		'label'    => sprintf( esc_html__( 'Custom Content %s', 'gridd-plus' ), $i ),
		'color'    => [ 'hsl(' . ( $i * 37 ) . ',50%,75%)', '#000' ],
		'priority' => 10 + $i,
	];
}
/**
 * Add a toggle to allow customizing the post content grid.
 * This is used as a template switch and as a condition to hide or show the grid control.
 *
 * @since 1.1
 */
Customizer::add_field(
	[
		'settings' => 'gridd_single_posts_grid_override',
		'section'  => 'gridd_grid_part_details_content',
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Enable custom grid for posts content', 'gridd-plus' ),
		'default'  => false,
		'priority' => 21,
	]
);

/**
 * Add the grid control.
 *
 * @since 1.1
 */
Customizer::add_field(
	[
		'settings'          => 'gridd_single_posts_grid',
		'section'           => 'gridd_grid_part_details_content',
		'type'              => 'gridd_grid',
		'grid-part'         => false,
		'priority'          => 23,
		'label'             => esc_html__( 'Mobile Grid Settings', 'gridd-plus' ),
		'description'       => sprintf(
			/* translators: Link attributes. */
			__( 'Edit settings for the grid. For more information and documentation on how the grid works, please read <a %s>this article</a>.', 'gridd-plus' ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'href="https://wplemon.com/documentation/gridd/the-grid-control/" target="_blank"'
		),
		'default'           => [
			'rows'         => 1,
			'columns'      => 1,
			'gridTemplate' => [
				'rows'    => [ 'auto' ],
				'columns' => [ 'auto' ],
			],
			'areas'        => []
		],
		'sanitize_callback' => [ $sanitization, 'grid' ],
		'choices'           => [
			'parts' => $grid_parts,
		],
		'active_callback'   => [
			[
				'setting'  => 'gridd_single_posts_grid_override',
				'value'    => true,
				'operator' => '===',
			],
		],
	]
);

/**
 * Add filter to change the template for singlr posts content.
 *
 * @since 1.1
 */
add_filter(
	'gridd_get_template_part',
	/**
	 * Filters the path to the template file.
	 *
	 * @since 1.1
	 * @param string|false $custom_path The custom template-part path. Defaults to false. Use absolute path.
	 * @param string       $slug        The template slug.
	 * @param string       $name        The template name.
	 * @return string|false
	 */
	function( $custom_path, $slug, $name ) {
		if ( 'template-parts/content' === $slug && 'post' === $name ) {
			if ( ! get_theme_mod( 'gridd_single_posts_grid_override', false ) ) {
				return $custom_path;
			}
			return GRIDD_PLUS_PATH . '/inc/templates/single-post-content-grid.php';
		}
		return $custom_path;
	},
	100,
	3
);

/**
 * Add the template parts.
 *
 * @since 1.1
 */
add_action(
	'gridd_the_grid_part',
	/**
	 * Add the template part.
	 *
	 * @since 1.1
	 * @param string $part The grid-part.
	 * @return void
	 */
	function( $part ) {
		/**
		 * Template for post-title.
		 *
		 * @since 1.1
		 */
		$styles = '';
		if ( 'single_post_title' === $part ) {
			?>
			<style>
			.gridd-tp-single_post_title {
				background-color: var(--gridd-plus-post-title-bg,#fff);
				padding:var(--gridd-plus-post-title-padding,0.5em);
				color:var(--gridd-plus-post-title-color,#000);
			}
			.gridd-tp-single_post_title h1 {
				color:currentColor;
				margin: 0;
			}
			</style>
			<div class="gridd-tp gridd-tp-single_post_title">
				<?php Theme::get_template_part( 'template-parts/part-post-title' ); ?>
			</div>
			<?php
		}

		/**
		 * Template for post-content.
		 *
		 * @since 1.1
		 */
		if ( 'single_post_content' === $part ) {
			?>
			<style>
			.gridd-tp-single_post_content {
				max-width: var(--gridd-content-max-width);
				margin-left: auto;
				margin-right: auto;
				background-color: var(--gridd-plus-post-content-bg,#fff);
				padding:var(--gridd-plus-post-content-padding,0.5em);
				color:var(--gridd-plus-post-content-color,#000);
				display: block;
				width: 100%;
			}
			</style>
			<div class="gridd-tp gridd-tp-single_post_content">
				<?php Theme::get_template_part( 'template-parts/the-content' ); ?>
			</div>
			<?php
		}

		/**
		 * Template for featured-image.
		 *
		 * @since 1.1
		 */
		if ( 'single_post_featured_image' === $part ) {
			?>
			<div class="gridd-tp gridd-tp-single_post_featured_image">
				<?php the_post_thumbnail(); ?>
			</div>
			<?php
		}

		/**
		 * Template part for custom content.
		 *
		 * @since 1.1
		 */
		if ( false !== strpos( $part, 'single_post_custom_content_' ) ) {
			$i = (int) str_replace( 'single_post_custom_content_', '', $part );
			?>
			<div class="gridd-tp gridd-tp-single_post_custom_content_<?php echo intval( $i ); ?>">
				<?php echo do_blocks( do_shortcode( get_theme_mod( 'gridd_plus_single_post_custom_content_content_' . $i, '' ) ) ); ?>
			</div>
			<?php
		}
	}
);

/**
 * Add section for post-title details.
 *
 * @since 1.1
 */
Customizer::add_section(
	'gridd_grid_part_details_single_post_title',
	[
		'title'   => esc_attr__( 'Post Title', 'gridd-plus' ),
		'section' => 'gridd_grid_part_details_content',
	]
);

Customizer::add_field(
	[
		'type'        => 'color',
		'settings'    => 'gridd_plus_single_post_title_background_color',
		'label'       => esc_html__( 'Background Color', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_title',
		'default'     => '#ffffff',
		'choices'     => [
			'alpha' => true,
		],
		'css_vars'    => '--gridd-plus-post-title-bg',
		'transport'   => 'postMessage',
	]
);

Customizer::add_field(
	[
		'type'        => 'color',
		'settings'    => 'gridd_plus_single_post_title_color',
		'label'       => esc_html__( 'Color', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_title',
		'default'     => '#000000',
		'choices'     => [
			'alpha' => true,
		],
		'css_vars'    => '--gridd-plus-post-title-color',
		'transport'   => 'postMessage',
	]
);

Customizer::add_field(
	[
		'type'        => 'dimension',
		'settings'    => 'gridd_plus_single_post_title_padding',
		'label'       => esc_html__( 'Padding', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_title',
		'default'     => '0.5em',
		'css_vars'    => '--gridd-plus-post-title-padding',
		'transport'   => 'postMessage',
	]
);

/**
 * Add section for post-content details.
 *
 * @since 1.1
 */
Customizer::add_section(
	'gridd_grid_part_details_single_post_content',
	[
		'title'   => esc_attr__( 'Post Content', 'gridd-plus' ),
		'section' => 'gridd_grid_part_details_content',
	]
);

Customizer::add_field(
	[
		'type'        => 'color',
		'settings'    => 'gridd_plus_single_post_content_background_color',
		'label'       => esc_html__( 'Background Color', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_content',
		'default'     => '#ffffff',
		'choices'     => [
			'alpha' => true,
		],
		'css_vars'    => '--gridd-plus-post-content-bg',
		'transport'   => 'postMessage',
	]
);

Customizer::add_field(
	[
		'type'        => 'color',
		'settings'    => 'gridd_plus_single_post_content_color',
		'label'       => esc_html__( 'Color', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_content',
		'default'     => '#000000',
		'choices'     => [
			'alpha' => true,
		],
		'css_vars'    => '--gridd-plus-post-content-color',
		'transport'   => 'postMessage',
	]
);

Customizer::add_field(
	[
		'type'        => 'dimension',
		'settings'    => 'gridd_plus_single_post_content_padding',
		'label'       => esc_html__( 'Padding', 'gridd-plus' ),
		'section'     => 'gridd_grid_part_details_single_post_content',
		'default'     => '0.5em',
		'css_vars'    => '--gridd-plus-post-content-padding',
		'transport'   => 'postMessage',
	]
);

/**
 * Add section for custom-content parts.
 *
 * @since 1.1
 */
for ( $i = 1; $i <= $custom_parts_nr; $i++ ) {
	Customizer::add_section(
		'gridd_grid_part_details_single_post_custom_content_' . $i,
		[
			/* Translators: Number. */
			'title'   => sprintf( esc_html__( 'Custom Content %s', 'gridd-plus' ), $i ),
			'section' => 'gridd_grid_part_details_content',
		]
	);

	Customizer::add_field(
		[
			'type'        => 'code',
			'settings'    => 'gridd_plus_single_post_custom_content_content_' . $i,
			'label'       => esc_html__( 'Content', 'gridd-plus' ),
			'description' => esc_html__( 'Accepts HTML & Shortcodes.', 'gridd-plus' ),
			'section'     => 'gridd_grid_part_details_single_post_custom_content_' . $i,
			'default'     => '',
			'choices'     => [
				'language' => 'html',
			],
		]
	);
}
