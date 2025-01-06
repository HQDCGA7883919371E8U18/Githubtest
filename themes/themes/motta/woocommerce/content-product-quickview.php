<?php
/**
 * Display product quickview.
 *
 * @author        UIX Themes
 * @package       Motta
 * @version       1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$classes = wc_get_product_class( '', $product  );

if ( get_option( 'motta_buy_now' ) == 'yes' ) {
	$classes[] = 'has-buy-now';
}

if ( \Motta\Helper::get_option( 'product_add_to_cart_ajax' ) ) {
	$classes[] = 'product-add-to-cart-ajax';
}

$classes[] = 'product-quickview layout-1';

?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	/**
	 * Hook: motta_woocommerce_before_product_quickview_summary
	 *
	 * @hooked woocommerce_show_product_sale_flash - 5
	 * @hooked woocommerce_show_product_images - 10
	 */
	do_action( 'motta_woocommerce_before_product_quickview_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: motta_woocommerce_product_quickview_summary
		 *
		 * @hooked woocommerce_template_single_title - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_rating - 30
		 * @hooked woocommerce_template_single_price - 40
		 * @hooked woocommerce_template_single_add_to_cart - 50
		 * @hooked woocommerce_template_single_meta - 60
		 */
		do_action( 'motta_woocommerce_product_quickview_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: motta_woocommerce_after_product_quickview_summary
	 *
	 * @hooked motta_WooCommerce_Template_Catalog::add_to_wishlist_button - 10
	 * @hooked motta_WooCommerce_Template_Product::product_share - 20
	 * @hooked motta_WooCommerce_Template_Catalog::quickview_detail_link - 30
	 */
	do_action( 'motta_woocommerce_after_product_quickview_summary' );
	?>
</div>