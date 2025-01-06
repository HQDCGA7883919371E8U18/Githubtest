<?php
/**
 * Navigation
 *
 * @package Motta
 */

namespace Motta\Blog;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Navigation initial
 */
class Navigation {

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter('next_posts_link_attributes', array( $this, 'posts_link_attributes') );
	}


	/**
	 * Navigation numberic
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function numberic() {
		the_posts_pagination( array(
			'end_size'  => 3,
			'prev_text' => \Motta\Icon::get_svg( 'left', 'ui', 'class=motta-pagination__arrow' ),
			'next_text' => \Motta\Icon::get_svg( 'right', 'ui', 'class=motta-pagination__arrow' )
		) );
	}

	/**
	 * Navigation Load More
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function load_more() {
		self::posts_found();
		$link = get_next_posts_link( esc_html__( 'Load More', 'motta' ) );

		if( empty( $link ) ) {
			return;
		}

		echo sprintf('
			<nav class="navigation pagination next-posts-navigation">
				<h4 class="screen-reader-text">%s</h4>
				%s
				<div class="motta-pagination--loading">
					<div class="motta-pagination--loading-dots">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
					<div class="motta-pagination--loading-text">%s</div>
				</div>
			</nav>',
			esc_html__( 'Next posts navigation', 'motta' ),
			$link,
			esc_html__( 'Loading more....', 'motta' )
		);
	}

	/**
	 * Add class button next navigation
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function posts_link_attributes() {
		return 'class="nav-links motta-button motta-button--base motta-button--bg-color-black motta-button--large"';
	}

	/**
	 * Get post found
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function posts_found() {
		global $wp_query;

		if ( $wp_query && $wp_query->found_posts ) {

			$post_text = $wp_query->found_posts > 1 ? esc_html__( 'Posts', 'motta' ) : esc_html__( 'Post', 'motta' );

			echo sprintf( '<div class="motta-posts-found motta-progress">
								<div class="motta-posts-found__inner motta-progress__inner">
								%s
								<span class="current-post"> %s </span>
								%s
								<span class="found-post"> %s </span>
								%s
								<span class="count-bar motta-progress__count-bar"></span>
							</div>
						</div>',
					esc_html__( 'Showing', 'motta' ),
					$wp_query->post_count,
					esc_html__( 'of', 'motta' ),
					$wp_query->found_posts, $post_text
			);

		}
	}


}
