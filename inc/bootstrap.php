<?php
/**
 * Bootstraps the plugin.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

/**
 * The Gridd-Plus Autoloader.
 *
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(
	function( $class ) {
		$prefix   = 'Gridd_Plus\\';
		$base_dir = __DIR__ . '/classes/';

		$len = strlen( $prefix );
		if ( 0 !== strncmp( $prefix, $class, $len ) ) {
			return;
		}
		$relative_class = substr( $class, $len );
		$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

/**
 * Add ACF.
 *
 * @since 1.0
 */
new ACF();

/**
 * Init the main plugin class.
 *
 * @since 1.0
 */
Plugin::get_instance();

/**
 * Add the plus grid parts.
 *
 * @since 1.0
 */
new Grid_Part\Nested_Grid();
new Grid_Part\Layer_Slider();
new Grid_Part\Slider_Revolution();
new Grid_Part\Offcanvas_Sidebar();

/**
 * Add the customizer modifications.
 *
 * @since 1.0
 */
new Customizer();

/**
 * Init the color deficiencies simulator.
 *
 * @since 1.0
 */
new Color_Deficiencies_Simulator();

/**
 * Init scroll-to-top feature.
 */
new Scroll_To_Top();

/**
 * Add Grid mods.
 *
 * @since 1.0
 */
new Grid();

/**
 * Add styles.
 *
 * @since 1.0
 */
new Styles();

/**
 * Add WooCommerce mods.
 *
 * @since 1.0
 */
new WooCommerce();

/**
 * Add scripts.
 *
 * @since 1.0
 */
new Scripts();

/**
 * Post mods.
 *
 * @since 1.0
 */
new Post();

/**
 * Include the updater.
 *
 * @since 1.0
 */
require_once GRIDD_PLUS_PATH . '/inc/updater/updater.php';

require_once GRIDD_PLUS_PATH . '/inc/customizer/control-wcag-linkcolor/bootstrap.php';
require_once GRIDD_PLUS_PATH . '/inc/customizer/control-wcag-textcolor/bootstrap.php';
