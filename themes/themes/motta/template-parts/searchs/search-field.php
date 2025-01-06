<?php
/**
 * Template part for displaying the search items
 *
 * @package Motta
 */

$placeholder = esc_attr__( 'Search for anything', 'motta' );
if ( \Motta\Helper::get_option( 'header_search_type' ) == 'adaptive' ) {
	if( \Motta\Header\Search::type() == 'post' ) {
		$placeholder = esc_attr__( 'Search the blog', 'motta' );
	} else {
		$placeholder = esc_attr__( 'Search products', 'motta' );
	}
}

$classes = ! empty( $args ) && isset( $args['trending_searches_position'] ) && $args['trending_searches_position'] == 'inside' ? ' header-search__field--trending-inside': '';

?>

<input type="text" name="s" class="header-search__field<?php echo esc_attr( $classes ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">