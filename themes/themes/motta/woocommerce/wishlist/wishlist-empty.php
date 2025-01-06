<?php
/**
 * Template for displaying the empty wishlist.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/wishlist/wishlist-empty.php.
 *
 * @author  WCBoost
 * @package WCBoost/Wishlist
 * @version 1.0.10
 */

defined( 'ABSPATH' ) || exit;

do_action( 'wcboost_wishlist_before_wishlist' ); ?>
<div class="wishlist-empty-form">
	<div class="wishlist-empty-icon">
		<span class="motta-button__icon"><?php echo \Motta\Icon::get_svg( 'wishlist' ); ?></span>
	</div>

	<div class="wishlist-empty woocommerce-info">
		<?php echo wp_kses_post( apply_filters( 'wcboost_wishlist_empty_message', __( 'Looks like you don&rsquo;t have anything saved', 'motta' ) ) ); ?>
	</div>
	<div class="wishlist-empty woocommerce-info-description">
		<?php echo wp_kses_post( apply_filters( 'wcboost_wishlist_empty_message_description', __( 'Sign in to sync your Saved Items across all your devices.', 'motta' ) ) ); ?>
	</div>

	<p class="return-to-shop">
		<?php
		echo wp_kses_post( apply_filters( 'wcboost_wishlist_return_to_shop_link', sprintf(
			'<a href="%s" class="button wc-backward">%s</a>',
			esc_url( wc_get_page_permalink( 'myaccount' ) ),
			esc_html__( 'Sign in', 'motta' )
		), $args ) );
		?>
	</p>
</div>

<?php do_action( 'wcboost_wishlist_after_wishlist' ); ?>
