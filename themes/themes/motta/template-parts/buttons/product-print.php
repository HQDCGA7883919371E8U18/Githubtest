<?php

/**
 * Template part for displaying the product print button
 *
 * @package Motta
 */
?>

 <a href="#" class="motta-button  motta-button--text motta-button--product-print">
	<span class="motta-button__icon"><?php echo \Motta\Icon::get_svg( 'print' ); ?></span>
	<span class="motta-button__text "><?php esc_html_e('Print', 'motta') ?></span>
</a>