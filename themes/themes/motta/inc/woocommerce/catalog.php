<?php
/**
 * Catalog hooks.
 *
 * @package Motta
 */

namespace Motta\WooCommerce;

use \Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Catalog
 */
class Catalog {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * @var string catalog view
	 */
	public static $catalog_view;

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
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'motta_wp_script_data', array( $this, 'catalog_script_data' ), 10, 3 );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 20 );

		// Page Header
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		add_filter( 'motta_page_header_classes', array( $this, 'page_header_classes' ) );
		add_action( 'motta_page_header_content', array( $this, 'background_image' ), 5 );
		add_filter( 'motta_get_default_page_header_elements', array( $this, 'page_header_elements' ) );

		// Remove shop loop header
		remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);

		// Shop Header
		if(  Helper::get_option( 'shop_header' ) ) {
			add_action( 'motta_after_site_content_open', array( $this, 'motta_shop_header_template' ), 10 );
		}

		// Filter Sidebar
		if( Helper::get_option( 'catalog_toolbar_layout' ) == '2' ) {
			add_action( 'wp_footer', array( $this, 'filter_sidebar' ) );
		}

		// Sidebar
		add_filter( 'motta_site_layout', array( $this, 'layout' ), 55 );
		add_filter('motta_get_sidebar', array( $this, 'sidebar' ), 20 );
		add_action( 'dynamic_sidebar_before', array( $this, 'catalog_sidebar_before_content' ) );
		add_action( 'dynamic_sidebar_after', array( $this, 'catalog_sidebar_after_content' ) );

		// Top Categories
		if ( Helper::get_option( 'top_categories' ) ) {
			add_action( 'motta_after_site_content_open', array( $this, 'top_categories' ), 10 );
		}

		// Catalog Toolbar
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		// Catalog Toolbar
		if ( Helper::get_option( 'catalog_toolbar' ) ) {
			add_action( 'woocommerce_before_shop_loop', array( $this, 'catalog_toolbar' ), 40 );
		}

		add_action( 'motta_woocommerce_before_products_toolbar', array( $this, 'result_count' ), 10 );

		add_filter( 'woocommerce_catalog_orderby', array( $this, 'catalog_orderby' ) );

		add_action( 'wp_footer', array( $this, 'orderby_list' ) );


		if( Helper::get_option( 'catalog_toolbar_layout' ) == '1' ) {
			if( in_array( 'sortby', ( array ) Helper::get_option( 'catalog_toolbar_view' ) ) ) {
				add_action( 'motta_woocommerce_products_toolbar', array( $this, 'tablet_catalog_filter_button' ), 10 );
				add_action( 'motta_woocommerce_products_toolbar', array( $this, 'ordering_label' ), 15 );
				add_action( 'motta_woocommerce_products_toolbar', 'woocommerce_catalog_ordering', 20 );
			}

			add_action( 'motta_woocommerce_before_products_toolbar', array( $this, 'mobile_catalog_toolbar' ), 5 );

		} else {
			add_action( 'motta_woocommerce_products_toolbar_top', array( $this, 'button_filters' ), 5 );
			add_action( 'motta_woocommerce_after_products_toolbar_top', array( $this, 'filters_actived' ) );
			add_action( 'motta_woocommerce_products_toolbar_top', array( $this, 'mobile_catalog_toolbar_sortby' ) );

			if( in_array( 'sortby', ( array ) Helper::get_option( 'catalog_toolbar_view' ) ) ) {
				add_action( 'motta_woocommerce_products_toolbar_top', array( $this, 'open_catalog_order' ), 80 );
				add_action( 'motta_woocommerce_products_toolbar_top', array( $this, 'ordering_label' ), 85 );
				add_action( 'motta_woocommerce_products_toolbar_top', 'woocommerce_catalog_ordering', 90 );
				add_action( 'motta_woocommerce_products_toolbar_top', array( $this, 'close_catalog_order' ), 95 );
			}
		}

		if( in_array( 'view', ( array ) Helper::get_option( 'catalog_toolbar_view' ) ) ) {
			add_action( 'motta_woocommerce_products_toolbar', array( $this, 'toolbar_view' ), 40 );
		}

		add_action( 'template_redirect', array( $this, 'motta_template_redirect' ) );

		add_filter( 'loop_shop_columns', array( $this, 'catalog_column' ) );

		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
		add_action( 'woocommerce_after_shop_loop', array( $this, 'pagination' ) );

		add_filter('next_posts_link_attributes', array( $this, 'posts_link_attributes') );

		add_filter( 'wcboost_wishlist_button_view_text',	array( $this, 'wishlist_button_view_text' ) );

		if ( intval( Helper::get_option( 'taxonomy_description_enable' ) )) {
			if ( Helper::get_option( 'taxonomy_description_position' ) == 'below' ) {
				add_action( 'motta_before_open_site_footer', array( $this, 'shop_description' ), 100 );
			} else {
				add_action( 'motta_after_header', array( $this, 'shop_description' ), 100 );
			}
		}

		// Allow HTML in taxonomy desc
		if ( intval( Helper::get_option( 'taxonomy_description_html' ) )) {
			remove_filter( 'pre_term_description', 'wp_filter_kses' );
			remove_filter( 'term_description', 'wp_kses_data' );
		}
	}

	/**
	 * Add 'woocommerce-active' class to the body tag.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $classes CSS classes applied to the body tag.
	 *
	 * @return array $classes modified to include 'woocommerce-active' class.
	 */
	public function body_class( $classes ) {
		$classes[] = 'motta-catalog-page';

		$catalog_view   = isset( $_COOKIE['catalog_view'] ) ? $_COOKIE['catalog_view'] : get_option( 'woocommerce_catalog_columns', 4 );

		$classes[] = 'catalog-view-' . apply_filters( 'motta_catalog_view', $catalog_view );

		if( ! empty( Helper::get_option( 'catalog_grid_border' ) ) ) {
			$classes[] = 'catalog-grid--' . Helper::get_option( 'catalog_grid_border' );
		}

		if ( Helper::get_option( 'catalog_toolbar_sticky' ) && Helper::get_option( 'mobile_navigation_bar' ) !== 'standard' ) {
			$classes[] = 'catalog-toolbar-sticky';
		}

		return $classes;
	}

	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function scripts() {
		if ( wp_style_is( 'select2', 'registered' ) ) {
			wp_enqueue_style( 'select2' );
		}

		if ( wp_script_is( 'select2', 'registered' ) ) {
			wp_enqueue_script( 'select2' );
		}

		wp_register_script( 'sticky-kit', get_template_directory_uri() . '/assets/js/plugins/sticky-kit.min.js', array( 'jquery' ), '1.1.3', true );

		if( Helper::get_option('catalog_sticky_sidebar') ) {
			wp_enqueue_script('sticky-kit');
		}

		wp_enqueue_script( 'motta-product-catalog', get_template_directory_uri() . '/assets/js/woocommerce/product-catalog.js', array(
			'motta',
		), '20240622', true );
	}

	/**
	 * Catalog script data.
	 *
	 * @since 1.0.0
	 *
	 * @param $data
	 *
	 * @return array
	 */
	public function catalog_script_data( $data ) {
		$data['catalog_toolbar_layout']   = Helper::get_option( 'catalog_toolbar_layout' );
		$data['shop_nav_ajax_url_change'] = Helper::get_option( 'catalog_nav_ajax_url_change' );
		$data['top_categories_layout']    = Helper::get_option( 'top_categories_layout' );

		return $data;
	}

	/**
	 * Layout
	 *
	 * @return string
	 */
	public function layout( $layout ) {
		if( ! is_active_sidebar( 'catalog-sidebar' ) ){
			return;
		}

		$layout = Helper::get_option( 'catalog_sidebar' );

		return $layout;
	}

	/**
	 * Get Sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function sidebar() {
		if ( Helper::get_option( 'catalog_sidebar' ) == 'no-sidebar' ) {
			return false;
		}

		return true;
	}

	/**
	 * Add modal content before Widget Content
	 *
	 * @since 1.0.0
	 *
	 * @param $index
	 *
	 * @return void
	 */
	public function catalog_sidebar_before_content( $index ) {
		if ( is_admin() ) {
			return;
		}

		if ( $index != 'catalog-sidebar' ) {
			return;
		}

		if ( ! apply_filters( 'motta_get_catalog_sidebar_before_content', true ) ) {
			return;
		}

		?>
        <div class="sidebar__backdrop"></div>
        <div class="sidebar__container">
		<?php echo \Motta\Icon::get_svg( 'close', 'ui', 'class=panel__button-close' ); ?>
		<div class="sidebar__header">
			<?php echo esc_html__( 'Filter & Sort', 'motta' ); ?>
		</div>
		<div class="sidebar__content">
		<?php

	}

	/**
	 * Change catalog sidebar after content
	 *
	 * @since 1.0.0
	 *
	 * @param $index
	 *
	 * @return void
	 */
	public function catalog_sidebar_after_content( $index ) {
		if ( is_admin() ) {
			return;
		}

		if ( $index != 'catalog-sidebar' ) {
			return;
		}

		if ( ! apply_filters( 'motta_get_catalog_sidebar_before_content', true ) ) {
			return;
		}

		?>
        </div>
        </div>
		<?php

	}

	/**
	 * Page Header Class
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function page_header_classes($classes) {
		$classes .= ' page-header--products';
		$classes .= ' page-header--' . Helper::get_option( 'shop_page_header' );

		if ( 'standard' == Helper::get_option( 'shop_page_header' ) ) {
			$page_header_textcolor          = Helper::get_option( 'shop_page_header_textcolor' );

			if ( is_product_taxonomy() ) {
				$term_id  = get_queried_object_id();
				$motta_page_header_textcolor                  = get_term_meta( $term_id, 'motta_page_header_textcolor', true );

				if ( $motta_page_header_textcolor ) {
					$page_header_textcolor = $motta_page_header_textcolor;
				}
			}

			$classes .= ' page-header--text-' . $page_header_textcolor;
		}

		if ( 'minimal' == Helper::get_option( 'shop_page_header' ) ) {
			$classes .= ' page-header--' . Helper::get_option( 'shop_page_header_title_align' );
		}

		return $classes;
	}

	/**
	 * Show background image
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function background_image() {
		if ( 'standard' == Helper::get_option( 'shop_page_header' ) ) {
			$background_image           = ! empty ( Helper::get_option( 'shop_page_header_image' ) ) ? Helper::get_option( 'shop_page_header_image' ) : '';
			$background_overlay         = ! empty ( Helper::get_option( 'shop_page_header_background_overlay' ) ) ? Helper::get_option( 'shop_page_header_background_overlay' ) : '';
			$background_overlay_opacity = '';

			if ( is_product_taxonomy() ) {
				$term_id  = get_queried_object_id();
				$image_id                                     = absint( get_term_meta( $term_id, 'motta_page_header_bg_id', true ) );
				$motta_page_header_background_overlay         = get_term_meta( $term_id, 'motta_page_header_background_overlay', true );
				$motta_page_header_background_overlay_opacity = get_term_meta( $term_id, 'motta_page_header_background_overlay_opacity', true );

				if ( $image_id ) {
					$image             = wp_get_attachment_image_src( $image_id, 'full' );
					$background_image = $image ? $image[0] : $background_image;
				}

				if ( $motta_page_header_background_overlay ) {
					$background_overlay = $motta_page_header_background_overlay;
				}

				if( $motta_page_header_background_overlay_opacity ) {
					$background_overlay_opacity = 'opacity: ' . esc_attr( $motta_page_header_background_overlay_opacity ) . ';';
				}
			}

			?>
			<div class="page-header__image" style="background-image: url(<?php echo esc_url( $background_image ); ?>);">
				<?php if ( ! empty( $background_overlay ) ) : ?>
					<div class="page-header__image-overlay" style="background-color: <?php echo esc_attr( $background_overlay ); ?>; <?php echo esc_attr( $background_overlay_opacity ); ?>"></div>
				<?php endif; ?>
			</div>
			<?php
		}
	}

	/**
	 * Get description
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function description($description) {
		ob_start();
		if( function_exists('is_shop') && is_shop() ) {
			woocommerce_product_archive_description();
		}

		$description = ob_get_clean();

		if ( is_tax() ) {
			$term = get_queried_object();
			if ( $term ) {
				$description = $term->description;
			}
		}

		if( $description ) {
			return '<div class="page-header__description">'. $description .'</div>';
		}
	}

	/**
	 * Check is shop
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function is_shop() {
		if( function_exists('is_product_category') && is_product_category() ) {
			return false;
		} elseif( function_exists('is_shop') && is_shop() ) {
			if ( ! empty( $_GET ) && ( isset($_GET['product_cat']) )) {
				return false;
			}

			return true;
		}

		return true;
	}

	/**
	 * Products header.
	 *
	 *  @return void
	 */
	public function page_header_elements( $items ) {
		if( empty( Helper::get_option( 'shop_page_header' ) ) ) {
			return false;
		}

		$items = [ 'breadcrumb', 'title' ];

		return $items;
	}

	/**
	 * Change shop header template
	 *
	 * @return void
	 */
	public function motta_shop_header_template() {
		$template_id = Helper::get_option( 'shop_header_template_id' );

		if ( is_product_taxonomy() ) {
			$term_id  = get_queried_object_id();

			if ( get_term_meta( $term_id, 'motta_shop_header_template', true ) !== '0' ) {
				$template_id  = get_term_meta( $term_id, 'motta_shop_header_template', true );
			}
		}

		if( empty( $template_id ) ) {
			return;
		}

		if ( class_exists( 'Elementor\Plugin' ) ) {
			$elementor_instance = \Elementor\Plugin::instance();
			echo !empty($elementor_instance) ? '<div class="shop-header">' . $elementor_instance->frontend->get_builder_content_for_display( $template_id ) . '</div>' : '';
		}
	}

	/**
	 * Show top categories
	 *
	 * @return void
	 */
	public function top_categories() {
		if( is_search() ) {
			return;
		}

		$queried        = get_queried_object();
		$current_term   = ! empty ( $queried->term_id ) ? $queried->term_id : '';
		$base_url       = is_shop() ? wc_get_page_permalink( 'shop' ) : get_term_link( $current_term );
		$status_product = (array) Helper::get_option( 'top_categories_status_product' );
		$orderby 		= Helper::get_option( 'top_categories_order' );
		$limit			= Helper::get_option( 'top_categories_limit' );
		$ouput          = [];

		if( $this->is_shop() ) {
			$args = array(
				'taxonomy' => 'product_cat',
				'parent'   => 0,
			);

		} else {
			$termchildren  = get_term_children( $queried->term_id, $queried->taxonomy );

			$args = array(
				'taxonomy' => $queried->taxonomy,
			);

			if( ! empty( $termchildren ) ) {
				$args['parent'] = $queried->term_id;

				if( count( $termchildren ) == 1 ) {
					$term = get_term_by( 'id', $termchildren[0], $queried->taxonomy );

					if( $term->count == 0 ) {
						$args['parent'] = $queried->parent;
					}
				}

			} else {
				$args['parent'] = $queried->parent;
			}
		}

		if ( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;

			if ( $orderby == 'order' ) {
				$args['menu_order'] = 'asc';
			} else {
				if ( $orderby == 'count' ) {
					$args['order'] = 'desc';
				}
			}
		}

		if( ! empty ( $limit ) && $limit !== '0' ) {
			$args['number'] =  Helper::get_option( 'top_categories_limit' );
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || ! $terms ) {
			return;
		}

		$ouput[] = sprintf(
				'<a class="catalog-top-categories__item %s" href="%s">
					<span class="catalog-top-categories__image all text">%s</span>
					<span class="catalog-top-categories__text">%s</span>
				</a>',
				( is_shop() && empty( $_GET['orderby'] ) && empty( $_GET['on_sale'] ) ) ? 'active' : '',
				esc_url( wc_get_page_permalink( 'shop' ) ),
				esc_html__( 'All', 'motta' ),
				esc_html__( 'Shop All', 'motta' )
			);

		if( in_array( 'new', $status_product ) && Helper::get_option( 'top_categories_layout' ) == '1' ) {
			$ouput[] = sprintf(
					'<a class="catalog-top-categories__item %s" href="%s">
						<span class="catalog-top-categories__image new text">%s</span>
						<span class="catalog-top-categories__text">%s</span>
					</a>',
					! empty( $_GET['orderby'] ) ? 'active' : '',
					esc_url( $base_url ) . '?orderby=date',
					esc_html__( 'New', 'motta' ),
					esc_html__( 'New Arrivals', 'motta' )
				);
		}

		if( in_array( 'sale', $status_product ) && Helper::get_option( 'top_categories_layout' ) == '1' ) {
			$ouput[] = sprintf(
					'<a class="catalog-top-categories__item %s" href="%s">
						<span class="catalog-top-categories__image sale text">%s</span>
						<span class="catalog-top-categories__text">%s</span>
					</a>',
					! empty( $_GET['on_sale'] ) ? 'active' : '',
					esc_url( $base_url ) . '?on_sale=1',
					esc_html__( 'Sale', 'motta' ),
					esc_html__( 'Sale', 'motta' )
				);
		}

		$thumbnail_size = apply_filters( 'motta_top_categories_thumbnail_size', 'thumbnail' );

		foreach( $terms as $term ) {
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$images = ! empty( wp_get_attachment_image_src( $thumb_id, $thumbnail_size ) ) ? wp_get_attachment_image_src( $thumb_id, $thumbnail_size )[0] : wc_placeholder_img_src( $thumbnail_size );

			$thumb_url = !empty( $thumb_id ) ? $images : wc_placeholder_img_src( $thumbnail_size );
			$term_img = !empty( $thumb_url ) ? '<img class="catalog-top-categories__image" src="' . esc_url( $thumb_url ) . '" alt="' . esc_attr( $term->name ) . '" />' : '<span class="catalog-top-categories__image">' . esc_attr( $term->name ) . '</span>';

			$ouput[] = sprintf(
						'<a class="catalog-top-categories__item %s" href="%s">
							%s
							<span class="catalog-top-categories__text">%s</span>
						</a>',
						( !empty( $current_term ) && $current_term == $term->term_id ) ? 'active' : '',
						esc_url( get_term_link( $term->term_id ) ),
						$term_img,
						esc_html( $term->name )
					);
		}

		$title = Helper::get_option( 'top_categories_layout' ) == '2' ? '<div class="catalog-top-categories__title">' . esc_html__( 'Shop by Category', 'motta' ) . '</div>' : '';
		echo sprintf(
				'<div class="catalog-top-categories catalog-top-categories__layout-v%s">
					%s
					<div class="catalog-top-categories__wrapper">%s</div>
				</div>',
				esc_attr( Helper::get_option( 'top_categories_layout' ) ),
				$title,
				implode( '', $ouput )
			);
	}

	/**
	 * Catalog toolbar.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function catalog_toolbar() {
		if ( wc_get_loop_prop( 'is_shortcode' ) ) {
			return;
		}

		if( Helper::get_option( 'catalog_toolbar_layout' ) == '2' ) {
			$sticky_class = ( Helper::get_option( 'catalog_toolbar_sticky' ) && Helper::get_option( 'mobile_navigation_bar' ) !== 'standard' ) ? 'mobile-catalog-toolbar--sticky' : '';

			echo '<div class="catalog-toolbar--top '. esc_attr( $sticky_class ).'">';
				/**
				 * Hook: motta_woocommerce_products_toolbar_top
				 */
				do_action( 'motta_woocommerce_products_toolbar_top' );

			echo '</div>';

			do_action( 'motta_woocommerce_after_products_toolbar_top' );
		}

        echo '<div class="catalog-toolbar">';
			/**
			 * Hook: motta_woocommerce_before_products_toolbar
			 */
			do_action( 'motta_woocommerce_before_products_toolbar' );

			echo '<div class="catalog-toolbar__toolbar">';
				/**
				 * Hook: motta_woocommerce_products_toolbar
				 */
				do_action( 'motta_woocommerce_products_toolbar' );

			echo '</div>';
			/**
			 * Hook: motta_woocommerce_after_products_toolbar
			 */
			do_action( 'motta_woocommerce_after_products_toolbar' );

		echo '</div>';
	}

	/**
	 * Result count.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function result_count() {
		if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
			return;
		}

		$total    = wc_get_loop_prop( 'total' );
		$per_page = wc_get_loop_prop( 'per_page' );
		$current  = wc_get_loop_prop( 'current_page' );

		echo '<p class="motta-result-count">';
			if ( 1 === intval( $total ) ) {
				_e( 'Single Result', 'motta' );
			} elseif ( $total <= $per_page || -1 === $per_page ) {
				printf( _n( '%s Result', '%s Results', $total, 'motta' ), $total );
			} else {
				$first = ( $per_page * $current ) - $per_page + 1;
				$last  = min( $total, $per_page * $current );
				printf( esc_html__( '%1$s&ndash;%2$s of %3$s Results', 'motta' ), $first, $last, $total );
			}
		echo '</p>';
	}

	/**
	 * Button Filters
	 *
	 * @return void
	 *
	 */
	public function button_filters() {
		echo sprintf(
			'<button class="button-filters motta-button--raised motta-button--color-black" data-toggle="off-canvas" data-target="filter-sidebar-panel">%s%s</button>',
			\Motta\Icon::get_svg( 'filter' ),
			esc_html__( 'All Filters', 'motta' )
		);
	}

	/**
	 * Open Catelog Order
	 *
	 * @return void
	 *
	 */
	public function open_catalog_order() {
		echo '<div class="catalog-order hidden-xs">';
	}

	/**
	 * Close Catelog Order
	 *
	 * @return void
	 *
	 */
	public function close_catalog_order() {
		echo '</div>';
	}

	/**
	 * Update ordering options.
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public static function catalog_orderby( $options ) {
		$options = array (
			'menu_order' => __( 'Default', 'motta' ),
			'popularity' => __( 'Popularity', 'motta' ),
			'rating'     => __( 'Average rating', 'motta' ),
			'date'       => __( 'Latest', 'motta' ),
			'price'      => __( 'Price: low to high', 'motta' ),
			'price-desc' => __( 'Price: high to low', 'motta' ),
		);
		/* $options['menu_order'] = esc_attr__( 'Sort by:', 'motta' ); */

		return $options;
	}

	/**
	 * Ordering Label
	 *
	 * @return void
	 */
	public function ordering_label() {
		echo '<span class="woocommerce-ordering__label">' . esc_html__( 'Sort by:', 'motta' ) . '</span>';
	}

	/**
	 * Toolbar view.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function toolbar_view() {
		$views = (array) Helper::get_option('catalog_toolbar_view_els');

		foreach( $views as $key ) {
			$key_current = str_replace('grid-', '', $key );
			$key_current = $key_current == 'default' ? '4' : $key_current;
			$class = self::$catalog_view == $key ? 'current' : '';
			$index = 'view-small';
			if( $key == 'grid-2' ) {
				$index = 'view-large';
			} elseif( $key == 'grid-3' ) {
				$index = 'view-medium';
			} elseif( $key == 'grid-5' ) {
				$index = 'view-small-extra';
			} elseif( $key == 'list' ) {
				$index = 'view-list';
			}

			$output_type[] = sprintf(
				'<a href="#" class="%1$s %2$s" data-view="%1$s" data-type="%1$s">%3$s</a>',
				esc_attr( $key ),
				esc_attr( $class ),
				\Motta\Icon::get_svg( $index )
			);
		}

		echo sprintf(
			'<div id="motta-toolbar-view" class="motta-toolbar-view">%s</div>',
			implode( $output_type )
		);
	}


	/**
	 * Tablet Catalog Filter Button
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function tablet_catalog_filter_button() {
		if( is_active_sidebar( 'catalog-sidebar' ) ){
			echo '<button class="tablet-catalog-toolbar__filter-button motta-button--subtle motta-button--color-black hidden-xs hidden-lg" data-toggle="off-canvas" data-target="mobile-filter-sidebar-panel">' . \Motta\Addons\Helper::get_svg( 'filter' ) . esc_html__( 'Filter', 'motta' ) . '</button>';
		}
	}

	/**
	 * Mobile Catalog Toolbar
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_catalog_toolbar() {
		$sticky_class = ( Helper::get_option( 'catalog_toolbar_sticky' ) && Helper::get_option( 'mobile_navigation_bar' ) !== 'standard' ) ? 'mobile-catalog-toolbar--sticky' : '';

		echo '<div class="mobile-catalog-toolbar '. esc_attr( $sticky_class ) .'">';

		if( is_active_sidebar( 'catalog-sidebar' ) ){
			echo '<button class="mobile-catalog-toolbar__filter-button motta-button--ghost motta-button--color-black hidden-sm hidden-md hidden-lg" data-toggle="off-canvas" data-target="mobile-filter-sidebar-panel">' . \Motta\Addons\Helper::get_svg( 'filter' ) . esc_html__( 'Filter', 'motta' ) . '</button>';
		}

		$this->mobile_catalog_toolbar_sortby();

		echo '</div>';
	}

	/**
	 * Mobile Catalog Toolbar
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mobile_catalog_toolbar_sortby() {
		$classes = Helper::get_option( 'catalog_toolbar_layout' ) == '1' ? 'motta-button--ghost' : 'motta-button--raised';

		if( in_array( 'sortby', ( array ) Helper::get_option( 'catalog_toolbar_view' ) ) ) {
			echo '<button class="mobile-catalog-toolbar__sort-button motta-button--color-black hidden-sm hidden-md hidden-lg '. esc_attr( $classes ) .'" data-toggle="modal" data-target="mobile-orderby-modal">'. esc_html__( 'Sort by :', 'motta' ) . '<span class="name">'. esc_html__( 'Default', 'motta' ) .'</span></button>';
		}
	}

	/**
	 * Template redirect
	 *
	 * @return void
	 */
	public function motta_template_redirect() {
		self::$catalog_view = isset( $_COOKIE['catalog_view'] ) ? $_COOKIE['catalog_view'] : Helper::get_option('catalog_toolbar_default_view');
		self::$catalog_view = apply_filters( 'motta_catalog_view', self::$catalog_view );
	}

	/**
	 * Change catalog column
	 *
	 * @return void
	 */
	public function catalog_column( $column ) {
		if( empty( $_COOKIE['catalog_view'] ) ) {
			return $column;
		}

		if( $_COOKIE['catalog_view'] == 'list' ) {
			$column = 1;
		}

		if( $_COOKIE['catalog_view'] == 'grid-2' ) {
			$column = 2;
		}

		if( $_COOKIE['catalog_view'] == 'grid-3' ) {
			$column = 3;
		}

		if( $_COOKIE['catalog_view'] == 'default' ) {
			$column = 4;
		}

		if( $_COOKIE['catalog_view'] == 'grid-5' ) {
			$column = 5;
		}

		return $column;
	}

	/**
	 * Products pagination.
	 */
	public static function pagination() {
		// Display the default pagination for [products] shortcode.
		if ( wc_get_loop_prop( 'is_shortcode' ) ) {
			woocommerce_pagination();
			return;
		}

		$nav_type = Helper::get_option( 'catalog_nav' );

		if ( 'numeric' == $nav_type ) {
			woocommerce_pagination();
		} elseif ( get_next_posts_link() ) {

			if ( 'loadmore' == $nav_type ) {
				self::posts_found();
			}

			$classes = array(
				'woocommerce-navigation',
				'woocommerce-navigation__catalog',
				'next-posts-navigation',
				'ajax-navigation',
				'ajax-' . $nav_type,
			);

			echo '<nav class="' . esc_attr( implode( ' ', $classes ) ) . '">';
				next_posts_link( esc_html__( 'Load More Products', 'motta' ) );
				echo '<div class="motta-pagination--loading">
					<div class="motta-pagination--loading-dots">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
					<div class="motta-pagination--loading-text">' . esc_html__( 'Loading more...', 'motta' ) . '</div>
				</div>';
			echo '</nav>';
		}
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

			$post_text = $wp_query->found_posts > 1 ? esc_html__( 'items', 'motta' ) : esc_html__( 'item', 'motta' );

			echo sprintf( '<div class="motta-posts-found motta-progress woocommerce-nav-%s">
								<div class="motta-posts-found__inner motta-progress__inner">
								%s
								<span class="current-post"> %s </span>
								%s
								<span class="found-post"> %s </span>
								%s
								<span class="count-bar motta-progress__count-bar"></span>
							</div>
						</div>',
					esc_attr( Helper::get_option( 'catalog_nav' ) ),
					esc_html__( 'Showing', 'motta' ),
					$wp_query->post_count,
					esc_html__( 'of', 'motta' ),
					$wp_query->found_posts, $post_text
			);

		}
	}

	/**
	 * Add class button next navigation
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function posts_link_attributes() {
		return 'class="nav-links motta-button motta-button--bg-color-black motta-button--large"';
	}

	/**
	 * Filter Sidebar
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function filter_sidebar() {
		get_template_part( 'template-parts/panels/filter-sidebar' );
	}

	/**
	 * Order by list
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function orderby_list() {
		if( ! in_array( 'sortby', ( array ) Helper::get_option( 'catalog_toolbar_view' ) ) ) {
			return;
		}

		$orderby = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => __( 'Default sorting', 'motta' ),
				'popularity' => __( 'Sort by popularity', 'motta' ),
				'rating'     => __( 'Sort by average rating', 'motta' ),
				'date'       => __( 'Sort by latest', 'motta' ),
				'price'      => __( 'Sort by price: low to high', 'motta' ),
				'price-desc' => __( 'Sort by price: high to low', 'motta' ),
			)
		);

		get_template_part( 'template-parts/panels/mobile-orderby', '', $orderby );
	}

	/**
	 * Filters actived
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function filters_actived() {
		echo '<div class="catalog-toolbar__filters-actived"></div>';
	}

	/**
	 * Change button text
	 *
	 * @return void
	 */
	public function wishlist_button_view_text() {
		return esc_html__( 'Wishlist', 'motta' );
	}

	public function shop_description() {
		echo '<div class="container clearfix shop-description">';
		woocommerce_taxonomy_archive_description();
		woocommerce_product_archive_description();
		echo '</div>';
	}
}
