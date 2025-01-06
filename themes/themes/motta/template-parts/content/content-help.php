<?php
/**
 * Template part for displaying help center
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a class="help-title" href="<?php the_permalink(); ?>"><?php \Motta\Help_Center\Article::get_loop_title(); ?></a>
	<?php \Motta\Help_Center\Article::get_loop_content(); ?>
</article>