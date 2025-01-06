<?php

/**
 * WooCommerce dokan functions
 *
 * @package motta
 */

 namespace Motta\Vendors;

 if ( ! defined( 'ABSPATH' ) ) {
	 exit; // Exit if accessed directly.
 }


/**
 * Class of Vendor Dokan
 *
 * @version 1.0
 */
class AWS_Search {
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
	 * Construction function
	 *
	 * @since  1.0
	 * @return Motta_Vendor
	 */
	public function __construct() {
		add_action('dgwt/wcas/form', array( $this, 'search_trending' ) );

		add_filter('motta_header_search_icon_args', array( $this, 'search_icon_args' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );

	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'motta-aws-search', get_template_directory_uri() . '/assets/css/vendors/aws-search.css', array(), '20231106' );
	}

	public function search_trending() {
		$args['trending_searches'] = \Motta\Helper::get_option('header_search_trending_searches');
		\Motta\Header\Search::trendings( $args );
	}

	public function search_icon_args($args) {
		if( \Motta\Helper::get_option('header_search_bar') == 'shortcode' ) {
			$args['search_modal'] = 'aws-search';
		}

		return $args;
	}

}