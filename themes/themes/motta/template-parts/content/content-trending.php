<?php
/**
 * Template part for displaying trending posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php \Motta\Blog\Post_Trending::thumbnail(); ?>
	<div class="entry-summary">
		<?php \Motta\Blog\Post_Trending::category(); ?>
		<?php \Motta\Blog\Post_Trending::title(); ?>
		<?php \Motta\Blog\Post_Trending::excerpt(); ?>
		<?php \Motta\Blog\Post_Trending::button(); ?>
		<div class="entry-meta">
			<?php \Motta\Blog\Post_Trending::author(); ?>
			<div class="entry-meta__content">
				<?php \Motta\Blog\Post_Trending::date(); ?>
				<?php \Motta\Blog\Post_Trending::comment(); ?>
			</div>
		</div>
	</div>
</article>
