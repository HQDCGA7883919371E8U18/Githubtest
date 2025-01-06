<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php \Motta\Blog\Post::thumbnail(); ?>
	<div class="entry-summary">
		<?php \Motta\Blog\Post::category(); ?>
		<?php \Motta\Blog\Post::title(); ?>
		<?php \Motta\Blog\Post::excerpt(); ?>
		<div class="entry-meta">
			<?php \Motta\Blog\Post::author(); ?>
			<?php \Motta\Blog\Post::date(); ?>
			<?php \Motta\Blog\Post::comment(); ?>
		</div>
		<?php \Motta\Blog\Post::button(); ?>
	</div>
</article>