<?php
/**
 * Template part for displaying the notices modal
 *
 * @package Motta
 */

if ( ! function_exists( 'WC' ) ) {
	return;
}
?>

<div id="motta-popup-add-to-cart" class="motta-popup-add-to-cart-modal modal woocommerce">
	<div class="modal__backdrop"></div>
	<div class="modal__notices woocommerce">
		<div class="modal__button-close"><?php echo \Motta\Icon::get_svg( 'close' ); ?></div>

		<div class="modal__content product-modal-content">
			<div class="motta-product-popup-atc__notice">
				<?php esc_html_e( 'Successfully added to your cart', 'motta' ) ?>
			</div>
			<div class="widget_shopping_cart_content"></div>
			<?php do_action( 'motta_product_popup_atc_recommendation' ); ?>
		</div>

		<span class="modal__loader"><span class="mottaSpinner"></span></span>
	</div>
</div>