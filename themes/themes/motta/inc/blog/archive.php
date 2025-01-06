<?php
/**
 * Archive functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Blog;

use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Archive initial
 *
 */
class Archive {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $Post
	 *
	 * @var $post
	 */
	protected $post = null;

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
		$this->post     		= new \Motta\Blog\Post();
		$this->load_sections();
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_sections() {
		// Blog content layout
		add_filter('motta_site_layout', array( $this, 'layout' ));

		add_action( 'motta_before_search_loop', array( $this, 'search_heading' ), 10 );

		// Post Tabs
		if( is_category() ) {
			add_action( 'motta_before_archive_content', array( $this, 'posts_heading' ) );
		}

		// Set attributes for post loop
		$this->post->set_display('category');
		$this->post->set_display('excerpt', Helper::get_option('excerpt_length'));

		// Navigation
		add_action( 'motta_after_archive_content', array( $this, 'navigation' ), 30 );
		add_action( 'motta_after_search_loop', array( $this, 'navigation' ), 30 );

		// Sidebar
		add_filter('motta_get_sidebar', array( $this, 'sidebar' ), 10 );
		add_filter('motta_primary_sidebar_classes', array( $this, 'sidebar_classes' ));

		// Body Class
		add_filter( 'body_class', array( $this, 'body_classes' ) );

		// Post Class
		add_filter( 'post_class', array( $this, 'post_classes' ), 10, 3 );
	}


	/**
	 * Post Tabs
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function posts_heading() {
		\Motta\Blog\Posts_Heading::group();
	}

	/**
	 * Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function layout($layout) {
		if( is_active_sidebar('blog-sidebar') ){
			$layout = 'content-sidebar';
		}

		return $layout;
	}


	/**
	 * Search Heading
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function search_heading() {
		echo '<h4 class="motta-search__heading">' . sprintf( esc_html__( 'Search Results for: %s', 'motta' ), get_search_query() ) . '</h4>';
	}


	/**
	 * Navigation Posts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function navigation() {
		$navigation = new \Motta\Blog\Navigation();
		if ( 'loadmore' == \Motta\Helper::get_option( 'blog_nav_type' ) ) {
			$navigation::load_more();
		} else {
			$navigation::numberic();
		}
	}

	/**
	 * Get Sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function sidebar() {
		if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
			return false;
		}

		return true;

	}

	/**
	 * Get Sidebar Classes
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function sidebar_classes( $classes ) {
		if ( \Motta\Helper::is_blog() ) {
			$classes .= ' sticky-sidebar';
		}

		return $classes;
	}

	/**
	 * Classes Body
	 * @since 1.0.0
	 *
	 * @param $classes
	 * @return $classes
	 */
	public function body_classes( $classes ) {
		$classes[] = 'motta-blog-page';
		if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}

	/**
	 * Add a class of blog layout to posts
	 *
	 * @param array $classes
	 * @param array $class
	 * @param int   $post_id
	 *
	 * @return mixed
	 */
	public function post_classes( $classes, $class, $post_id ) {
		if ( ! is_search() || 'post' == get_post_type( $post_id ) || ! is_main_query() ) {
			return $classes;
		}

		$classes[] = 'hentry';

		return $classes;
	}
}
