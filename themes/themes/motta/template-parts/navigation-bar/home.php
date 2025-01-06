<?php
/**
 * Template file for displaying Home mobile
 *
 * @package Motta
 */
?>

<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="motta-mobile-navigation-bar__icon home-icon">
	<?php echo \Motta\Icon::get_svg( 'home' ); ?>
	<em><?php echo esc_html__( 'Home', 'motta' ); ?></em>
</a>