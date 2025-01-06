<?php
/**
 * Template part for displaying the cart panel
 *
 * @package Motta
 */

if ( ! function_exists( 'WC' ) ) {
	return;
}
if( \Motta\Helper::get_option( 'header_cart_icon_behaviour' ) == 'page' ) {
	return;
}
$counter = ! empty(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
?>

<div id="cart-panel" class="offscreen-panel cart-panel woocommerce">
	<div class="panel__backdrop"></div>
	<div class="panel__container">
		<?php echo \Motta\Icon::get_svg( 'close', 'ui', 'class=panel__button-close' ); ?>

		<div class="panel__header">
			<?php echo esc_html__( 'Shopping Cart ', 'motta' ); ?><span class="cart-panel__counter"><?php echo '('. $counter .')'; ?></span>
		</div>

		<div class="panel__content motta-skin--subtle motta-qty-medium">
			<div class="widget_shopping_cart_content ">
				<?php woocommerce_mini_cart(); ?>
			</div>
		</div>
	</div>
</div>