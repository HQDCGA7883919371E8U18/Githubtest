<?php
/**
 * Frontend functions and definitions.
 *
 * @package Motta
 */

namespace Motta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Header initial
 *
 */
class Frontend {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

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
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'motta_after_site_content_open', array( $this, 'open_site_content_container' ) );
		add_action( 'motta_before_site_content_close', array( $this, 'close_site_content_container' ), 30 );

		add_filter( 'motta_get_sidebar', array( $this, 'has_sidebar' ) );

		add_action( 'elementor/theme/register_locations', array( $this, 'register_elementor_locations' ) );


	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		$classes[] = $this->content_layout();

		if( Helper::get_option('shape_style') != 'default' ) {
			$classes[] = "motta-shape--" . Helper::get_option('shape_style');
		}

		if( is_page() || \Motta\Helper::is_blog() || \Motta\Helper::is_catalog() ) {
			$top_spacing = get_post_meta( \Motta\Helper::get_post_ID(), 'motta_content_top_spacing', true );
			$top_spacing = \Motta\Helper::is_help_center_page() ? 'no' : $top_spacing;
			if ( ! empty($top_spacing) && $top_spacing != 'default' ) {
				$classes[] = sprintf( ' site-content-%s-top-spacing', $top_spacing );
			}

			$bottom_spacing = get_post_meta( \Motta\Helper::get_post_ID(), 'motta_content_bottom_spacing', true );
			$bottom_spacing = \Motta\Helper::is_help_center_page() ? 'no' : $bottom_spacing;
			if ( ! empty($bottom_spacing) && $bottom_spacing != 'default' ) {
				$classes[] = sprintf( ' site-content-%s-bottom-spacing', $bottom_spacing );
			}
		}

		if ( get_post_meta( \Motta\Helper::get_post_ID(), 'motta_hide_header_border', true ) ) {
			$classes[] = 'header-hide-border';
		}

		// Add a class of rtl background
		if ( intval( Helper::get_option( 'rtl_smart' ) ) && is_rtl() ) {
			$classes[] = 'motta-rtl-smart';
		}

		return $classes;
	}

	/**
	 * Check has sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function has_sidebar() {
		if( $this->content_layout() != 'no-sidebar' ) {
			return true;
		}

		return false;
	}

	/**
	 * Get site layout
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function content_layout() {
		if( is_search() ) {
			if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
				$layout = 'no-sidebar';
			} else {
				$layout = 'content-sidebar';
			}
		} else {
			$layout = 'no-sidebar';
		}

		return apply_filters( 'motta_site_layout', $layout );
	}

	/**
	 * Print the open tags of site content container
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function open_site_content_container() {
		if( Helper::is_built_with_elementor() ) {
			return;
		}
		$classes = '';
		if( Helper::is_catalog() ) {
			$classes .= ' site-content-container';
		}
		echo '<div class="container clearfix '. esc_attr( $classes ) .'">';
	}

	/**
	 * Print the close tags of site content container
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function close_site_content_container() {
		if( Helper::is_built_with_elementor() ) {
			return;
		}
		echo '</div>';
	}


	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		$font_url =Helper::get_fonts_url();
		if( ! empty( $font_url ) ) {
			wp_enqueue_style( 'motta-fonts', Helper::get_fonts_url(), array(), '20220922' );
		}
		wp_enqueue_style( 'select2' );
		wp_register_style( 'motta-swiper', get_template_directory_uri() . '/assets/css/swiper.css');

		$style_file = is_rtl() ? 'style-rtl.css' : 'style.css';
		wp_enqueue_style( 'motta', apply_filters( 'motta_get_style_directory_uri', get_template_directory_uri() ) . '/' . $style_file, array(
			'motta-swiper',
		), '20241215' );

		do_action( 'motta_after_enqueue_style' );

		/**
		 * Register and enqueue scripts
		 */
		$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/assets/js/plugins/html5shiv.min.js', array(), '3.7.2' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

		wp_enqueue_script( 'respond', get_template_directory_uri() . '/assets/js/plugins/respond.min.js', array(), '1.4.2' );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

		wp_register_script( 'swiper', get_template_directory_uri() . '/assets/js/plugins/swiper.min.js', array( 'jquery' ), '5.3.8', true );

		wp_register_script( 'headroom', get_template_directory_uri() . '/assets/js/plugins/headroom.min.js', array(), '0.9.3', true );

		if ( 'none' != \Motta\Helper::get_option( 'header_sticky' ) && 'up' == \Motta\Helper::get_option( 'header_sticky_on' ) ) {
			wp_enqueue_script( 'headroom' );
		}
		wp_enqueue_script( 'notify', get_template_directory_uri() . '/assets/js/plugins/notify.min.js', array(), '1.0.0', true );
		wp_enqueue_script( 'motta', get_template_directory_uri() . "/assets/js/scripts" . $debug . ".js", array(
			'jquery',
			'swiper',
			'imagesloaded',
		), '20240715', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$motta_data = array(
			'direction'            				=> is_rtl() ? 'true' : 'false',
			'ajax_url'             				=> class_exists( 'WC_AJAX' ) ? \WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
			'nonce'                				=> wp_create_nonce( '_motta_nonce' ),
			'sticky_header'                     => \Motta\Header\Manager::has_sticky() ? true : false,
			'sticky_header_on'                     => \Motta\Helper::get_option( 'header_sticky_on' ),
			'blog_nav_ajax_url_change' 			=> Helper::get_option( 'blog_nav_ajax_url_change' ),
			'blog_archive_nav_ajax_url_change' 	=> Helper::get_option( 'blog_archive_nav_ajax_url_change' ),
			'header_search_type' 				=> Helper::get_option( 'header_search_type' ),
			'header_ajax_search'   				=> intval( Helper::get_option( 'header_search_ajax' ) ),
			'header_search_number' 				=> Helper::get_option( 'header_search_number' ),
			'post_type' 	     				=> \Motta\Header\Search::type(),
			'mobile_product_columns'     		=> Helper::get_option( 'mobile_product_columns' ),
		);

		$motta_data = apply_filters( 'motta_wp_script_data', $motta_data );

		wp_localize_script(
			'motta', 'mottaData', $motta_data
		);

	}

	function register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}

}
