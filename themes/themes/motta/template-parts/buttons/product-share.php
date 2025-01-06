<?php

/**
 * Template part for displaying the product share button
 *
 * @package Motta
 */
$icon = 'share-mini';
if( !empty( $args ) && !empty( $args['icon'] ) ) {
	$icon = $args['icon'];
}
$text = esc_html__('Share', 'motta');
if( !empty( $args ) && !empty( $args['text'] ) ) {
	$text = $args['text'];
}
?>

 <a href="#" class="motta-button  motta-button--text motta-button--product-share" data-toggle="modal" data-target="socials-popup">
	<span class="motta-button__icon"><?php echo \Motta\Icon::get_svg( $icon ); ?></span>
	<span class="motta-button__text "><?php echo esc_html( $text ) ?></span>
</a>