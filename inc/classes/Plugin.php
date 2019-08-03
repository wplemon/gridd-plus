<?php
/**
 * The main plugin class.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

use Gridd\Grid_Part\Sidebar;
use Gridd\Theme;

/**
 * The Gridd_Plus object.
 * Takes care of initializing the plugin and doing what must be done.
 *
 * @since 1.0
 */
class Plugin {

	/**
	 * A single instance of this object.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var Gridd_Plus
	 */
	private static $instance;

	/**
	 * Get a single instance of this object.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @return Gridd_Plus
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * The object constructor.
	 *
	 * @access private
	 * @since 1.0
	 */
	private function __construct() {

		// Gridd theme filters and actions.
		add_action( 'gridd_nav_handheld_part_template', [ $this, 'handheld_nav_widget_parts' ] );
		add_filter( 'gridd_featured_image_use_background', [ $this, 'featured_image_use_background' ] );
		add_filter( 'gridd_render_grid_part', [ $this, 'gridd_render_grid_part' ], 10, 2 );
	}

	/**
	 * Additional templates for nav-handheld parts that are only available in plus.
	 *
	 * @access public
	 * @since 1.0
	 * @param string $part The part we're rendering.
	 * @return void
	 */
	public function handheld_nav_widget_parts( $part ) {
		switch ( $part ) {
			case 'widget-area':
				$label_class = get_theme_mod( 'gridd_grid_nav-handheld_hide_labels', false ) ? 'screen-reader-text' : 'label';
				?>
				<div id="gridd-handheld-widget-area">
					<?php
					/**
					 * Prints the button.
					 * No need to escape this, it's already escaped in the function itself.
					 */
					echo Theme::get_toggle_button( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						[
							'expanded_state_id' => 'griddHandheldWidgetAreaWrapper',
							'expanded'          => 'false',
							'label'             => get_theme_mod( 'gridd_grid_nav-handheld_widget_area_icon', '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"/></svg>' ) . '<span class="' . $label_class . '">' . get_theme_mod( 'gridd_grid_nav-handheld_widget_area_label', esc_html__( 'Settings', 'gridd-plus' ) ) . '</span>',
							'classes'           => [ 'gridd-nav-handheld-btn' ],
						]
					);
					?>
					<div id="gridd-handheld-widget-area-wrapper" class="gridd-hanheld-nav-popup-wrapper">
						<?php dynamic_sidebar( 'sidebar_handheld_widget_area' ); ?>
						<?php if ( ! is_active_sidebar( 'sidebar_handheld_widget_area' ) ) : ?>
							<div style="padding: 2em;"><?php esc_html_e( 'Please add a widget to this widget area to see your content.', 'gridd-plus' ); ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php
				break;
			case 'woo-cart':
				if ( class_exists( 'WooCommerce' ) ) {
					$label_class = get_theme_mod( 'gridd_grid_nav-handheld_hide_labels', false ) ? 'screen-reader-text' : 'label';

					$count_styles = '';
					$label        = '<span class="' . esc_attr( $label_class ) . '">';
					$label       .= esc_html__( 'Cart', 'gridd-plus' );
					$label       .= '<div class="count">' . \WC()->cart->get_cart_contents_count() . '</div>';
					$label       .= '</span>';
					?>
					<nav id="gridd-handheld-woo-cart">
						<?php
						/**
						 * Prints the button.
						 * No need to escape this, it's already escaped in the function itself.
						 */
						echo Theme::get_toggle_button( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							[
								'expanded_state_id' => 'griddHandheldWooCartWrapper',
								'expanded'          => 'false',
								/* translators: number of items in the cart. */
								'label'             => '<svg class="gridd-inline-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm6.304-15l-3.431 12h-2.102l2.542-9h-16.813l4.615 11h13.239l3.474-12h1.929l.743-2h-4.196z"/></svg>' . $label,
								'classes'           => [ 'gridd-nav-handheld-btn' ],
							]
						);
						?>
						<div id="gridd-handheld-cart-wrapper" class="gridd-hanheld-woo-popup-wrapper">
							<?php
							the_widget(
								'WC_Widget_Cart',
								[
									'title' => '',
								]
							);
							?>
						</div>
					</nav>
					<?php
				}
				break;
		}
	}

	/**
	 * Figure out if we want to use a background-image for featured images or not.
	 *
	 * @access public
	 * @since 1.0
	 * @return bool
	 */
	public function featured_image_use_background() {
		if ( 'fixed' === get_theme_mod( 'gridd_featured_image_mode_singular', 'alignwide' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Handles the visibility for grid-parts.
	 *
	 * @access public
	 * @since 1.0
	 * @param bool   $render Whether we want to render this grid-part or not.
	 * @param string $part   The grid-part.
	 * @return bool
	 */
	public function gridd_render_grid_part( $render, $part ) {
		$visibility_settings = [];
		$has_rules           = false;
		$queried_object      = get_queried_object();
		$sidebars_number     = Sidebar::get_number_of_sidebars();
		for ( $i = 1; $i <= $sidebars_number; $i++ ) {
			$visibility_settings[ "sidebar_$i" ] = [
				'post' => "gridd_grid_sidebar_{$i}_visibility_post_id",
				'term' => "gridd_grid_sidebar_{$i}_visibility_term_id",
			];
		}

		$post_visibility = false;
		$term_visibility = false;
		if ( isset( $visibility_settings[ $part ] ) ) {

			// Get visibility by post-ID.
			if ( isset( $visibility_settings[ $part ]['post'] ) ) {
				$post_visibility = get_theme_mod( $visibility_settings[ $part ]['post'] );
			}

			// Get visibility by term-ID.
			if ( isset( $visibility_settings[ $part ]['term'] ) ) {
				$term_visibility = get_theme_mod( $visibility_settings[ $part ]['term'] );
			}
		}

		if ( $post_visibility ) {
			$has_rules = true;
			if ( isset( $queried_object->ID ) ) {

				// Get array of posts where we want to show this grid-part.
				$post_visibility = explode( ',', $post_visibility );
				foreach ( $post_visibility as $visibility_id ) {
					$visibility_id = (int) $visibility_id;

					// Check if we want to show on this post-ID.
					if ( $queried_object->ID === $visibility_id ) {
						return true;
					}
				}
			}
		}

		if ( $term_visibility ) {
			$has_rules = true;
			if ( isset( $queried_object->term_id ) ) {

				// Get array of terms where we want to show this grid-part.
				$term_visibility = explode( ',', $term_visibility );
				foreach ( $term_visibility as $visibility_id ) {
					$visibility_id = (int) $visibility_id;

					// Check if we want to show on this term-ID.
					if ( $queried_object->term_id === $visibility_id ) {
						return true;
					}
				}
			}
		}

		if ( $has_rules ) {
			// If we got this far and we have rules defined, tests did not succeed so hide this grid-part.
			return false;
		}
		return $render;
	}
}
