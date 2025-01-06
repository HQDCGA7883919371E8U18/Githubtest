<?php
/**
 * Help Center functions and definitions.
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
class Help_Center {
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
		if( ! is_singular('motta_help_article') && ('motta_help_article' == get_query_var('post_type') || is_tax('motta_help_cat') ) ) {
			\Motta\Help_Center\Category::instance();
		}

		if( 'motta_help_article' == get_query_var('post_type') || is_tax('motta_help_cat') || \Motta\Helper::is_help_center_page() ) {
			\Motta\Help_Center\Header::instance();
			\Motta\Help_Center\Footer::instance();

			\Motta\Help_Center\Page_Header::instance();

		}

		if( is_singular('motta_help_article') ) {
			\Motta\Help_Center\Article::instance();
		}

	}

}
