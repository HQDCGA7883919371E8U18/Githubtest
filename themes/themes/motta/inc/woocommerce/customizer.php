<?php
/**
 * WooCommerce Customizer functions and definitions.
 *
 * @package motta
 */

namespace Motta\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The motta WooCommerce Customizer class
 */
class Customizer {
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
		add_filter( 'motta_customize_panels', array( $this, 'get_customize_panels' ) );
		add_filter( 'motta_customize_sections', array( $this, 'get_customize_sections' ) );
		add_filter( 'motta_customize_settings', array( $this, 'get_customize_settings' ) );
	}

	/**
	 * Adds theme options panels of WooCommerce.
	 *
	 * @since 1.0.0
	 *
	 * @param array $panels Theme options panels.
	 *
	 * @return array
	 */
	public function get_customize_panels( $panels ) {
		$panels['woocommerce'] = array(
			'priority' => 50,
			'title'    => esc_html__( 'Woocommerce', 'motta' ),
		);

		$panels['shop'] = array(
			'priority' => 50,
			'title'    => esc_html__( 'Shop', 'motta' ),
		);

		if( apply_filters('motta_get_single_product_settings', true ) ) {
			$panels['single_product'] = array(
				'priority' => 55,
				'title'    => esc_html__( 'Single Product', 'motta' ),
			);
		}

		$panels['vendors'] = array(
			'priority' => 60,
			'title'    => esc_html__( 'Vendors', 'motta' ),
		);

		return $panels;
	}

	/**
	 * Adds theme options sections of WooCommerce.
	 *
	 * @since 1.0.0
	 *
	 * @param array $sections Theme options sections.
	 *
	 * @return array
	 */
	public function get_customize_sections( $sections ) {
		// Typography
		$sections['typo_catalog'] = array(
			'title'    => esc_html__( 'Product Catalog', 'motta' ),
			'panel'    => 'typography',
		);
		$sections['typo_product'] = array(
			'title'    => esc_html__( 'Product', 'motta' ),
			'panel'    => 'typography',
		);

		// Compare Page
		$sections['compare_page'] = array(
			'title'    => esc_html__( 'Compare Page', 'motta' ),
			'panel'    => 'woocommerce',
		);

		// Not Log In
		$sections['sign_in'] = array(
			'title'    => esc_html__( 'Sign In', 'motta' ),
			'panel'    => 'woocommerce',
		);

		if( apply_filters('motta_get_product_archive_settings', true) ) {
			// Page Header
			$sections['shop_catalog_header'] = array(
				'title'    => esc_html__( 'Page Header', 'motta' ),
				'panel'    => 'shop',
			);

			// Shop Header
			$sections['shop_header'] = array(
				'title'    => esc_html__( 'Shop Header', 'motta' ),
				'panel'    => 'shop',
			);

			// Top Categories
			$sections['shop_top_categories'] = array(
				'title'    => esc_html__( 'Top Categories', 'motta' ),
				'panel'    => 'shop',
			);

			$sections['taxonomy_description'] = array(
				'title'    => esc_html__( 'Taxonomy Description', 'motta' ),
				'panel'    => 'shop',
			);

			// Catalog toolbar
			$sections['shop_catalog_toolbar'] = array(
				'title'    => esc_html__( 'Catalog Toolbar', 'motta' ),
				'panel'    => 'shop',
			);


			// Catalog Layout
			$sections['shop_catalog'] = array(
				'title'    => esc_html__( 'Product Catalog', 'motta' ),
				'panel'    => 'shop',
			);
		}

		// Product Card
		$sections['product_card'] = array(
			'title'    => esc_html__( 'Product Card', 'motta' ),
			'panel'    => 'shop',
		);

		// Product Notifications
		$sections['product_notifications'] = array(
			'title'    => esc_html__( 'Product Notifications', 'motta' ),
			'panel'    => 'shop',
		);

		// Badges
		$sections['badges'] = array(
			'title'    => esc_html__( 'Badges', 'motta' ),
			'panel'    => 'shop',
		);

		// Quick View
		$sections['quickview'] = array(
			'title'    => esc_html__( 'Quick View', 'motta' ),
			'panel'    => 'shop',
		);

		// Single Product
		$sections['product'] = array(
			'title'    => esc_html__( 'Product Layout', 'motta' ),
			'panel'    => 'single_product',
		);

		// Related Product
		$sections['product_sharing'] = array(
			'title'    => esc_html__( 'Product Sharing', 'motta' ),
			'panel'    => 'single_product',
		);

		// Related Product
		$sections['related_products'] = array(
			'title'    => esc_html__( 'Related Products', 'motta' ),
			'panel'    => 'single_product',
		);

		// Upsells Product
		$sections['upsells_products'] = array(
			'title'    => esc_html__( 'Up-Sells  Products', 'motta' ),
			'panel'    => 'single_product',
		);

		// Store style active when use wcfm
		$sections['vendors_store_style'] = array(
			'title'    => esc_html__( 'Store Style', 'motta' ),
			'panel'    => 'vendors',
		);

		$sections['vendors_store_manager'] = array(
			'title'    => esc_html__( 'Store Manager', 'motta' ),
			'panel'    => 'vendors',
		);

		// Store List
		$sections['vendors_store_list'] = array(
			'title'    => esc_html__( 'Store List', 'motta' ),
			'panel'    => 'vendors',
		);

		//Store Page
		$sections['vendors_store_page'] = array(
			'title'    => esc_html__( 'Store Page', 'motta' ),
			'panel'    => 'vendors',
		);

		$sections['vendors_product_page'] = array(
			'title'    => esc_html__( 'Product Page', 'motta' ),
			'panel'    => 'vendors',
		);


		return $sections;
	}

	/**
	 * Adds theme options of WooCommerce.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields Theme options fields.
	 *
	 * @return array
	 */
	public function get_customize_settings( $settings ) {
		// Typography - catalog.
		$settings['typo_catalog'] = array(
			'typo_catalog_page_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Page Header Title', 'motta' ),
				'description' => esc_html__( 'Customize the font of page header title', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '700',
					'font-size'      => '32px',
					'line-height'    => '1.33333',
					'text-transform' => 'none',
					'color'          => 'inherit',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.page-header--products h1.page-header__title',
					),
				),
			),
			'typo_catalog_page_description'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Page Header Description', 'motta' ),
				'description' => esc_html__( 'Customize the font of page header description', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '400',
					'font-size'      => '12px',
					'line-height'    => '1.66667',
					'text-transform' => 'none',
					'color'          => 'inherit',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.page-header--products div.page-header__description',
					),
				),
			),
			'typo_catalog_product_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Product Name', 'motta' ),
				'description' => esc_html__( 'Customize the font of product name', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '400',
					'font-size'      => '12px',
					'line-height'    => '1.5',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => 'ul.products li.product h2.woocommerce-loop-product__title a',
					),
				),
			),
		);

		// Typography - product.
		$settings['typo_product'] = array(
			'typo_product_title'              => array(
				'type'        => 'typography',
				'label'       => esc_html__( 'Product Name', 'motta' ),
				'description' => esc_html__( 'Customize the font of product name', 'motta' ),
				'default'     => array(
					'font-family'    => 'inherit',
					'variant'        => '500',
					'font-size'      => '24px',
					'line-height'    => '1.33333',
					'text-transform' => 'none',
					'color'          => '#1d2128',
					'subsets'        => array( 'latin-ext' ),
				),
				'transport' => 'postMessage',
				'js_vars'      => array(
					array(
						'element' => '.single-product div.product h1.product_title, .single-product div.product.layout-4 h1.product_title, .single-product div.product.layout-5 h1.product_title, .single-product div.product.layout-6 .product-summary-wrapper h1.product_title',
					),
				),
			),
		);

		// Product Card
		$settings['product_card'] = array(
			'product_card_layout' => array(
				'type'               => 'select',
				'label'              => esc_html__( 'Product Layout', 'motta' ),
				'default'            => '1',
				'choices'            => array(
					'1'                 => esc_html__( 'Layout v1', 'motta' ),
					'2'                 => esc_html__( 'Layout v2', 'motta' ),
					'3'                 => esc_html__( 'Layout v3', 'motta' ),
					'4'                 => esc_html__( 'Layout v4', 'motta' ),
					'5'                 => esc_html__( 'Layout v5', 'motta' ),
					'6'                 => esc_html__( 'Layout v6', 'motta' ),
				),
				'priority'    => 5,
			),
			'product_card_hover' => array(
				'type'              => 'select',
				'label'             => esc_html__( 'Product Hover', 'motta' ),
				'description'       => esc_html__( 'Product hover animation.', 'motta' ),
				'default'           => '',
				'choices'           => array(
					''                 => esc_html__( 'Standard', 'motta' ),
					'slider'           => esc_html__( 'Slider', 'motta' ),
					'zoom'             => esc_html__( 'Zoom', 'motta' ),
					'fadein'           => esc_html__( 'Fadein', 'motta' ),
				),
				'priority'    => 10,
			),
			'product_card_add_to_cart_button_custom'  => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
				'priority'    => 15,
			),
			'product_card_title_lines' => array(
				'type'               => 'select',
				'label'              => esc_html__( 'Product Title in', 'motta' ),
				'default'            => '',
				'choices'            => array(
					''                 => esc_html__( 'Default', 'motta' ),
					'2'                 => esc_html__( '2 lines', 'motta' ),
					'3'                 => esc_html__( '3 lines', 'motta' ),
					'4'                 => esc_html__( '4 lines', 'motta' ),
				),
				'priority'    => 20,
			),
			'product_card_title_tag' => array(
				'type'               => 'select',
				'label'              => esc_html__( 'Product Title Heading Tag', 'motta' ),
				'default'            => 'h2',
				'choices'            => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				),
				'priority'    => 25,
			),
			'product_card_taxonomy_custom'  => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
				'priority'    => 35,
			),
			'product_card_taxonomy'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Product Taxonomy', 'motta' ),
				'default'         => 'product_cat',
				'choices'         => array(
					''              => esc_html__( 'None', 'motta' ),
					'product_cat'   => esc_html__( 'Category', 'motta' ),
					'product_brand' => esc_html__( 'Brand', 'motta' ),
				),
				'priority'    => 35,
			),
			'product_card_stars_rating' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Stars Rating', 'motta' ),
				'default' => true,
				'priority'    => 40,
			),
			'product_card_add_to_cart_button' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Add To Cart', 'motta' ),
				'default' => true,
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
				'priority'    => 45,
			),
			'product_card_quick_view_button' => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Quick View', 'motta' ),
				'default' => false,
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
				'priority'    => 50,
			),
			'product_card_quickview_behaviour'            => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Quick View Behaviour', 'motta' ),
				'default' => 'modal',
				'choices' => array(
					'modal' => esc_html__( 'Modal', 'motta' ),
					'panel' => esc_html__( 'Panel', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
					array(
						'setting'  => 'product_card_quick_view_button',
						'operator' => '==',
						'value'    => true,
					),
				),
				'priority'    => 55,
			),

			'product_card_attribute_custom'            => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
				'priority'    => 65,
			),
			'product_card_attribute'                     => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Product Attribute', 'motta' ),
				'default'     => 'none',
				'choices'     => $this->get_product_attributes(),
				'description' => esc_html__( 'Show product attribute in the product card', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
				'priority'    => 70,
			),
			'product_card_attribute_in'                     => array(
				'type'        => 'multicheck',
				'label'       => esc_html__( 'Product Attribute In', 'motta' ),
				'default'     => array('variable', 'simple'),
				'choices'  => array(
					'variable' => esc_html__( 'Variable Product', 'motta' ),
					'simple'   => esc_html__( 'Simple Product', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
					array(
						'setting'  => 'product_card_attribute',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
				'priority'    => 75,
			),
			'product_card_attribute_number' => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Product Attribute Number', 'motta' ),
				'default'         => 4,
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
					array(
						'setting'  => 'product_card_attribute',
						'operator' => '!=',
						'value'    => 'none',
					),
				),
				'priority'    => 80,
			),
		);

		if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCFMmp' ) || class_exists( 'Marketkingcore' ) ) {
			$settings['product_card']['product_card_vendor_name'] = array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Vendor Name', 'motta' ),
				'default' => true,
				'priority'    => 42,
			);
		}

		if( function_exists('wcboost_wishlist') ) {
			$settings['product_card']['product_card_wishlist'] = array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Wishlist', 'motta' ),
				'default' => true,
				'priority'    => 42,
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
			);
		}

		if ( function_exists('wcboost_products_compare') ) {
			$settings['product_card']['product_card_compare'] = array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Compare', 'motta' ),
				'default' => true,
				'priority'    => 42,
				'active_callback' => array(
					array(
						'setting'  => 'product_card_layout',
						'operator' => '!=',
						'value'    => '5',
					),
				),
			);

			$columns = [
				'rating'      => esc_html__( 'Rating', 'motta' ),
				'price'       => esc_html__( 'Price', 'motta' ),
				'stock'       => esc_html__( 'Availability', 'motta' ),
				'sku'         => esc_html__( 'SKU', 'motta' ),
				'dimensions'  => esc_html__( 'Dimensions', 'motta' ),
				'weight'      => esc_html__( 'Weight', 'motta' ),
				'add-to-cart' => esc_html__( 'Add To Cart', 'motta' ),
			];

			$columns = array_merge( $columns, $this->get_product_attributes() );
			if( isset( $columns['none'] ) ) {
				unset($columns['none']);
			}
			$settings['compare_page'] = array(
				'compare_page_columns'                => array(
					'type'     => 'multicheck',
					'label'    => esc_html__('Table Columns', 'motta'),
					'default'  => array('rating', 'price', 'stock', 'sku', 'dimensions', 'weight', 'add-to-cart'),
					'choices'  => $columns,
				)
			);
		}

		// Page Header
		$settings['shop_catalog_header'] = array(
			'shop_page_header'                => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Page Header Style', 'motta' ),
				'default' => 'minimal',
				'choices' => array(
					''                => esc_attr__( 'No page header', 'motta' ),
					'standard'        => esc_attr__( 'Standard (image and text)', 'motta' ),
					'minimal'         => esc_attr__( 'Minimal (text only)', 'motta' ),
					'only-breadcrumb' => esc_attr__( 'Only Breadcrumb', 'motta' ),
				),
			),
			'shop_catalog_header_hr_1'        => array(
				'type'            => 'custom',
				'default'         => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'shop_page_header_image'          => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Page Header Image', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'standard',
					),
				),
			),
			'shop_page_header_background_overlay' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background Overlay', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => '',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'standard',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.page-header--standard .page-header__image-overlay',
						'property' => 'background-color',
					),
				),
			),
			'shop_page_header_textcolor_hr'  => array(
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
			'shop_page_header_textcolor'      => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Text Color', 'motta' ),
				'default'         => 'dark',
				'choices'         => array(
					'dark'   => esc_attr__( 'Dark', 'motta' ),
					'light'  => esc_attr__( 'Light', 'motta' ),
					'custom' => esc_attr__( 'Custom', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'standard',
					),
				),
			),
			'shop_page_header_textcolor_custom' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'standard',
					),
					array(
						'setting'  => 'shop_page_header_textcolor',
						'operator' => '==',
						'value'    => 'custom',
					),
				),
				'js_vars'         => array(
					array(
						'element'  => '.page-header--products',
						'property' => '--motta-text-color',
					),
				),

			),
			'shop_page_header_height_hr'  => array(
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
			'shop_page_header_height'         => array(
				'type'            => 'slider',
				'label'           => esc_html__( 'Height', 'motta' ),
				'transport'       => 'postMessage',
				'default'         => 260,
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
			'shop_page_header_title_align'      => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Title Align', 'motta' ),
				'default'         => 'center',
				'choices'         => array(
					'center'   => esc_attr__( 'Center', 'motta' ),
					'left'  => esc_attr__( 'Left', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'shop_page_header',
						'operator' => '==',
						'value'    => 'minimal',
					),
				),
			),
		);

		// Shop Header
		$settings['shop_header'] = array(
			'shop_header'                    => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Shop Header', 'motta' ),
				'default' => false,
			),
			'shop_header_template_id'                       => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Page Template', 'motta' ),
				'default' => '',
				'choices' => \Motta\Helper::customizer_get_posts( array( 'post_type' => 'elementor_library' ) ),
			),
		);

		// Top Categories.
		$settings['shop_top_categories'] = array(
			'top_categories'                    => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Top Categories', 'motta' ),
				'default' => false,
			),
			'top_categories_layout'      => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Layout', 'motta' ),
				'default'         => '1',
				'choices'         => array(
					'1'   => esc_attr__( 'Layout v1', 'motta' ),
					'2'   => esc_attr__( 'Layout v2', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'top_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'top_categories_status_product'         => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Status Product', 'motta' ),
				'default'         => array( 'new', 'sale' ),
				'choices'         => array(
					'new'  => esc_html__( 'New Arrivals', 'motta' ),
					'sale' => esc_html__( 'Sale', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'top_categories',
						'operator' => '==',
						'value'    => true,
					),
					array(
						'setting'  => 'top_categories_layout',
						'operator' => '==',
						'value'    => '1',
					),
				),
			),
			'top_categories_limit' => array(
				'type'            => 'number',
				'label'     	  => esc_html__( 'Limit', 'motta' ),
				'description'     => esc_html__( 'Enter 0 to get all categories. Enter a number to get limit number of top categories.', 'motta' ),
				'default'         => 0,
				'active_callback' => array(
					array(
						'setting'  => 'top_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'top_categories_order' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Order By', 'motta' ),
				'default'         => 'order',
				'choices'         => array(
					'order' => esc_html__( 'Category Order', 'motta' ),
					'name'  => esc_html__( 'Category Name', 'motta' ),
					'id'    => esc_html__( 'Category ID', 'motta' ),
					'count' => esc_html__( 'Product Counts', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'top_categories',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		// Catalog toolbar.
		$settings['taxonomy_description'] = array(
			'taxonomy_description_enable'               => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Taxonomy Description', 'motta' ),
				'default' => true,
			),

			'taxonomy_description_position'      => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Taxonomy Description Position', 'motta' ),
				'description' => esc_html__('This option works with the taxonomy such as product category, tag, brand...', 'motta'),
				'default' => 'above',
				'choices' => array(
					'above' => esc_html__( 'Above the Products', 'motta' ),
					'below' => esc_html__( 'Below the Products', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'taxonomy_description_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'taxonomy_description_html'               => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Taxonomy Description HTML', 'motta' ),
				'description' => esc_html__('Enable this option to allow HTML in the Taxonomy Description', 'motta'),
				'default' => false,
				'active_callback' => array(
					array(
						'setting'  => 'taxonomy_description_enable',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		// Catalog toolbar.
		$settings['shop_catalog_toolbar'] = array(
			'catalog_toolbar'                    => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Catalog Toolbar', 'motta' ),
				'default' => true,
			),
			'catalog_toolbar_layout'      => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Layout', 'motta' ),
				'default'         => '1',
				'choices'         => array(
					'1'   => esc_attr__( 'Layout v1', 'motta' ),
					'2'   => esc_attr__( 'Layout v2', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'catalog_toolbar_list_hr'  => array(
				'type'            => 'custom',
				'default'         => '<hr/>',
			),
			'catalog_toolbar_view'         => array(
				'type'            => 'multicheck',
				'label'           => esc_html__( 'Catalog View', 'motta' ),
				'default'         => array( 'sortby', 'view' ),
				'choices'         => array(
					'sortby'    => esc_html__( 'Sort By', 'motta' ),
					'view'  	=> esc_html__( 'View', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'catalog_toolbar_view_els' => array(
				'type'               => 'multicheck',
				'label'              => esc_html__( 'View', 'motta' ),
				'default'            => array( 'grid-2', 'grid-3', 'grid-4', 'grid-5', 'list' ),
				'choices'            => array(
					'grid-2'       => esc_html__( 'Grid 2 Columns', 'motta' ),
					'grid-3'       => esc_html__( 'Grid 3 Columns', 'motta' ),
					'grid-4'       => esc_html__( 'Grid 4 Columns', 'motta' ),
					'grid-5'       => esc_html__( 'Grid 5 Columns', 'motta' ),
					'list'         => esc_html__( 'List', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
			'catalog_toolbar_default_view' => array(
				'type'               => 'select',
				'label'              => esc_html__( 'Default View', 'motta' ),
				'default'            => 'grid-4',
				'choices'            => array(
					'grid-2'       => esc_html__( 'Grid 2 Columns', 'motta' ),
					'grid-3'       => esc_html__( 'Grid 3 Columns', 'motta' ),
					'grid-4'       => esc_html__( 'Grid 4 Columns', 'motta' ),
					'grid-5'       => esc_html__( 'Grid 5 Columns', 'motta' ),
					'list'       => esc_html__( 'List', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'catalog_toolbar',
						'operator' => '==',
						'value'    => true,
					),
				),
			),
		);

		$settings['shop_catalog'] = array(
			'catalog_sidebar' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sidebar', 'motta' ),
				'description'     => esc_html__( 'Go to appearance > widgets find to catalog sidebar to edit your sidebar', 'motta' ),
				'default'         => 'sidebar-content',
				'choices'         => array(
					'content-sidebar' => esc_html__( 'Right Sidebar', 'motta' ),
					'sidebar-content' => esc_html__( 'Left Sidebar', 'motta' ),
					'no-sidebar'      => esc_html__( 'No Sidebar', 'motta' ),
				),
			),
			'catalog_sticky_sidebar'        => array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Sticky Sidebar', 'motta' ),
				'description' => esc_html__( 'Attachs the sidebar to the page when the user scrolls', 'motta' ),
				'default' => false,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_sidebar',
						'operator' => '!=',
						'value'    => 'no-sidebar',
					),
				),
			),
			'catalog_nav_hr'  => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'catalog_nav'           => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Navigation Type', 'motta' ),
				'default' => 'numeric',
				'choices' => array(
					'numeric'  => esc_attr__( 'Numeric', 'motta' ),
					'infinite' => esc_attr__( 'Infinite Scroll', 'motta' ),
					'loadmore' => esc_attr__( 'Load More', 'motta' ),
				),
			),
			'catalog_nav_ajax_url_change'               => array(
				'type'            => 'checkbox',
				'label'           => esc_html__( 'Change the URL after page loaded', 'motta' ),
				'default'         => true,
				'active_callback' => array(
					array(
						'setting'  => 'catalog_nav',
						'operator' => '!=',
						'value'    => 'numeric',
					),
				),
			),
			'catalog_grid_border_hr'  => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'catalog_grid_border' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Catalog Grid Border', 'motta' ),
				'default'         => '',
				'choices'         => array(
					''                  => esc_html__( 'No Border', 'motta' ),
					'has-border'        => esc_html__( 'Border', 'motta' ),
					'has-border-bottom' => esc_html__( 'Border Bottom Only', 'motta' ),
				),
			),
			'product_description_border_hr'  => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'catalog_product_description'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Description', 'motta' ),
				'default'     => true,
			),
			'catalog_product_description_lines'       => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Description Lines', 'motta' ),
				'description'     => esc_html__( 'This option does not work with the motta_more shortcode', 'motta' ),
				'default'         => 3,
			),
		);

		// Badges
		$settings['badges'] = array(
			'badges_sale'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Sale Badge', 'motta' ),
				'description' => esc_html__( 'Display a badge for sale products.', 'motta' ),
				'default'     => true,
			),
			'badges_sale_type'     => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Sale Badge Type', 'motta' ),
				'default'         => 'percent',
				'choices'         => array(
					'percent'        => esc_html__( 'Percentage', 'motta' ),
					'text'           => esc_html__( 'Text', 'motta' ),
					'text-price'     => esc_html__( 'Text And Price', 'motta' ),
					'text-countdown' => esc_html__( 'Text And Countdown', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'badges_sale',
						'operator' => '=',
						'value'    => true,
					),
				),
			),
			'badges_sale_text'     => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Sale Badge Text', 'motta' ),
				'default'         => esc_attr__( 'Sale', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'badges_sale',
						'operator' => '=',
						'value'    => true,
					),
					array(
						'setting'  => 'badges_sale_type',
						'operator' => '!=',
						'value'    => 'percent',
					),
				),
			),
			'badges_sale_bg'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Sale Badge Background', 'motta' ),
				'default'         => '#ff311c',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_sale',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .onsale',
						'property' => 'background-color',
					),
				),
			),
			'badges_sale_text_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Sale Badge Text Color', 'motta' ),
				'default'         => '#ffffff',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_sale',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .onsale',
						'property' => 'color',
					),
				),
			),
			'badges_hr_2'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'badges_new'           => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'New Badge', 'motta' ),
				'description' => esc_html__( 'Display a badge for new products.', 'motta' ),
				'default'     => true,
			),
			'badges_new_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'New Badge Text', 'motta' ),
				'default'         => esc_attr__( 'New', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'badges_new',
						'operator' => '=',
						'value'    => true,
					),
				),
			),
			'badges_newness'       => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Display the "New" badge for how many days?', 'motta' ),
				'tooltip'         => esc_html__( 'You can also add the NEW badge to each product in the Advanced setting tab of them.', 'motta' ),
				'default'         => 3,
				'active_callback' => array(
					array(
						'setting'  => 'badges_new',
						'operator' => '=',
						'value'    => true,
					),
				),
			),
			'badges_new_bg'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'New Badge Background', 'motta' ),
				'default'         => '#3fb981',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_new',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .new',
						'property' => 'background-color',
					),
				),
			),
			'badges_new_text_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'New Badge Text Color', 'motta' ),
				'default'         => '#ffffff',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_new',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .new',
						'property' => 'color',
					),
				),
			),
			'badges_hr_3'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'badges_featured'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Featured Badge', 'motta' ),
				'description' => esc_html__( 'Display a badge for featured products.', 'motta' ),
				'default'     => true,
			),
			'badges_featured_text' => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Featured Badge Text', 'motta' ),
				'default'         => esc_attr__( 'Hot', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'badges_featured',
						'operator' => '=',
						'value'    => true,
					),
				),
			),
			'badges_featured_bg'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Featured Badge Background', 'motta' ),
				'default'         => '#ff7316',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_featured',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .featured',
						'property' => 'background-color',
					),
				),
			),
			'badges_featured_text_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Featured Badge Text Color', 'motta' ),
				'default'         => '#ffffff',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_featured',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .featured',
						'property' => 'color',
					),
				),
			),
			'badges_hr_4'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'badges_soldout'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Sold Out Badge', 'motta' ),
				'description' => esc_html__( 'Display a badge for out of stock products.', 'motta' ),
				'default'     => false,
			),
			'badges_soldout_text' => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Sold Out Badge Text', 'motta' ),
				'default'         => esc_attr__( 'Out Of Stock', 'motta' ),
				'active_callback' => array(
					array(
						'setting'  => 'badges_soldout',
						'operator' => '=',
						'value'    => true,
					),
				),
			),
			'badges_soldout_bg'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Sold Out Badge Background', 'motta' ),
				'default'         => '#e0e0e0',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_soldout',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .sold-out',
						'property' => 'background-color',
					),
				),
			),
			'badges_soldout_text_color'  => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Sold Out Badge Text Color', 'motta' ),
				'default'         => '#ffffff',
				'choices'     => [
					'alpha' => true,
				],
				'active_callback' => array(
					array(
						'setting'  => 'badges_soldout',
						'operator' => '=',
						'value'    => true,
					),
				),
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .sold-out',
						'property' => 'color',
					),
				),
			),
			'badges_custom_badge'       => array(
				'type'    => 'custom',
				'default' => '<hr/><h3>' . esc_html__( 'Custom Badge', 'motta' ) . '</h3>',
			),

			'badges_custom_bg'    => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Background', 'motta' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .custom',
						'property' => 'background-color',
					),
				),
			),

			'badges_custom_color' => array(
				'type'            => 'color',
				'label'           => esc_html__( 'Color', 'motta' ),
				'default'         => '',
				'transport'       => 'postMessage',
				'js_vars'         => array(
					array(
						'element'  => '.woocommerce-badges .custom ',
						'property' => 'color',
					),
				),
			),

		);

		// Single Product
		$settings['product'] = array(
			'product_layout' => array(
				'type'               => 'select',
				'label'              => esc_html__( 'Product Layout', 'motta' ),
				'default'            => '1',
				'choices'            => array(
					'1'                 => esc_html__( 'Layout v1', 'motta' ),
					'2'                 => esc_html__( 'Layout v2', 'motta' ),
					'3'                 => esc_html__( 'Layout v3', 'motta' ),
					'4'                 => esc_html__( 'Layout v4', 'motta' ),
					'5'                 => esc_html__( 'Layout v5', 'motta' ),
					'6'                 => esc_html__( 'Layout v6', 'motta' ),
				),
			),
			'product_image_zoom_hr'                => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'product_image_zoom'          => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Image Zoom', 'motta' ),
				'description' => esc_html__( 'Zooms in where your cursor is on the image', 'motta' ),
				'default'     => false,
			),
			'product_image_lightbox'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Image Lightbox', 'motta' ),
				'description' => esc_html__( 'Opens your images against a dark backdrop', 'motta' ),
				'default'     => true,
			),
			'product_add_to_cart_ajax' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Add to cart with AJAX', 'motta' ),
				'default'     => true,
				'description' => esc_html__( 'Check this option to enable add to cart with AJAX on the product page.', 'motta' ),
			),
			'product_product_deal_hr'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'product_sale_type'         => array(
				'type'            => 'radio',
				'label'           => esc_html__( 'Product Deal Type', 'motta' ),
				'default'         => 'text',
				'choices'         => array(
					'text'    => esc_html__( 'Text', 'motta' ),
					'countdown'  => esc_html__( 'Countdown', 'motta' ),
				),
			),
			'product_sale_image' => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Background Image', 'motta' ),
				'default'         => get_theme_file_uri( '/images/bg-deal.jpg' ),
				'js_vars'   => array(
					array(
						'element'  => '.motta-single-product-sale',
						'property' => 'background-image',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_sale_type',
						'operator' => '==',
						'value'    => 'countdown',
					),
				),
			),
			'product_sale_bgcolor' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Background Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-single-product-sale',
						'property' => 'background-color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_sale_type',
						'operator' => '==',
						'value'    => 'countdown',
					),
				),
			),
			'product_sale_textcolor' => array(
				'type'    => 'color',
				'label'   => esc_html__( 'Text Color', 'motta' ),
				'default'   => '',
				'transport' => 'postMessage',
				'js_vars'   => array(
					array(
						'element'  => '.motta-single-product-sale',
						'property' => 'color',
					),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_sale_type',
						'operator' => '==',
						'value'    => 'countdown',
					),
				),
			),
			'product_taxonomy_hr'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'product_taxonomy'               => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Product Taxonomy', 'motta' ),
				'default'         => 'product_cat',
				'choices'         => array(
					'product_cat'   => esc_html__( 'Category', 'motta' ),
					''              => esc_html__( 'None', 'motta' ),
					'product_brand' => esc_html__( 'Brand', 'motta' ),
				),
			),
			'product_tabs_hr'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array('3', '5'),
					),
				),

			),
			'product_tabs_status'           => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Product Tabs Status', 'motta' ),
				'default' => 'close',
				'choices' => array(
					'close' => esc_html__( 'Close all tabs', 'motta' ),
					'first' => esc_html__( 'Open first tab', 'motta' ),
				)
			),
			'product_tags_hr'          => array(
				'type'    => 'custom',
				'default' => '<hr>',
			),
			'product_description'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Description', 'motta' ),
				'default'     => false,
			),
			'product_description_lines'       => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Product Description Lines', 'motta' ),
				'description'     => esc_html__( 'This option does not work with the motta_more shortcode', 'motta' ),
				'default'         => 6,
			),
			'product_single_tags'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Tags', 'motta' ),
				'default'     => false,
			),
			'product_single_categories'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Categories', 'motta' ),
				'default'     => false,
			),
			'product_side_products_hr'                => array(
				'type'    => 'custom',
				'default' => '<hr>',
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array( '4', '6' ),
					),
				),
			),
			'product_side_products_enable'      => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Side Products', 'motta' ),
				'default'     => true,
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array( '6' ),
					),
				),
			),
			'product_side_products'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Side Products Source', 'motta' ),
				'description'     => esc_html__( 'Display recommended products on the right side', 'motta' ),
				'default'         => 'best_selling_products',
				'choices'         => array(
					'best_selling_products' => esc_html__( 'Best selling products', 'motta' ),
					'featured_products'     => esc_html__( 'Featured products', 'motta' ),
					'related_products'      => esc_html__( 'Related products', 'motta' ),
					'recent_products'       => esc_html__( 'Recent products', 'motta' ),
					'sale_products'         => esc_html__( 'Sale products', 'motta' ),
					'top_rated_products'    => esc_html__( 'Top rated products', 'motta' ),
				),
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array( '4', '6' ),
					),
				),
			),
			'product_side_products_limit' => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Number of products', 'motta' ),
				'default'         => 5,
				'active_callback' => array(
					array(
						'setting'  => 'product_layout',
						'operator' => 'in',
						'value'    => array( '4', '6' ),
					),
				),
			),
		);

		$settings['product_sharing']= array(
			'product_sharing'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Product Sharing', 'motta' ),
				'description' => esc_html__( 'Enable post sharing.', 'motta' ),
				'default'     => true,
			),
		);

		$settings['related_products']= array(
			'related_products'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Related Products', 'motta' ),
				'default'     => true,
			),
			'related_products_by_cats'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'By Categories', 'motta' ),
				'default'     => true,
			),
			'related_products_by_tags'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'By Tags', 'motta' ),
				'default'     => true,
			),
			'related_products_numbers' => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Numbers', 'motta' ),
				'default'         => 10,
			),
		);

		$settings['upsells_products']= array(
			'upsells_products'         => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Upsells Products', 'motta' ),
				'default'     => true,
			),
			'upsells_products_numbers' => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Numbers', 'motta' ),
				'default'         => 10,
			),
		);

		// vendor Store List
		if ( class_exists( 'WeDevs_Dokan' ) || class_exists( 'WCFMmp' ) ) {
			$settings['vendors_store_list']['store_list_page_header'] = array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Page Header Elements', 'motta'),
				'default'  => array('breadcrumb'),
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'motta'),
					'title'      => esc_html__('Title', 'motta'),
				),
			);

			$settings['vendors_store_page']['store_page_page_header'] = array(
				'type'     => 'multicheck',
				'label'    => esc_html__('Page Header Elements', 'motta'),
				'default'  => array('breadcrumb'),
				'choices'  => array(
					'breadcrumb' => esc_html__('BreadCrumb', 'motta'),
					'title'      => esc_html__('Title', 'motta'),
				),
			);
		}

		if ( class_exists( 'WCFMmp' ) ) {
			$settings['vendors_store_style']['vendor_store_style_theme'] = array(
				'type'    => 'toggle',
				'label'   => esc_html__( 'Enable Style From Theme', 'motta' ),
				'description' => esc_html__( 'Enable the store list and store page style from theme.', 'motta' ),
				'default' => true,
			);

			$settings['vendors_store_manager']['wcfm_dashboard_custom_fields'] = array(
				'type'    => 'multicheck',
				'label'    => esc_html__( 'Custom Fields', 'motta' ),
				'default'  => array(),
				'choices'  => array(
					'video' => esc_html__( 'Product Video', 'motta' ),
				),
			);
		}

		if ( class_exists( 'WeDevs_Dokan' ) ) {
			$settings['vendors_product_page']['product_tab_vendor_info'] = array(
				'type'     => 'toggle',
				'label'    => esc_html__('Hide Vendor Info tab', 'motta'),
				'default' => true,
			);

			$settings['vendors_product_page']['product_tab_more_products'] = array(
				'type'     => 'toggle',
				'label'    => esc_html__('Hide More Product tab', 'motta'),
				'default' => true,
			);
		}


		// Product Notifications
		$settings['product_notifications'] = array(
			'added_to_cart_notice'                => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Added to Cart Notice', 'motta' ),
				'description' => esc_html__( 'Display a notification when a product is added to cart.', 'motta' ),
				'default'     => 'none',
				'choices'     => array(
					'mini'  => esc_html__( 'Open mini cart', 'motta' ),
					'popup' => esc_html__( 'Open cart popup', 'motta' ),
					'none'  => esc_html__( 'None', 'motta' ),
				),
			),

			'added_to_cart_notice_products'       => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Recommended Products', 'motta' ),
				'description'     => esc_html__( 'Display recommended products on the cart popup', 'motta' ),
				'default'         => 'related_products',
				'choices'         => array(
					'none'                  => esc_html__( 'None', 'motta' ),
					'best_selling_products' => esc_html__( 'Best selling products', 'motta' ),
					'featured_products'     => esc_html__( 'Featured products', 'motta' ),
					'recent_products'       => esc_html__( 'Recent products', 'motta' ),
					'sale_products'         => esc_html__( 'Sale products', 'motta' ),
					'top_rated_products'    => esc_html__( 'Top rated products', 'motta' ),
					'related_products'      => esc_html__( 'Related products', 'motta' ),
					'upsells_products'      => esc_html__( 'Upsells products', 'motta' ),

				),
				'active_callback' => array(
					array(
						'setting'  => 'added_to_cart_notice',
						'operator' => '==',
						'value'    => 'popup',
					),
				),
			),
			'added_to_cart_notice_products_limit' => array(
				'type'            => 'number',
				'description'     => esc_html__( 'Number of products', 'motta' ),
				'default'         => 8,
				'active_callback' => array(
					array(
						'setting'  => 'added_to_cart_notice',
						'operator' => '==',
						'value'    => 'popup',
					),
				),
			),
			'added_to_wishlist_custom'                 => array(
				'type'     => 'custom',
				'default'  => '<hr/>',
			),
			'added_to_wishlist_notice' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Added to Wishlist Notification', 'motta' ),
				'description' => esc_html__( 'Display a notification when a product is added to wishlist', 'motta' ),
				'section'     => 'product_notifications',
				'default'     => 0,
			),

			'wishlist_notice_auto_hide'   => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Wishlist Notification Auto Hide', 'motta' ),
				'description'     => esc_html__( 'How many seconds you want to hide the notification.', 'motta' ),
				'section'         => 'product_notifications',
				'active_callback' => array(
					array(
						'setting'  => 'added_to_wishlist_notice',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'default'         => 3,
			),
			'added_to_compare_custom'                 => array(
				'type'     => 'custom',
				'default'  => '<hr/>',
			),
			'added_to_compare_notice' => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Added to Compare Notification', 'motta' ),
				'description' => esc_html__( 'Display a notification when a product is added to compare', 'motta' ),
				'section'     => 'product_notifications',
				'default'     => 0,
			),

			'compare_notice_auto_hide'   => array(
				'type'            => 'number',
				'label'           => esc_html__( 'Compare Notification Auto Hide', 'motta' ),
				'description'     => esc_html__( 'How many seconds you want to hide the notification.', 'motta' ),
				'section'         => 'product_notifications',
				'active_callback' => array(
					array(
						'setting'  => 'added_to_compare_notice',
						'operator' => '==',
						'value'    => 1,
					),
				),
				'default'         => 3,
			),
		);

		// Not Log In
		$settings['sign_in'] = array(
			'header_sign_in_logo_type'      => array(
				'type'    => 'radio',
				'label'   => esc_html__( 'Logo Type', 'motta' ),
				'default' => 'default',
				'choices' => array(
					'default' => esc_html__( 'Image', 'motta' ),
					'image' => esc_html__( 'Image', 'motta' ),
					'text'  => esc_html__( 'Text', 'motta' ),
					'svg'   => esc_html__( 'SVG', 'motta' ),
				),
			),
			'header_sign_in_logo_text'      => array(
				'type'            => 'text',
				'label'           => esc_html__( 'Logo Text', 'motta' ),
				'default'         => get_bloginfo( 'name' ),
				'active_callback' => array(
					array(
						'setting'  => 'header_sign_in_logo_type',
						'operator' => '==',
						'value'    => 'text',
					),
				),
			),
			'header_sign_in_logo_svg'       => array(
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
						'setting'  => 'header_sign_in_logo_type',
						'operator' => '==',
						'value'    => 'svg',
					),
				),
			),
			'header_sign_in_logo'           => array(
				'type'            => 'image',
				'label'           => esc_html__( 'Logo Image', 'motta' ),
				'default'         => '',
				'active_callback' => array(
					array(
						'setting'  => 'header_sign_in_logo_type',
						'operator' => '==',
						'value'    => 'image',
					),
				),
			),
			'header_sign_in_logo_dimension' => array(
				'type'            => 'dimensions',
				'label'           => esc_html__( 'Logo Dimension', 'motta' ),
				'default'         => array(
					'width'  => '',
					'height' => '',
				),
				'active_callback' => array(
					array(
						'setting'  => 'header_sign_in_logo_type',
						'operator' => '!=',
						'value'    => 'text',
					),
				),
			),
			'not_log_in_footer_layout_custom'                 => array(
				'type'     => 'custom',
				'default'  => '<hr/>',
			),
			'not_log_in_footer_layout' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Footer Layout', 'motta' ),
				'choices'         => \Motta\Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
			'not_log_in_footer_mobile' => array(
				'type'            => 'select',
				'label'           => esc_html__( 'Mobile Footer', 'motta' ),
				'choices'         => \Motta\Helper::customizer_get_posts( array( 'post_type' => 'motta_footer' ) ),
			),
		);

		return $settings;
	}

	/**
	* Get product attributes
	*
	* @return string
	*/
	public function get_product_attributes() {
		$output = array();
		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$attributes_tax = wc_get_attribute_taxonomies();
			if ( $attributes_tax ) {
				$output['none'] = esc_html__( 'None', 'motta' );

				foreach ( $attributes_tax as $attribute ) {
					$output[$attribute->attribute_name] = ucfirst($attribute->attribute_label);
				}

			}
		}

		return $output;
	}

}
