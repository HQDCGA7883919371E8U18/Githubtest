<?php
/**
 * Template part for displaying the search icon
 *
 * @package Motta
 */

use Motta\Helper;

if ( ! function_exists( 'WC' ) ) {
	return;
}

$link  = wc_get_page_permalink( 'compare' );

if ( Helper::get_option( 'header_compare_link' ) ) {
	$link = Helper::get_option( 'header_compare_link' );
}

?>

<a class="motta-mobile-navigation-bar__icon compare-icon" href="<?php echo esc_url( $link ); ?>">
	<span>
		<?php echo \Motta\Icon::get_svg( 'compare' ); ?>
		<span class="counter compare-counter"><?php echo \WCBoost\ProductsCompare\Plugin::instance()->list->count_items(); ?></span>
	</span>
	<em><?php echo esc_html__( 'Compare', 'motta' ); ?></em>
</a>
