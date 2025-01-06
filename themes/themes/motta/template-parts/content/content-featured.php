<?php
/**
 * Template part for displaying featured loop content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('swiper-slide'); ?>>
	<?php \Motta\Blog\Post_Featured::thumbnail(); ?>
	<div class="entry-summary">
		<?php \Motta\Blog\Post_Featured::category(); ?>
		<?php \Motta\Blog\Post_Featured::title(); ?>
		<div class="entry-meta">
			<?php \Motta\Blog\Post_Featured::date(); ?>
			<?php \Motta\Blog\Post_Featured::comment(); ?>
		</div>
	</div>
</article>
