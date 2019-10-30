<?php
/**
 * Template part for the offcanvas sidebar.
 *
 * @package Gridd
 * @since 1.0
 */

use Gridd\Grid_Part\Sidebar;
use Gridd\Style;
use Gridd\Theme;

// Early exit if we don't want to show the sidebar.
if ( ! is_active_sidebar( 'offcanvas-sidebar' ) && ! is_customize_preview() ) {
	return;
}
if ( is_customize_preview() && ! is_active_sidebar( 'offcanvas-sidebar' ) ) {
	echo '<style>#offcanvas-wrapper{display:none!important;};</style>';
}
?>
<div id="offcanvas-wrapper" class="position-<?php echo esc_attr( get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) ); ?>" tabindex="0">
	<?php
	/**
	 * Prints the toggling button.
	 * No need to escape this, there's zero user input.
	 * Everything is hardcoded and things that need escaping
	 * are properly escaped in the function itself.
	 */
	echo Theme::get_toggle_button( // phpcs:ignore WordPress.Security.EscapeOutput
		[
			'context'           => [ 'offcanvas-sidebar' ],
			'expanded_state_id' => 'griddPlusOffcanvasSidebar',
			'expanded'          => 'false',
			'label'             => '<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z"/></svg><span class="screen-reader-text">' . esc_html__( 'Toggle Sidebar', 'gridd-plus' ) . '</span>',
			'classes'           => [ 'toggle-gridd-plus-offcanvas-sidebar', 'position-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) ],
		]
	);
	?>

	<?php if ( is_active_sidebar( 'offcanvas-sidebar' ) ) : ?>
		<div <?php Theme::print_attributes( [ 'class' => 'gridd-tp gridd-tp-sidebar gridd-tp-offcanvas-sidebar position-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) ], 'wrapper-offcanvas-sidebar' ); ?>>
			<?php
			$style = Style::get_instance( 'grid-part/sidebar/offcanvas-sidebar' );
			$style->add_string( '#offcanvas-wrapper{display:none;}' );

			if ( 'desktop' === get_theme_mod( 'offcanvas_sidebar_visibility', 'always' ) ) {
				$style->add_string( '@media only screen and (min-width:' . get_theme_mod( 'gridd_mobile_breakpoint', '992px' ) . '){' );
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/grid-part-offcanvas-sidebar.min.css' );
				$style->add_string( 'body{padding-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) . ':calc(2.5em + 2px);}#wpadminbar{padding-left:5em;}@media screen and (max-width:782px){#wpadminbar{padding-left:3em;}}' );
				$style->add_string( '}' );
			} elseif ( 'mobile' === get_theme_mod( 'offcanvas_sidebar_visibility', 'always' ) ) {
				$style->add_string( '@media only screen and (max-width:' . get_theme_mod( 'gridd_mobile_breakpoint', '992px' ) . '){' );
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/grid-part-offcanvas-sidebar.min.css' );
				$style->add_string( 'body{padding-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) . ':calc(2.5em + 2px);}#wpadminbar{padding-left:5em;}@media screen and (max-width:782px){#wpadminbar{padding-left:3em;}}' );
				$style->add_string( '}' );
			} else {
				$style->add_file( GRIDD_PLUS_PATH . '/assets/css/grid-part-offcanvas-sidebar.min.css' );
				$style->add_string( 'body{padding-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) . ':calc(2.5em + 2px);}#wpadminbar{padding-left:5em;}@media screen and (max-width:782px){#wpadminbar{padding-left:3em;}}' );
			}

			$style->the_css( 'gridd-inline-css-offcanvas-sidebar' );
			?>
			<div class="inner">
				<?php dynamic_sidebar( 'offcanvas-sidebar' ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
