<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( \Motta\Helper::get_option( 'product_layout' ) == '6' && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="posted_in"><?php esc_html_e( 'SKU:', 'motta' ); ?> <span class="sku"><?php echo ! empty( $product->get_sku() ) && $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'motta' ); ?></span></span>

	<?php endif; ?>

	<?php if ( \Motta\Helper::get_option( 'product_single_categories' ) ) { echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'motta' ) . ' ', '</span>' ); } ?>

	<?php if ( \Motta\Helper::get_option( 'product_single_tags' ) ) { echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'motta' ) . ' ', '</span>' );  }?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
