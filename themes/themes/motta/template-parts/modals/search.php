<?php
/**
 * Template part for displaying the hamburger modal
 *
 * @package Motta
 */
?>

<div id="search-modal" class="modal search-modal">
	<div class="modal__backdrop"></div>
	<div class="modal__container">
		<div class="modal__header">
			<form class="search-modal__form" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
				<input type="text" name="s" class="search-modal__field motta-input--medium  motta-input--raised" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr__( 'Search for anything', 'motta' ); ?>" autocomplete="off">
				<button class="search-modal__submit mt-button__icon--subtle motta-button--text" type="submit"><?php echo \Motta\Icon::get_svg( 'search' ); ?></button>
				<?php
					if ( intval( \Motta\Helper::get_option( 'header_search_ajax' ) ) ) {
						echo \Motta\Icon::get_svg( 'close', 'ui', 'class=close-search-results' );
						echo '<div class="header-search__results search-results woocommerce"></div>';
					}
				?>
				<input type="hidden" name="post_type" class="search-modal__post-type" value="<?php echo isset( $_GET['post_type'] ) && ! empty( $_GET['post_type'] ) ? esc_attr( $_GET['post_type']) : esc_attr( \Motta\Header\Search::type() ); ?>">
			</form>
		</div>

		<div class="modal__content">
			<?php
				if ( \Motta\Helper::get_option( 'header_mobile_search_trending_searches' ) ) {
					$args['trending_searches'] = true;
					\Motta\Header\Search::trendings( $args );
				}
			?>
		</div>
		<button class="modal__button-close motta-button--text" type="submit"><?php echo \Motta\Icon::get_svg( 'close' ); ?> <?php esc_html_e('Close', 'motta') ?></button>
	</div>
</div>