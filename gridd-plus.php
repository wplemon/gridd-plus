<?php
/**
 * Plugin Name: Gridd Plus
 * Plugin URI:  https://wplemon.com
 * Author:      Ari Stathopoulos
 * Author URI:  http://aristath.github.io
 * Version:     1.0.7
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
	define( 'GRIDD_PLUS_VERSION', '1.0.7' );
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
