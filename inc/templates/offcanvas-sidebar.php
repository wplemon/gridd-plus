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
if ( ! get_theme_mod( 'gridd_pluss_offcanvas_sidebar_enable', false ) ) {
	return;
}
?>
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
		'label'             => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg><span class="screen-reader-text">' . esc_html__( 'Toggle Sidebar', 'gridd-plus' ) . '</span>',
		'classes'           => [ 'toggle-gridd-plus-offcanvas-sidebar', 'position-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) ],
	]
);
?>

<div <?php Theme::print_attributes( [ 'class' => 'gridd-tp gridd-tp-sidebar gridd-tp-offcanvas-sidebar position-' . get_theme_mod( 'gridd_pluss_offcanvas_sidebar_position', 'left' ) ], 'wrapper-offcanvas-sidebar' ); ?>>
	<?php
	$style = Style::get_instance( 'grid-part/sidebar/offcanvas-sidebar' );
	$style->add_file( GRIDD_PLUS_PATH . '/assets/css/grid-part-offcanvas-sidebar.min.css' );
	$style->the_css( 'gridd-inline-css-offcanvas-sidebar' );
	?>
	<?php dynamic_sidebar( 'offcanvas-sidebar' ); ?>
</div>
