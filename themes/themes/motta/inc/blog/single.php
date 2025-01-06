<?php
/**
 * Single functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Blog;
use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Single initial
 */
class Single {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $post
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
		$this->post     = new \Motta\Blog\Post();
		$this->init();
	}

	/**
	 * Init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'motta_site_layout', array( $this, 'content_layout' ));

		// Blog Header
		add_filter( 'motta_get_page_header_elements', array( $this, 'page_header_elements' ) );

		$this->post->set_display('author');
		$this->post->set_display('category');

		if(Helper::get_option( 'post_layout' ) == 'no-sidebar' || ! is_active_sidebar( 'single-sidebar' ) ) {
			$this->post->set_display('image');
		} else {
			add_action( 'motta_after_site_content_open', array( $this, 'post_format_image' ), 20 );
		}

		if( Helper::get_option('post_sharing') ){
			$this->post->set_display('share');
		}

		if (Helper::get_option('post_author_box') ) {
			add_action( 'motta_after_post_content', array( $this, 'author_info' ), 20 );
		}

		if (Helper::get_option('post_navigation') ) {
			add_action( 'motta_after_post_content', array( $this, 'navigation' ), 40 );
		}

		if (Helper::get_option('post_navigation') ) {
			add_action( 'motta_after_post_content', array( $this, 'related_posts' ), 60 );
		}

		// Sidebar
		add_filter('motta_get_sidebar', array( $this, 'sidebar' ), 10 );
	}

	/**
	 * Get site layout
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function content_layout($layout) {
		if ( ! is_active_sidebar( 'single-sidebar' ) ) {
			$layout = 'no-sidebar';
		} else {
			$layout = Helper::get_option( 'post_layout' );
		}

		return $layout;
	}


	/**
	 * Post format image
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function post_format_image() {
		$this->post->set_display('image');
		$this->post->image();
		$this->post->remove_display('image');
	}

	/**
	 * Page Header Elements
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function page_header_elements( $items ) {
		$items = [];

		return $items;
	}

	/**
	 * Meta author description
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function author_info() {
		get_template_part( 'template-parts/post/biography');
	}

	/**
	 * Meta post navigation
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */

	public function navigation() {
		get_template_part( 'template-parts/post/post', 'navigation');
	}

	/**
	 * Related post
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function related_posts() {
		get_template_part( 'template-parts/post/related-posts' );
	}

	/**
	 * Get Sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function sidebar() {
		if ( ! is_active_sidebar( 'single-sidebar' ) ) {
			return false;
		} elseif( Helper::get_option( 'post_layout' ) == 'no-sidebar') {
			return false;
		}

		return true;

	}
}
