<?php
/**
 * Post tweaks.
 *
 * @package Gridd Plus
 * @since 1.0
 */

namespace Gridd_Plus;

use Gridd\Theme;

/**
 * The Gridd_Plus object.
 * Takes care of initializing the plugin and doing what must be done.
 *
 * @since 1.0
 */
class Post {

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function __construct() {
		add_filter( 'gridd_get_template_part', [ $this, 'get_template_part' ], 10, 3 );
	}

	/**
	 * Modify the path to template files.
	 *
	 * @access public
	 * @since 1.0
	 * @param string|false $custom_path The custom template-part path. Defaults to false. Use absolute path.
	 * @param string       $slug        The template slug.
	 * @param string       $name        The template name.
	 * @return string|false
	 */
	public function get_template_part( $custom_path, $slug, $name ) {
		$empty = GRIDD_PLUS_PATH . '/inc/templates/empty.php';

		switch ( $slug ) {
			case 'template-parts/part-post-title':
				if ( get_field( 'gridd_plus_hide_title' ) ) {
					return $empty;
				}
				break;
		}
		return $custom_path;
	}
}
