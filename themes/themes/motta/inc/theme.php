<?php
/**
 * Motta init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Motta
 */

namespace Motta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Motta theme init
 */
final class Theme {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance = null;

	/**
	 * Blog manager instance.
	 *
	 * @var $blog_manager
	 */
	public $blog_manager = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->include_files();
	}

	/**
	 * Function to include files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function include_files() {
		require_once get_template_directory() . '/inc/autoload.php';

		if ( is_admin() ) {
			require_once get_template_directory() . '/inc/libs/tgm-plugin-activation.php';
		}
	}

	/**
	 * Hooks to init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		// Before init action.
		do_action( 'before_motta_init' );

		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'after_setup_theme', array( $this, 'setup_content_width' ), 0 );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );

		add_action( 'init', array( $this, 'loads' ), 50);
		add_action( 'template_redirect', array( $this, 'load_post_types' ), 30 );
		\Motta\Admin::instance();
		\Motta\Maintenance::instance();

		if( class_exists('WooCommerce')  ) {
			\Motta\WooCommerce::instance();
		}

		\Motta\Admin\Kirki_Fonts::instance();

		// Init action.
		do_action( 'after_motta_init' );

	}

		/**
	 * Hooks to loads
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function loads() {
		\Motta\Options::instance();
		\Motta\Frontend::instance();
		\Motta\Dynamic_CSS::instance();

		\Motta\Header\Manager::instance();

		\Motta\Page_Header::instance();
		\Motta\Search_Ajax::instance();

		\Motta\Blog\Manager::instance();

		\Motta\Comments::instance();

		\Motta\Footer\Manager::instance();

		\Motta\Mobile\Navigation_bar::instance();

		\Motta\Languages\WPML::instance();

		if( class_exists('TRP_Translate_Press') ) {
			\Motta\Languages\TRP::instance();
		}
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_post_types() {
		\Motta\Help_Center::instance();
		if(is_page() && ! \Motta\Helper::is_help_center_page()) {
			\Motta\Page::instance();
		}

		if( is_404() ) {
			\Motta\Page_404::instance();
		}

	}

	/**
	 * Get Razzi Class.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			default :
				$class = ucwords( $class );
				$class = "\Motta\\" . $class;
				if ( class_exists( $class ) ) {
					return $class::instance();
				}
				break;
		}

	}

	/**
	 * Setup theme
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_theme() {
		// Theme supports
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_editor_style( 'assets/css/editor-style.css' );

		// Load regular editor styles into the new block-based editor.
		add_theme_support( 'editor-styles' );

		// Load default block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'align-full' );

		// Enable support for common post formats
		add_theme_support( 'post-formats', array( 'gallery', 'video' ) );

		add_image_size( 'motta-post-thumbnail-small', 100, 70, true );
		add_image_size( 'motta-post-thumbnail-medium', 364, 205, true );
		add_image_size( 'motta-post-thumbnail-large', 752, 420, true );
		add_image_size( 'motta-post-slider-widget', 276, 160, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu'    	=> esc_html__( 'Primary Menu', 'motta' ),
			'secondary-menu'    => esc_html__( 'Secondary Menu', 'motta' ),
			'category-menu'    	=> esc_html__( 'Category Menu', 'motta' ),
			'socials'    		=> esc_html__( 'Socials Menu', 'motta' ),
		) );

	}

	/**
	 * Set the $content_width global variable used by WordPress to set image dimennsions.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setup_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'motta_content_width', 640 );
	}

	/**
	 * Register widget area.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function widgets_init() {
		$sidebars = array(
			'blog-sidebar' => esc_html__( 'Blog Sidebar', 'motta' ),
			'single-sidebar' => esc_html__( 'Single Sidebar', 'motta' ),
		);

		// Register sidebars
		foreach ( $sidebars as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			);
		}

	}
	/**
	 * Setup the theme global variable.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function setup_prop( $args = array() ) {
		$default = array(
			'panels' => array(),
			'modals' => array(),
			'modals-addons' => array(),
		);

		if ( isset( $GLOBALS['motta'] ) ) {
			$default = array_merge( $default, $GLOBALS['motta'] );
		}

		$GLOBALS['motta'] = wp_parse_args( $args, $default );
	}

	/**
	 * Get a propery from the global variable.
	 *
	 * @param string $prop Prop to get.
	 * @param string $default Default if the prop does not exist.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_prop( $prop, $default = '' ) {
		self::setup_prop(); // Ensure the global variable is setup.

		return isset( $GLOBALS['motta'], $GLOBALS['motta'][ $prop ] ) ? $GLOBALS['motta'][ $prop ] : $default;
	}

	/**
	 * Sets a property in the global variable.
	 *
	 * @param string $prop Prop to set.
	 * @param string $value Value to set.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function set_prop( $prop, $value = '' ) {
		if ( ! isset( $GLOBALS['motta'] ) ) {
			self::setup_prop();
		}

		if ( ! isset( $GLOBALS['motta'][ $prop ] ) ) {
			$GLOBALS['motta'][ $prop ] = $value;

			return;
		}

		if( array_search( $value,  self::get_prop( $prop ) ) !== false ) {
			return;
		}

		if ( is_array( $GLOBALS['motta'][ $prop ] ) ) {
			if ( is_array( $value ) ) {
				$GLOBALS['motta'][ $prop ] = array_merge( $GLOBALS['motta'][ $prop ], $value );
			} else {
				$GLOBALS['motta'][ $prop ][] = $value;
				array_unique( $GLOBALS['motta'][ $prop ] );
			}
		} else {
			$GLOBALS['motta'][ $prop ] = $value;
		}
	}
}
