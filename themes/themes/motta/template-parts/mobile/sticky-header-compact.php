<?php

/**
 * Template part for displaying the sticky header compact for mobile
 *
 * @package Motta
 */
global $product;
?>
<div class="product-sticky-header">
	<a href="<?php echo esc_url( get_home_url() ); ?>" class="motta-button motta-button--text motta-button--history">
		<?php echo \Motta\Icon::get_svg( 'left' ); ?>
	</a>
	<div class="product-info">
		<span class="product-title"><?php the_title(); ?></span>
		<span class="product-price">
		<?php echo wp_kses_post($product->get_price_html());?>
		</span>
	</div>
	<div class="product-buttons">
		<?php \Motta\WooCommerce\Single_Product::share_button('share'); ?>
		<a href="#" class="motta-button motta-button--text motta-button--product-more" data-toggle="modal" data-target="product-more-popup">
			<?php echo \Motta\Icon::get_svg( 'more' ); ?>
		</a>
	</div>
</div>