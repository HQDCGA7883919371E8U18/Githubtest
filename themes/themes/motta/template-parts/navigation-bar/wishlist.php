<?php
/**
 * Template file for displaying wishlist mobile
 *
 * @package Motta
 */

if ( ! function_exists( 'WC' ) ) {
	return;
}

if( ! class_exists( '\WCBoost\Wishlist\Helper' ) ) {
	return;
}
?>

<a href="<?php echo esc_url( wc_get_page_permalink( 'wishlist' ) ) ?>" class="motta-mobile-navigation-bar__icon wishlist-icon">
	<span>
		<?php echo \Motta\Icon::get_svg( 'wishlist' ); ?>
		<span class="counter wishlist-counter"><?php echo intval( \WCBoost\Wishlist\Helper::get_wishlist()->count_items() ); ?></span>
	</span>
	<em><?php echo esc_html__( 'Wishlist', 'motta' ); ?></em>
</a>
