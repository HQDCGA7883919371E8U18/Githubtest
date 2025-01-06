<?php

/**
 * Theme Options
 *
 * @package Motta
 */

namespace Motta;

use WPML\Collect\Support\Arr;

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class Options {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * $motta_customize
	 *
	 * @var $motta_customize
	 */
	protected static $motta_customize = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self:: $instance;
	}

	/**
	 * The class constructor
	 *
	 * @since 1.0.0
	 *
	 */
	public function __construct() {
		add_filter('motta_customize_config', array($this, 'customize_settings'));
		self::$motta_customize = \Motta\Customizer::instance();
	}

	/**
	 * This is a short hand function for getting setting value from customizer
	 *
	 * @since 1.0.0
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option($name) {
		if ( is_object( self::$motta_customize ) ) {
			$value = self::$motta_customize->get_option( $name );
		} elseif (false !== get_theme_mod($name)) {
			$value = get_theme_mod($name);
		} else {
			$value = $this->get_option_default($name);
		}
		return apply_filters('motta_get_option', $value, $name);
	}

	/**
	 * Get default option values
	 *
	 * @since 1.0.0
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default($name) {
		if ( is_object( self::$motta_customize ) ) {
			return self::$motta_customize->get_option_default( $name );
		}

		$config   = $this->customize_settings();
		$settings = array_reduce( $config['settings'], 'array_merge', array() );

		if ( ! isset( $settings[ $name ] ) ) {
			return false;
		}

		return isset( $settings[ $name ]['default'] ) ? $settings[ $name ]['default'] : false;
	}

	/**
	 * Options of topbar items
	 *
	 * @return array
	 */
	public static function topbar_items_option() {
		return apply_filters( 'motta_topbar_items_option', array(
			''     			    => esc_html__( 'Select an Item', 'motta' ),
			'primary-menu' 	    => esc_html__( 'Primary Menu', 'motta' ),
			'secondary-menu'    => esc_html__( 'Secondary Menu', 'motta' ),
			'language' 			=> esc_html__( 'Language', 'motta' ),
			'currency' 			=> esc_html__( 'Currency', 'motta' ),
			'language-currency' => esc_html__( 'Language/Currency', 'motta' ),
			'socials'        => esc_html__( 'Socials', 'motta' ),
			'hamburger'      => esc_html__( 'Hamburger Menu', 'motta' ),
		) );
	}

	/**
	 * Options of header items
	 *
	 * @return array
	 */
	public static function header_items_option() {
		return apply_filters( 'motta_header_items_option', array(
			''     			 => esc_html__( 'Select an Item', 'motta' ),
			'logo'           => esc_html__( 'Logo', 'motta' ),
			'cart'           => esc_html__( 'Cart', 'motta' ),
			'wishlist'       => esc_html__( 'Wishlist', 'motta' ),
			'compare'        => esc_html__( 'Compare', 'motta' ),
			'account'        => esc_html__( 'Account', 'motta' ),
			'search'         => esc_html__( 'Search', 'motta' ),
			'primary-menu'   => esc_html__( 'Primary Menu', 'motta' ),
			'secondary-menu' => esc_html__( 'Secondary Menu', 'motta' ),
			'category-menu'  => esc_html__( 'Category Menu', 'motta' ),
			'hamburger'      => esc_html__( 'Hamburger Menu', 'motta' ),
			'socials'        => esc_html__( 'Socials', 'motta' ),
			'return'         => esc_html__( 'Return Button', 'motta' ),
			'custom-text'    => esc_html__( 'Custom Text', 'motta' ),
			'empty-space'    => esc_html__( 'Empty Space', 'motta' ),
			'language'     	 => esc_html__( 'Language', 'motta' ),
			'currency'     	 => esc_html__( 'Currency', 'motta' ),
			'preferences'    => esc_html__( 'Preferences', 'motta' ),
			'view-history'   => esc_html__( 'View History', 'motta' ),
		) );
	}

	/**
	 * Options of header mobile items
	 *
	 * @return array
	 */
	public static function header_mobile_items_option() {
		return apply_filters( 'motta_header_mobile_items_option', array(
			''     					=> esc_html__( 'Select an Item', 'motta' ),
			'logo'           		=> esc_html__( 'Logo', 'motta' ),
			'cart'          		=> esc_html__( 'Cart', 'motta' ),
			'wishlist'          	=> esc_html__( 'Wishlist', 'motta' ),
			'compare'          		=> esc_html__( 'Compare', 'motta' ),
			'account'        		=> esc_html__( 'Account', 'motta' ),
			'hamburger'           	=> esc_html__( 'Hamburger Menu', 'motta' ),
			'search'           		=> esc_html__( 'Search', 'motta' ),
			'language'      		=> esc_html__( 'Language', 'motta' ),
			'currency'    			=> esc_html__( 'Currency', 'motta' ),
			'preferences'     		=> esc_html__( 'Preferences', 'motta' ),
			'view-history'     		=> esc_html__( 'View History', 'motta' ),
		) );
	}

	/**
	 * Options of header sticky items
	 *
	 * @return array
	 */
	public static function header_sticky_items_option() {
		return apply_filters( 'motta_header_sticky_items_option', array(
			''     			 => esc_html__( 'Select an Item', 'motta' ),
			'logo'           => esc_html__( 'Logo', 'motta' ),
			'cart'           => esc_html__( 'Cart', 'motta' ),
			'wishlist'       => esc_html__( 'Wishlist', 'motta' ),
			'compare'        => esc_html__( 'Compare', 'motta' ),
			'account'        => esc_html__( 'Account', 'motta' ),
			'search'         => esc_html__( 'Search', 'motta' ),
			'primary-menu'   => esc_html__( 'Primary Menu', 'motta' ),
			'secondary-menu' => esc_html__( 'Secondary Menu', 'motta' ),
			'category-menu'  => esc_html__( 'Category Menu', 'motta' ),
			'hamburger'      => esc_html__( 'Hamburger Menu', 'motta' ),
			'language'     	 => esc_html__( 'Language', 'motta' ),
			'currency'     	 => esc_html__( 'Currency', 'motta' ),
			'preferences'    => esc_html__( 'Preferences', 'motta' ),
		) );
	}

	/**
	 * Options of header mobile sticky items
	 *
	 * @return array
	 */
	public static function header_mobile_sticky_items_option() {
		return apply_filters( 'motta_header_mobile_sticky_items_option', array(
			''     					=> esc_html__( 'Select an Item', 'motta' ),
			'logo'           		=> esc_html__( 'Logo', 'motta' ),
			'cart'          		=> esc_html__( 'Cart', 'motta' ),
			'wishlist'          	=> esc_html__( 'Wishlist', 'motta' ),
			'compare'          		=> esc_html__( 'Compare', 'motta' ),
			'account'        		=> esc_html__( 'Account', 'motta' ),
			'hamburger'           	=> esc_html__( 'Hamburger Menu', 'motta' ),
			'search'           		=> esc_html__( 'Search', 'motta' ),
			'language'      		=> esc_html__( 'Language', 'motta' ),
			'currency'    			=> esc_html__( 'Currency', 'motta' ),
			'preferences'     		=> esc_html__( 'Preferences', 'motta' ),
		) );
	}

	/**
	 * Options of account items
	 *
	 * @return array
	 */
	public static function account_items_option() {
		return apply_filters( 'motta_account_items_option', array(
			'my-account'    => esc_html__( 'My Account (For Logged In)', 'motta' ),
			'sign-in'     	=> esc_html__( 'Sign In', 'motta' ),
			'create-account'=> esc_html__( 'Create Account', 'motta' ),
			'wishlist'		=> esc_html__( 'Wishlist', 'motta' ),
			'compare'		=> esc_html__( 'Compare', 'motta' ),
			'track-order'	=> esc_html__( 'Track Order', 'motta' ),
			'help-center'   => esc_html__( 'Help Center', 'motta' ),
			'custom-menu'   => esc_html__( 'Custom Menu', 'motta' ),
			'sign-out'      => esc_html__( 'Sign Out (For Logged In)', 'motta' ),
		) );
	}

	/**
	 * Options of navigation bar items
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function navigation_bar_items_option() {
		return apply_filters( 'motta_navigation_bar_items_option', array(
			'home'     => esc_html__( 'Home', 'motta' ),
			'shop'     => esc_html__( 'Shop', 'motta' ),
			'cart'     => esc_html__( 'Cart', 'motta' ),
			'wishlist' => esc_html__( 'Wishlist', 'motta' ),
			'compare'  => esc_html__( 'Compare', 'motta' ),
			'account'  => esc_html__( 'Account', 'motta' ),
			'categories'  => esc_html__( 'Categories', 'motta' ),
		) );
	}


	/**
	 * Get customize settings
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function customize_settings() {
		$settings = array(
			'theme' => 'motta',
		);

		$panels = array(
			'general'    => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'motta' ),
			),
			'typography' => array(
				'priority' => 20,
				'title'    => esc_html__( 'Typography', 'motta' ),
			),
			'header'       => array(
				'priority' => 30,
				'title'    => esc_html__( 'Header', 'motta' ),
			),
			'blog'       => array(
				'priority' => 50,
				'title'    => esc_html__( 'Blog', 'motta' ),
			),
			'page'       => array(
				'priority' => 50,
				'title'    => esc_html__( 'Page', 'motta' ),
			),
			'help_center' => array(
				'priority'   => 80,
				'title'      => esc_html__('Help Center', 'motta'),
			),
			'mobile' => array(
				'priority'   => 90,
				'title'      => esc_html__('Mobile', 'motta'),
			),
		);

		$sections = array(
			// Maintenance
			'maintenance'  => array(
				'title'      => esc_html__('Maintenance', 'motta'),
				'priority'   => 10,
				'capability' => 'edit_theme_options',
			),
			'styling' => array(
				'priority' => 10,
				'title'    => esc_html__('Styling', 'motta'),
				'capability'  => 'edit_theme_options',
			),
			'api_keys' => array(
				'title'    => esc_html__( 'API Keys', 'motta' ),
				'panel'    => 'general',
			),
			'backtotop' => array(
				'title'    => esc_html__( 'Back To Top', 'motta' ),
				'panel'    => 'general',
			),
			'share_socials' => array(
				'title'    => esc_html__( 'Share Socials', 'motta' ),
				'panel'    => 'general',
			),
			'typo_main'         => array(
				'title'    => esc_html__( 'Main', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_headings'     => array(
				'title'    => esc_html__( 'Headings', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_header_logo'         => array(
				'title'    => esc_html__( 'Header Logo Text', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_header_menu_primary'       => array(
				'title'    => esc_html__( 'Header Primary Menu', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_header_menu_secondary'       => array(
				'title'    => esc_html__( 'Header Secondary Menu', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_header_menu_category'       => array(
				'title'    => esc_html__( 'Header Category Menu', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_page'         => array(
				'title'    => esc_html__( 'Page', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_posts'        => array(
				'title'    => esc_html__( 'Blog', 'motta' ),
				'panel'    => 'typography',
			),
			'typo_widget'       => array(
				'title'    => esc_html__( 'Widgets', 'motta' ),
				'panel'    => 'typography',
			),
			'header_top'        => array(
				'title'    => esc_html__( 'Topbar', 'motta' ),
				'panel'    => 'header',
			),
			'header_layout'        => array(
				'title'    => esc_html__( 'Header Layout', 'motta' ),
				'panel'    => 'header',
			),
			'header_main'       => array(
				'title'    => esc_html__( 'Header Main', 'motta' ),
				'panel'    => 'header',
			),
			'header_bottom'       => array(
				'title'    => esc_html__( 'Header Bottom', 'motta' ),
				'panel'    => 'header',
			),
			'header_sticky'       => array(
				'title'    => esc_html__( 'Sticky Header', 'motta' ),
				'panel'    => 'header',
			),
			'header_background'       => array(
				'title'    => esc_html__( 'Header Background', 'motta' ),
				'panel'    => 'header',
			),
			'header_campaign'   => array(
				'title'    => esc_html__( 'Campaign Bar', 'motta' ),
				'panel'    => 'header',
			),
			'logo'              => array(
				'title'    => esc_html__( 'Logo', 'motta' ),
				'panel'    => 'header',
			),
			'header_search'              => array(
				'title'    => esc_html__( 'Search', 'motta' ),
				'panel'    => 'header',
			),
			'header_account'    => array(
				'title'    => esc_html__( 'Account', 'motta' ),
				'panel'    => 'header',
			),
			'header_wishlist'    => array(
				'title'    => esc_html__( 'Wishlist', 'motta' ),
				'panel'    => 'header',
			),
			'header_compare'    => array(
				'title'    => esc_html__( 'Compare', 'motta' ),
				'panel'    => 'header',
			),
			'header_cart'    => array(
				'title'    => esc_html__( 'Cart', 'motta' ),
				'panel'    => 'header',
			),
			'header_hamburger'       => array(
				'title'    => esc_html__( 'Hamburger', 'motta' ),
				'panel'    => 'header',
			),
			'header_primary_menu'    => array(
				'title'    => esc_html__( 'Primary Menu', 'motta' ),
				'panel'    => 'header',
			),
			'header_secondary_menu'    => array(
				'title'    => esc_html__( 'Secondary Menu', 'motta' ),
				'panel'    => 'header',
			),
			'header_category_menu'    => array(
				'title'    => esc_html__( 'Category Menu', 'motta' ),
				'panel'    => 'header',
			),
			'header_preferences'    => array(
				'title'    => esc_html__( 'Preferences', 'motta' ),
				'panel'    => 'header',
			),
			'header_view_history'    => array(
				'title'    => esc_html__( 'View History', 'motta' ),
				'panel'    => 'header',
			),
			'header_custom_text'    => array(
				'title'    => esc_html__( 'Custom Text', 'motta' ),
				'panel'    => 'header',
			),
			'header_empty_space'    => array(
				'title'    => esc_html__( 'Empty Space', 'motta' ),
				'panel'    => 'header',
			),
			'header_return_button'    => array(
				'title'    => esc_html__( 'Return Button', 'motta' ),
				'panel'    => 'header',
			),

			// Footer
			'footer_layout'        => array(
				'title'    => esc_html__( 'Footer', 'motta' ),
				'capability'  => 'edit_theme_options',
				'priority' => 45,
			),

			// Blog
			'blog_prebuilt_header'      => array(
				'title'    => esc_html__( 'Prebuilt Header', 'motta' ),
				'panel'    => 'blog',
			),
			'blog_prebuilt_footer'      => array(
				'title'    => esc_html__( 'Prebuilt Footer', 'motta' ),
				'panel'    => 'blog',
			),
			'blog_header'      => array(
				'title'    => esc_html__( 'Blog Header', 'motta' ),
				'panel'    => 'blog',
			),
			'blog_archive'      => array(
				'title'    => esc_html__( 'Blog Archive', 'motta' ),
				'panel'    => 'blog',
			),
			'blog_single'       => array(
				'title'    => esc_html__( 'Blog Single', 'motta' ),
				'panel'    => 'blog',
			),

			// Page
			'page_prebuilt_header'       => array(
				'title'       => esc_html__('Prebuilt Header', 'motta'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page',
			),
			'page_prebuilt_footer'       => array(
				'title'       => esc_html__('Prebuilt Footer', 'motta'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page',
			),
			// Page
			'page_header'       => array(
				'title'       => esc_html__('Page Header', 'motta'),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'page',
			),

			'page_404'      => array(
				'title'    => esc_html__( '404 Page', 'motta' ),
				'panel'    => 'page',
			),

			// Help Center Header
			'help_center_header'      => array(
				'title'    => esc_html__( 'Header Layout', 'motta' ),
				'panel'    => 'help_center',
			),
			// Help Center Footer
			'help_center_footer'      => array(
				'title'    => esc_html__( 'Footer Layout', 'motta' ),
				'panel'    => 'help_center',
			),
			'help_center_search'      => array(
				'title'    => esc_html__( 'Search Bar', 'motta' ),
				'panel'    => 'help_center',
			),
			// Help Center Archive
			'help_center_archive'      => array(
				'title'    => esc_html__( 'Archive Page', 'motta' ),
				'panel'    => 'help_center',
			),

			'help_center_single'      => array(
				'title'    => esc_html__( 'Single Page', 'motta' ),
				'panel'    => 'help_center',
			),

			// Mobile
			'topbar_mobile'        => array(
				'title'    => esc_html__( 'Topbar', 'motta' ),
				'panel'    => 'mobile',
			),
			'campaign_bar_mobile'        => array(
				'title'    => esc_html__( 'Campaign Bar', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_layout'        => array(
				'title'    => esc_html__( 'Header Layout', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_main'       => array(
				'title'    => esc_html__( 'Header Main', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_bottom'       => array(
				'title'    => esc_html__( 'Header Bottom', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_sticky'       => array(
				'title'    => esc_html__( 'Header Sticky', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_logo'       => array(
				'title'    => esc_html__( 'Header Logo', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_hamburger'       => array(
				'title'    => esc_html__( 'Header Hamburger', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_search'       => array(
				'title'    => esc_html__( 'Header Search', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_account'       => array(
				'title'    => esc_html__( 'Header Account', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_wishlist'       => array(
				'title'    => esc_html__( 'Header Wishlist', 'motta' ),
				'panel'    => 'mobile',
			),
			'header_mobile_cart'       => array(
				'title'    => esc_html__( 'Header Cart', 'motta' ),
				'panel'    => 'mobile',
			),
			'footer_mobile'        => array(
				'title'    => esc_html__( 'Footer', 'motta' ),
				'panel'    => 'mobile',
			),
			'mobile_product_card'        => array(
				'title'    => esc_html__( 'Product Card', 'motta' ),
				'panel'    => 'mobile',
			),
			'mobile_product_catalog'        => array(
				'title'    => esc_html__( 'Product Catalog', 'motta' ),
				'panel'    => 'mobile',
			),
			'mobile_single_product'        => array(
				'title'    => esc_html__( 'Single Product', 'motta' ),
				'panel'    => 'mobile',
			),
			'mobile_navigation_bar'        => array(
				'title'    => esc_html__( 'Navigation Bar', 'motta' ),
				'panel'    => 'mobile',
			),

			// RTL
			'rtl'        => array(
				'title'    => esc_html__( 'RTL', 'motta' ),
				'panel'    => 'general',
			),
		);

		$settings   = array();

		$settings['page_prebuilt_header'] = array(
			'page_header_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Header', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt header for pages', 'motta' ),
				'default'         => 'v12',
				'choices'         => array(
					''  => esc_html__( 'Default', 'motta' ),
					'v1'  => esc_html__( 'Header V1', 'motta' ),
					'v2'  => esc_html__( 'Header V2', 'motta' ),
					'v3'  => esc_html__( 'Header V3', 'motta' ),
					'v4'  => esc_html__( 'Header V4', 'motta' ),
					'v5'  => esc_html__( 'Header V5', 'motta' ),
					'v6'  => esc_html__( 'Header V6', 'motta' ),
					'v7'  => esc_html__( 'Header V7', 'motta' ),
					'v8'  => esc_html__( 'Header V8', 'motta' ),
					'v9'  => esc_html__( 'Header V9', 'motta' ),
					'v10' => esc_html__( 'Header V10', 'motta' ),
					'v11' => esc_html__( 'Header V11', 'motta' ),
					'v12' => esc_html__( 'Header V12', 'motta' ),
				),
				'priority'    => 20,
			),
			'page_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority'    => 25,
			),
			'header_page_hide_topbar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Topbar', 'motta' ),
				'default'     => true,
				'priority'    => 30,
			),
			'header_page_hide_campaign_bar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Campaign Bar', 'motta' ),
				'default'     => true,
				'priority'    => 35,
			),
			'header_page_transparent'     => array(
				'type'        => 'toggle',
				'default'     => false,
				'label'       => esc_html__('Header Transparent', 'motta'),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_version',
						'operator' => '==',
						'value'    => 'v12',
					),
				),
				'priority'    => 35,
			),
			'header_page_text_color'              => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Text Color', 'motta' ),
				'default'         => 'dark',
				'choices'         => array(
					'light' => esc_html__( 'Light', 'motta' ),
					'dark'  => esc_html__( 'Dark', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'page_header_version',
						'operator' => '==',
						'value'    => 'v12',
					),
					array(
						'setting'  => 'header_page_transparent',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority'    => 35,
			),
			'header_page_logo_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'priority'    => 40,
			),
			'header_page_logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__( 'Default', 'motta' ),
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
				'priority'    => 45,
			),
			'header_page_logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
				'priority'    => 50,
			),
			'header_page_logo_svg'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
				'priority'    => 55,
			),
			'header_page_logo_svg_light'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG Light', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
					array(
						'setting'  => 'header_page_transparent',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'header_page_text_color',
						'operator' => '==',
						'value'    => 'light',
					),
				),
				'priority'    => 55,
			),
			'header_page_logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Image', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
				'priority'    => 60,
			),
			'header_page_logo_light'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Image Light', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
					array(
						'setting'  => 'header_page_transparent',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'header_page_text_color',
						'operator' => '==',
						'value'    => 'light',
					),
				),
				'priority'    => 60,
			),
			'header_page_logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
				'priority'    => 65,
			),
		);

		$settings['page_prebuilt_footer'] = array(
			'page_footer_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Footer', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer present for pages', 'motta' ),
				'default'         => '',
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
			'page_mobile_footer_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Mobile Footer', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer present for pages', 'motta' ),
				'default'         => '',
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),

		);

		$settings['page_404'] = array(
			'page_404_layout' => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Layout', 'motta' ),
				'default'     => 'v1',
				'choices'     => array(
					'v1' => esc_html__( 'Layout 1', 'motta' ),
					'v2'   => esc_html__( 'Layout 2', 'motta' ),
				),
			),
			'header_page_hr'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
			),
			'header_page_404_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Header Page', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt header for 404 page', 'motta' ),
				'default'         => 'v12',
				'choices'         => array(
					''  => esc_html__( 'Default', 'motta' ),
					'v1'  => esc_html__( 'Header V1', 'motta' ),
					'v2'  => esc_html__( 'Header V2', 'motta' ),
					'v3'  => esc_html__( 'Header V3', 'motta' ),
					'v4'  => esc_html__( 'Header V4', 'motta' ),
					'v5'  => esc_html__( 'Header V5', 'motta' ),
					'v6'  => esc_html__( 'Header V6', 'motta' ),
					'v7'  => esc_html__( 'Header V7', 'motta' ),
					'v8'  => esc_html__( 'Header V8', 'motta' ),
					'v9'  => esc_html__( 'Header V9', 'motta' ),
					'v10' => esc_html__( 'Header V10', 'motta' ),
					'v11' => esc_html__( 'Header V11', 'motta' ),
					'v12' => esc_html__( 'Header V12', 'motta' ),
				),
			),
			'page_404_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
			),
			'header_page_404_hide_topbar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Topbar', 'motta' ),
				'default'     => false,
			),
			'header_page_404_hide_campaign_bar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Campaign Bar', 'motta' ),
				'default'     => false,
			),
			'header_page_404_logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__( 'Default', 'motta' ),
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
			),
			'header_page_404_logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_404_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'header_page_404_logo_svg'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_404_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'header_page_404_logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Image', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_page_404_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'header_page_404_logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_page_404_logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
			),
			'page_404_hr' => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
			),
			'footer_page_404_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Footer', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer present for 404 page', 'motta' ),
				'default'         => '',
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
		);

		$settings['page_header'] = array(
			'page_header'             => array(
				'type'        => 'toggle',
				'default'     => true,
				'label'       => esc_html__('Enable Page Header', 'motta'),
				'description' => esc_html__('Enable to show a page header for the page below the site header', 'motta'),
				'priority'    => 10,
			),

			'page_header_custom_field_1' => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'page_header_els' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Page Header Elements', 'motta'),
				'default'  => array('title'),
				'priority' => 10,
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'motta'),
					'title'      => esc_html__('Title', 'motta'),
				),
				'description'     => esc_html__('Select which elements you want to show.', 'motta'),
				'active_callback' => array(
					array(
						'setting'  => 'page_header',
						'operator' => '==',
						'value'    => true,
					),
				),

			),

		);

		$settings['maintenance'] = array(
			// Maintenance
			'maintenance_enable'             => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Enable Maintenance Mode', 'motta'),
				'description' => esc_html__('Put your site into maintenance mode', 'motta'),
				'default'     => false,
			),
			'maintenance_mode'               => array(
				'type'        => 'radio',
				'label'       => esc_html__('Mode', 'motta'),
				'description' => esc_html__('Select the correct mode for your site', 'motta'),
				'tooltip'     => wp_kses_post(sprintf(__('If you are putting your site into maintenance mode for a longer perior of time, you should set this to "Coming Soon". Maintenance will return HTTP 503, Comming Soon will set HTTP to 200. <a href="%s" target="_blank">Learn more</a>', 'motta'), 'https://yoast.com/http-503-site-maintenance-seo/')),
				'default'     => 'maintenance',
				'choices'     => array(
					'maintenance' => esc_html__('Maintenance', 'motta'),
					'coming_soon' => esc_html__('Coming Soon', 'motta'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'maintenance_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'maintenance_page'               => array(
				'type'            => 'dropdown-pages',
				'label'           => esc_html__('Maintenance Page', 'motta'),
				'default'         => 0,
				'active_callback' => array(
					array(
						'setting'  => 'maintenance_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		$settings['styling'] = array(
			'shape_style'       => array(
				'type'            => 'radio-buttonset',
				'label'           => esc_html__( 'Shape', 'motta' ),
				'default'         => 'default',
				'choices'         => array(
					'default' 	=> esc_html__( 'Default', 'motta' ),
					'sharp' 	=> esc_html__( 'Sharp', 'motta' ),
					'round'  	=> esc_html__( 'Round', 'motta' ),
					'circle'  	=> esc_html__( 'Circle', 'motta' ),
				),
			),
			'primary_color_custom_hr'  => array(
				'type'            => 'custom',
				'default'         => '<hr />',
			),
			'primary_color_title'  => array(
				'type'  => 'custom',
				'label' => esc_html__( 'Primary Color', 'motta' ),
			),
			'primary_color'        => array(
				'type'            => 'color-palette',
				'default'         => '#3449ca',
				'choices'         => array(
					'colors' => array(
						'#3449ca',
						'#6e2eff',
						'#ff9e20',
						'#06b18f',
						'#ff5951',
						'#ffee61',
						'#d8125d',
						'#03c631',
						'#11248f',
					),
					'style'  => 'round',
				),
				'active_callback' => array(
					array(
						'setting'  => 'primary_color_custom',
						'operator' => '!=',
						'value'    => true,
					),
				),
			),
			'primary_color_custom' => array(
				'type'      => 'checkbox',
				'label'     => esc_html__( 'Pick my favorite color', 'motta' ),
				'default'   => false,

			),
			'primary_color_custom_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Custom Color', 'motta' ),
				'default'         => '#3449ca',
				'active_callback' => array(
					array(
						'setting'  => 'primary_color_custom',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'primary_text_color'             => array(
				'type'        => 'select',
				'default'     => false,
				'label'       => esc_html__('Text on Primary Color', 'motta'),
				'default'         => 'light',
				'choices'         => array(
					'light' 	=> esc_html__( 'Light', 'motta' ),
					'dark' 	    => esc_html__( 'Dark', 'motta' ),
					'custom'  	=> esc_html__( 'Custom', 'motta' ),
				),
			),
			'primary_text_color_custom'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Custom Color', 'motta' ),
				'default'         => '#fff',
				'active_callback' => array(
					array(
						'setting'  => 'primary_text_color',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
		);

		// API Keys.
		$settings['api_keys'] = array(
			'api_instagram_token' => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Instagram Access Token', 'motta' ),
				'description' => esc_html__( 'This Access Token is required to display your Instagram photos on this website.', 'motta' ) . ' <a href="https://tools.uix.store/instagram-access-token/" target="_blank">' . esc_html__( 'Get my Access Token', 'motta' ) . '</a>',
			),
		);

		// Back To Top.
		$settings['backtotop'] = array(
			'backtotop'    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Back To Top', 'motta' ),
				'description' => esc_html__( 'Check this to show back to top.', 'motta' ),
				'default'     => true,
			),
		);

		// Back To Top.
		$settings['share_socials'] = array(
			'post_sharing_socials' => array(
				'type'            => 'sortable',
				'description'     => esc_html__( 'Select social media for sharing posts/products', 'motta' ),
				'default'         => array(
					'facebook',
					'twitter',
					'googleplus',
					'pinterest',
					'tumblr',
					'reddit',
					'telegram',
					'email',
				),
				'choices'         => array(
					'facebook'    => esc_html__( 'Facebook', 'motta' ),
					'twitter'     => esc_html__( 'Twitter', 'motta' ),
					'googleplus'  => esc_html__( 'Google Plus', 'motta' ),
					'pinterest'   => esc_html__( 'Pinterest', 'motta' ),
					'tumblr'      => esc_html__( 'Tumblr', 'motta' ),
					'reddit'      => esc_html__( 'Reddit', 'motta' ),
					'linkedin'    => esc_html__( 'Linkedin', 'motta' ),
					'stumbleupon' => esc_html__( 'StumbleUpon', 'motta' ),
					'digg'        => esc_html__( 'Digg', 'motta' ),
					'telegram'    => esc_html__( 'Telegram', 'motta' ),
					'whatsapp'    => esc_html__( 'WhatsApp', 'motta' ),
					'vk'          => esc_html__( 'VK', 'motta' ),
					'email'       => esc_html__( 'Email', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'post_sharing',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'post_sharing_whatsapp_number' => array(
				'type'        => 'text',
				'description' => esc_html__( 'WhatsApp Phone Number', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'post_sharing',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'post_sharing_socials',
						'operator' => 'contains',
						'value'    => 'whatsapp',
					),
				),
			),
		);

		// Typography - body.
		$settings['typo_main'] = array(
			'typo_body'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Body', 'motta' ),
				'description' => esc_html__( 'Customize the body font', 'motta' ),
				'default'     => array(
					'font-family' => 'Outfit',
					'variant'     => 'regular',
					'font-size'   => '18px',
					'line-height' => '1.5',
					'color'       => '#282c33',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'body',
					),
				),
			),
		);

		// Typography - headings.
		$settings['typo_headings'] = array(
			'typo_h1'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 1', 'motta' ),
				'description' => esc_html__( 'Customize the H1 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '500',
					'font-size'      => '72px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h1, .h1',
					),
				),
			),
			'typo_h2'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 2', 'motta' ),
				'description' => esc_html__( 'Customize the H2 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '54px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
				array(
						'element' => 'h2, .h2',
					),
				),
			),
			'typo_h3'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 3', 'motta' ),
				'description' => esc_html__( 'Customize the H3 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '36px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h3, .h3',
					),
				),
			),
			'typo_h4'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 4', 'motta' ),
				'description' => esc_html__( 'Customize the H4 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '28px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h4, .h4',
					),
				),
			),
			'typo_h5'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 5', 'motta' ),
				'description' => esc_html__( 'Customize the H5 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '18px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h5, .h5',
					),
				),
			),
			'typo_h6'                        => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Heading 6', 'motta' ),
				'description' => esc_html__( 'Customize the H6 font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '16px',
					'line-height'    => '1.25',
					'color'          => '#282c33',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'h6, .h6',
					),
				),
			),
		);

		// Typography - header primary menu.
		$settings['typo_header_logo'] = array(
			'logo_font'      => array(
				'type'            => 'typography',
				'label'           => esc_html__( 'Logo Font', 'motta' ),
				'default'         => array(
					'font-family'    => '',
					'variant'		 => '700',
					'font-size'      => '30px',
					'letter-spacing' => '0',
					'subsets'        => array( 'latin-ext' ),
					'text-transform' => 'uppercase',
				),
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
			),
		);

		// Typography - header primary menu.
		$settings['typo_header_menu_primary'] = array(
			'typo_menu'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Menu', 'motta' ),
				'description' => esc_html__( 'Customize the menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '500',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.primary-navigation .nav-menu > li > a, .header-v2 .primary-navigation .nav-menu > li > a, .header-v4 .primary-navigation .nav-menu > li > a, .header-v6 .primary-navigation .nav-menu > li > a, .header-v8 .primary-navigation .nav-menu > li > a, .header-v9 .primary-navigation .nav-menu > li > a, .header-v10 .primary-navigation .nav-menu > li > a',
					),
				),
			),
			'typo_submenu'                   => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Sub-Menu', 'motta' ),
				'description' => esc_html__( 'Customize the sub-menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.primary-navigation li li a, .primary-navigation li li span, .primary-navigation li li h6',
					),
				),
			),
		);

		// Typography - header secondary menu.
		$settings['typo_header_menu_secondary'] = array(
			'typo_secondary_menu'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Menu', 'motta' ),
				'description' => esc_html__( 'Customize the menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '500',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.secondary-navigation .nav-menu > li > a, .header-v2 .secondary-navigation .nav-menu > li > a, .header-v3 .secondary-navigation .nav-menu > li > a, .header-v5 .secondary-navigation .nav-menu > li > a, .header-v6 .secondary-navigation .nav-menu > li > a, .header-v8 .secondary-navigation .nav-menu > li > a, .header-v9 .secondary-navigation .nav-menu > li > a, .header-v10 .secondary-navigation .nav-menu > li > a',
					),
				),
			),
			'typo_sub_secondary_menu'                   => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Sub-Menu', 'motta' ),
				'description' => esc_html__( 'Customize the sub-menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.secondary-navigation li li a, .secondary-navigation li li span, .secondary-navigation li li h6',
					),
				),
			),
		);

		// Typography - header category menu.
		$settings['typo_header_menu_category'] = array(
			'typo_category_menu_title'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Title', 'motta' ),
				'description' => esc_html__( 'Customize the menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '500',
					'font-size'      => '16px',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.header-category__name, .header-category-menu > .motta-button--text .header-category__name',
					),
				),
			),
			'typo_category_menu'                      => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Menu', 'motta' ),
				'description' => esc_html__( 'Customize the menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '14px',
					'line-height'    => '2.5',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.header-category__menu > ul > li > a',
					),
				),
			),
			'typo_sub_category_menu'                   => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Sub-Menu', 'motta' ),
				'description' => esc_html__( 'Customize the sub-menu font', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => 'regular',
					'font-size'      => '16px',
					'line-height'    => '2',
					'text-transform' => 'none',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.header-category__menu ul ul li > *',
					),
				),
			),
		);

		// Typography - page.
		$settings['typo_page'] = array(
			'typo_page_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Page Title', 'motta' ),
				'description' => esc_html__( 'Customize the page title font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '700',
					'font-size'      => '54px',
					'line-height'    => '1.25',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.page-header .page-header__title',
					),
				),
			),
		);

		// Typography - posts.
		$settings['typo_posts'] = array(
			'typo_blog_header_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Header Title', 'motta' ),
				'description' => esc_html__( 'Customize the font of blog header', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '700',
					'font-size'      => '54px',
					'line-height'    => '1.25',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.motta-blog-page .page-header__title',
					),
				),
			),
			'typo_blog_header_description'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Header Description', 'motta' ),
				'description' => esc_html__( 'Customize the font of blog header', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => 'regular',
					'font-size'      => '18px',
					'line-height'    => '1.75',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.motta-blog-page .page-header__description',
					),
				),
			),
			'typo_blog_post_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Post Title', 'motta' ),
				'description' => esc_html__( 'Customize the font of blog post title', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '700',
					'font-size'      => '18px',
					'line-height'    => '1.5',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.hfeed .hentry .entry-title',
					),
				),
			),
			'typo_blog_post_excerpt'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Blog Post Excerpt', 'motta' ),
				'description' => esc_html__( 'Customize the font of blog post excerpt', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => 'regular',
					'font-size'      => '14px',
					'line-height'    => '1.5',
					'text-transform' => 'none',
					'color'          => '#7c818b',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.hfeed .hentry .entry-excerpt',
					),
				),
			),
		);

		// Typography - widgets.
		$settings['typo_widget'] = array(
			'typo_widget_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Widget Title', 'motta' ),
				'description' => esc_html__( 'Customize the widget title font', 'motta' ),
				'default'     => array(
					'font-family'    => 'Outfit',
					'variant'        => '700',
					'font-size'      => '18px',
					'line-height'    => '1.25',
					'text-transform' => 'uppercase',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.blog-sidebar .widget .widget-title, .blog-sidebar .widget .widgettitle, .blog-sidebar .widget .wp-block-search__label, .single-sidebar .widget .widget-title, .single-sidebar .widget .widgettitle, .single-sidebar .widget .wp-block-search__label',
					),
				),
			),
		);

		// Topbar.
		$settings['header_top'] = array(
			'topbar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Topbar', 'motta' ),
				'description' => esc_html__( 'Display a bar on the top', 'motta' ),
				'default'     => false,
				'priority' => 5,
			),
			'topbar_custom_hr_1'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 10,
			),
			'topbar_left'       => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of the topbar', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->topbar_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 15,
			),
			'topbar_center'       => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the center side of the topbar', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->topbar_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 20,
			),
			'topbar_right'      => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right side of the topbar', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->topbar_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 25,
			),
			'topbar_custom_hr_2'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 30,
			),
			'topbar_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 35,
			),
			'topbar_secondary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Secondary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 40,
			),
			'topbar_custom_heading_4'    => array(
				'type'    => 'custom',
				'default' => '<hr/><h2>'. esc_html__( 'Topbar Background', 'motta' ) .'</h2>',
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 45,
			),
			'topbar_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.topbar',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 60,
			),
			'topbar_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.topbar-navigation .nav-menu > li > a',
						'property' => 'color',
					),
					array(
						'element'  => '.motta-location',
						'property' => 'color',
					),
					array(
						'element'  => '.topbar .header-preferences',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 65,
			),
			'topbar_hover_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Hover Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.topbar-navigation .nav-menu > li > a:hover',
						'property' => 'color',
					),
					array(
						'element'  => '.motta-location a:hover',
						'property' => 'color',
					),
					array(
						'element'  => '.topbar .header-preferences a:hover',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 65,
			),
		);

		// Header layout settings.
		$settings['header_layout'] = array(
			'header_present' => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Present', 'motta' ),
				'description' => esc_html__( 'Select a prebuilt header or build your own', 'motta' ),
				'default'     => 'prebuild',
				'choices'     => array(
					'prebuild' => esc_html__( 'Use pre-build header', 'motta' ),
					'custom'   => esc_html__( 'Build my own', 'motta' ),
				),
			),
			'header_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Header', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt header present', 'motta' ),
				'default'         => 'v1',
				'choices'         => array(
					'v1'  => esc_html__( 'Header V1', 'motta' ),
					'v2'  => esc_html__( 'Header V2', 'motta' ),
					'v3'  => esc_html__( 'Header V3', 'motta' ),
					'v4'  => esc_html__( 'Header V4', 'motta' ),
					'v5'  => esc_html__( 'Header V5', 'motta' ),
					'v6'  => esc_html__( 'Header V6', 'motta' ),
					'v7'  => esc_html__( 'Header V7', 'motta' ),
					'v8'  => esc_html__( 'Header V8', 'motta' ),
					'v9'  => esc_html__( 'Header V9', 'motta' ),
					'v10' => esc_html__( 'Header V10', 'motta' ),
					'v11' => esc_html__( 'Header V11', 'motta' ),
					'v12' => esc_html__( 'Header V12', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
				),
			),
			'header_present_search'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Search', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_present_account'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Account', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9','v10'),
					),
				),
			),
			'header_present_compare'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Compare', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v6', 'v8'),
					),
				),
			),
			'header_present_wishlist'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Wishlist', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v10'),
					),
				),
			),
			'header_present_cart'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Cart', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_present_hamburger'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Hamburger', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v3', 'v5', 'v8'),
					),
				),
			),
			'header_present_category_menu'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Category Menu', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v6', 'v7', 'v9', 'v10'),
					),
				),
			),
			'header_present_primary_menu'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Primary Menu', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v4', 'v6', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_present_secondary_menu'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Secondary Menu', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v2', 'v3', 'v5', 'v6', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_present_custom_text'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Custom Text', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v1'),
					),
				),
			),
			'header_present_preferences'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Preferences', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v2', 'v7' , 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_present_view_history'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header View History', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_version',
						'operator' => 'in',
						'value'    => array('v8', 'v9', 'v10'),
					),
				),
			),
			'header_container' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Header Container', 'motta' ),
				'default'         => 'container',
				'choices'         => array(
					'container'  			=> esc_html__( 'Default', 'motta' ),
					'motta-container'  		=> esc_html__( 'Large', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),

		);

		// Header main settings.
		$settings['header_main'] = array(
			'header_main_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_main_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_main_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_main_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_main_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_main_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '100',
				'choices'   => array(
					'min' => 50,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header__desktop .header-main',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);

		// Header bottom settings.
		$settings['header_bottom'] = array(
			'header_bottom_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_bottom_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_bottom_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_bottom_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_bottom_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_bottom_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_bottom_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_bottom_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '60',
				'choices'   => array(
					'min' => 30,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header__desktop .header-bottom',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);

		// Header bottom settings.
		$settings['header_sticky'] = array(
			'header_sticky'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sticky Header', 'motta' ),
				'default'         => 'none',
				'choices'         => array(
					'none'   => esc_html__( 'No sticky', 'motta' ),
					'normal' => esc_html__( 'Normal sticky', 'motta' ),
					'custom' => esc_html__( 'Custom sticky', 'motta' ),
				),
			),
			'header_sticky_on'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sticky On', 'motta' ),
				'default'         => 'down',
				'choices'         => array(
					'down'   => esc_html__( 'Scroll Down', 'motta' ),
					'up'   => esc_html__( 'Scroll Up', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
			),
			'header_sticky_el'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sticky Header Section', 'motta' ),
				'default'         => 'header_main',
				'choices'         => array(
					'header_main'   => esc_html__('Header Main', 'motta'),
					'header_bottom' => esc_html__('Header Bottom', 'motta'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 'normal',
					),
				),
			),
			'header_sticky_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_sticky_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_sticky_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_sticky_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_sticky_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_sticky_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Main::instance(), 'render' ),
					),
				),
			),
			'header_sticky_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_sticky_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '80',
				'choices'   => array(
					'min' => 30,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-sticky',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);

		// Header Background
		$settings['header_background'] = array(
			'header_enable_background_color' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Custom Background Color', 'motta' ),
				'default'     => false,
			),
			'header_background_color'        => array(
				'type'            => 'color-palette',
				'default'         => '',
				'choices'         => array(
					'colors' => array(
						'#ffffff',
						'#1b1a41',
						'#0b5052',
						'#3e0f9e',
						'#11248f',
						'#08091b',
					),
					'style'  => 'round',
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_enable_background_color',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'header_pick_background_color',
						'operator' => '==',
						'value'    => false,
					),
				),
			),
			'header_pick_background_color' => array(
				'type'      => 'checkbox',
				'label'     => esc_html__( 'Pick my favorite color', 'motta' ),
				'default'   => false,
				'active_callback' => array(
					array(
						'setting'  => 'header_enable_background_color',
						'operator' => '==',
						'value'    => true,
					),
				),

			),
			'header_custom_background_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Color', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_pick_background_color',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_custom_background_text_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Text Color', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_pick_background_color',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_custom_background_border_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Border Color', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_pick_background_color',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

		);

		// Campaign bar.
		$settings['header_campaign'] = array(
			'campaign_bar' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Campaign Bar', 'motta' ),
				'description' => esc_html__( 'Display a bar before, after the site header.', 'motta' ),
				'default'     => false,
				'priority' => 0,
			),
			'campaign_items'       => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Campaign Items', 'motta' ),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Campaign', 'motta' ),
					'field' => 'text',
				),
				'fields'          => array(
					'icon' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Icon', 'motta' ),
					),
					'text' => array(
						'type'    => 'textarea',
						'label'   => esc_html__( 'Text', 'motta' ),
					),
					'button' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Button Text', 'motta' ),
					),
					'link' => array(
						'type'    => 'text',
						'label'   => esc_html__( 'Button URL', 'motta' ),
					),
				),
				'sanitize_callback' => '\Motta\Options::repeater_sanitize_icon',
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 5,
			),
			'campaign_bar_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'priority' => 10,
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),

			'campaign_bar_position'                     => array(
				'type'    => 'select',
				'label'   => esc_html__('Position', 'motta'),
				'default' => 'before',
				'choices' => array(
					'before' => esc_html__('Before Header', 'motta'),
					'after'  => esc_html__('After Header', 'motta'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 10,
			),
			'campaign_image' => array(
				'type'    => 'image',
				'label'   => esc_html__( 'Background Image', 'motta' ),
				'default' => '',
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar',
						'property' => 'background-image',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 15,
			),
			'campaign_bgcolor' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 20,
			),
			'campaign_textcolor'        => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Text Color', 'motta' ),
				'default'         => 'dark',
				'choices'         => array(
					'dark'   => esc_html__( 'Dark', 'motta' ),
					'light'  => esc_html__( 'Light', 'motta' ),
					'custom' => esc_html__( 'Custom', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 25,
			),
			'campaign_textcolor_custom' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar__item',
						'property' => '--mt-color__primary',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'campaign_textcolor',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 30,
			),
			'campaign_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height(px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '44',
				'choices'   => array(
					'min' => 30,
					'max' => 100,
				),
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar .campaign-bar__container',
						'property' => 'min-height',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 35,
			),
			'campaign_text_size'      => array(
				'type'            => 'slider',
				'label'           => esc_html__( 'Text Size', 'motta' ),
				'transport' => 'postMessage',
				'default'         => '14',
				'choices'   => array(
					'min' => 0,
					'max' => 100,
				),
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar .campaign-bar__item',
						'property' => 'font-size',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 40,
			),
			'campaign_text_weight'        => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Text Weight', 'motta' ),
				'default'         => '700',
				'choices'         => array(
					'400' => esc_html__( 'Normal', 'motta' ),
					'500' => esc_html__( 'Medium', 'motta' ),
					'700' => esc_html__( 'Bold', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 45,
			),
			'campaign_button_spacing' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Button Spacing', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '31',
				'choices'   => array(
					'min' => 0,
					'max' => 250,
				),
				'js_vars'   => array(
					array(
						'element'  => '.campaign-bar .campaign-bar__button',
						'property' => 'margin-left',
						'units'    => 'px',
					),
					array(
						'element'  => '.rtl .campaign-bar .campaign-bar__button',
						'property' => 'margin-right',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 50,
			),
			'campaign_bar_hr_2'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'campaign_bar',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 55,
			),

		);

		// Logo.
		$settings['logo'] = array(
			'logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'image',
				'choices' => array(
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
			),
			'logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'logo_svg'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => 'auto',
					'height' => 'auto',
				),
				'active_callback' => array(
					array(
						'setting'  => 'logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
			),
		);

		// Header search.
		$settings['header_search'] = array(
			'header_search_bar'                        => array(
				'type'    => 'select',
				'label'   => esc_html__('Search Bar', 'motta'),
				'default' => 'default',
				'section' => 'header_search',
				'choices' => array(
					'default'        => esc_html__('Default of the theme', 'motta'),
					'shortcode' => esc_html__('Using a shortcode', 'motta'),
				),
				'priority' => 10
			),
			'header_search_shortcode'       => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Shortcode', 'motta' ),
				'description'     => esc_html__( 'Add search form using shortcode such as [fibosearch]', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'shortcode',
					),
				),
				'priority' => 15
			),
			'header_search_type'        => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Search For', 'motta' ),
				'default'         => '',
				'choices'         => array(
					''         => esc_html__( 'Search for everything', 'motta' ),
					'product'  => esc_html__( 'Search for products', 'motta' ),
					'post'     => esc_html__( 'Search for posts', 'motta' ),
					'adaptive' => esc_html__( 'Search for adaptive', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 20
			),
			'search_columns'                   => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Search Columns', 'motta' ),
				'default'     => array( 'post_title', 'post_excerpt', 'post_content' ),
				'priority'    => 90,
				'choices'     => array(
					'post_title'  => esc_html__( 'Title', 'motta' ),
					'post_excerpt' => esc_html__( 'Excerpt', 'motta' ),
					'post_content'   => esc_html__( 'Content', 'motta' ),
				),
				'description' => esc_html__( 'Select which columns you want to search.', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 22
			),
			'header_search_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 25
			),
			'header_search_style'        => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Search Style', 'motta' ),
				'default'         => 'form',
				'choices'         => array(
					'form' => esc_html__( 'Form', 'motta' ),
					'icon' => esc_html__( 'Icon Only', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 30
			),
			'header_search_form_width' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Search Form Width(px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '655',
				'choices'   => array(
					'min' => 100,
					'max' => 1400,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-contents .header-search--form',
						'property' => 'max-width',
						'units'    => 'px',
					),
				),
				'partial_refresh' => array(
					'header_search_form_width' => array(
						'selector'        => '.header-search',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'items' ),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
				),
				'priority' => 35
			),
			'header_search_hr_1'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 40
			),
			'header_search_items'       => array(
				'type'    => 'sortable',
				'label'   => esc_html__( 'Search Items', 'motta' ),
				'default' => array(
					'search-field',
					'divider',
					'categories',
				),
				'choices' => array(
					'icon'       => esc_html__( 'Icon', 'motta' ),
					'search-field' => esc_html__( 'Search Field', 'motta' ),
					'divider'    => '|',
					'categories' => esc_html__( 'Categories', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 45
			),
			'header_search_items_button_display' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Button Display', 'motta' ),
				'default'     => 'icon',
				'choices'     => array(
					'none' => esc_html__( 'None', 'motta' ),
					'icon' => esc_html__( 'Icon', 'motta' ),
					'text' => esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 50
			),
			'header_search_items_button_position' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Button Position', 'motta' ),
				'default'     => 'outside',
				'choices'     => array(
					'outside' => esc_html__( 'Outside', 'motta' ),
					'inside'  => esc_html__( 'Inside', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_items_button_display',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 55
			),
			'header_search_items_button_spacing' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Button Spacing', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_items_button_display',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'setting'  => 'header_search_items_button_position',
						'operator' => '==',
						'value'    => 'outside',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 60
			),
			'header_search_hr_2'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => function() {
					return $this->display_header_categories();
				},
				'priority' => 65
			),
			'header_search_product_cats'     => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Product Categories', 'motta' ),
				'description'     => esc_html__( 'Enter category names, separate by commas. Leave empty to get all categories. Enter a number to get limit number of top categories.', 'motta' ),
				'default'         => '',
				'active_callback' => function() {
					return $this->display_header_categories( array( 'product', 'adaptive' ) );
				},
				'priority' => 70
			),
			'header_search_post_cats'        => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Post Categories', 'motta' ),
				'description'     => esc_html__( 'Enter category names, separate by commas. Leave empty to get all categories. Enter a number to get limit number of top categories.', 'motta' ),
				'default'         => '',
				'active_callback' => function() {
					return $this->display_header_categories( array( 'post' ) );
				},
				'priority' => 75
			),
			'header_search_cats_top'     => array(
				'type'            => 'checkbox',
				'label'           => esc_html__( 'Show Top Categories', 'motta' ),
				'description'     => esc_html__( 'Display first level categories only. This option does not work if you enter category names above.', 'motta' ),
				'default'         => false,
				'active_callback' => function() {
					return $this->display_header_categories();
				},
				'priority' => 80
			),
			'header_search_cats_empty'     => array(
				'type'            => 'checkbox',
				'label'           => esc_html__( 'Show empty categories', 'motta' ),
				'description'     => esc_html__( 'Show all categories including empty categories.', 'motta' ),
				'default'         => false,
				'active_callback' => function() {
					return $this->display_header_categories();
				},
				'priority' => 85
			),
			'header_search_skins' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Search Skin', 'motta' ),
				'default'         => 'base',
				'choices'         => array(
					'base' 		=> esc_html__( 'Base', 'motta' ),
					'raised'  	=> esc_html__( 'Raised', 'motta' ),
					'smooth'  	=> esc_html__( 'Smooth', 'motta' ),
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
				),
				'priority' => 90
			),
			'header_search_hr_3'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array (
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 95
			),
			'header_search_ajax'                        => array(
				'type'        => 'toggle',
				'label'       => esc_html__('AJAX Search', 'motta'),
				'section'     => 'header_search',
				'default'     => 0,
				'description' => esc_html__('Check this option to enable AJAX search in the header', 'motta'),
				'active_callback'   => array(
					array(
						'setting'  => 'header_search_type',
						'operator' => '!=',
						'value'    => '',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 100
			),
			'header_search_number'                      => array(
				'type'            => 'number',
				'label'           => esc_html__('AJAX Product Numbers', 'motta'),
				'default'         => 3,
				'section'         => 'header_search',
				'active_callback' => array(
					array(
						'setting'  => 'header_search_ajax',
						'operator' => '==',
						'value'    => '1',
					),
					array(
						'setting'  => 'header_search_type',
						'operator' => '!=',
						'value'    => '',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 105
			),
			'header_search_hr_4'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array (
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 110
			),
			'header_search_trending_searches' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Trending Searches', 'motta' ),
				'description'     => esc_html__( 'Display a list of links bellow the search field', 'motta' ),
				'default'         => false,
				'priority' => 115
			),
			'header_search_trending_searches_position' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Position', 'motta' ),
				'default'     => 'outside',
				'choices'     => array(
					'outside' => esc_html__( 'Outside', 'motta' ),
					'inside'  => esc_html__( 'Inside', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_trending_searches',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'header_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 120
			),
			'header_search_links'       => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Links', 'motta' ),
				'description'     => esc_html__( 'Add custom links of the trending searches', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Link', 'motta' ),
					'field' => 'text',
				),
				'fields'          => array(
					'text' => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'motta' ),
					),
					'url'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'URL', 'motta' ),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_search_trending_searches',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority' => 123
			),
			'header_search_hr_5'     => array(
				'type'    => 'custom',
				'default' => '<hr/><h3>'. esc_html__( 'Custom Color', 'motta' ) .'</h3>',
				'active_callback' => function() {
					return $this->display_header_search_custom_color();
				},
				'priority' => 125
			),
			'header_search_skins_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-search--form.motta-skin--smooth',
						'property' => '--mt-input__background-color',
					),
					array(
						'element'  => '.header-search--form .motta-button--smooth',
						'property' => '--mt-color__primary--gray',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_skins',
						'operator' => '==',
						'value'    => 'smooth',
					),
				),
				'priority' => 130
			),
			'header_search_skins_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-search__categories-label span',
						'property' => 'color',
					),
					array(
						'element'  => '.header-search--form .motta-type--input-text .header-search__field::placeholder',
						'property' => 'color',
					),
					array(
						'element'  => '.header-search__icon span',
						'property' => 'color',
					),
					array(
						'element'  => '.header-search--form .motta-button--smooth',
						'property' => '--mt-color__primary',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_skins',
						'operator' => '==',
						'value'    => 'smooth',
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 135
			),
			'header_search_skins_border_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Border Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-search--form .motta-type--input-text',
						'property' => 'border-color',
					),
					array(
						'element'  => '.header-search--form.header-search--outside .header-search__button',
						'property' => 'border-color',
					),
				),
				'active_callback' => array (
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_search_skins',
						'operator' => 'contains',
						'value'    => array( 'ghost', 'subtle', 'text' ),
					),
					array(
						'setting'  => 'header_search_bar',
						'operator' => '==',
						'value'    => 'default',
					),
				),
				'priority' => 140
			),
			'header_search_skins_button_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Button Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-search--form .header-search__button',
						'property' => '--mt-color__primary',
					),
					array(
						'element'  => '.header-search--form .header-search__button',
						'property' => '--mt-color__primary--dark',
					),
					array(
						'element'  => '.header-search--form .header-search__button',
						'property' => '--mt-color__primary--darker',
					),
					array(
						'element'  => '.header-search--form .header-search__button.motta-button--raised',
						'property' => '--mt-color__primary--box-shadow',
					),
				),
				'active_callback' => function() {
					return $this->display_header_search_button();
				},
				'priority' => 145
			),
			'header_search_skins_button_icon_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Button Icon Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-search--form .header-search__button',
						'property' => '--mt-color__primary--light',
					),
				),
				'active_callback' => function() {
					return $this->display_header_search_button();
				},
				'priority' => 150
			),
		);

		// Header account.
		$settings['header_account'] = array(
			'header_account_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Account Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'   => esc_html__( 'Icon Only', 'motta' ),
					'text'   => esc_html__( 'Text Only', 'motta' ),
					'icon-text'  => esc_html__( 'Icon & Text', 'motta' ),
					'icon-subtext'  => esc_html__( 'Icon & Subtext', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_account_icon_position'      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Account Icon Position', 'motta' ),
				'default'         => 'icon-left',
				'choices'         => array(
					'icon-left'   => esc_html__( 'Icon on the Left', 'motta' ),
					'icon-top'  => esc_html__( 'Icon on the Top', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_account_display',
						'operator' => '==',
						'value'    => 'icon-text',
					),
				),
			),
			'header_account_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_account_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Account Skin', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_account_hr_1'     => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_account_avatar_icon' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Avatar Icon', 'motta' ),
				'default'         => false,
				'description' => esc_html__('Replace the account icon or account text with the avatar icon', 'motta'),
			),
			'header_account_icon_behaviour' => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Account Icon Behaviour', 'motta' ),
				'default'         => 'panel',
				'choices'         => array(
					'panel'   => esc_html__( 'Open the account panel', 'motta' ),
					'dropdown'  => esc_html__( 'Open the account dropdown', 'motta' ),
				),
			),
			'header_account_hr_2'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_account_links' => array(
				'type'            => 'sortable',
				'label'     => esc_html__( 'Account Links', 'motta' ),
				'default'         => array(
					'my-account',
					'sign-in',
					'create-account',
					'sign-out'
				),
				'choices'         => $this->account_items_option(),
			),
			'header_account_custom_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Custom Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),

			),
			'header_signin_hr_2'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_signin_icon_behaviour' => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Sign in Icon Behaviour', 'motta' ),
				'default'         => '',
				'choices'         => array(
					''   => esc_html__( 'Default', 'motta' ),
					'page'  => esc_html__( 'Open the account page', 'motta' ),
				),
			),
		);

		// Header hamburger.
		$settings['header_hamburger'] = array(
			'header_hamburger_menu_items'       => array(
				'type'    => 'repeater',
				'label'   => esc_html__( 'Menu items', 'motta' ),
				'fields'   => [
					'item' => [
						'type'        => 'select',
						'label'       => esc_html__( 'Item', 'motta' ),
						'choices'     => $this->header_menu_panel_items(),
					],
				],
				'default'  => [
					[
						'item'   => 'track-order',
					],
					[
						'item'   => 'help-center',
					],
				],
				'row_label'    => [
					'type'  => 'field',
					'value' => '',
					'field' => 'item',
				],
				'priority' => 10,
			),
			'header_hamburger_custom_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Custom Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 15,

			),
			'header_hamburger_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 15,

			),
			'header_hamburger_category_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Category Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 15,

			),
			'header_hamburger_account_info'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Account Info', 'motta' ),
				'default'     => true,
				'priority' => 18,
			),
			'header_hamburger_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'priority' => 20,
			),
			'header_hamburger_space_left' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Left Spacing (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => 0,
				'choices'   => array(
					'min' => 0,
					'max' => 200,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-hamburger',
						'property' => 'margin-left',
						'units'    => 'px',
					),
				),
				'priority' => 30,
			),
			'header_hamburger_space_right' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Right Spacing (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => 0,
				'choices'   => array(
					'min' => 0,
					'max' => 200,
				),
				'priority' => 40,
				'js_vars'   => array(
					array(
						'element'  => '.header-hamburger',
						'property' => 'margin-right',
						'units'    => 'px',
					),
				),
			),
		);

		$settings['header_primary_menu'] = array(
			'header_primary_menu_caret' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Menu Caret Arrow', 'motta' ),
				'default'     => false,
			),
			'header_primary_menu_dividers' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Menu Dividers', 'motta' ),
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_primary_menu_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_primary_menu_font_size_parent_item'              => array(
				'type'        => 'slider',
				'label'       => esc_html__( 'Font Size Parent Item (px)', 'motta' ),
				'default'     => 14,
				'choices'   => array(
					'min' => 1,
					'max' => 100,
				),
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.site-header .primary-navigation .nav-menu > li > a',
						'property' => 'font-size',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_primary_menu_spacing_parent_item' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing Parent Item (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '12',
				'choices'   => array(
					'min' => 0,
					'max' => 200,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header .primary-navigation .nav-menu > li:not(:first-child) > a',
						'property' => 'padding-left',
						'units'    => 'px',
					),
					array(
						'element'  => '.site-header .primary-navigation .nav-menu > li:not(:last-child) > a',
						'property' => 'padding-right',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
		);

		$settings['header_secondary_menu'] = array(
			'header_secondary_menu_caret' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Menu Caret Arrow', 'motta' ),
				'default'     => false,
			),
			'header_secondary_menu_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_secondary_menu_font_size_parent_item'              => array(
				'type'        => 'slider',
				'label'       => esc_html__( 'Font Size Parent Item (px)', 'motta' ),
				'default'     => 14,
				'transport' => 'postMessage',
				'choices'   => array(
					'min' => 1,
					'max' => 100,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header .secondary-navigation .nav-menu > li > a',
						'property' => 'font-size',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_secondary_menu_spacing_parent_item' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing Parent Item (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '12',
				'choices'   => array(
					'min' => 0,
					'max' => 200,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header .secondary-navigation .nav-menu > li:not(:first-child) > a',
						'property' => 'padding-left',
						'units'    => 'px',
					),
					array(
						'element'  => '.site-header .secondary-navigation .nav-menu > li:not(:last-child) > a',
						'property' => 'padding-right',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
		);

		$settings['header_category_menu'] = array(
			'header_category_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Category Display', 'motta' ),
				'default'         => 'both',
				'choices'         => array(
					'text'   	  => esc_html__( 'Text', 'motta' ),
					'icon'  	  => esc_html__( 'Icon', 'motta' ),
					'both'  	  => esc_html__( 'Both', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_category_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Category Type', 'motta' ),
				'default'         => 'ghost',
				'choices'         => array(
					'ghost'   	  => esc_html__( 'Ghost', 'motta' ),
					'subtle'  	  => esc_html__( 'Subtle', 'motta' ),
					'text'  	  => esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_category_icon' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Category Icon', 'motta' ),
				'default'         => 'v1',
				'choices'         => array(
					'v1'   	  => esc_html__( 'Category v1', 'motta' ),
					'v2'  	  => esc_html__( 'Category v2', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_category_display',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
			),
			'header_category_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_category_space' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing Left (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => 0,
				'choices'   => array(
					'min' => 0,
					'max' => 200,
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-category-menu',
						'property' => 'margin-left',
						'units'    => 'px',
					),
				),
			),
			'header_category_hr_1'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_category_arrow_spacing' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing Arrow Active (%)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => 50,
				'choices'   => array(
					'min' => 0,
					'max' => 100,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-category-menu.header-category--both > .motta-button--subtle:after',
						'property' => 'left',
						'units'    => '%',
					),
					array(
						'element'  => '.header-category--text .motta-button--text:before',
						'property' => 'left',
						'units'    => '%',
					),
				),
			),
			'header_category_content_spacing' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'List Content Spacing (px)', 'motta' ),
				'transport' => 'postMessage',
				'default'   => 0,
				'choices'   => array(
					'min' => -800,
					'max' => 800,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-category-menu .header-category__content',
						'property' => 'left',
						'units'    => 'px',
					),
				),
			),
		);

		// Header preferences.
		$settings['header_preferences'] = array(
			'header_preferences_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Preferences Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'         => esc_html__( 'Icon Only', 'motta' ),
					'icon-text'    => esc_html__( 'Icon & Text', 'motta' ),
					'icon-subtext' => esc_html__( 'Icon & Subtext', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_preferences_flag' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Show Flag', 'motta' ),
				'default'     => false,
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_preferences_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_preferences_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Preferences Skin', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
		);

		// Header view history
		$settings['header_view_history'] = array(
			'header_view_history_link' => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Button Link', 'motta' ),
				'active_callback' => function() {
					return $this->display_header_view_history();
				},
			),
		);

		// Header wishlist
		$settings['header_wishlist'] = array(
			'header_wishlist_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Wishlist Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'   => esc_html__( 'Icon Only', 'motta' ),
					'icon-text'  => esc_html__( 'Icon & Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_wishlist_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Wishlist Skin', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_wishlist_icon_position'      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Wishlist Icon Position', 'motta' ),
				'default'         => 'icon-left',
				'choices'         => array(
					'icon-left'   => esc_html__( 'Icon on the Left', 'motta' ),
					'icon-top'  => esc_html__( 'Icon on the Top', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_wishlist_display',
						'operator' => '==',
						'value'    => 'icon-text',
					),
				),
			),
			'header_wishlist_counter'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Counter', 'motta'),
				'default'     => 0,
				'description' => esc_html__('Check this option to show the counter in the header.', 'motta'),
			),
			'header_wishlist_counter_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-wishlist__counter',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_wishlist_counter',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_wishlist_counter_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-wishlist__counter',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_wishlist_counter',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		// Header compare
		$settings['header_compare'] = array(
			'header_compare_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Compare Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'   => esc_html__( 'Icon Only', 'motta' ),
					'icon-text'  => esc_html__( 'Icon & Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_compare_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Compare Skin', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_compare_icon_position'      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Compare Icon Position', 'motta' ),
				'default'         => 'icon-left',
				'choices'         => array(
					'icon-left'   => esc_html__( 'Icon on the Left', 'motta' ),
					'icon-top'  => esc_html__( 'Icon on the Top', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_compare_display',
						'operator' => '==',
						'value'    => 'icon-text',
					),
				),
			),
			'header_compare_counter'                  => array(
				'type'        => 'toggle',
				'label'       => esc_html__('Counter', 'motta'),
				'default'     => 0,
				'description' => esc_html__('Check this option to show the counter in the header.', 'motta'),
			),
			'header_compare_counter_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-compare__counter',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_compare_counter',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'header_compare_counter_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-compare__counter',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_compare_counter',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		// Header cart
		$settings['header_cart'] = array(
			'header_cart_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'   => esc_html__( 'Icon Only', 'motta' ),
					'icon-text'  => esc_html__( 'Icon & Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_cart_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Skin', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'base' 		=> esc_html__( 'Base', 'motta' ),
					'ghost'  	=> esc_html__( 'Ghost', 'motta' ),
					'subtle'  	=> esc_html__( 'Subtle', 'motta' ),
					'text'  	=> esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_cart_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_cart_icon' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Icon', 'motta' ),
				'description'     => esc_html__( 'Select a Cart Icon', 'motta' ),
				'default'         => 'trolley',
				'choices'         => array(
					'trolley'   => esc_html__( 'Trolley', 'motta' ),
					'bag'  => esc_html__( 'Bag', 'motta' ),
					'custom'  => esc_html__( 'Custom', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_cart_icon_custom'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Cart SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your Cart here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_cart_icon',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_cart_icon_position'      => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Icon Position', 'motta' ),
				'default'         => 'icon-left',
				'choices'         => array(
					'icon-left'   => esc_html__( 'Icon on the Left', 'motta' ),
					'icon-top'  => esc_html__( 'Icon on the Top', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_cart_display',
						'operator' => '==',
						'value'    => 'icon-text',
					),
				),
			),
			'header_cart_hr_1'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'header_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
			),
			'header_cart_icon_behaviour' => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Cart Icon Behaviour', 'motta' ),
				'default'         => 'panel',
				'choices'         => array(
					'panel'   => esc_html__( 'Open the cart panel', 'motta' ),
					'dropdown'  => esc_html__( 'Open the cart dropdown', 'motta' ),
					'page'  => esc_html__( 'Open the cart page', 'motta' ),
				),
			),
			'header_cart_hr_2'     => array(
				'type'    => 'custom',
				'default' => '<hr/><h2>'. esc_html__( 'Custom Color', 'motta' ) .'</h2>',
			),
			'header_cart_hr_3'     => array(
				'type'    => 'custom',
				'default' => '<h3>'. esc_html__( 'Button', 'motta' ) .'</h3>',
				'active_callback' => function() {
					return $this->display_header_cart_custom_color();
				},
			),
			'header_cart_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-cart .motta-button--base',
						'property' => '--mt-color__primary',
					),
					array(
						'element'  => '.header-cart .motta-button--base',
						'property' => '--mt-color__primary--dark',
					),
					array(
						'element'  => '.header-cart .motta-button--base',
						'property' => '--mt-color__primary--darker',
					),
				),
				'active_callback' => function() {
					return $this->display_header_cart_custom_color();
				},
			),
			'header_cart_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-cart',
						'property' => 'color',
					),
				),
				'active_callback' => function() {
					return $this->display_header_cart_custom_color();
				},
			),
			'header_cart_hr_4'     => array(
				'type'    => 'custom',
				'default' => '<h3>'. esc_html__( 'Counter', 'motta' ) .'</h3>',
			),
			'header_cart_counter_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-cart__counter',
						'property' => 'background-color',
					),
					array(
						'element'  => '.header-cart .motta-button--base .header-cart__counter',
						'property' => 'background-color',
					),
				),
			),
			'header_cart_counter_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-cart__counter',
						'property' => 'color',
					),
					array(
						'element'  => '.header-cart .motta-button--base .header-cart__counter',
						'property' => 'color',
					),
				),
			),
		);

		// Header Custom Text
		$settings['header_custom_text'] = array(
			'header_custom_text'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Content', 'motta' ),
				'description'     => esc_html__( 'The content of the Header Custom Text', 'motta' ),
				'output'          => array(
					array(
						'element' => '.header-custom-text',
					),
				),
				'active_callback' => function() {
					return $this->display_header_custom_text();
				},
			),
			'header_custom_text_custom_1'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
				'active_callback' => function() {
					return $this->display_header_custom_text();
				},
			),
			'header_custom_text_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-custom-text',
						'property' => 'color',
					),
				),
				'active_callback' => function() {
					return $this->display_header_custom_text();
				},
			),
			'header_custom_text_font_size'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Font Size', 'motta' ),
				'default'     => 14,
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-custom-text',
						'property' => 'font-size',
						'units'    => 'px',
					),
				),
				'active_callback' => function() {
					return $this->display_header_custom_text();
				},
			),
			'header_custom_text_font_weight'       => array(
				'type'            => 'radio-buttonset',
				'label'           => esc_html__( 'Font Weight', 'motta' ),
				'default'         => '500',
				'choices'         => array(
					'400' => esc_html__( 'Regular', 'motta' ),
					'500' => esc_html__( 'Medium', 'motta' ),
					'700' => esc_html__( 'Bold', 'motta' ),
				),
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.header-custom-text',
						'property' => 'font-weight',
					),
				),
				'active_callback' => function() {
					return $this->display_header_custom_text();
				},
			),
		);

		// Header Empty Space
		$settings['header_empty_space'] = array(
			'header_empty_space' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '266',
				'choices'   => array(
					'min' => 0,
					'max' => 2000,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-empty-space',
						'property' => 'min-width',
						'units'    => 'px',
					),
				),
				'active_callback' => function() {
					return $this->display_header_empty_space();
				},
			),
		);

		// Header Empty Space
		$settings['header_return_button'] = array(
			'header_return_button_link' => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Return Link', 'motta' ),
				'default'         => '',
			),
		);

		$settings['topbar_mobile'] = array(
			'mobile_topbar' => array(
				'type'      => 'toggle',
				'label'     => esc_html__( 'Topbar', 'motta' ),
				'description' => esc_html__( 'Display topbar on mobile', 'motta' ),
				'default'   => false,
			),
			'mobile_topbar_section' => array(
				'type'      => 'select',
				'label'     => esc_html__( 'Topbar Items', 'motta' ),
				'default'   => 'left',
				'choices' => array(
					'left'   => esc_html__( 'Keep left items', 'motta' ),
					'center' => esc_html__( 'Keep center items', 'motta' ),
					'right'  => esc_html__( 'Keep right items', 'motta' ),
					'both'   => esc_html__( 'Keep both left and right items', 'motta' ),
					'all'    => esc_html__( 'Keep all items', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_topbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		$settings['campaign_bar_mobile'] = array(
			'campaign_mobile_text_size'      => array(
				'type'            => 'slider',
				'label'           => esc_html__( 'Text Size', 'motta' ),
				'default'         => '14',
				'choices'   => array(
					'min' => 0,
					'max' => 100,
				),
			),
		);

		// Header mobile.
		$settings['header_mobile_layout'] = array(
			'header_mobile_breakpoint'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Breakpoint (px)', 'motta' ),
				'description' => esc_html__( 'Set a breakpoint where the mobile header displays and the desktop header is hidden.', 'motta' ),
				'default'     => 1199,
				'choices'     => [
					'min'  => 991,
					'max'  => 1199,
					'step' => 1,
				],
			),
			'header_mobile_present_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_mobile_present' => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Present', 'motta' ),
				'description' => esc_html__( 'Select a prebuilt header or build your own', 'motta' ),
				'default'     => 'prebuild',
				'choices'     => array(
					'prebuild' => esc_html__( 'Use pre-build header', 'motta' ),
					'custom'   => esc_html__( 'Build my own', 'motta' ),
				),
			),
			'header_mobile_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Header', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt header present', 'motta' ),
				'default'         => 'v1',
				'choices'         => array(
					'v1'  => esc_html__( 'Header V1', 'motta' ),
					'v2'  => esc_html__( 'Header V2', 'motta' ),
					'v3'  => esc_html__( 'Header V3', 'motta' ),
					'v4'  => esc_html__( 'Header V4', 'motta' ),
					'v5'  => esc_html__( 'Header V5', 'motta' ),
					'v6'  => esc_html__( 'Header V6', 'motta' ),
					'v7'  => esc_html__( 'Header V7', 'motta' ),
					'v8'  => esc_html__( 'Header V8', 'motta' ),
					'v9'  => esc_html__( 'Header V9', 'motta' ),
					'v10' => esc_html__( 'Header V10', 'motta' ),
					'v11' => esc_html__( 'Header V11', 'motta' ),
					'v12' => esc_html__( 'Header V12', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
				),
			),
			'header_mobile_present_search'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Search', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_mobile_present_hamburger'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Hamburger', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_mobile_present_account'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Account', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v1'),
					),
				),
			),
			'header_mobile_present_wishlist'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Wishlist', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v3', 'v5', 'v10'),
					),
				),
			),
			'header_mobile_present_preferences'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Preferences', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v7', 'v8', 'v9'),
					),
				),
			),
			'header_mobile_present_primary_menu'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Primary Menu', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v8', 'v9', 'v10'),
					),
				),
			),
			'header_mobile_present_cart'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Header Cart', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'prebuild',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
			),
			'header_mobile_main_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_mobile_main_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Header Main Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '62',
				'choices'   => array(
					'min' => 30,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header__mobile .header-mobile-main',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
			'header_mobile_bottom_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_mobile_bottom_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Header Bottom Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '48',
				'choices'   => array(
					'min' => 30,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.site-header__mobile .header-mobile-bottom',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);
		// Header main settings.
		$settings['header_mobile_main'] = array(
			'header_mobile_main_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header mobile main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_main_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_main_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header mobile main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_main_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_main_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header mobile main', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_main_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),

		);

		// Header bottom settings.
		$settings['header_mobile_bottom'] = array(
			'header_mobile_bottom_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header mobile bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_bottom_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_bottom_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header mobile bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_bottom_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_bottom_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header mobile bottom', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_bottom_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),

		);

		// Header bottom settings.
		$settings['header_mobile_sticky'] = array(
			'header_mobile_sticky'   => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sticky Header', 'motta' ),
				'default'         => 'none',
				'choices'         => array(
					'none'   => esc_html__( 'No sticky', 'motta' ),
					'normal' => esc_html__( 'Normal sticky', 'motta' ),
					'custom' => esc_html__( 'Custom sticky', 'motta' ),
				),
			),
			'header_mobile_sticky_left'   => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Left Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the left side of header mobile sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_sticky_left' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_sticky_center' => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Center Items', 'motta' ),
				'description'     => esc_html__( 'Control items at the center of header mobile sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_sticky_center' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_sticky_right'  => array(
				'type'            => 'repeater',
				'label'           => esc_html__( 'Right Items', 'motta' ),
				'description'     => esc_html__( 'Control items on the right of header mobile sticky', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => array(),
				'row_label'       => array(
					'type'  => 'field',
					'value' => esc_html__( 'Item', 'motta' ),
					'field' => 'item',
				),
				'fields'          => array(
					'item' => array(
						'type'    => 'select',
						'choices' => $this->header_mobile_sticky_items_option(),
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_sticky',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'partial_refresh' => array(
					'header_mobile_sticky_right' => array(
						'selector'        => '#site-header',
						'render_callback' => array( \Motta\Header\Mobile::instance(), 'render' ),
					),
				),
			),
			'header_mobile_sticky_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_mobile_sticky_height' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Height', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '64',
				'choices'   => array(
					'min' => 30,
					'max' => 500,
				),
				'js_vars'   => array(
					array(
						'element'  => '.header-mobile-sticky',
						'property' => 'height',
						'units'    => 'px',
					),
				),
			),
		);

		// Header mobile menu.
		$settings['header_mobile_logo'] = array(
			'mobile_logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__( 'Default', 'motta' ),
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
				'priority' => 5,
			),
			'mobile_logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
				'priority' => 10,
			),
			'mobile_logo_svg'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
				'priority' => 15,
			),
			'mobile_logo_image'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'mobile_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
				'priority' => 20,
			),
			'mobile_logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
				'priority' => 25,
			),
		);

		$settings['header_mobile_hamburger'] = array(
			'header_mobile_menu_items'       => array(
				'type'    => 'repeater',
				'label'   => esc_html__( 'Hamburger Menu items', 'motta' ),
				'fields'   => [
					'item' => [
						'type'        => 'select',
						'label'       => esc_html__( 'Item', 'motta' ),
						'choices'     => $this->header_menu_panel_items(),
					],
				],
				'default'  => [
					[
						'item'   => 'track-order',
					],
					[
						'item'   => 'help-center',
					],
					[
						'item'   => 'divider',
					],
					[
						'item'   => 'category-menu',
					],
					[
						'item'   => 'divider',
					],
					[
						'item'   => 'primary-menu',
					],
					[
						'item'   => 'divider',
					],
					[
						'item'   => 'preferences',
					],
				],
				'row_label'    => [
					'type'  => 'field',
					'value' => '',
					'field' => 'item',
				],
				'priority' => 35,
			),
			'header_mobile_custom_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Hamburger Custom Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 40,

			),
			'header_mobile_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Hamburger Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 40,

			),
			'header_mobile_category_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Hamburger Category Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'priority' => 45,

			),
			'header_mobile_open_submenus'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Open submenus on', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'both' => esc_html__( 'Title & Icon click', 'motta' ),
					'icon' => esc_html__( 'Icon click', 'motta' ),
				),
				'priority' => 50,

			),
			'header_mobile_account_info'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Account Info', 'motta' ),
				'default'     => true,
				'priority' => 55,
			),
		);
		$settings['header_mobile_search'] = array(
			'header_mobile_search_style_prebuild'                 => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Search Style', 'motta' ),
				'default'     => 'form',
				'choices'     => array(
					'form'     => esc_html__( 'Form', 'motta' ),
					'icon'     => esc_html__( 'Icon', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '!=',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_version',
						'operator' => 'in',
						'value'    => array('v1', 'v2', 'v3', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10'),
					),
				),
				'priority' => 55,
			),
			'header_mobile_search_style'                 => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Search Style', 'motta' ),
				'default'     => 'form',
				'choices'     => array(
					'form'     => esc_html__( 'Form', 'motta' ),
					'icon'     => esc_html__( 'Icon', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 55,
			),

			'header_mobile_search_items'       => array(
				'type'    => 'sortable',
				'label'   => esc_html__( 'Search Items', 'motta' ),
				'default' => array(
					'search-field',
				),
				'choices' => array(
					'icon'       => esc_html__( 'Icon', 'motta' ),
					'search-field' => esc_html__( 'Search Field', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
				),
				'priority' => 60,
			),
			'header_mobile_search_items_button_display' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Search Button Display', 'motta' ),
				'default'     => 'icon',
				'choices'     => array(
					'none' => esc_html__( 'None', 'motta' ),
					'icon' => esc_html__( 'Icon', 'motta' ),
					'text' => esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
				),
				'priority' => 65,
			),
			'header_mobile_search_items_button_position' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Search Button Position', 'motta' ),
				'default'     => 'outside',
				'choices'     => array(
					'outside' => esc_html__( 'Outside', 'motta' ),
					'inside'  => esc_html__( 'Inside', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_search_items_button_display',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'setting'  => 'header_mobile_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
				),
				'priority' => 70,
			),
			'header_mobile_search_items_button_spacing' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Search Button Spacing', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_search_style',
						'operator' => '==',
						'value'    => 'form',
					),
					array(
						'setting'  => 'header_mobile_search_items_button_display',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'setting'  => 'header_mobile_search_items_button_position',
						'operator' => '==',
						'value'    => 'outside',
					),
				),
				'priority' => 75,
			),
			'header_mobile_search_icon_type' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Search Icon Type', 'motta' ),
				'default'     => 'text',
				'choices'     => array(
					'base' 	 => esc_html__( 'Base', 'motta' ),
					'raised' => esc_html__( 'Raised', 'motta' ),
					'ghost' => esc_html__( 'Ghost', 'motta' ),
					'text' => esc_html__( 'Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
					array(
						'setting'  => 'header_mobile_search_style',
						'operator' => '==',
						'value'    => 'icon',
					),
				),
				'priority' => 80,
			),
			'header_mobile_search_trending_searches' => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Trending Searches', 'motta' ),
				'description'     => esc_html__( 'Display a list of links bellow the search field', 'motta' ),
				'default'         => false,
				'priority' => 85,
			),
		);
		$settings['header_mobile_account'] = array(
			'header_mobile_account_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Account Type', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'text'   => esc_html__( 'Text', 'motta' ),
					'raised'  => esc_html__( 'Raised', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 95,
			),
		);
		$settings['header_mobile_wishlist'] = array(
			'header_mobile_wishlist_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Wishlist Type', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'text'   => esc_html__( 'Text', 'motta' ),
					'raised'  => esc_html__( 'Raised', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 105,
			),
		);
		$settings['header_mobile_cart'] = array(
			'header_mobile_cart_display' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Display', 'motta' ),
				'default'         => 'icon',
				'choices'         => array(
					'icon'   => esc_html__( 'Icon Only', 'motta' ),
					'icon-text'  => esc_html__( 'Icon & Text', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 115,
			),
			'header_mobile_cart_type' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Cart Type', 'motta' ),
				'default'         => 'subtle',
				'choices'         => array(
					'subtle'   => esc_html__( 'Subtle', 'motta' ),
					'raised'  => esc_html__( 'Raised', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_mobile_present',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'priority' => 125,
			),
		);

		// Footer layout settings.
		$settings['footer_layout'] = array(
			'footer_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Footer', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer present', 'motta' ),
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),

		);

		// Mobile Footer Settings
		$settings['footer_mobile'] = array(
			'footer_mobile_breakpoint'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Breakpoint (px)', 'motta' ),
				'description' => esc_html__( 'Set a breakpoint where the mobile footer displays and the desktop footer is hidden.', 'motta' ),
				'default'     => 767,
				'choices'     => [
					'min'  => 767,
					'max'  => 1024,
					'step' => 1,
				],
			),
			'footer_mobile_version_hr' => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
			),
			'footer_mobile_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Footer', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer present', 'motta' ),
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
		);

		// Mobile Catalog Toolbar
		$settings['mobile_product_card'] = array(
			'mobile_product_card_atc'        => array(
				'type'            => 'toggle',
				'label'           => esc_html__( 'Show Add To Cart Button', 'motta' ),
				'default'         => '0',
			),
			'mobile_product_card_featured_icons'  => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Show Featured Icons', 'motta' ),
				'choices'         => array(
					'none'   => esc_html__( 'None', 'motta' ),
					'hover'  => esc_html__( 'On Hover', 'motta' ),
					'load'  => esc_html__( 'On Load', 'motta' ),
				),
				'default'     => 'hover',
				'active_callback' => array(
					array(
						'setting'  => 'mobile_product_card_atc',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),

		);
		if( apply_filters('motta_get_product_archive_settings', true) ) {
			// Mobile Catalog Toolbar
			$settings['mobile_product_catalog'] = array(
				'shop_page_header_mobile_height'         => array(
					'type'            => 'slider',
					'label'           => esc_html__( 'Page Header Height', 'motta' ),
					'transport'       => 'postMessage',
					'default'         => 130,
					'choices'         => array(
						'min'  => 20,
						'max'  => 1000,
						'step' => 1,
					),
					'active_callback' => array(
						array(
							'setting'  => 'shop_page_header',
							'operator' => '==',
							'value'    => 'standard',
						),
					),
					'js_vars'         => array(
						array(
							'element'  => '.page-header--products .page-header__content',
							'property' => 'height',
							'units'    => 'px',
						),
					),
				),
				'shop_page_header_mobile_height_hr'  => array(
					'type'            => 'custom',
					'default'         => '<hr/>',
					'active_callback' => array(
						array(
							'setting'  => 'shop_page_header',
							'operator' => '==',
							'value'    => 'standard',
						),
					),
				),
				'catalog_toolbar_sticky'                    => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Sticky Toolbar', 'motta' ),
					'default' => false,
					'active_callback' => array(
						array(
							'setting'  => 'mobile_navigation_bar',
							'operator' => '!==',
							'value'    => 'standard',
						),
					),
				),
				'catalog_toolbar_sticky_hr'  => array(
					'type'            => 'custom',
					'default'         => '<hr/>',
					'active_callback' => array(
						array(
							'setting'  => 'shop_page_header',
							'operator' => '==',
							'value'    => 'standard',
						),
					),
				),
				'mobile_product_grid_hr'  => array(
					'type'            => 'custom',
					'default'         => '<h2>'. esc_html__( 'Product Grid', 'motta' ) .'</h2>',
				),
				'mobile_product_columns'     => array(
					'label'   => esc_html__( 'Product Columns', 'motta' ),
					'section' => 'mobile_product_catalog',
					'type'    => 'select',
					'default' => '2',
					'choices' => array(
						'1' => esc_html__( '1 Column', 'motta' ),
						'2' => esc_html__( '2 Columns', 'motta' ),
					),
				),
				'mobile_product_list_hr'  => array(
					'type'            => 'custom',
					'default'         => '<hr/><h2>'. esc_html__( 'Product List', 'motta' ) .'</h2>',
				),
				'mobile_product_list_desc'                    => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Product Description', 'motta' ),
					'default' => false,
				),

			);
		} else {
			$settings['mobile_product_catalog'] = array(
				'mobile_product_grid_hr'  => array(
					'type'            => 'custom',
					'default'         => '<h2>'. esc_html__( 'Product Grid', 'motta' ) .'</h2>',
				),
				'mobile_product_columns'     => array(
					'label'   => esc_html__( 'Product Columns', 'motta' ),
					'section' => 'mobile_product_catalog',
					'type'    => 'select',
					'default' => '2',
					'choices' => array(
						'1' => esc_html__( '1 Column', 'motta' ),
						'2' => esc_html__( '2 Columns', 'motta' ),
					),
				),
				'mobile_product_list_hr'  => array(
					'type'            => 'custom',
					'default'         => '<hr/><h2>'. esc_html__( 'Product List', 'motta' ) .'</h2>',
				),
				'mobile_product_list_desc'                    => array(
					'type'    => 'toggle',
					'label'   => esc_html__( 'Product Description', 'motta' ),
					'default' => false,
				),

			);
		}

		if( apply_filters('motta_get_single_product_settings', true ) ) {
			// Mobile Catalog Toolbar
			$settings['mobile_single_product'] = array(
				'mobile_product_header'     => array(
					'label'   => esc_html__( 'Mobile Header', 'motta' ),
					'section' => 'mobile_single_product',
					'type'    => 'select',
					'default' => 'default',
					'choices' => array(
						'default' => esc_attr__( 'Default', 'motta' ),
						'compact' => esc_attr__( 'Compact', 'motta' ),
					),
				),
				'mobile_product_gallery_fixed'     => array(
					'label'   => esc_html__( 'Fixed Product Gallery', 'motta' ),
					'section' => 'mobile_single_product',
					'type'    => 'toggle',
					'default' => true,
					'active_callback' => array(
						array(
							'setting'  => 'mobile_product_header',
							'operator' => '===',
							'value'    => 'compact',
						),
					),
				),
			);
		}

		// Mobile Navigation Bar
		$settings['mobile_navigation_bar'] = array(
			'mobile_navigation_bar'                 => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Navigation Bar', 'motta' ),
				'default' => 'none',
				'choices' => array(
					'none'              => esc_html__( 'None', 'motta' ),
					'standard'          => esc_html__( 'Standard', 'motta' ),
					'standard_adaptive' => esc_html__( 'Standard Adaptive', 'motta' ),
				),
			),
			'mobile_navigation_bar_items'           => array(
				'type'            => 'sortable',
				'label'           => esc_html__( 'Items', 'motta' ),
				'default'         => array( 'home', 'shop', 'cart', 'wishlist', 'account' ),
				'choices'         => $this->navigation_bar_items_option(),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_category_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Category Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar_items',
						'operator' => 'contains',
						'value'    => 'categories',
					),
				),
			),
			'mobile_navigation_bar_heading_1'    => array(
				'type'    => 'custom',
				'default' => '<hr/><h2>'. esc_html__( 'Custom Style', 'motta' ) .'</h2>',
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_box_shadow_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Box Shadow Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'choices'     => [
					'alpha' => true,
				],
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar',
						'property' => '--mt-color__navigation-bar--box-shadow',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_spacing' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '0',
				'choices'   => array(
					'min' => 0,
					'max' => 250,
				),
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar',
						'property' => 'margin-left',
						'units'    => 'px',
					),
					array(
						'element'  => '.motta-mobile-navigation-bar',
						'property' => 'margin-right',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_spacing_bottom' => array(
				'type'      => 'slider',
				'label'     => esc_html__( 'Spacing Bottom', 'motta' ),
				'transport' => 'postMessage',
				'default'   => '0',
				'choices'   => array(
					'min' => 0,
					'max' => 250,
				),
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar',
						'property' => 'margin-bottom',
						'units'    => 'px',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_counter_background_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Counter Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon .counter',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
			'mobile_navigation_bar_counter_color' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Counter Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon .counter',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'mobile_navigation_bar',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
			),
		);
		// Blog Header
		$settings['blog_prebuilt_header'] = array(
			'header_blog_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Header Blog', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt header for blog page', 'motta' ),
				'default'         => 'v11',
				'choices'         => array(
					''  => esc_html__( 'Default', 'motta' ),
					'v1'  => esc_html__( 'Header V1', 'motta' ),
					'v2'  => esc_html__( 'Header V2', 'motta' ),
					'v3'  => esc_html__( 'Header V3', 'motta' ),
					'v4'  => esc_html__( 'Header V4', 'motta' ),
					'v5'  => esc_html__( 'Header V5', 'motta' ),
					'v6'  => esc_html__( 'Header V6', 'motta' ),
					'v7'  => esc_html__( 'Header V7', 'motta' ),
					'v8'  => esc_html__( 'Header V8', 'motta' ),
					'v9'  => esc_html__( 'Header V9', 'motta' ),
					'v10' => esc_html__( 'Header V10', 'motta' ),
					'v11' => esc_html__( 'Header V11', 'motta' ),
					'v12' => esc_html__( 'Header V12', 'motta' ),
				),
			),
			'blog_primary_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Primary Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
			),
			'header_blog_hide_topbar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Topbar', 'motta' ),
				'default'     => false,
			),
			'header_blog_hide_campaign_bar'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Campaign Bar', 'motta' ),
				'default'     => false,
			),
			'header_blog_hide_header_main'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Hide Header Main', 'motta' ),
				'default'     => true,
			),
			'header_blog_logo_hr'     => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'header_blog_logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__( 'Default', 'motta' ),
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
			),
			'header_blog_logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_blog_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'header_blog_logo_svg'       => array(
				'type'            => 'textarea',
				'label'           => esc_html__( 'Logo SVG', 'motta' ),
				'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
				'sanitize_callback' => 'Motta\Icon::sanitize_svg',
				'output'          => array(
					array(
						'element' => '.site-header .header-logo',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_blog_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'header_blog_logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Image', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_blog_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'header_blog_logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_blog_logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
			),
		);
		$settings['blog_prebuilt_footer'] = array(
			'footer_blog_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Footer Blog', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer for blog page', 'motta' ),
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
			'mobile_footer_blog_version' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Prebuilt Mobile Footer Blog', 'motta' ),
				'description'     => esc_html__( 'Select a prebuilt footer for blog page on mobile', 'motta' ),
				'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
		);

		// Blog Header
		$settings['blog_header'] = array(
			'blog_header'            => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Enable Blog Header', 'motta' ),
				'description' => esc_html__( 'Enable the blog header on blog pages.', 'motta' ),
				'default'     => true,
			),
			'blog_header_custom_field_1' => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'blog_header',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_header_els' => array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Blog Header Elements', 'motta'),
				'default'  => array( 'title' ),
				'priority' => 10,
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'motta'),
					'title'      => esc_html__('Title', 'motta'),
				),
				'description'     => esc_html__('Select which elements you want to show.', 'motta'),
				'active_callback' => array(
					array(
						'setting'  => 'blog_header',
						'operator' => '==',
						'value'    => true,
					),
				),

			),
		);

		// Blog Archive
		$settings['blog_archive'] = array(
			'blog_trending_posts'       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Trending Posts', 'motta' ),
				'description' => esc_html__( 'Display the trending posts section on blog page', 'motta' ),
				'default'     => false,
			),
			'blog_trending_tag'           => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Trending Tag', 'motta' ),
				'description'     => esc_html__( 'Specify the tag you will use on posts to be displayed as Trending Content', 'motta' ),
				'default'         => 'trending',
				'active_callback' => array(
					array(
						'setting'  => 'blog_trending_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_trending_layout'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Trending Layout', 'motta' ),
				'description' => esc_html__( 'The trending layout of blog page', 'motta' ),
				'default'     => '1',
				'choices'     => array(
					'1' 	=> esc_html__('Layout 1', 'motta'),
					'2' 	=> esc_html__('Layout 2', 'motta'),
					'3' 	=> esc_html__('Layout 3', 'motta'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_trending_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_trending_carousel_number'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Number of Item', 'motta' ),
				'description' => esc_html__( 'Maximum number of posts for trending post section', 'motta' ),
				'default'     => 3,
				'active_callback' => array(
					array(
						'setting'  => 'blog_trending_posts',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'blog_trending_layout',
						'operator' => '==',
						'value'    => '2',
					),
				),
			),
			'blog_trending_length'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Excerpt Length', 'motta' ),
				'description' => esc_html__( 'The number of words of the post excerpt', 'motta' ),
				'default'     => 17,
				'active_callback' => array(
					array(
						'setting'  => 'blog_trending_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_archive_custom_hr_2'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
			),
			'blog_featured_posts'       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Featured Posts', 'motta' ),
				'description' => esc_html__( 'Display the Featured Posts section on blog page', 'motta' ),
				'default'     => false,
			),
			'blog_featured_tag'           => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Featured Tag', 'motta' ),
				'description'     => esc_html__( 'Specify the tag you will use on posts to be displayed as Featured Posts', 'motta' ),
				'default'         => 'featured',
				'active_callback' => array(
					array(
						'setting'  => 'blog_featured_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_featured_link_url'           => array(
				'type'            => 'text',
				'label'           => esc_html__( 'See All Link', 'motta' ),
				'default'         => '#',
				'active_callback' => array(
					array(
						'setting'  => 'blog_featured_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_featured_posts_columns'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Columns', 'motta' ),
				'description' => esc_html__( 'The number of columns of the post', 'motta' ),
				'default'     => '3',
				'choices'     => array(
					'3' 	=> esc_html__('3 Columns', 'motta'),
					'4' 	=> esc_html__('4 Columns', 'motta'),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_featured_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_featured_posts_total'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Total Number', 'motta' ),
				'description' => esc_html__( 'The number of total number of the post', 'motta' ),
				'default'     => 6,
				'choices'     => [
					'min'  => 4,
					'max'  => 10,
					'step' => 1,
				],
				'active_callback' => array(
					array(
						'setting'  => 'blog_featured_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_featured_position'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Featured Posts Position', 'motta' ),
				'default'         => 'under',
				'choices'         => array(
					'above' => esc_html__( 'Above Posts Content', 'motta' ),
					'under' => esc_html__( 'Under Posts Content', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_featured_posts',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_archive_custom_hr_3'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
			),
			'blog_posts_heading'       => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Posts Heading', 'motta' ),
				'description' => esc_html__( 'Display the Posts Heading section on blog page', 'motta' ),
				'default'     => false,
			),
			'blog_posts_heading_type'          => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Posts Heading Type', 'motta' ),
				'default'         => 'group',
				'choices'         => array(
					'recent' => esc_html__( 'Recent Heading', 'motta' ),
					'group' => esc_html__( 'Group Tabs', 'motta' ),
					'menu' => esc_html__( 'Menu Tabs', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'blog_posts_heading',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'blog_posts_heading_menu'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Menu', 'motta' ),
				'default'         => '',
				'choices'         => $this->get_menus(),
				'active_callback' => array(
					array(
						'setting'  => 'blog_posts_heading',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'blog_posts_heading_type',
						'operator' => '==',
						'value'    => 'menu',
					),
				),
			),
			'blog_archive_custom_hr_4'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
			),
			'blog_layout'                 => array(
				'type'        => 'radio',
				'label'       => esc_html__( 'Blog Layout', 'motta' ),
				'description' => esc_html__( 'The layout of blog posts', 'motta' ),
				'default'     => 'default',
				'choices'     => array(
					'default' => esc_html__( 'Default', 'motta' ),
					'classic' => esc_html__( 'Classic', 'motta' ),
					'grid'    => esc_html__( 'Grid', 'motta' ),
				),
			),
			'excerpt_length'              => array(
				'type'        => 'number',
				'label'       => esc_html__( 'Excerpt Length', 'motta' ),
				'description' => esc_html__( 'The number of words of the post excerpt', 'motta' ),
				'default'     => 30,
			),
			'blog_main_custom_hr_5'    => array(
				'type'    => 'custom',
				'default' => '<hr/>',
			),
			'blog_nav_type'               => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Navigation Type', 'motta' ),
				'default' => 'numeric',
				'choices' => array(
					'numeric'  => esc_html__( 'Numeric', 'motta' ),
					'loadmore' => esc_html__( 'Load more', 'motta' ),
				),
			),
			'blog_nav_ajax_url_change'               => array(
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Change the URL after page loaded', 'motta' ),
				'default' => true,
				'active_callback' => array(
					array(
						'setting'  => 'blog_nav_type',
						'operator' => '!=',
						'value'    => 'numeric',
					),
				),
			),
		);

		// Blog single.
		$settings['blog_single'] = array(
			'post_layout'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Post Layout', 'motta' ),
				'description' => esc_html__( 'The layout of single posts', 'motta' ),
				'default'     => 'no-sidebar',
				'choices'     => array(
					'no-sidebar'      => esc_html__('No Sidebar', 'motta'),
					'content-sidebar' => esc_html__('Right Sidebar', 'motta'),
					'sidebar-content' => esc_html__('Left Sidebar', 'motta'),
				),
			),
			'post_featured_image_position'                 => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Featured Image Position', 'motta' ),
				'default'     => '',
				'choices'     => array(
					''      => esc_html__('Default', 'motta'),
					'top' => esc_html__('Above the category', 'motta'),
				),
			),
			'post_author_box'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Author Box', 'motta' ),
				'description' => esc_html__( 'Display the post author box', 'motta' ),
				'default'     => false,
			),
			'post_navigation'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Post Navigation', 'motta' ),
				'description' => esc_html__( 'Display the next and previous posts', 'motta' ),
				'default'     => true,
			),
			'post_related_posts'   => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Related Posts', 'motta' ),
				'description' => esc_html__( 'Display related posts', 'motta' ),
				'default'     => true,
			),
			'post_sharing'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Post Sharing', 'motta' ),
				'description' => esc_html__( 'Enable post sharing.', 'motta' ),
				'default'     => false,
			),
		);

		// Help Center
		if( empty( get_option('help_center_disable') ) ) {
			$settings['help_center_header'] = array(
				'help_center_header' => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Prebuilt Header', 'motta' ),
					'description'     => esc_html__( 'Select a prebuilt header for the archive help center and single help center', 'motta' ),
					'default'         => 'v12',
					'choices'         => array(
						''  => esc_html__( 'Default', 'motta' ),
						'v1'  => esc_html__( 'Header V1', 'motta' ),
						'v2'  => esc_html__( 'Header V2', 'motta' ),
						'v3'  => esc_html__( 'Header V3', 'motta' ),
						'v4'  => esc_html__( 'Header V4', 'motta' ),
						'v5'  => esc_html__( 'Header V5', 'motta' ),
						'v6'  => esc_html__( 'Header V6', 'motta' ),
						'v7'  => esc_html__( 'Header V7', 'motta' ),
						'v8'  => esc_html__( 'Header V8', 'motta' ),
						'v9'  => esc_html__( 'Header V9', 'motta' ),
						'v10' => esc_html__( 'Header V10', 'motta' ),
						'v11' => esc_html__( 'Header V11', 'motta' ),
						'v12' => esc_html__( 'Header V12', 'motta' ),
					),
				),
				'help_center_primary_menu'       => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Primary Menu', 'motta' ),
					'default'         => '',
					'choices'         => $this->get_menus(),
				),
				'help_center_header_transparent'     => array(
					'type'        => 'toggle',
					'default'     => false,
					'label'       => esc_html__('Header Transparent', 'motta'),
					'active_callback' => array(
						array(
							'setting'  => 'help_center_header',
							'operator' => '==',
							'value'    => 'v12',
						),
					),
				),
				'header_help_center_color'              => array(
					'type'            => 'radio',
					'label'           => esc_html__( 'Text Color', 'motta' ),
					'transport'       => 'postMessage',
					'default'         => 'dark',
					'choices'         => array(
						'light' => esc_html__( 'Light', 'motta' ),
						'dark'  => esc_html__( 'Dark', 'motta' ),
					),
					'active_callback' => array(
						array(
							'setting'  => 'help_center_header',
							'operator' => '==',
							'value'    => 'v12',
						),
						array(
							'setting'  => 'help_center_header_transparent',
							'operator' => '==',
							'value'    => true,
						),
					),
				),
				'header_help_center_logo_hr'    => array(
					'type'    => 'custom',
					'default' => '<hr/>',
				),
				'header_help_center_logo_type'      => array(
					'type'    => 'radio',
					'label'   => esc_html__( 'Logo Type', 'motta' ),
					'default' => 'default',
					'choices' => array(
						'default' => esc_html__( 'Default', 'motta' ),
						'image' => esc_html__( 'Image', 'motta' ),
						'text'  => esc_html__( 'Text', 'motta' ),
						'svg'   => esc_html__( 'SVG', 'motta' ),
					),
				),
				'header_help_center_logo_text'      => array(
					'type'            => 'text',
					'label'           => esc_html__( 'Logo Text', 'motta' ),
					'default'         => get_bloginfo( 'name' ),
					'active_callback' => array(
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '==',
							'value'    => 'text',
						),
					),
				),
				'header_help_center_logo_svg'       => array(
					'type'            => 'textarea',
					'label'           => esc_html__( 'Logo SVG', 'motta' ),
					'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
					'sanitize_callback' => 'Motta\Icon::sanitize_svg',
					'output'          => array(
						array(
							'element' => '.site-header .header-logo',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '==',
							'value'    => 'svg',
						),
					),
				),
				'header_help_center_logo'           => array(
					'type'            => 'image',
					'label'           => esc_html__( 'Logo Image', 'motta' ),
					'default'         => '',
					'active_callback' => array(
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '==',
							'value'    => 'image',
						),
					),
				),
				'header_help_center_logo_hr_light'    => array(
					'type'    => 'custom',
					'default' => '<hr/>',
					'active_callback' => array(
						array(
							'setting'  => 'help_center_header_transparent',
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => 'header_help_center_color',
							'operator' => '==',
							'value'    => 'light',
						),
					),
				),
				'header_help_center_logo_light_svg'       => array(
					'type'            => 'textarea',
					'label'           => esc_html__( 'Logo Light SVG', 'motta' ),
					'description'     => esc_html__( 'Paste SVG code of your logo here', 'motta' ),
					'sanitize_callback' => 'Motta\Icon::sanitize_svg',
					'output'          => array(
						array(
							'element' => '.site-header .header-logo',
						),
					),
					'active_callback' => array(
						array(
							'setting'  => 'help_center_header_transparent',
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => 'header_help_center_color',
							'operator' => '==',
							'value'    => 'light',
						),
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '==',
							'value'    => 'svg',
						),
					),
				),
				'header_help_center_logo_light'           => array(
					'type'            => 'image',
					'label'           => esc_html__( 'Logo Light Image', 'motta' ),
					'default'         => '',
					'active_callback' => array(
						array(
							'setting'  => 'help_center_header_transparent',
							'operator' => '==',
							'value'    => true,
						),
						array(
							'setting'  => 'header_help_center_color',
							'operator' => '==',
							'value'    => 'light',
						),
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '==',
							'value'    => 'image',
						),
					),
				),
				'header_help_center_logo_dimension' => array(
					'type'            => 'dimensions',
					'label'           => esc_html__( 'Logo Dimension', 'motta' ),
					'default'         => array(
						'width'  => '',
						'height' => '',
					),
					'active_callback' => array(
						array(
							'setting'  => 'header_help_center_logo_type',
							'operator' => '!=',
							'value'    => 'text',
						),
					),
				),
			);

			$settings['help_center_footer'] = array(
				'help_center_footer' => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Prebuilt Footer', 'motta' ),
					'description'     => esc_html__( 'Select a prebuilt footer present', 'motta' ),
					'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
				),
				'help_center_footer_mobile' => array(
					'type'            => 'select',
					'label'           => esc_html__( 'Prebuilt Mobile Footer', 'motta' ),
					'description'     => esc_html__( 'Select a prebuilt Mobile Footer present', 'motta' ),
					'choices'         => Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
				)
			);

			$settings['help_center_search'] = array(
				'help_center_search' => array(
					'type'     => 'multicheck',
					'label'    => esc_html__('Search Bar For', 'motta'),
					'default'  => array('archive', 'single'),
					'priority' => 10,
					'choices'  => array(
						'archive' => esc_html__('Archive page', 'motta'),
						'single'      => esc_html__('Single page', 'motta'),
					),
					'description'     => esc_html__('Select which pages you want to show.', 'motta'),
				),
				'help_center_search_bgcolor'       => array(
					'type'            => 'color',
					'label'     	  => esc_html__( 'Background Color', 'motta' ),
					'default'         => '',
					'transport'       => 'postMessage',
					'js_vars'         => array(
						array(
							'element'  => '.search-bar-hc',
							'property' => 'background-color',
						),
					),
				),
				'help_center_search_color'              => array(
					'type'            => 'radio',
					'label'           => esc_html__( 'Text Color', 'motta' ),
					'default'         => 'dark',
					'choices'         => array(
						'light' => esc_html__( 'Light', 'motta' ),
						'dark'  => esc_html__( 'Dark', 'motta' ),
					),
				),
				'help_center_search_space_top' => array(
					'type'      => 'slider',
					'label'     => esc_html__( 'Spacing Top', 'motta' ),
					'transport' => 'postMessage',
					'default'   => '50',
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'   => array(
						array(
							'element'  => '.search-bar-hc',
							'property' => 'padding-top',
							'units'    => 'px',
						),
					),
				),
				'help_center_search_space_bottom' => array(
					'type'      => 'slider',
					'label'     => esc_html__( 'Spacing Bottom', 'motta' ),
					'transport' => 'postMessage',
					'default'   => '50',
					'choices'   => array(
						'min' => 0,
						'max' => 500,
					),
					'js_vars'   => array(
						array(
							'element'  => '.search-bar-hc',
							'property' => 'padding-bottom',
							'units'    => 'px',
						),
					),
				),
			);

			$settings['help_center_archive'] = array(
				'help_article_length'              => array(
					'type'        => 'number',
					'label'       => esc_html__( 'Excerpt Length', 'motta' ),
					'description' => esc_html__( 'The number of words of the article excerpt', 'motta' ),
					'default'     => 17,
				),
			);

			$settings['help_center_single'] = array(
				'help_center_single_hide_sidebar'     => array(
					'type'        => 'toggle',
					'default'     => false,
					'label'       => esc_html__('Hide Sidebar', 'motta'),
				),
				'help_center_single_sidebar_posts_number'     => array(
					'type'        => 'number',
					'default'     => 10,
					'choices'   => array(
						'min' => 2,
						'max' => 50,
					),
					'label'       => esc_html__('Sidebar posts number', 'motta'),
				),
				'help_center_single_hide_title_hr'    => array(
					'type'    => 'custom',
					'default' => '<hr/>',
				),
				'help_center_single_hide_title'     => array(
					'type'        => 'toggle',
					'default'     => false,
					'label'       => esc_html__('Hide Title', 'motta'),
				),
			);
		}

		$settings['rtl'] = array(
			'rtl_smart'     => array(
				'type'        => 'toggle',
				'default'     => false,
				'label'       => esc_html__('Smart RTL', 'motta'),
				'description' => esc_html__('Enable this option to automatically change background image, padding, and position... to RTL', 'motta'),
			),
		);

		return array(
			'theme'    => 'motta',
			'panels'   => apply_filters( 'motta_customize_panels', $panels ),
			'sections' => apply_filters( 'motta_customize_sections', $sections ),
			'settings' => apply_filters( 'motta_customize_settings', $settings ),
		);

	}

	/**
	 * Get nav menus
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_menus() {
		if ( ! is_admin() ) {
			return [];
		}

		$menus = wp_get_nav_menus();
		if ( ! $menus ) {
			return [];
		}

		$output = array(
			0 => esc_html__( 'Select Menu', 'motta' ),
		);
		foreach ( $menus as $menu ) {
			$output[ $menu->slug ] = $menu->name;
		}

		return $output;
	}

	/**
	 * Repeater Santitize Icon
	 *
	 * @since 1.0.0
	 *
	 * @return $sanitized_value
	 */
	public static function repeater_sanitize_icon( $value ) {
		$sanitized_value = array();
		$value = ( is_array( $value ) ) ? $value : json_decode( urldecode( $value ), true );

		foreach ( $value as $key => $subvalue ) {
			$sanitized_value[ $key ] = $subvalue;

			if ( isset( $sanitized_value[ $key ]['icon'] ) ) {
				$sanitized_value[ $key ]['icon'] = \Motta\Icon::sanitize_svg( $sanitized_value[ $key ]['icon'] );
			}
		}

		return $sanitized_value;
	}

	/**
	 * Display header categories
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_categories( $post_type = '' ) {
		if ( 'shortcode' == get_theme_mod( 'header_search_bar' ) ) {
			return false;
		}

		if( empty(get_theme_mod( 'header_search_type' )) ) {
			return false;
		}

		if( ! empty( $post_type) ) {
			if ( is_array ( $post_type ) &&  ! in_array( get_theme_mod( 'header_search_type'), $post_type ) ) {
				return false;
			}
		}

		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			if( get_theme_mod( 'header_search_style' ) != 'form') {
				return false;
			}

			if( ! in_array( 'categories', get_theme_mod( 'header_search_items' ) )) {
				return false;
			}

			return true;
		} else {
			return true;
		}
	}

	/**
	 * Display header categories
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_cart_custom_color() {
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			if(  in_array( get_theme_mod( 'header_cart_type' ), array( 'base') ) ) {
				return true;
			}

			return false;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v4' ) ) ) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Display header hamburger
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_hamburger() {
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			return true;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v3', 'v5', 'v8' ) ) ) {
				return true;
			}

			return false;
		}
	}


	/**
	 * Display header hamburger
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function header_menu_panel_items() {
		$items = array(
			'' => esc_html__( 'Select an item', 'motta' ),
			'divider' => esc_html__( 'Divider', 'motta' ),
			'track-order' => esc_html__( 'Track Order', 'motta' ),
			'help-center'  => esc_html__( 'Help Center', 'motta' ),
			'custom-menu'  => esc_html__( 'Custom Menu', 'motta' ),
			'primary-menu'  => esc_html__( 'Primary menu', 'motta' ),
			'category-menu'  => esc_html__( 'Category Menu', 'motta' ),
			'preferences'  => esc_html__( 'Preferences', 'motta' ),
		);

		if ( function_exists('wcboost_wishlist') ) {
			$items['wishlist'] = esc_html__( 'Wishlist', 'motta' );
		}

		if ( function_exists('wcboost_products_compare') ) {
			$items['compare'] = esc_html__( 'Compare', 'motta' );
		}

		$items = apply_filters('motta_get_header_menu_panel_items', $items);

		return $items;
	}


	/**
	 * Display header custom text
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_view_history() {
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			return true;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v8', 'v9', 'v10' ) ) ) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Display header custom text
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_custom_text() {
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			return true;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v1' ) ) ) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Display header empty space
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_empty_space() {
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			return true;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v2' ) ) ) {
				return true;
			}

			return false;
		}
	}

	/**
	 * Display header search button
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_search_button() {
		if ( 'shortcode' == get_theme_mod( 'header_search_bar' ) ) {
			return false;
		}
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			if( in_array(get_theme_mod('header_search_skins'), array( 'base', 'raised', 'ghost'))) {
				return true;
			}
			return false;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v9' ) ) ) {
				return true;
			}

			return false;
		}
	}


	/**
	 * Display header search
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_header_search_custom_color() {
		if ( 'shortcode' == get_theme_mod( 'header_search_bar' ) ) {
			return false;
		}
		if ( 'custom' == get_theme_mod( 'header_present' ) ) {
			return true;
		} else {
			if(  in_array( get_theme_mod( 'header_version' ), array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v9' ) ) ) {
				return true;
			}

			return false;
		}
	}
}
