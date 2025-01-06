<?php
/**
 * Kirki fonts functions
 *
 * @package Motta
 */

namespace Motta\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Block Editor
 *
 */
class Kirki_Fonts {
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
		if ( defined( 'KIRKI_VERSION' ) && version_compare( KIRKI_VERSION, '5.0.0', '<=' ) ) {
			add_filter( 'http_request_args', array( $this,'fix_kirki_fonts_request_headers'), 10, 2 );
			add_action( 'after_switch_theme', array( $this,'fix_kirki_fonts' ) );
			add_action( 'wp_ajax_kirki_clear_font_cache', array( $this, 'fix_kirki_fonts' ) );
		}
	}

	/**
	 * Change the http request headers of 'user-agent' to download .woff2 fonts frm Google.
	 *
	 * @param  array $args
	 * @param  string $url
	 *
	 * @return array
	 */
	function fix_kirki_fonts_request_headers( $args, $url ) {
		if ( false === strpos( $url, 'https://fonts.googleapis.com/css' ) ) {
			return $args;
		}

		if ( isset( $args['user-agent'] ) && $args['user-agent'] == 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8' ) {
			$args['user-agent'] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0';
		}

		return $args;
	}

	/**
	 * Fix incorrect fonts files downloaded from Google.
	 * Delete the Kirki's transients to force downloading font files again.
	 *
	 * @return void
	 */
	function fix_kirki_fonts() {
		delete_transient( 'kirki_remote_url_contents' );
	}
}
