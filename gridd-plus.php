<?php
/**
 * Plugin Name: Gridd Plus
 * Plugin URI:  https://wplemon.com
 * Author:      Ari Stathopoulos
 * Author URI:  http://aristath.github.io
 * Version:     2.0.0
 * Description: Premium addon plugin for the Gridd theme.
 * Text Domain: gridd-plus
 *
 * @package   Grid Plus
 * @category  Core
 * @author    Ari Stathopoulos
 * @copyright Copyright (c) 2019, Ari Stathopoulos
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the URL.
if ( ! defined( 'GRIDD_PLUS_VERSION' ) ) {
	define( 'GRIDD_PLUS_VERSION', '2.0.0' );
}

// Define the path.
if ( ! defined( 'GRIDD_PLUS_PATH' ) ) {
	define( 'GRIDD_PLUS_PATH', __DIR__ );
}

if ( ! defined( 'GRIDD_PLUS_PLUGIN_FILE' ) ) {
	define( 'GRIDD_PLUS_PLUGIN_FILE', __FILE__ );
}

// Define the URL.
if ( ! defined( 'GRIDD_PLUS_URL' ) ) {
	define( 'GRIDD_PLUS_URL', plugins_url( '', __FILE__ ) );
}

/**
 * Init the plugin - hooked on "gridd_setup".
 *
 * @since 1.0
 * @return void
 */
function gridd_plus_bootstrap() {

	// Require the main plugin class.
	require_once GRIDD_PLUS_PATH . '/inc/bootstrap.php';
}
add_action( 'gridd_setup', 'gridd_plus_bootstrap' );

/**
 * Filter sidebars number.
 * 
 * This needs to be in the main plugin file because of filter priorities.
 *
 * @since 2.0.0
 * @return int
 */
function gridd_plus_sidebars_number() {
	return (int) get_theme_mod( 'gridd_grid_widget_areas_number', 3 );
}
add_filter( 'gridd_get_number_of_widget_areas', 'gridd_plus_sidebars_number' );
