<?php
/**
 * Header Main functions and definitions.
 *
 * @package Motta
 */

namespace Motta;

use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Header Main initial
 *
 */
class Page_404 {

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
		add_filter('motta_get_header_layout', array($this, 'header_layout'));
		add_filter('motta_get_header_mobile_layout', array($this, 'header_layout'));
		add_filter('motta_header_logo_type', array( $this, 'logo_type' ) );
		add_filter('motta_header_logo', array( $this, 'logo' ), 20, 2 );
		add_filter('motta_header_logo_dimension', array( $this, 'logo_dimension' ) );
		add_filter('motta_get_primary_menu', array($this, 'primary_menu'));
		add_filter( 'motta_get_footer_layout', array( $this, 'footer_layout' ) );
		add_filter( 'motta_get_footer_mobile_layout', '__return_false' );
		add_filter( 'motta_get_topbar', array( $this, 'get_topbar' ) );
		add_filter( 'motta_get_campaign_bar', array( $this, 'get_campaign_bar' ) );
	}


	/**
	 * Header Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function header_layout( $layout ) {
		$page_version = \Motta\Helper::get_option( 'header_page_404_version' );
		$layout = $page_version !== '' ? $page_version : $layout;

		return $layout;
	}

	/**
	 * 	Primary Menu
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function primary_menu( $menu_id ) {
		$primary_menu_id = Helper::get_option('page_404_primary_menu');
		if( ! empty( $primary_menu_id ) ) {
			$menu_id = $primary_menu_id;
		}

		return $menu_id;
	}


	/**
	 * Footer Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function footer_layout( $layout ) {
		$page_404_version = \Motta\Helper::get_option( 'footer_page_404_version' );
		$layout = $page_404_version != '' ? $page_404_version : $layout;
		return $layout;
	}

	/**
	 * Top bar
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_topbar( $topbar ) {
		if( \Motta\Helper::get_option( 'header_page_404_hide_topbar' ) ) {
			$topbar = false;
		}


		return $topbar;
	}

		/**
	 * Footer Layout
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function get_campaign_bar( $campaign_bar ) {
		if( \Motta\Helper::get_option( 'header_page_404_hide_campaign_bar' ) ) {
			$campaign_bar = false;
		}

		return $campaign_bar;
	}

	/**
	 *Header logo Type
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function logo_type( $type  ) {
		$logo_type = Helper::get_option('header_page_404_logo_type');
		$type = $logo_type != 'default' ? $logo_type : $type;

		return $type;
	}

	/**
	 *Header logo
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function logo( $logo, $type ) {
		$type = \Motta\Helper::get_option('header_page_404_logo_type');
		$custom_logo = $this->custom_logo($logo, $type);
		$logo = empty( $custom_logo ) ? $logo : $custom_logo;
		return $logo;
	}



	/**
	 *Header Custom logo
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function custom_logo( $type='' ) {
		$custom_logo = '';
		$type = $this->logo_type( $type );

		if ( 'text' == $type ) {
			$custom_logo =  Helper::get_option('header_page_404_logo_text');
		} elseif ( 'svg' == $type ) {
			$custom_logo =  Helper::get_option('header_page_404_logo_svg');
		} elseif ( 'image' == $type ) {
			$custom_logo =  Helper::get_option('header_page_404_logo');
		}
		return $custom_logo;
	}

	/**
	 *Header logo Type
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function logo_dimension( $dimension  ) {
		$logo_dimension = Helper::get_option('header_page_404_logo_dimension');
		if( ! empty( $logo_dimension ) && ( ! empty ( $logo_dimension['width'] ) || ! empty ( $logo_dimension['height'] ) ) ) {
			if( isset($logo_dimension['width']) ) {
				$dimension['width'] = $logo_dimension['width'];
			}
			if( isset($logo_dimension['height']) ) {
				$dimension['height'] = $logo_dimension['height'];
			}
		}

		return $dimension;
	}

}
