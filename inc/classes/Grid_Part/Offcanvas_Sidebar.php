<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Gridd Sidebar grid-part
 *
 * @package Gridd
 */

namespace Gridd_Plus\Grid_Part;

use Gridd\Grid_Part;
use Gridd\Rest;

/**
 * The Gridd\Grid_Part\Sidebar object.
 *
 * @since 1.0
 */
class Offcanvas_Sidebar extends Grid_Part {

	/**
	 * Have the global styles already been added?
	 *
	 * @static
	 * @access public
	 * @since 1.0.8
	 * @var bool
	 */
	public static $global_styles_added = false;

	/**
	 * The grid-part ID.
	 *
	 * @access protected
	 * @since 1.0
	 * @var string
	 */
	protected $id = 'offcanvas-sidebar';

    /**
	 * Hooks & extra operations.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function init() {
		$this->register_rest_api_partials();
		add_action( 'widgets_init', [ $this, 'register_sidebars' ] );
		add_action( 'gridd_the_grid_part', [ $this, 'render' ] );
		add_action( 'get_sidebar', [ $this, 'get_sidebar' ] );
		add_action( 'gridd_the_partial', [ $this, 'the_partial' ] );
		add_filter( 'gridd_smart_grid_main_parts_order', [ $this, 'grid_parts_order' ] );

		// Add script.
		add_filter( 'gridd_footer_inline_script_paths', [ $this, 'footer_inline_script_paths' ] );
	}

	/**
	 * Returns the grid-part definition.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function set_part() {
        $this->part = [
			'label'    => esc_html__( 'Offcanvas Sidebar', 'gridd-plus' ),
			'color'    => [ '#74BEA7', '#000' ],
			'priority' => 10,
			'hidden'   => true,
			'id'       => $this->id,
		];
    }

	/**
	 * Add action on the get_sidebar hook.
	 *
	 * @access public
	 * @since 1.0.3
	 * @param string $name The sidebar name.
	 * @return void
	 */
	public function get_sidebar( $name ) {
		$this->render( $name );
	}

	/**
	 * Render this grid-part.
	 *
	 * @access public
	 * @since 1.0
	 * @param string $part The grid-part ID.
	 * @return void
	 */
	public function render( $part ) {
        if ( 'offcanvas-sidebar' === $part ) {
            if ( Rest::is_partial_deferred( $part ) ) {
                echo '<div class="gridd-tp gridd-tp-' . esc_attr( $part ) . ' gridd-rest-api-placeholder"></div>';
                return;
            }
            $this->the_partial( $part );
        }
	}

	/**
	 * Renders the grid-part partial.
	 *
	 * @access public
	 * @since 1.1
	 * @param string $part The grid-part ID.
	 * @return void
	 */
	public function the_partial( $part ) {
        if ( 'offcanvas-sidebar' === $part ) {
            include GRIDD_PLUS_PATH . '/inc/templates/offcanvas-sidebar.php';
		}
	}

	/**
	 * Register the sidebar(s).
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function register_sidebars() {
        register_sidebar(
            [
                'name'          => esc_html__( 'Offcanvas Sidebar', 'gridd-plus' ),
                'id'            => 'offcanvas-sidebar',
                'description'   => esc_html__( 'Add widgets here.', 'gridd-plus' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title h3">',
                'after_title'   => '</h2>',
            ]
        );
	}

	/**
	 * Registers the partial(s) for the REST API.
	 *
	 * @access public
	 * @since 1.1
	 * @return void
	 */
	public function register_rest_api_partials() {
        Rest::register_partial(
            [
                'id'    => 'offcanvas-sidebar',
                'label' => esc_html__( 'Offcanvas Sidebar', 'gridd-plus' ),
            ]
        );
	}

		/**
	 * Change the position of the grid-part and put it right after the header.
	 *
	 * @access public
	 * @since 2.0.0
	 * @param array $parts An array of our ordered grid-parts.
	 * @return array
	 */
	public function grid_parts_order( $parts ) {
		$final_parts = [];
		foreach ( $parts as $part ) {
			$final_parts[] = $part;
			if ( 'header' === $part ) {
				$final_parts[] = 'offcanvas-sidebar';
			}
		}

		return $final_parts;
	}

	/**
	 * Adds the script to the footer.
	 *
	 * @access public
	 * @since 2.0.0
	 * @param array $paths Paths to scripts we want to load.
	 * @return array
	 */
	public function footer_inline_script_paths( $paths ) {
		if ( is_active_sidebar( 'offcanvas-sidebar' ) ) {
			$paths[] = GRIDD_PLUS_PATH . '/assets/js/offcanvas.min.js';
		}
		return $paths;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
