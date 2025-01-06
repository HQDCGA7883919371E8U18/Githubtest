<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */
$css_class = 'motta-single-popup motta-popup-' . get_the_ID();
?>

<div id="post-<?php the_ID(); ?>" class="<?php echo esc_attr($css_class); ?>" >
	<div class="motta-popup__backdrop"></div>
	<div class="motta-popup__content">
		<?php the_content(); ?>
		<?php echo \Motta\Icon::get_svg( 'close', 'ui', 'class=motta-popup__close' ); ?>
	</div>
</div>