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
		<div class="modal__header header-search--form">
			<?php
			echo do_shortcode( \Motta\Helper::get_option('header_search_shortcode') );
			?>
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