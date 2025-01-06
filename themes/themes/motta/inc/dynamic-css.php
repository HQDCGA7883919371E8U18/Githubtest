<?php
/**
 * Style functions and definitions.
 *
 * @package Motta
 */

namespace Motta;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Style initial
 *
 * @since 1.0.0
 */
class Dynamic_CSS {
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
		add_action( 'motta_after_enqueue_style', array( $this, 'add_static_css' ) );
	}

	/**
	 * Get get style data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function add_static_css() {
		$parse_css = $this->primary_color_static_css();
		$parse_css .= $this->typography_css();
		$parse_css .= $this->header_static_css();
		$parse_css .= $this->header_color_static_css();
		$parse_css .= $this->header_mobile_static_css();
		$parse_css .= $this->page_static_css();
		$parse_css .= $this->footer_mobile_static_css();
		$parse_css .= $this->topbar_static_css();
		$parse_css .= $this->campaign_bar_static_css();
		$parse_css .= $this->mobile_static_css();
		wp_add_inline_style( 'motta', apply_filters( 'motta_inline_style', $parse_css ) );
	}

	/**
	 * Get Color Scheme style data
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function primary_color_static_css() {
		$color_style = '';
		$primary_text_color = Helper::get_option('primary_text_color');
		if( $primary_text_color != 'light' ) {
			$custom_color = $primary_text_color == 'custom' ? Helper::get_option('primary_text_color_custom') : '#1d2128';
			$color_style .= '--mt-color__primary--light:' . $custom_color;
		}

		$primary_color = Helper::get_option( 'primary_color_custom' ) ? Helper::get_option( 'primary_color_custom_color' ) : Helper::get_option( 'primary_color' );
		if( empty($primary_color) || $primary_color == '#3449ca' ) {
			return 'body{'. $color_style .'}';
		}
		$color_hsl = $this->hex_to_hsl($primary_color);

		if( $color_hsl && count( $color_hsl ) > 2 ) {
			$color_dark =  $this->color_hsl($color_hsl[0], $color_hsl[1] - 3, $color_hsl[2] - 9);
			$color_darken =  $this->color_hsl($color_hsl[0], $color_hsl[1] - 9, $color_hsl[2] - 18);
			$color_style .= ';--mt-color__primary:' . $primary_color . ';--mt-color__primary--dark:'. $color_dark .';--mt-color__primary--darker: ' .  $color_darken;
		}

		$color_gray =  $this->hex_to_rgba( $primary_color, 0.12 );
		$color_grayer =  $this->hex_to_rgba( $primary_color, 0.24 );
		$color_grayest = $this->hex_to_rgba( $primary_color, 0.48 );
		$color_style .= ';--mt-color__primary--gray:' . $color_gray . ';--mt-color__primary--grayer:'. $color_grayer .';--mt-color__primary--grayest: ' .  $color_grayest;


		if( $color_style ) {
			$color_style = 'body{'. $color_style .'}';
		}

		$color_boxshadow = $this->hex_to_rgba( $primary_color, 0.4 );

		if($color_boxshadow) {
			$color_style .= '.motta-button--raised, .motta-skin--raised{--mt-color__primary--box-shadow:' . $color_boxshadow . '}';
		}

		return $color_style;

	}

	/**
	 * Get Color Scheme Light
	 *
	 * @since  1.0.0
	 *
	 * $color: color
	 *
	 * @return boolean
	 */
	protected function color_light($hex) {
		// Remove the "#" symbol from the beginning of the color.
		$hex = ltrim( $hex, '#' );

		// Make sure there are 6 digits for the below calculations.
		if ( 3 === strlen( $hex ) ) {
			$hex = substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 2, 1 ) . substr( $hex, 2, 1 );
		}

		// Get red, green, blue.
		$red   = hexdec( substr( $hex, 0, 2 ) );
		$green = hexdec( substr( $hex, 2, 2 ) );
		$blue  = hexdec( substr( $hex, 4, 2 ) );

		// Calculate the luminance.
		$lum = ( 0.2126 * $red ) + ( 0.7152 * $green ) + ( 0.0722 * $blue );
		return (int) round( $lum ) > 127 ? true : false;
	}

	/**
	 * Get Color Scheme style data
	 *
	 * @since  1.0.0
	 *
	 * $color_h: color hue
	 * $color_s: color saturation
	 * $color_l: color lightness
	 * $color_l_max: max of color lightness
	 * $color_l_min: if color lightness is than 90%, set color lightness again
	 *
	 * @return string
	 */
	protected function color_hsl($color_h, $color_s, $color_l, $color_l_max = 0, $color_l_min = 0) {
		if( $color_l_max && $color_l_min ) {
			$color_l = $color_l > $color_l_max ? $color_l_min : $color_l;
		}
		return 'hsl(' . $color_h . ', ' . $color_s . '%,' . $color_l . '%' . ')';
	}

	/**
	 * Convert hex to hsl
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	function hex_to_hsl($hex) {
		$hex = str_replace("#", "", $hex);
		$red = hexdec(substr($hex, 0, 2)) / 255;
		$green = hexdec(substr($hex, 2, 2)) / 255;
		$blue = hexdec(substr($hex, 4, 2)) / 255;

		$cmin = min($red, $green, $blue);
		$cmax = max($red, $green, $blue);
		$delta = $cmax - $cmin;

		if ($delta == 0) {
			$hue = 0;
		} elseif ($cmax === $red) {
			$hue = (($green - $blue) / $delta);
		} elseif ($cmax === $green) {
			$hue = ($blue - $red) / $delta + 2;
		} else {
			$hue = ($red - $green) / $delta + 4;
		}

		$hue = round($hue * 60);
		if ($hue < 0) {
			$hue += 360;
		}

		$lightness = (($cmax + $cmin) / 2);
		$saturation = $delta === 0 ? 0 : ($delta / (1 - abs(2 * $lightness - 1)));
		if ($saturation < 0) {
			$saturation += 1;
		}

		$lightness = round($lightness*100);
		$saturation = round($saturation*100);

		return array($hue, $saturation, $lightness);
	}

	/**
	 * Convert hex to rgba
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function hex_to_rgba($color, $opacity = false) {
		if (isset($color[0]) && $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		}

		if( empty( $hex ) || ! is_array( $hex ) ) {
			return;
		}

		$rgb =  array_map('hexdec', $hex);

		if($opacity){
			if(abs($opacity) > 1) {
				$opacity = 1.0;
			}

			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}

		return $output;
	}

	/**
	 * Get typography CSS base on settings
	 */
	protected function typography_css() {
		$settings = array(
			'typo_body'                  	=> 'body, .block-editor .editor-styles-wrapper',
			'typo_h1'                    	=> 'h1, .h1',
			'typo_h2'                    	=> 'h2, .h2',
			'typo_h3'                    	=> 'h3, .h3',
			'typo_h4'                    	=> 'h4, .h4',
			'typo_h5'                    	=> 'h5, .h5',
			'typo_h6'                    	=> 'h6, .h6',
			'typo_menu'                  	=> '.primary-navigation .nav-menu > li > a, .header-v2 .primary-navigation .nav-menu > li > a, .header-v4 .primary-navigation .nav-menu > li > a, .header-v6 .primary-navigation .nav-menu > li > a, .header-v8 .primary-navigation .nav-menu > li > a, .header-v9 .primary-navigation .nav-menu > li > a, .header-v10 .primary-navigation .nav-menu > li > a',
			'typo_submenu'               	=> '.primary-navigation li li a, .primary-navigation li li span, .primary-navigation li li h6',
			'typo_secondary_menu'        	=> '.secondary-navigation .nav-menu > li > a, .header-v2 .secondary-navigation .nav-menu > li > a, .header-v3 .secondary-navigation .nav-menu > li > a, .header-v5 .secondary-navigation .nav-menu > li > a, .header-v6 .secondary-navigation .nav-menu > li > a, .header-v8 .secondary-navigation .nav-menu > li > a, .header-v9 .secondary-navigation .nav-menu > li > a, .header-v10 .secondary-navigation .nav-menu > li > a',
			'typo_sub_secondary_menu'    	=> '.secondary-navigation li li a, .secondary-navigation li li span, .secondary-navigation li li h6',
			'typo_category_menu_title'   	=> '.header-category__name, .header-category-menu > .motta-button--text .header-category__name',
			'typo_category_menu'       	 	=> '.header-category__menu > ul > li > a',
			'typo_sub_category_menu'     	=> '.header-category__menu ul ul li > *',
			'typo_page_title'     		 	=> '.page-header .page-header__title',
			'typo_blog_header_title'     	=> '.motta-blog-page .page-header__title',
			'typo_blog_header_description' 	=> '.motta-blog-page .page-header__description',
			'typo_blog_post_title'     		=> '.hfeed .hentry .entry-title',
			'typo_blog_post_excerpt'     	=> '.hfeed .hentry .entry-excerpt',
			'typo_widget_title'     		=> '.blog-sidebar .widget .widget-title, .blog-sidebar .widget .widgettitle, .blog-sidebar .widget .wp-block-search__label, .single-sidebar .widget .widget-title, .single-sidebar .widget .widgettitle, .single-sidebar .widget .wp-block-search__label',
			'typo_product_title'     		=> '.single-product div.product h1.product_title, .single-product div.product.layout-4 h1.product_title, .single-product div.product.layout-5 h1.product_title, .single-product div.product.layout-6 .product-summary-wrapper h1.product_title',
			'typo_catalog_page_title'     	=> '.page-header--products h1.page-header__title',
			'typo_catalog_page_description' => '.page-header--products div.page-header__description',
			'typo_catalog_product_title' 	=> 'ul.products li.product h2.woocommerce-loop-product__title a',
		);

		return $this->get_typography_css( $settings );
	}

	/**
	 * Get typography CSS base on settings
	 */
	protected function get_typography_css( $settings, $print_default = false ) {
		if ( empty( $settings ) ) {
			return '';
		}

		$css        = '';
		$properties = array(
			'font-family'    => 'font-family',
			'font-size'      => 'font-size',
			'variant'        => 'font-weight',
			'line-height'    => 'line-height',
			'letter-spacing' => 'letter-spacing',
			'color'          => 'color',
			'text-transform' => 'text-transform',
			'text-align'     => 'text-align',
			'font-weight'    => 'font-weight',
			'font-style'     => 'font-style',
		);

		foreach ( $settings as $setting => $selector ) {
			if ( ! is_string( $setting ) ) {
				continue;
			}

			$selector   = is_array( $selector ) ? implode( ',', $selector ): $selector;
			$typography = Helper::get_option( $setting );
			$default    = (array) Helper::get_option_default( $setting );
			$style      = '';

			// Correct the default values. Copy from Kirki_Field_Typography::sanitize
			if ( isset( $default['variant'] ) ) {
				if ( ! isset( $default['font-weight'] ) ) {
					$default['font-weight'] = filter_var( $default['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$default['font-weight'] = ( 'regular' === $default['variant'] || 'italic' === $default['variant'] ) ? '400' : absint( $default['font-weight'] );
				}

				// Get font-style from variant.
				if ( ! isset( $default['font-style'] ) ) {
					$default['font-style'] = ( false === strpos( $default['variant'], 'italic' ) ) ? 'normal' : 'italic';
				}
			}

			if ( isset( $typography['variant'] ) && ( ! empty( $typography['font-weight'] ) || ! empty( $typography['font-style'] ) ) ) {
				unset( $typography['variant'] );
			}


			foreach ( $properties as $key => $property ) {
				if ( ! isset( $default[ $key ] ) ) {
					continue;
				}

				if ( isset( $typography[ $key ] ) && ! empty( $typography[ $key ] ) ) {
					if ( ! $print_default && strtoupper( $default[ $key ] ) == strtoupper( $typography[ $key ] ) ) {
						continue;
					}

					$value = 'font-family' == $key ? rtrim( trim( $typography[ $key ] ), ',' ) : $typography[ $key ];
					$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;


					if ( $value ) {
						$style .= $property . ': ' . $value . ';';
					}
				}
			}

			if ( ! empty( $style ) ) {
				$css .= $selector . '{' . $style . '}';
			}
		}

		return $css;
	}

	/**
	 * Header static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function header_static_css() {
		$static_css = '';
		$header_present = \Motta\Helper::get_option( 'header_present' );
		$header_version = \Motta\Helper::get_option( 'header_version' );

		// Header height.
		$height_main = \Motta\Helper::get_option( 'header_main_height' );
		if ( $height_main && $height_main != 100 ) {
			$static_css .= '.site-header__desktop .header-main { height: ' . $height_main . 'px; }';
		}

		$height_bottom = \Motta\Helper::get_option( 'header_bottom_height' );
		if ( $height_bottom && $height_bottom != 60 ) {
			$static_css .= '.site-header__desktop .header-bottom { height: ' . $height_bottom . 'px; }';
		}

		$height_sticky = \Motta\Helper::get_option( 'header_sticky_height' );
		if ( $height_sticky && $height_sticky != 80 ) {
			$static_css .= '.site-header__desktop .header-sticky { height: ' . $height_sticky . 'px; }';
		}

		// Logo dimension.
		$logo_dimension = (array) \Motta\Helper::get_option( 'logo_dimension' );
		$logo_dimension = apply_filters('motta_header_logo_dimension', $logo_dimension);
		$logo_width = ! empty($logo_dimension['width']) ? $logo_dimension['width'] : '';
		$logo_height = ! empty($logo_dimension['height']) ? $logo_dimension['height'] : '';

		$unit_width = $logo_width != 'auto' ? 'px;' : ';';
		$unit_height = $logo_height != 'auto' ? 'px;' : ';';

		$width = ! empty($logo_width) ? 'width: ' . $logo_width . $unit_width : '';
		$height = ! empty($logo_height) ? 'height: ' . $logo_height . $unit_height : '';
		if ( $width || $height ) {
			$static_css .= '.header-logo > a img, .header-logo > a svg {' . $width . $height . '}';
		}

		$logo_dimension = (array) \Motta\Helper::get_option( 'mobile_logo_dimension' );
		$logo_dimension = apply_filters('motta_header_logo_dimension', $logo_dimension);
		$logo_width = ! empty($logo_dimension['width']) ? $logo_dimension['width'] : '';
		$logo_height = ! empty($logo_dimension['height']) ? $logo_dimension['height'] : '';
		$unit_width = $logo_width != 'auto' ? 'px;' : ';';
		$unit_height = $logo_height != 'auto' ? 'px;' : ';';
		$width = ! empty($logo_width) ? 'width: ' . $logo_width . $unit_width : '';
		$height = ! empty($logo_height) ? 'height: ' . $logo_height . $unit_height : '';
		if ( $width || $height ) {
			$static_css .= '.site-header__mobile .header-logo > a img,.site-header__mobile .header-logo > a svg {' . $width . $height . '}';
		}

		// Hamburger Menu
		if ( $header_present == 'custom' && $left = \Motta\Helper::get_option( 'header_hamburger_space_left' ) ) {
			$static_css .= '.header-hamburger { margin-left: ' . $left . 'px; }';
		}
		if ( $header_present == 'custom' && $right = \Motta\Helper::get_option( 'header_hamburger_space_right' ) ) {
			$static_css .= '.header-hamburger, .header-v3 .header-hamburger { margin-right: ' . $right . 'px; }';
		}

		// Primary Menu
		if ( $header_present == 'custom' && ( $font_size = \Motta\Helper::get_option( 'header_primary_menu_font_size_parent_item' ) ) != 14 ) {
			$static_css .= '.site-header .primary-navigation .nav-menu > li > a { font-size: ' . $font_size . 'px; }';
		}
		if ( $header_present == 'custom' && ( $space = \Motta\Helper::get_option( 'header_primary_menu_spacing_parent_item' ) ) != 12 ) {
			$static_css .= '.site-header .primary-navigation .nav-menu > li > a { padding-left: ' . $space . 'px; padding-right: ' . $space . 'px; }';
			$static_css .= '.site-header .primary-navigation--dividers .nav-menu > li > a { padding-left: 0; padding-right: 0; }';
			$static_css .= '.site-header .primary-navigation--dividers .nav-menu > li > a:before { right: -'. $space .'px; }';
			$static_css .= '.site-header .primary-navigation--dividers .nav-menu > li:not( :first-child ) { padding-left: ' . $space . 'px; }';
			$static_css .= '.site-header .primary-navigation--dividers .nav-menu > li:not( :last-child ) { padding-right: ' . $space . 'px; }';
		}

		// Secondary Menu
		if ( $header_present == 'custom' && ( $font_size = \Motta\Helper::get_option( 'header_secondary_menu_font_size_parent_item' ) ) != 14 ) {
			$static_css .= '.site-header .secondary-navigation .nav-menu > li > a { font-size: ' . $font_size . 'px; }';
		}
		if ( $header_present == 'custom' && ( $space = \Motta\Helper::get_option( 'header_secondary_menu_spacing_parent_item' ) ) != 12 ) {
			$static_css .= '.site-header .secondary-navigation .nav-menu > li:not(:first-child) > a { padding-left: ' . $space . 'px; }';
			$static_css .= '.site-header .secondary-navigation .nav-menu > li:not(:last-child) > a { padding-right: ' . $space . 'px; }';
		}

		// Category Menu
		if ( $header_present == 'custom' && $space = \Motta\Helper::get_option( 'header_category_space' ) ) {
			$static_css .= '.header-category-menu { margin-left: ' . esc_attr( $space ) . 'px; }';
		}

		$category_arrow_spacing = \Motta\Helper::get_option( 'header_category_arrow_spacing' );
		if ( isset( $category_arrow_spacing ) && $category_arrow_spacing != 50 ) {
			$static_css .= '.header-category-menu.header-category--both > .motta-button--subtle:after,
							.header-category--text .motta-button--text:before { left: ' . esc_attr( $category_arrow_spacing ) . '%; }';
		}
		if ( $space = \Motta\Helper::get_option( 'header_category_content_spacing' ) ) {
			$static_css .= '.header-category-menu .header-category__content { left: ' . esc_attr( $space ) . 'px; }';
			$static_css .= '.header-category--icon .header-category__content { left: auto; right: calc( ' . esc_attr( $space ) . 'px * -1 ); }';
		}

		// Search
		$header_search_skins = 'text';
		if( $header_present == 'custom' ) {
			$header_search_skins = \Motta\Helper::get_option( 'header_search_skins' );
		} else {
			if( in_array( $header_version, array( 'v1', 'v5' ) ) ) {
				$header_search_skins = 'raised';
			} elseif( $header_version == 'v4' ) {
				$header_search_skins = 'ghost';
			} elseif(in_array( $header_version, array( 'v8', 'v10' ) ) ) {
				$header_search_skins = 'smooth';
			} elseif(in_array( $header_version, array( 'v2', 'v3' ) ) ) {
				$header_search_skins = 'base';
			}
		}

		if ( $header_search_skins == 'smooth' ) {
			if ( $background_color = \Motta\Helper::get_option( 'header_search_skins_background_color' ) ) {
				$static_css .= '.header-search--form.motta-skin--smooth { --mt-input__background-color: ' . $background_color . '; }';
				$static_css .= '.header-search--form .motta-button--smooth { --mt-color__primary--gray: ' . $background_color . '; }';
			}

			if ( $color = \Motta\Helper::get_option( 'header_search_skins_color' ) ) {
				$static_css .= '.header-search__categories-label span,
								.header-search--form .motta-type--input-text .header-search__field::placeholder,
								.header-search__icon span { color: ' . $color . '; }';
				$static_css .= '.header-search--form .motta-button--smooth { --mt-color__primary: ' . $color . '; }';
			}
		}
		if ( ! in_array( $header_search_skins, array( 'base', 'raised', 'smooth' ) ) && ( $border_color = \Motta\Helper::get_option( 'header_search_skins_border_color' ) ) ) {
			$static_css .= '.header-search--form .motta-type--input-text,
							.header-search--form.header-search--outside .header-search__button { border-color: ' . $border_color . '; }';
		}
		if ( in_array( $header_search_skins, array( 'base', 'raised', 'ghost' ) ) && ( $button_color = \Motta\Helper::get_option( 'header_search_skins_button_color' ) ) ) {
			$static_css .= '.header-search--form .header-search__button { --mt-color__primary: ' . $button_color . ';
																			--mt-color__primary--dark: ' . $button_color . ';
																			--mt-color__primary--darker: ' . $button_color . '; }';
			$static_css .= '.header-search--form .header-search__button.motta-button--raised { --mt-color__primary--box-shadow: ' . $this->hex_to_rgba( $button_color, 0.4 ) . '; }';
		}
		if ( in_array( $header_search_skins, array( 'base', 'raised', 'ghost' ) ) && ( $button_icon_color = \Motta\Helper::get_option( 'header_search_skins_button_icon_color' ) ) ) {
			$static_css .= '.header-search--form .header-search__button { --mt-color__primary--light: ' . $button_icon_color . '; }';
			$static_css .= '.header-search--form.header-search--inside .header-search__button { color: ' . $button_icon_color . '; }';
		}

		// Cart
		$header_cart_skins = '';
		if( $header_present == 'custom' ) {
			$header_cart_skins = \Motta\Helper::get_option( 'header_cart_type' );
		} elseif( $header_version == 'v4' ) {
			$header_cart_skins = 'base';
		}
		if ( in_array( $header_cart_skins, array( 'base' ) ) ) {
			if ( $background_color = \Motta\Helper::get_option( 'header_cart_background_color' ) ) {
				$static_css .= '.header-cart .motta-button--base,
								.header-cart .motta-button--smooth { --mt-color__primary: ' . $background_color . ';--mt-color__primary--dark: ' . $background_color . ';--mt-color__primary--darker: ' . $background_color . '; }';
			}
			if ( $color = \Motta\Helper::get_option( 'header_cart_color' ) ) {
				$static_css .= '.header-cart { color: ' . $color . '; }';
			}
		}
		if ( $background_color = \Motta\Helper::get_option( 'header_cart_counter_background_color' ) ) {
			$static_css .= '.header-cart__counter, .header-cart .motta-button--base .header-cart__counter { background-color: ' . $background_color . '; }';
		}
		if ( $color = \Motta\Helper::get_option( 'header_cart_counter_color' ) ) {
			$static_css .= '.header-cart__counter, .header-cart .motta-button--base .header-cart__counter { color: ' . $color . '; }';
		}


		// Wishlist
		if ( \Motta\Helper::get_option( 'header_wishlist_counter' ) ) {
			if ( $background_color = \Motta\Helper::get_option( 'header_wishlist_counter_background_color' ) ) {
				$static_css .= '.header-wishlist__counter { background-color: ' . $background_color . '; }';
			}
			if ( $color = \Motta\Helper::get_option( 'header_wishlist_counter_color' ) ) {
				$static_css .= '.header-wishlist__counter { color: ' . $color . '; }';
			}
		}

		// Compare
		if ( \Motta\Helper::get_option( 'header_compare_counter' ) ) {
			if ( $background_color = \Motta\Helper::get_option( 'header_compare_counter_background_color' ) ) {
				$static_css .= '.header-compare__counter { background-color: ' . $background_color . '; }';
			}
			if ( $color = \Motta\Helper::get_option( 'header_compare_counter_color' ) ) {
				$static_css .= '.header-compare__counter { color: ' . $color . '; }';
			}
		}

		// Custom HTML
		if ( $color = \Motta\Helper::get_option( 'header_custom_text_color' ) ) {
			$static_css .= '.header-custom-html { color: ' . $color . ' }';
		}
		$font_weight = \Motta\Helper::get_option( 'header_custom_text_font_weight' );
		if ( !empty($font_weight) && $font_weight != 500 ) {
			$static_css .= '.header-custom-html { font-weight: ' . $font_weight . ' }';
		}
		$font_size = \Motta\Helper::get_option( 'header_custom_text_font_size' );
		if ( !empty($font_size) && $font_size != 14 ) {
			$static_css .= '.header-custom-html { font-size: ' . $font_size . 'px; }';
		}

		// Empty Space
		$width = \Motta\Helper::get_option( 'header_empty_space' );
		if ( !empty($width) && $width != 14 ) {
			$static_css .= '.header-empty-space { min-width: ' . $width . 'px; }';
		}

		// Hide main content for header layout v11
		if ( intval( \Motta\Helper::get_option( 'header_blog_hide_header_main' ) ) ) {
			$static_css .= '#site-header .header-v11 .header-main { display: none; }';
		}

		return $static_css;
	}

		/**
	 * Header static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function header_color_static_css() {
		if( ! \Motta\Helper::get_option( 'header_enable_background_color' ) ) {
			return;
		}
		$header_layout = 'prebuild' == Helper::get_option( 'header_present' ) ? Helper::get_option( 'header_version' ) : 'custom';
		$header_section = '.site-header__section.header-'.$header_layout;
		$static_css = $this->header_background_color($header_section);
		$header_mobile_layout = 'prebuild' == Helper::get_option( 'header_mobile_present' ) ? Helper::get_option( 'header_mobile_version' ) : 'custom';
		if( $header_mobile_layout != $header_layout ) {
			$header_mobile = '.site-header__mobile.header-'.$header_mobile_layout;
			$static_css .= $this->header_background_color($header_mobile);
		}

		return $static_css;
	}

	protected function header_background_color($header_section) {
		$static_css = '';
		$pick_color = \Motta\Helper::get_option('header_pick_background_color');
		if( $pick_color ) {
			$header_bc = \Motta\Helper::get_option('header_custom_background_color');
			$header_color = \Motta\Helper::get_option('header_custom_background_text_color');
			$header_border_color = \Motta\Helper::get_option('header_custom_background_border_color');
			$header_sub_text_color = $this->hex_to_rgba( $header_color, 0.8 );
			$static_css .= $header_section.' .header-items .header-category-menu.motta-open > .motta-button--ghost{border-color:'.$header_border_color.';box-shadow: none}';
			$static_css .= $header_section.' .header-search--form.motta-skin--ghost{--mt-input__border-width: 0}';
		} else {
			$color_palette = \Motta\Helper::get_option('header_background_color');
			if( '#ffffff' == $color_palette ) {
				$header_bc = '#fff';
				$header_color = '#1d2128';
				$header_border_color = '#ecf0f4';
				$header_sub_text_color = '#7c818b';
				$static_css .= $header_section.' .header-search--form.motta-skin--base,'. $header_section. ' .header-search--form.motta-skin--text{--mt-input__border-width: 2px}';
				$static_css .= $header_section.' .header-search--simple .motta-type--input-text{border-width: var(--mt-input__border-width); border-style: solid; border-color: #dadfe3;}';
			} else {
				$header_bc = $color_palette;
				$header_color = '#fff';
				$header_border_color = 'rgba(255,255,255,.12)';
				$header_sub_text_color = 'rgba(255,255,255,.5)';
				$static_css .= $header_section.' .header-items .header-category-menu.motta-open > .motta-button--ghost{border-color:#fff;box-shadow: none}';
				$static_css .= $header_section.' .header-search--form.motta-skin--ghost{--mt-input__border-width: 0}';
			}
		}

		$variable_css = '--mt-header-bc:'. $header_bc . ';--mt-header-color: ' . $header_color . ';';
		$variable_css .= '--mt-header-border-color:'.$header_border_color.';';
		$variable_css .= '--mt-header-sub-text-color:'.$header_sub_text_color.';';
		$static_css .= $header_section.' {' . $variable_css . '}';
		$static_css .= '.site-header__section.header-v9 .header-sticky:not(.header-bottom)  {--mt-header-bc:' . $header_bc . ';--mt-header-color: ' . $header_color . '}';
		$static_css .= $header_section.' .header-main {--mt-header-main-background-color:'. $header_bc.';--mt-header-main-text-color:'.$header_color.'}';
		$static_css .= '.site-header__section.header-v9 .header-mobile-bottom {--mt-header-mobile-bottom-bc:'. $header_bc.';--mt-header-mobile-bottom-tc:'.$header_color.'}';
		return $static_css;
	}

	/**
	 * Header mobile static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function header_mobile_static_css() {
		$static_css = '';

		$header_breakpoint = \Motta\Helper::get_option( 'header_mobile_breakpoint' );
		$header_breakpoint = ! empty( $header_breakpoint ) ? $header_breakpoint : '1199';

		if ( intval( $header_breakpoint ) ) {
			$static_css .= '@media (max-width: '. $header_breakpoint .'px) { .site-header__mobile { display: block; } }';
			$static_css .= '@media (max-width: '. $header_breakpoint .'px) { .site-header__desktop { display: none; } }';
		}

		// Header height.
		$height_main = \Motta\Helper::get_option( 'header_mobile_main_height' );
		if ( $height_main && $height_main != 62 ) {
			$static_css .= '.site-header__mobile .header-mobile-main { height: ' . $height_main . 'px; }';
		}

		$height_bottom = \Motta\Helper::get_option( 'header_mobile_bottom_height' );
		if ( $height_bottom && $height_bottom != 48 ) {
			$static_css .= '.site-header__mobile .header-mobile-bottom { height: ' . $height_bottom . 'px; }';
		}

		$height_sticky = \Motta\Helper::get_option( 'header_mobile_sticky_height' );
		if ( $height_sticky && $height_sticky != 64 ) {
			$static_css .= '.header-mobile-sticky { height: ' . $height_sticky . 'px; }';
		}

		return $static_css;
	}

	/**
	 * Page static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function page_static_css() {
		$static_css = '';

		if ( $top = get_post_meta( Helper::get_post_ID(), 'motta_content_top_padding', true ) ) {
			$static_css .= '.site-content-custom-top-spacing #site-content { padding-top: ' . $top . 'px; }';
		}

		if ( $bottom = get_post_meta( Helper::get_post_ID(), 'motta_content_bottom_padding', true ) ) {
			$static_css .= '.site-content-custom-bottom-spacing #site-content { padding-bottom: ' . $bottom . 'px; }';
		}

		return $static_css;
	}

	/**
	 * Mobile Footer static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function footer_mobile_static_css() {
		$static_css = '';

		$footer_breakpoint = \Motta\Helper::get_option( 'footer_mobile_breakpoint' );
		$footer_breakpoint = ! empty( $footer_breakpoint ) ? $footer_breakpoint : '767';

		if ( intval( $footer_breakpoint ) ) {
			$static_css .= '@media (max-width: '. $footer_breakpoint .'px) { .footer-mobile { display: block; } }';
			$static_css .= '@media (max-width: '. $footer_breakpoint .'px) { .footer-main:not( .show-on-mobile ) { display: none; } }';
		}

		return $static_css;
	}

	/**
	 * Topbar static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function topbar_static_css() {
		$static_css = '';

		if( $background_color = \Motta\Helper::get_option('topbar_background_color') ) {
			$static_css .= '.topbar { background-color: ' . $background_color . '; }';
			$static_css .= '.topbar:before { display: none; }';
		}

		if( $color = \Motta\Helper::get_option('topbar_color') ) {
			$static_css .= '.topbar,.topbar-navigation .nav-menu > li > a,
							.topbar .motta-location,
							.topbar .socials-navigation .nav-menu a,
							.topbar .header-preferences { color: ' . $color . '; }';
		}

		if( $hover_color = \Motta\Helper::get_option('topbar_hover_color') ) {
			$static_css .= '.topbar-navigation .nav-menu > li > a:hover,
							.topbar .motta-location a:hover,
							.topbar .socials-navigation .nav-menu a:hover,
							.topbar .header-preferences a:hover { color: ' . $hover_color . '; }';
		}

		return $static_css;
	}

	/**
	 * Campaign bar static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function campaign_bar_static_css() {
		$static_css = '';

		if( \Motta\Helper::get_option('campaign_bar') ) {
			if( \Motta\Helper::get_option('campaign_image') ) {
				$static_css .= '.campaign-bar { background-image: url(' . esc_url( \Motta\Helper::get_option('campaign_image') ) . '); }';
			}

			if( \Motta\Helper::get_option('campaign_bgcolor') ) {
				$static_css .= '.campaign-bar { background-color: ' . \Motta\Helper::get_option('campaign_bgcolor') . '; }';
			}

			if( \Motta\Helper::get_option('campaign_textcolor') == 'custom' && \Motta\Helper::get_option( 'campaign_textcolor_custom' ) ) {
				$static_css .= '.campaign-bar__item { --mt-color__primary: ' . \Motta\Helper::get_option( 'campaign_textcolor_custom' ) . '; }';
			}

			if( intval( \Motta\Helper::get_option('campaign_height') ) != 44 ) {
				$static_css .= '.campaign-bar .campaign-bar__container { min-height: ' . intval( \Motta\Helper::get_option('campaign_height') ) . 'px; }';
			}

			if( intval( \Motta\Helper::get_option('campaign_text_size') ) != 14 ) {
				$static_css .= '.campaign-bar .campaign-bar__item { --mt-campaign-bar-size: ' . intval( \Motta\Helper::get_option('campaign_text_size') ) . 'px; }';
			}

			if( intval( \Motta\Helper::get_option('campaign_mobile_text_size') ) != 14 ) {
				$static_css .= '.campaign-bar .campaign-bar__item { --mt-campaign-bar-mobile-size: ' . intval( \Motta\Helper::get_option('campaign_mobile_text_size') ) . 'px; }';
			}

			if( intval( \Motta\Helper::get_option('campaign_text_weight') ) != 700 ) {
				$static_css .= '.campaign-bar .campaign-bar__item { font-weight: ' . intval( \Motta\Helper::get_option('campaign_text_weight') ) . '; }';
			}

			if( intval( \Motta\Helper::get_option('campaign_button_spacing') ) != 31 ) {
				$static_css .= '.campaign-bar .campaign-bar__button { margin-left: ' . intval( \Motta\Helper::get_option('campaign_button_spacing') ) . 'px; }';
				$static_css .= '.rtl .campaign-bar .campaign-bar__button { margin-right: ' . intval( \Motta\Helper::get_option('campaign_button_spacing') ) . 'px; }';
			}
		}

		return $static_css;
	}

	/**
	 * Mobile static css
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	protected function mobile_static_css() {
		$static_css = '';

		if( \Motta\Helper::get_option('mobile_navigation_bar') !== 'none' ) {
			if( \Motta\Helper::get_option('mobile_navigation_bar_background_color') ) {
				$static_css .= '.motta-mobile-navigation-bar { background-color: ' . \Motta\Helper::get_option('mobile_navigation_bar_background_color') . '; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_color') ) {
				$static_css .= '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon { color: ' . \Motta\Helper::get_option( 'mobile_navigation_bar_color' ) . '; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_box_shadow_color') ) {
				$static_css .= '.motta-mobile-navigation-bar { --mt-color__navigation-bar--box-shadow: ' . \Motta\Helper::get_option('mobile_navigation_bar_box_shadow_color') . '; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_spacing') ) {
				$static_css .= '.motta-mobile-navigation-bar { margin-left: ' . \Motta\Helper::get_option('mobile_navigation_bar_spacing') . 'px; margin-right: ' . \Motta\Helper::get_option('mobile_navigation_bar_spacing') . 'px; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_spacing_bottom') ) {
				$static_css .= '.motta-mobile-navigation-bar { margin-bottom: ' . \Motta\Helper::get_option('mobile_navigation_bar_spacing_bottom') . 'px; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_counter_background_color') ) {
				$static_css .= '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon .counter { background-color: ' . \Motta\Helper::get_option('mobile_navigation_bar_counter_background_color') . '; }';
			}

			if( \Motta\Helper::get_option('mobile_navigation_bar_counter_color') ) {
				$static_css .= '.motta-mobile-navigation-bar .motta-mobile-navigation-bar__icon .counter { color: ' . \Motta\Helper::get_option( 'mobile_navigation_bar_counter_color' ) . '; }';
			}
		}

		return $static_css;
	}
}
