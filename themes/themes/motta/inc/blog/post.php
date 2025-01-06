<?php
/**
 * Motta Blog Post functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Blog;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Motta Post
 *
 */
class Post {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;


	/**
	 * $fields
	 *
	 * @var $fields
	 */
	protected static $fields = [];

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
	}

	/**
	 * Set Display
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function set_display($name, $value=true) {
		self::$fields[$name] = $value;
	}


	/**
	 * Get Display
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public static function get_display($name) {
		if( isset( self::$fields[$name] ) ) {
			return self::$fields[$name];
		}

		return false;
	}

	/**
	 * Remove Display
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function remove_display($name) {
		if( isset( self::$fields[$name] ) ) {
			unset(self::$fields[$name]);
		}
	}

	/**
	 * Get entry thumbmail
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function thumbnail() {
		if ( ! has_post_thumbnail() ) {
			return;
		}

		$size = 'motta-post-thumbnail-medium';
		$size = apply_filters('motta_get_post_thumbnail_size', $size);

		$get_image = wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $size);

		if ( empty( $get_image ) ) {
			return;
		}

		echo sprintf(
			'<a class="post-thumbnail" href="%s" aria-hidden="true" tabindex="-1">%s%s</a>',
			esc_url( get_permalink() ),
			$get_image,
			self::get_format_icon()
		);
	}

	/**
	 * Get format
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function get_format_icon() {
		$icon = '';
		switch ( get_post_format() ) {
			case 'video':
				$icon = \Motta\Icon::get_svg( 'video', 'ui', array( 'class' => 'post-format-icon icon-video' ) );
				break;

			case 'gallery':
				$icon = \Motta\Icon::get_svg( 'gallery', 'ui', array( 'class' => 'post-format-icon icon-gallery' ) );
				break;
		}

		return $icon;
	}

	/**
	 * Get post image
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function image() {
		if( ! self::get_display('image') ) {
			return;
		}

		if ( ! has_post_thumbnail() ) {
			return;
		}
		$html = '';
		switch ( get_post_format() ) {
			case 'gallery':
				$images = get_post_meta( get_the_ID(), 'images' );

				if ( empty( $images ) ) {
					break;
				}

				$gallery = array();
				foreach ( $images as $image ) {
					$gallery[] = wp_get_attachment_image( $image, 'full', null, array( 'class' => 'swiper-slide' ) );
				}
				$html .= sprintf( '<div class="entry-thumbnail entry-gallery swiper-container"><div class="swiper-wrapper">%s</div><div class="motta-swiper-pagination swiper-pagination--background swiper-pagination--light"></div>%s%s</div>',
							implode( '', $gallery ),
							\Motta\Icon::get_svg( 'left', 'ui', array( 'class' => 'swiper-button motta-swiper-button-prev' ) ),
							\Motta\Icon::get_svg( 'right', 'ui', array( 'class' => 'swiper-button motta-swiper-button-next' ) )
						);
				break;

			case 'video':
				$video = get_post_meta( get_the_ID(), 'video', true );
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1140 ) ) ) {
						$html .= '<div class="entry-thumbnail entry-video">' . $oembed . '</div>';
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1140,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= '<div class="entry-thumbnail entry-video">' . wp_video_shortcode( $atts ) . '</div>';
					}
				} // If embed code: just display
				else {
					$html .= '<div class="entry-thumbnail entry-video">' . $video . '</div>';
				}
				break;

			default:
				$html = '<div class="entry-thumbnail">' . get_the_post_thumbnail( get_the_ID(), 'full' ) . '</div>';

				break;
		}

		echo apply_filters( __FUNCTION__, $html, get_post_format() );
	}


	/**
	 * Get entry title
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function title($tag = 'h2') {
		the_title( '<'.$tag.' class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></'.$tag.'>' );
	}

	/**
	 * Get category
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function category() {
		if( ! self::get_display('category') ) {
			return;
		}

		echo '<div class="entry-category">';
		the_category( ', ' );
		echo '</div>';
	}


	/**
	 * Meta author
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function author() {
		if( ! self::get_display('author') ) {
			return;
		}

		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'motta' ),
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
		);

		echo sprintf( '<div class="entry-meta__author">%s</div>', $byline );
	}

	/**
	 * Meta date
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function date() {
		echo sprintf( '<div class="entry-meta__date">%s</div>', esc_html( get_the_date() ) );
	}

	/**
	 * Meta comment
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function comment() {
		echo '<div class="entry-meta__comments">' . \Motta\Icon::get_svg( 'comment-mini' ) . get_comments_number() . '</div>';
	}

	/**
	 * Get Excerpt
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function excerpt() {
		if( ! self::get_display('excerpt') ) {
			return;
		}

		$length = self::get_display('excerpt');

		if( empty($length) ) {
			return;
		}

		self::get_excerpt($length);
	}

	/**
	 * Get Excerpt
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function get_excerpt($length) {
		echo '<div class="entry-excerpt">';

		echo \Motta\Helper::get_content_limit( $length, '' );

		echo '</div>';
	}

	/**
	 * Readmore button
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function button() {
		if( ! self::get_display('button') ) {
			return;
		}

		echo sprintf( '<div class="entry-read-more"><a class="motta-button motta-button--base motta-button--medium motta-button--bg-color-black" href="%s">%s</a></div>', get_permalink(), esc_html__( 'Read More', 'motta' ) );
	}

	/**
	 * Meta tag
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function tags() {
		if ( has_tag() == false ) {
			return;
		}

		if ( has_tag() ) :
			the_tags( '<div class="entry-tags">', ' ', '</div>' );
		endif;
	}

	/**
	 * Get entry share social
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function share() {
		if( ! self::get_display('share') ) {
			return;
		}
		echo '<div class="entry-meta__share">';
		echo \Motta\Icon::get_svg( 'share-mini' );
		esc_html_e('Share', 'motta');
		self::share_link();
		echo '</div>';
	}

	/**
	 * Share social
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function share_link() {
		if( ! self::get_display('share') ) {
			return;
		}

		echo \Motta\Helper::share_socials();
	}

}
