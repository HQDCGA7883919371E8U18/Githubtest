<?php
/**
 * Template part for displaying the custom html
 *
 * @package Motta
 */

if ( empty( \Motta\Helper::get_option( 'header_custom_text' ) ) ) {
	return;
}
?>

<div id="header-custom-text" class="header-custom-text">
	<?php echo do_shortcode( wp_kses_post( \Motta\Helper::get_option( 'header_custom_text' ) ) ) ?>
</div>