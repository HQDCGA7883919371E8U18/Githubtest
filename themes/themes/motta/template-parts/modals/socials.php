<?php
/**
 * Template part for displaying socials content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */
?>
<div id="socials-popup" class="product-socials__popup modal">
	<div class="modal__backdrop"></div>
	<div class="product-socials__content">
		<div class="product-socials__top">
			<div class="product-socials__heading"><?php echo esc_html__('Share', 'motta'); ?></div>
			<div class="product-socials__close modal__button-close"><?php echo \Motta\Icon::get_svg( 'close' ); ?></div>
		</div>
		<div class="product-socials__share"><?php echo $args; ?></div>
		<div class="product-socials__copylink">
			<div class="product-socials__copylink-heading"><?php echo esc_html__( 'Copy Link', 'motta' ); ?></div>
			<form>
				<input class="product-socials__copylink--link motta-copylink__link" type="text" value="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>" readonly="readonly" />
				<button class="product-socials__copylink--button motta-copylink__button motta-button motta-button--bg-color-black"><?php echo esc_html__( 'Copy', 'motta' ); ?></button>
			</form>
		</div>
	</div>
</div>