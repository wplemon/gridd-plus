<?php
/**
 * Template part for the Nested Grids.
 *
 * @package Gridd Plus
 * @since 1.0
 */

use Gridd\Grid;
use Gridd\Style;

$settings = Grid::get_options( "gridd_nested_grid_$id" );
$classes  = [
	'gridd-tp',
	"gridd-tp-nested-grid-$id",
];
if ( get_theme_mod( "gridd_nested_grid_{$id}_sticky", false ) ) {
	$classes[] = 'gridd-sticky';
}

$style = Style::get_instance( "grid-part/nested-grid-$id" );
$style->add_string(
	Grid::get_styles_responsive(
		[
			'context'    => "nested-grid-$id",
			'large'      => $settings,
			'small'      => false,
			'breakpoint' => get_theme_mod( 'gridd_mobile_breakpoint', '800px' ),
			'selector'   => '.gridd-tp-nested-grid-1 > .inner',
			'prefix'     => true,
		]
	)
);
$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nested-grid-default.min.css' );

// Add styles for large screens.
$style->add_string( '@media only screen and (min-width:' . get_theme_mod( 'gridd_mobile_breakpoint', '800px' ) . '){' );
$style->add_file( GRIDD_PLUS_PATH . '/assets/css/nested-grid-large.min.css' );
$style->add_string( '}' );

// Generate grid styles for parts.
$style->add_string( Grid::get_styles( $settings, "gridd-tp-nested-grid-$id > .inner", true ) );
$style->replace( 'ID', $id );
$style->add_vars(
	[
		"gridd-nested-grid-$id-background" => get_theme_mod( "gridd_nested_grid_{$id}_background_color", '#ffffff' ),
		"gridd-nested-grid-$id-padding"    => get_theme_mod( "gridd_nested_grid_{$id}_padding", 0 ),
		"gridd-nested-grid-$id-box-shadow" => get_theme_mod( "gridd_nested_grid_{$id}_box_shadow", 'none' ),
		"gridd-nested-grid-$id-max-width"  => get_theme_mod( "gridd_nested_grid_{$id}_max_width", '' ),
		"gridd-nested-grid-$id-grid-gap"   => get_theme_mod( "gridd_nested_grid_{$id}_gap", 0 ),
	]
);
?>
<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	/**
	 * Print styles.
	 */
	$style->the_css( 'gridd-inline-css-nested-grid-' . $id );
	?>
	<div class="inner">
		<?php if ( isset( $settings['areas'] ) ) : ?>
			<?php foreach ( array_keys( $settings['areas'] ) as $part ) : ?>
				<?php do_action( 'gridd_the_grid_part', $part ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
