<?php
/**
 * Hooks of Compare.
 *
 * @package Motta
 */

namespace Motta\WooCommerce;

use \Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of QuickView template.
 */
class Compare {
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
		add_filter( 'wcboost_products_compare_button_template_args', array( $this, 'products_compare_button_template_args' ), 10, 2 );
		add_filter( 'wcboost_products_compare_add_to_compare_fragments', array( $this, 'products_compare_add_to_compare_fragments' ), 10, 1 );
		add_filter( 'wcboost_products_compare_single_add_to_compare_link', array( $this, 'add_to_compare_link' ), 20, 2 );
		add_filter('wcboost_products_compare_loop_add_to_compare_link', array( $this, 'add_to_compare_link' ), 20, 2 );
		if( apply_filters( 'motta_change_compare_button_settings', true ) ) {
			add_filter('wcboost_products_compare_button_add_text', array( $this, 'compare_button_add_text' ) );
			add_filter('wcboost_products_compare_button_remove_text', array( $this, 'compare_button_remove_text' ) );
			add_filter('wcboost_products_compare_button_view_text', array( $this, 'compare_button_view_text' ) );
		}
		// Compare button.
		$compare = \WCBoost\ProductsCompare\Frontend::instance();
		remove_action( 'woocommerce_after_add_to_cart_form', [ $compare, 'single_add_to_compare_button' ] );
		remove_action( 'woocommerce_after_shop_loop_item', [ $compare, 'loop_add_to_compare_button' ], 15 );

		add_filter('wcboost_products_compare_fields', array( $this, 'products_compare_fields' ) );
		add_action('wcboost_products_compare_custom_field', array( $this, 'products_compare_custom_field' ), 20, 3 );

		add_action( 'customize_register', [ $this, 'register' ], 20 );
	}


	/**
	 * Show button compare.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function products_compare_button_template_args( $args, $product ) {
		$args['class'][] = 'motta-button motta-button--text';

		switch ( get_option( 'wcboost_products_compare_exists_item_button_behaviour', 'remove' ) ) {
			case 'remove':
				$args['class'][] = 'motta-button-compare--remove';
				break;

			case 'view':
				$args['class'][] = 'motta-button-compare--view';
				break;

			case 'popup':
				$args['class'][] = 'motta-button-compare--view';
				break;
		}

		$args['product_title'] = $product->get_title();

		return $args;
	}

	/**
	 * Ajaxify update count compare
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public static function products_compare_add_to_compare_fragments( $data ) {
		$compare_counter = intval(\WCBoost\ProductsCompare\Plugin::instance()->list->count_items());
		$compare_class = $compare_counter == 0 ? ' hidden' : '';
		$data['.header-compare .header-compare__counter'] = '<span class="header-counter header-compare__counter' . $compare_class . '">'. $compare_counter . '</span>';
		$data['.motta-mobile-navigation-bar__icon .compare-counter'] = '<span class="counter compare-counter' . $compare_class . '">'. $compare_counter . '</span>';

		return $data;
	}


	/**
	 * Update compare text
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function compare_button_add_text() {
		return esc_html__('Compare', 'motta');
	}

	/**
	 * Update compare text
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function compare_button_remove_text() {
		return esc_html__('Remove', 'motta');
	}

	/**
	 * Update compare text
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function compare_button_view_text() {
		return esc_html__('Browse', 'motta');
	}


	/**
	 * Change compare link
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_to_compare_link($html, $args) {
		global $product;
		return sprintf(
			'<a href="%s" data-product_id="%s" data-product_title="%s" class="%s" aria-label="%s" role="button">
				%s
				<span class="wcboost-products-compare-button__text" data-add="%s" data-remove="%s" data-view="%s">%s</span>
			</a>',
			esc_url( isset( $args['url'] ) ? $args['url'] : add_query_arg( [ 'add-to-compare' => $product->get_id() ] ) ),
			esc_attr( isset( $args['product_id'] ) ? $args['product_id'] : $product->get_id() ),
			esc_attr( isset( $args['product_title'] ) ? $args['product_title'] : $product->get_title() ),
			esc_attr( isset( $args['class'] ) ? $args['class'] : 'wcboost-products-compare-button wcboost-products-compare-button--loop motta-button motta-button--text' ),
			esc_attr( isset( $args['aria-label'] ) ? $args['aria-label'] : sprintf( __( 'Compare %s', 'motta' ), '&ldquo;' . $product->get_title() . '&rdquo;' ) ),
			'<span class="wcboost-products-compare-button__icon">' . \Motta\Icon::get_svg( 'compare' ) . '</span>',
			esc_attr__('Add To Compare', 'motta'),
			esc_attr__('Remove Compare', 'motta'),
			esc_attr__('Browse Compare', 'motta'),
			esc_html( isset( $args['label'] ) ? $args['label'] : __( 'Compare', 'motta' ) )
		);
	}

	public function products_compare_fields($fields) {
		$options = (array) Helper::get_option('compare_page_columns');
		$fields = $this->get_default_compare_fields($fields, $options);
		$attributes = $this->attribute_taxonomies($options);

		if( $attributes ) {
			if( isset($fields['add-to-cart']) ) {
				unset( $fields['add-to-cart'] );
			}
			if(in_array( 'add-to-cart', $options ) ) {
				$attributes['add-to-cart'] = '';
			}
			$fields = array_merge( $fields, $attributes );
		}

		return $fields;
	}

	private function get_default_compare_fields($fields, $options) {
		$default_columns = [
			'rating'      => esc_html__( 'Rating', 'motta' ),
			'price'       => esc_html__( 'Price', 'motta' ),
			'stock'       => esc_html__( 'Availability', 'motta' ),
			'sku'         => esc_html__( 'SKU', 'motta' ),
			'dimensions'  => esc_html__( 'Dimensions', 'motta' ),
			'weight'      => esc_html__( 'Weight', 'motta' ),
			'add-to-cart' => esc_html__( 'Add To Cart', 'motta' ),
		];

		foreach( $default_columns as $key => $name ){
			if (isset($fields[$key]) && !  in_array( $key, $options )) {
				unset($fields[$key]);
			}
		}

		if( isset($fields['attributes']) ) {
			unset( $fields['attributes'] );
		}

		return $fields;

	}

	/**
	 * Get Woocommerce Attribute Taxonomies
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function attribute_taxonomies($options) {

		$attributes = array();

		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( empty( $attribute_taxonomies ) ) {
			return array();
		}
		foreach ( $attribute_taxonomies as $attribute ) {
			$tax_name =  $attribute->attribute_name;
			$tax = wc_attribute_taxonomy_name( $tax_name );

			if ( taxonomy_exists( $tax ) && in_array( $tax_name, $options ) ) {
				$attributes[ $tax ] = ucfirst( $attribute->attribute_label );
			}
		}


		return $attributes;
	}

	public function products_compare_custom_field($field, $product, $key) {
		if ( taxonomy_exists( $field ) ) {
			$attributes = array();
			$terms                     = get_the_terms( $product->get_id(), $field );
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$term                        = sanitize_term( $term, $field );
					$attributes[] = $term->name;
				}
			}
			echo implode( ', ', $attributes );
		}
	}

}
