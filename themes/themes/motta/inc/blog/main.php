<?php
/**
 * Posts functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Blog;

use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts initial
 *
 */
class Main {
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
	 * $Post
	 *
	 * @var int $post
	 */
	protected $trending_count = 0;


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


		// Trending Posts
		$this->trending_posts();

		// Featured Posts
		if(Helper::get_option('blog_featured_posts')) {
			if ( \Motta\Helper::get_option( 'blog_featured_position' ) == 'under' ) {
				add_action( 'motta_before_site_content_close', array( $this, 'featured_posts' ), 10 );
			} else {
				add_action( 'motta_after_site_content_open', array( $this, 'featured_posts' ), 30 );
			}
		}

		// Post Tabs
		if(Helper::get_option('blog_posts_heading')) {
			add_action( 'motta_before_blog_main_content', array( $this, 'posts_heading' ) );
		}

		// Blog Posts
		add_filter( 'post_class', array( $this, 'post_classes' ), 10, 3 );
		add_filter('motta_get_post_thumbnail_size', array( $this, 'post_thumbnail_size' ));

		// Set attributes for post loop
		$this->post->set_display('category');
		if(Helper::get_option( 'blog_layout' ) == 'default') {
			$this->post->set_display('excerpt', Helper::get_option('excerpt_length'));
		} elseif(Helper::get_option( 'blog_layout' ) == 'classic') {
			$this->post->set_display('excerpt', Helper::get_option('excerpt_length'));
			$this->post->set_display('author');
			$this->post->set_display('button');
		}


		// Recent Post Heading
		if(	Helper::get_option('blog_recent_posts_heading')) {
			add_action( 'motta_before_blog_main_content', array( $this, 'recent_posts_heading' ) );
		}

		// Navigation
		add_action( 'motta_after_blog_main_content', array( $this, 'navigation' ), 30 );

		// Sidebar
		add_filter('motta_get_sidebar', array( $this, 'sidebar' ), 10 );

		// Body Class
		add_filter( 'body_class', array( $this, 'body_classes' ) );
	}


	/**
	 * Post Tabs
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function posts_heading() {
		switch ( \Motta\Helper::get_option( 'blog_posts_heading_type' ) ) {
			case 'recent':
				\Motta\Blog\Posts_Heading::recent_heading();
				break;

			case 'group':
				\Motta\Blog\Posts_Heading::group();
				break;

			case 'menu':
				\Motta\Blog\Posts_Heading::menu();
				break;
		}
	}

	/**
	 * Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function layout( $layout ) {
		if( 'grid' !== Helper::get_option( 'blog_layout' )  && is_active_sidebar( 'blog-sidebar' ) ){
			$layout = 'content-sidebar';
		}

		return $layout;
	}

	/**
	 * Get Classes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function trending_posts() {
		if(	! Helper::get_option('blog_trending_posts')) {
			return;
		}

		add_action( 'motta_after_site_content_open', array( $this, 'get_trending_posts' ), 20 );

		if ( \Motta\Helper::get_option( 'blog_trending_layout' ) == 2 ) {
			add_action( 'motta_before_trending_posts_content', array( $this, 'open_box_carousel_wrapper' ) );
			add_action( 'motta_after_trending_posts_content', array( $this, 'close_box_carousel_wrapper' ) );
		}

		if ( \Motta\Helper::get_option( 'blog_trending_layout' ) == 1 ) {
			add_action( 'motta_before_trending_post_loop_content', array( $this, 'open_trending_posts_small' ) );
			add_action( 'motta_after_trending_post_loop_content', array( $this, 'close_trending_posts_small' ) );

			$this->post->set_display( 'button_class', 'small' );
		}
	}

	/**
	 * Trending Posts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_trending_posts() {
		$layout = \Motta\Helper::get_option( 'blog_trending_layout' );
		$number_item = 1;

		if ( $layout == 1 ) {
			$number_item = 3;
		} elseif ( $layout == 2 ) {
			$number_item = \Motta\Helper::get_option( 'blog_trending_carousel_number' );
		}

		$args = \Motta\Blog\Helper::get_post_ids_by_tags( array(
			'posts_per_page' => $number_item,
			'tag'            => \Motta\Helper::get_option( 'blog_trending_tag' ),
		) );

		if( empty( $args ) ) {
			return;
		}

		if( in_array ( $layout, array('2','3') ) ){
			$this->post->set_display('td_excerpt', \Motta\Helper::get_option( 'blog_trending_length' ));
			$this->post->set_display('author');
		}

		get_template_part( 'template-parts/post/trending', 'posts', $args );

	}

	/**
	 * Open box trending posts small
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function open_box_carousel_wrapper() {
		echo '<div class="swiper-container"><div class="trending-posts__wrapper swiper-wrapper">';
	}

	/**
	 * Open box trending posts small
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function close_box_carousel_wrapper() {
		echo '</div></div>';

		echo \Motta\Icon::get_svg( 'arrow-left-long', 'ui', array( 'class' => 'swiper-button motta-swiper-button-prev swiper-button--raised' ) );
		echo \Motta\Icon::get_svg( 'arrow-right-long', 'ui', array( 'class' => 'swiper-button motta-swiper-button-next swiper-button--raised' ) );
	}

	/**
	 * Open box trending posts small
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function open_trending_posts_small() {
		if ( $this->trending_count == 1 ) {
			echo '<div class="trending-posts--small">';
		}
	}

	/**
	 * Close box trending posts small
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function close_trending_posts_small( $trending ) {
		$count_item = $trending->post_count == 2 ? 1 : 2;

		if ( $this->trending_count == $count_item ) {
			echo '</div>';
		}

		$this->trending_count++;
	}

	/**
	 * Featured Posts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function featured_posts() {
		$args = \Motta\Blog\Helper::get_post_ids_by_tags( array(
			'posts_per_page' => \Motta\Helper::get_option( 'blog_featured_posts_total' ),
			'tag'            => \Motta\Helper::get_option( 'blog_featured_tag' ),
		) );

		if ( ! apply_filters( 'motta_featured_posts_duplicate', false ) && \Motta\Helper::get_option( 'blog_trending_posts' ) ) {
			$args['post__not_in'] = \Motta\Blog\Helper::get_post_ids_by_tags( array(
				'tag'            => \Motta\Helper::get_option( 'blog_trending_tag' )
			) );
		}

		get_template_part( 'template-parts/post/featured', 'posts', $args);
	}

	/**
	 * Recent Post Heading
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function recent_posts_heading() {
		echo '<h4 class="motta-recent-post__heading">'. apply_filters( 'motta_recent_posts_heading', esc_html__( 'Recent Posts', 'motta' ) ) .'</h4>';
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
	 * Add a class of blog layout to posts
	 *
	 * @param array $classes
	 * @param array $class
	 * @param int   $post_id
	 *
	 * @return mixed
	 */
	public function post_classes( $classes, $class, $post_id ) {
		if ('post' != get_post_type( $post_id ) || ! is_main_query() ) {
			return $classes;
		}

		if ( $this->get_post_large() ) {
			$classes[] = 'post-large';
		}

		return $classes;
	}

	/**
	 * Get post thumbnail size
	 *
	 * @param $size
	 *
	 * @return mixed
	 */
	public function post_thumbnail_size( $size ) {
		$size = $this->get_post_large() ? 'motta-post-thumbnail-large' : $size;

		return $size;
	}


	/**
	 * Get post large
	 *
	 * @return bool
	 */
	public function get_post_large() {
		if ( 'classic' == \Motta\Helper::get_option( 'blog_layout' ) ) {
			global $wp_query;
			$current_post = $wp_query->current_post;

			if ( 'loadmore' == \Motta\Helper::get_option( 'blog_nav_type' ) ) {
				$paged        = get_query_var( 'paged' );
				$paged        = min( 0, $paged - 1 );
				$current_post += $paged * get_query_var( 'posts_per_page' );
			}

			if ( $current_post == 0 || 0 === $current_post % 5 ) {
				return true;
			}
		}

		return false;
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

		if ( \Motta\Helper::get_option( 'blog_layout' ) == 'grid' ) {
			return false;
		}

		return true;
	}

	/**
	 * Classes Body
	 */
	public function body_classes( $classes ) {
		$classes[] = 'motta-blog-page';
		$classes[] = 'blog--' . \Motta\Helper::get_option( 'blog_layout' );

		if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
			$classes[] = 'no-sidebar';
		}

		return $classes;
	}
}
