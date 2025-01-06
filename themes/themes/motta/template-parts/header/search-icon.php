<?php
/**
 * Template part for displaying the search icon
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

$search_type = \Motta\Helper::is_blog() || is_singular('post') ? 'post' : \Motta\Helper::get_option( 'header_search_type' );

?>

<div class="header-search header-search--icon">
	<form class="header-search__form header-search__form--medium" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
		<div class="header-search__container">
			<button class="header-search__button motta-button motta-button--icon motta-button--medium motta-button--subtle motta-button--no-spacing motta-button--color-black" type="submit">
				<?php echo '<span class="motta-button__icon">' . \Motta\Icon::get_svg( 'search' ) . '</span>'; ?>
			</button>

			<input type="text" name="s" class="header-search__field motta-input--medium" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">

			<?php echo \Motta\Header\Search::trendings( $args ); ?>
		</div>

		<div class="header-search__icon">
			<?php echo \Motta\Icon::get_svg( 'search' ); ?>
		</div>

		<?php if ( $search_type ) : ?>
			<input type="hidden" name="post_type" value="<?php echo isset( $_GET['post_type'] ) && ! empty( $_GET['post_type'] ) ? esc_attr( $_GET['post_type']) : esc_attr( \Motta\Header\Search::type() ); ?>">
		<?php endif; ?>
	</form>
</div>
