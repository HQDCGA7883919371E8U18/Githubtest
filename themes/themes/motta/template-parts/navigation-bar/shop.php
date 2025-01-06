<?php
/**
 * Template file for displaying menu mobile
 *
 * @package Motta
 */
?>

<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="motta-mobile-navigation-bar__icon menu-icon">
	<?php echo \Motta\Icon::get_svg( 'categories-v2' ); ?>
	<em><?php echo esc_html__( 'Shop', 'motta' ); ?></em>
</a>
