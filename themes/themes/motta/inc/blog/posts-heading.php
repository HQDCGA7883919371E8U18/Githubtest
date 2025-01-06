<?php
/**
 * Post Tabs
 *
 * @package Motta
 */

namespace Motta\Blog;

use Motta\Helper;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Single initial
 */
class Posts_Heading {

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Post Tabs
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function recent_heading() {
		echo sprintf(
			'<h4 class="motta-recent-post__heading">%s</h4>',
			apply_filters( 'motta_recent_posts_heading', esc_html__( 'Recent Posts', 'motta' ) )
		);
	}

	/**
	 * Post Tabs
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function group() {
		$current_tab = $term_link = '';
		if(isset( $_GET['posts_group'] ) && ! empty( $_GET['posts_group'] ) ) {
			$current_tab = $_GET['posts_group'];
		}

		if( is_category() ) {
			$term_id = get_queried_object()->term_id;
			$term_link = get_term_link( $term_id, 'category' );
		} else {
			$term_link = get_permalink( get_option( 'page_for_posts' ) );
		}


		echo sprintf(
			'<div id="motta-posts-group" class="motta-posts-group">
				<ul class="motta-posts-group__items">
					<li><a class="%s" href="%s">%s</a></li>
					<li><a class="popular %s" href="%s">%s</a></li>
					<li><a class="featured %s" href="%s">%s</a></li>
				</ul>
			</div>',
			$current_tab == '' ? 'active' : '',
			$term_link,
			esc_html__( 'Recent Posts', 'motta' ),
			$current_tab == 'popular' ? 'active' : '',
			$term_link . '?posts_group=popular',
			esc_html__( 'Popular Posts', 'motta' ),
			$current_tab == 'featured' ? 'active' : '',
			$term_link . '?posts_group=featured',
			esc_html__( 'Featured Posts', 'motta' )
		);
	}

	/**
	 * Posts menu
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function menu() {
		$menu_slug = \Motta\Helper::get_option( 'blog_posts_heading_menu' );
		if( empty( $menu_slug ) ) {
			return;
		}

		wp_nav_menu( array(
			'theme_location' => '__no_such_location',
			'menu'           => $menu_slug,
			'container'      => 'div',
			'container_class' => 'motta-posts-group',
			'container_id'    => 'motta-posts-group',
			'menu_id'        => 'motta-posts-group-menu',
			'menu_class'     => 'motta-posts-group__items motta-posts-group--menu nav-menu menu',
			'depth'          => 1,
		) );
	}
}
