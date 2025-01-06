<?php
/**
 * Blog functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Blog;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class Manager {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance = null;

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
		add_filter('motta_get_footer_layout', array($this, 'footer_layout'));
		add_filter('motta_get_footer_mobile_layout', array($this, 'mobile_footer_layout'));
		add_action( 'pre_get_posts', array( $this, 'posts_group_query' ) );

		add_action('template_redirect', array($this, 'template_hooks'));

	}


	/**
	 * Template hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function template_hooks() {
		if( is_home() ) {
			\Motta\Blog\Main::instance();
		} elseif( is_singular('post') ) {
			\Motta\Blog\Single::instance();
		} elseif( is_archive() || is_search() )  {
			\Motta\Blog\Archive::instance();
		}

		if( \Motta\Helper::is_blog() || is_singular('post') ) {
			\Motta\Blog\Page_Header::instance();
			\Motta\Blog\Header::instance();
		}

	}

	/**
	 * Change the main query to get posts by group
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function posts_group_query( $query ) {
		if ( is_admin() || ! isset( $_GET['posts_group'] ) || empty( $_GET['posts_group'] ) || ( ! is_home() && ! is_category() ) || ! $query->is_main_query() ) {
			return;
		}

		switch ( $_GET['posts_group'] ) {
			case 'featured':
				$query->set( 'post__in', \Motta\Blog\Helper::get_post_ids_by_tags( array( 'tag' => 'featured' ) ) );
				break;

			case 'popular':
				$query->set( 'order', 'DESC' );
				$query->set( 'orderby', 'comment_count' );
				break;
		}
	}

	/**
	 * Footer Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function footer_layout( $layout ) {
		if ( \Motta\Helper::is_blog() || is_singular('post') ) {
			$blog_version = \Motta\Helper::get_option( 'footer_blog_version' );
			$layout = ! empty($blog_version) ? $blog_version : $layout;
		}

		return $layout;
	}


	/**
	 * Mobile Footer Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_footer_layout( $layout ) {
		if ( \Motta\Helper::is_blog() || is_singular('post') ) {
			$blog_version = \Motta\Helper::get_option( 'footer_blog_version' );
			$blog_mobile_version = \Motta\Helper::get_option( 'mobile_footer_blog_version' );
			if( ! empty($blog_version) ) {
				$layout = $blog_mobile_version;
			} else {
				$layout = !empty($blog_mobile_version) ? $blog_mobile_version : $layout;
			}
		}

		return $layout;
	}

}
