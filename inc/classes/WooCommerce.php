<?php
/**
 * The main plugin class.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

/**
 * The Gridd_Plus object.
 * Takes care of initializing the plugin and doing what must be done.
 *
 * @since 1.0
 */
class WooCommerce {

	/**
	 * The object constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		// Menu Cart.
		add_filter( 'wp_nav_menu_items', [ $this, 'wp_nav_menu_items' ], 10, 2 );

		// AJAX Cart.
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_link_fragment' ] );
	}

	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'gridd-plus' ); ?>">
			<svg class="gridd-inline-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm6.304-15l-3.431 12h-2.102l2.542-9h-16.813l4.615 11h13.239l3.474-12h1.929l.743-2h-4.196z"/></svg>
			<?php
			// Items count.
			$count = WC()->cart->get_cart_contents_count();
			// Count text.
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', $count, 'gridd-plus' ),
				$count
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
			<?php if ( $count ) : ?>
				<span class="count" aria-label="<?php echo esc_html( $item_count_text ); ?>"><?php echo absint( $count ); ?></span>
			<?php endif; ?>
		</a>
		<?php
	}

	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	public function cart_link_fragment( $fragments ) {
		ob_start();
		$this->cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}

	/**
	 * Add cart menu-item.
	 *
	 * @access public
	 * @since 1.0
	 * @param string $items The menu items.
	 * @param object $args  The menu.
	 * @return string
	 */
	public function wp_nav_menu_items( $items, $args ) {
		$is_cart     = ( function_exists( 'is_cart' ) && is_cart() );
		$is_checkout = ( ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_checkout_pay_page' ) && is_checkout_pay_page() ) );
		$menu_id     = absint( str_replace( 'menu-', '', $args->theme_location ) );
		$show_in_nav = get_theme_mod( "nav_{$menu_id}_woo_cart", 1 === $menu_id );

		if ( ! $is_cart && ! $is_checkout && $show_in_nav ) {
			ob_start();

			// Add the link.
			$this->cart_link();

			// Add the widget.
			echo '<ul id="nav-primary-cart" class="sub-menu">';
			the_widget(
				'WC_Widget_Cart',
				[
					'title' => '',
				]
			);
			echo '</ul>';

			// Print the item.
			$items .= '<li class="menu-item menu-item-has-children nav-cart">' . ob_get_clean() . '</li>';
		}
		return $items;
	}
}
