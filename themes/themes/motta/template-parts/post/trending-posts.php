<?php
/**
 * The template part for displaying trending posts
 *
 * @package Motta
 */

$trending = new WP_Query( array(
    'post__in'  => $args
) );
if ( ! $trending->have_posts() ) {
	return;
}

$classes = 'motta-trending-posts trending-posts--number-' . $trending->post_count;
$classes .= ' trending-posts--layout-' . \Motta\Helper::get_option( 'blog_trending_layout' );

?>
<div id="trending-posts" class="<?php echo apply_filters( 'motta_trending_posts_classes', $classes );?>">
    <div class="trending-posts__items">

        <?php do_action( 'motta_before_trending_posts_content' ) ?>

        <?php
            while ( $trending->have_posts() ) : $trending->the_post();

                do_action( 'motta_before_trending_post_loop_content', $trending );

                    get_template_part( 'template-parts/content/content', 'trending' );

                do_action( 'motta_after_trending_post_loop_content', $trending );

            endwhile;
        ?>

        <?php do_action( 'motta_after_trending_posts_content' ) ?>

    </div>
</div>
<?php
wp_reset_postdata();