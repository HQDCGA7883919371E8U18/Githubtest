<?php
/**
 * Posts functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Header;

use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts initial
 *
 */
class Hamburger {
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
	 * Custom template tags of header
	 *
	 * @package Motta
	 *
	 * @since 1.0.0
	 *
	 * @param $items
	 */
	public static function items( $args ) {
		if( empty( $args ) ){
			return;
		}
		if( empty( $args['list_items'] ) ){
			return;
		}
		$items = $args['list_items'];
		foreach ( $items as  $item ) {

			if( empty( $item['item'] ) ) {
				continue;
			}
			switch ( $item['item'] ) {
				case 'divider':
					echo '<hr class="mobile-menu__divider divider">';
					break;

				case 'account':
					\Motta\Helper::account_links();
					break;

				case 'wishlist':
					if($wishlist_html = Helper::wishlist_link()) {
						echo sprintf('<div class="hamburger-panel__item">%s</div>', $wishlist_html);
					}
					break;

				case 'compare':
					if($compare_html = Helper::compare_link()) {
						echo sprintf('<div class="hamburger-panel__item">%s</div>', $compare_html);
					}
					break;

				case 'track-order':
					if($track_html = Helper::track_order_link()) {
						echo sprintf('<div class="hamburger-panel__item">%s</div>', $track_html);
					}
					break;

				case 'help-center':
					if($help_html = Helper::help_center_link()) {
						echo sprintf('<div class="hamburger-panel__item">%s</div>', $help_html);
					}
					break;

				case 'custom-menu':
					$mega_menu 		= false;
					$menu_class		= 'custom-menu-navigation main-navigation';
					$menu_id = ! empty( $args['custom_menu_id'] ) ?  $args['custom_menu_id'] : '';
					if( ! empty( $menu_id ) ) {
						Helper::navigation_menu_by_id( $mega_menu, $menu_id, $menu_class );
					}
					break;

				case 'primary-menu':
					$mega_menu 		= true;
					$menu_class		= 'main-navigation primary-navigation';
					$menu_id = ! empty( $args['primary_menu_id'] ) ?  $args['primary_menu_id'] : '';
					if( ! empty( $menu_id ) ) {
						Helper::navigation_menu_by_id( $mega_menu, $menu_id, $menu_class );
					} else {
						Helper::navigation_menu_by_location( $mega_menu, $item['item'], $menu_class );
					}
					break;

				case 'category-menu':
					$mega_menu 		= true;
					$menu_class		= 'header-category__menu';
					$menu_id = !empty( $args['category_menu_id'] ) ?  $args['category_menu_id'] : '';
					echo '<div class="header-category-menu header-category--hamburger"><div class="header-category__title ">';
					echo sprintf('<span class="header-category__name">%s</span>', esc_html__('Shop by Category', 'motta'));
					echo sprintf('<a class="motta-button motta-button--subtle  motta-button--color-black  motta-button--medium" href="%s">
									<span class="motta-button__text">%s</span>
								</a>',
								wc_get_page_permalink( 'shop' ),
								esc_html__('See All', 'motta')
					);
					echo '</div>';
					if( ! empty( $menu_id ) ) {
						Helper::navigation_menu_by_id( $mega_menu, $menu_id, $menu_class );
					} else {
						Helper::navigation_menu_by_location( $mega_menu, $item['item'], $menu_class );
					}
					echo '</div>';
					break;

				case 'search':
					$args['search_class'] = 'motta-skin--base';
					$args['search_items_input_class'] = 'motta-type--input-text';
					$args['search_items_button_display'] = 'none';
					$args['search_items'] = array( 'icon', 'search-field' );
					get_template_part( 'template-parts/header/search-form', '', $args );
					break;

				case 'socials':
					get_template_part( 'template-parts/header/socials', '', $args );
					break;

				case 'preferences':
					$languages = Helper::language_status();

					if ( ! empty( $languages ) ) {
						foreach ( (array) $languages as $key => $language ) {
							if( $language['active'] ) {
								$args['language'] = $language['native_name'];
							} else {
								$key = key($languages);
								$args['language'] = $languages[$key]['native_name'];
							}
						}
					}

					$currencies_code = \Motta\Helper::get_option('header_currency_code');
					if( ! $currencies_code ) {

						$currencies = \Motta\WooCommerce\Currency::currency_status();

						if( ! empty($currencies) ) {
							$args['currency'] = $currencies['current_currency'];
						}
					}

					get_template_part( 'template-parts/panels/preferences-menu', '', $args );
					break;

				default:
					do_action( 'motta_mobile_menu_items', $item );
					break;
			}
		}
	}
}
