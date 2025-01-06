<?php

/**
 * Template part for displaying the header compact for mobile
 *
 * @package Motta
 */

?>
<div class="product-header-main">
	<a href="<?php echo esc_url( get_home_url() ); ?>" class="motta-button  motta-button--text motta-button--history">
		<span class="motta-button__icon"><?php echo \Motta\Icon::get_svg( 'left' ); ?></span>
	</a>
	<?php \Motta\WooCommerce\Single_Product::share_button('share'); ?>
</div>