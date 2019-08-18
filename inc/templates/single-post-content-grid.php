<?php
/**
 * Template part for single posts content custom grid.
 *
 * @package Gridd Plus
 * @since 1.1
 */

use Gridd\Grid;
use Gridd\Style;

$settings = Grid::get_options( 'gridd_single_posts_grid' );
$classes  = [ 'gridd-tp', 'gridd-tp-content-grid' ];

$style = Style::get_instance( 'grid-part/single-post-content-grid' );
$style->add_string(
	Grid::get_styles_responsive(
		[
			'context'    => 'single-post-content-grid',
			'large'      => $settings,
			'small'      => false,
			'breakpoint' => get_theme_mod( 'gridd_mobile_breakpoint', '800px' ),
			'selector'   => '.gridd-tp-content-grid',
			'prefix'     => true,
		]
	)
);
$style->add_string( '.gridd-tp.gridd-tp-content-grid{max-width:100%}' );

// Generate grid styles for parts.
$style->add_string( Grid::get_styles( $settings, 'gridd-tp-content-grid', true ) );
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	/**
	 * Print styles.
	 */
	$style->the_css( 'gridd-inline-css-single-post-custom-content-grid' );

	/**
	 * Print the grid.
	 */
	if ( isset( $settings['areas'] ) ) {
		foreach ( array_keys( $settings['areas'] ) as $part ) {
			do_action( 'gridd_the_grid_part', $part );
		}
	}
	?>
</div>
