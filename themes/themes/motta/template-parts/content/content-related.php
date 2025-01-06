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
	<?php \Motta\Blog\Post_Related::thumbnail(); ?>
	<?php \Motta\Blog\Post_Related::title(); ?>
	<div class="entry-meta">
		<?php \Motta\Blog\Post_Related::date(); ?>
		<?php \Motta\Blog\Post_Related::comment(); ?>
	</div>
</article>