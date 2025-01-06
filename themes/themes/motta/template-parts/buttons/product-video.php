<?php

/**
 * Template part for displaying the product video button
 *
 * @package Motta
 */
?>

 <a href="<?php echo esc_url( \Motta\WooCommerce\Single_Product::get_video_url() ); ?>" class="motta-button motta-button--icon motta-button--raised motta-shape--circle motta-button--video">
	<?php echo \Motta\Icon::get_svg( 'video' ); ?>
</a>