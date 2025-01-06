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
	<header class="entry-header">
		<?php \Motta\Help_Center\Article::get_single_title('h1');?>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
