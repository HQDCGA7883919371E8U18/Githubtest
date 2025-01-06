<?php
/**
 * Template file for displaying cart mobile
 *
 * @package Motta
 */

$cart_icon = \Motta\Helper::get_option( 'header_cart_icon' );

if ( $cart_icon == 'custom' ) {
	$cart_icon = \Motta\Helper::get_option( 'header_cart_icon_custom' );
}

$counter = ! empty(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
$hidden = ! $counter ? 'hidden' : '';
?>

<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="motta-mobile-navigation-bar__icon cart-icon" data-toggle="off-canvas" data-target="cart-panel">
	<span>
		<?php
			switch( $cart_icon ) {
				case 'trolley':
				case 'bag':
					echo \Motta\Icon::get_svg( 'cart-' . $cart_icon );
					break;
				default:
					echo '<span class="motta-svg-icon">' . \Motta\Icon::sanitize_svg( $cart_icon ) . '</span>';
					break;
			}
		?>
		<span class="counter cart-counter <?php echo esc_attr($hidden); ?>"><?php echo intval( $counter ); ?></span>
	</span>
	<em><?php echo esc_html__( 'Cart', 'motta' ); ?></em>
</a>
