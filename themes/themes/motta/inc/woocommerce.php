<?php
/**
 * Woocommerce functions and definitions.
 *
 * @package Motta
 */

namespace Motta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Woocommerce initial
 *
 */
class WooCommerce {
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
		\Motta\WooCommerce\Customizer::instance();
		\Motta\WooCommerce\Sidebars::instance();
		add_action( 'after_setup_theme', array( $this, 'woocommerce_setup' ) );
		add_action('init', array($this, 'init'));
		add_action( 'wp', array( $this, 'add_actions' ), 10 );
	}

	/**
	 * WooCommerce Init
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {
		\Motta\WooCommerce\General::instance();
		\Motta\WooCommerce\Settings::instance();
		\Motta\WooCommerce\Dynamic_CSS::instance();
		\Motta\WooCommerce\Product_Card::instance();
		\Motta\WooCommerce\Badges::instance();
		\Motta\WooCommerce\QuickView::instance();
		if(  ! empty( Helper::get_option('product_card_attribute') && Helper::get_option('product_card_attribute') != 'none'  ) ) {
			\Motta\WooCommerce\Product_Attribute::instance();
		}

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			\Motta\Vendors\Dokan::instance();
		}

		if ( class_exists( 'WCFMmp' ) ) {
			\Motta\Vendors\WCFM::instance();
		}

		if ( class_exists( 'Marketkingcore' ) ) {
			\Motta\Vendors\Marketking::instance();
		}

		if ( class_exists( 'DGWT_WC_Ajax_Search' ) ) {
			\Motta\Vendors\Fibo_Search::instance();
		}

		if ( class_exists( 'AWS_Main' ) ) {
			\Motta\Vendors\AWS_Search::instance();
		}

		if(is_admin()) {
			\Motta\WooCommerce\Product::instance();
			\Motta\WooCommerce\Track_Order::instance();
		}
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_actions() {
		if (  apply_filters('motta_load_woo_product_archive', \Motta\Helper::is_catalog() ) ) {
			\Motta\WooCommerce\Catalog::instance();
		}
		if ( apply_filters('motta_load_woo_single_product', is_singular( 'product' ) ) ) {
			\Motta\WooCommerce\Single_Product::instance();
			if ( ! empty(Helper::get_option( 'related_products')) ) {
				\Motta\WooCommerce\Related_Products::instance();
			} else {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
		}
		if ( function_exists('is_cart') && is_cart() ) {
			\Motta\WooCommerce\Cart::instance();
		}

		//if ( function_exists('is_checkout') && is_checkout() ) {
			\Motta\WooCommerce\Checkout::instance();
		//}

		if ( function_exists('wcboost_wishlist') ) {
			\Motta\WooCommerce\Wishlist::instance();
		}

		if ( function_exists('wcboost_products_compare') ) {
			\Motta\WooCommerce\Compare::instance();
		}

		\Motta\WooCommerce\Account::instance();
		\Motta\WooCommerce\Products_Recently_Viewed::instance();
		\Motta\WooCommerce\Product_Notices::instance();
		\Motta\WooCommerce\Currency::instance();

	}

		/**
	 * WooCommerce setup function.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function woocommerce_setup() {
		add_theme_support( 'woocommerce', array(
			'product_grid' => array(
				'default_rows'    => 4,
				'min_rows'        => 2,
				'max_rows'        => 20,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 7,
			),
			'wishlist' => array(
				'single_button_position' => 'theme',
				'loop_button_position'   => 'theme',
				'button_type'            => 'theme',
			),
		) );
		add_theme_support( 'wc-product-gallery-slider' );

		if( Helper::get_option( 'product_image_zoom' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		if ( Helper::get_option( 'product_image_lightbox' ) ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
	}
}
