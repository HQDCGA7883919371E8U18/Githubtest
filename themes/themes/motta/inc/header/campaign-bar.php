<?php
/**
 * Campaign Bar functions and definitions.
 *
 * @package Motta
 */

namespace Motta\Header;

use Motta\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Campaign Bar initial
 *
 */
class Campaign_Bar {
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
	 * Display campaign bar item.
	 *
	 * @since 1.0.0
	 *
	 * @param array $items
	 */
	public static function campaign_items( $items ) {
		if( empty( $items) ) {
			return;
		}

		foreach ( $items as $id => $item ) {
			$campaign = apply_filters( 'motta_campaign_item_args', $item, $id );
			$args = wp_parse_args( $item, array(
				'icon'   => '',
				'image'  => '',
				'text'   => '',
				'button' => '',
				'link'   => '#',
			) );

			$button = '';
			if ( ! empty( $args['button'] ) ) {
				$link = ! empty( $args['link'] ) ? $args['link'] : '#';
				$button = sprintf(
					'<a href="%s" class="campaign-bar__button motta-button motta-button--subtle">%s</a>',
					esc_url( $link ),
					esc_html( $args['button'] )
				);
			}

			echo '<div class="campaign-bar__item text-'.esc_attr( \Motta\Helper::get_option('campaign_textcolor') ) .'">';
				if ( $args['icon'] ) {
					echo '<div class="campaign-bar__icon">' . \Motta\Icon::sanitize_svg( $args['icon'] ). '</div>';
				}

				if ( $args['text'] ) {
					echo '<div class="campaign-bar__text">'. wp_kses_post( $args['text'] ) . '</div>';
				}
				echo ! empty( $button ) ? $button : '';
			echo '</div>';
		}
	}

}
