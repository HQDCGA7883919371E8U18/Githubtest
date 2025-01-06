<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Motta
 */

?>

<?php do_action( 'motta_before_site_content_close' ); ?>
</div><!-- #content -->
<?php do_action( 'motta_before_open_site_footer' ) ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {?>
	<footer id="site-footer" class="site-footer">
		<?php do_action('motta_footer'); ?>
	</footer>
<?php } ?>
<?php do_action( 'motta_after_close_site_footer' ); ?>

</div><!-- #page -->

<?php do_action( 'motta_after_site' ) ?>

<?php wp_footer(); ?>

</body>
</html>
