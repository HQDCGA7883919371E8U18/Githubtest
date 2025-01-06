<?php
/**
 * Template part for displaying the language currency
 *
 * @package Motta
 */

if ( ! function_exists( 'WC' ) ) {
	return;
}

$button_url = \Motta\Helper::get_option( 'header_view_history_link' );
$button_url = ! empty( $button_url ) ? $button_url : wc_get_page_permalink( 'shop' );

?>
<div class="header-view-history">
	<div class="header-view-history__title motta-button--text">
		<?php
			echo \Motta\Icon::get_svg( 'select-arrow', 'ui', 'class=header-view-history__arrow' );
			echo '<span class="header-view-history__name">'. esc_html__('Browsing History', 'motta') .'</span>';
		?>
	</div>
	<div class="header-view-history__content">
		<div class="header-view-history__wrapper container">
			<div class="header-view-history__content-heading">
				<?php
					echo '<span class="header-view-history__content-title">'. esc_html__('Browsing History', 'motta') .'</span>';
					echo '<a href="' . esc_url( $button_url ) . '" class="header-view-history__button motta-button motta-button--subtle motta-button--color-black motta-button--medium"><span class="motta-button__text">'. esc_html__('See All History', 'motta') .'</span></a>';
				?>
			</div>
			<?php echo '<div class="motta-pagination--loading">
							<div class="motta-pagination--loading-dots">
								<span></span>
								<span></span>
								<span></span>
								<span></span>
							</div>
							<div class="motta-pagination--loading-text">' . esc_html__( 'Loading more...', 'motta' ) . '</div>
						</div>';
			?>
			<div class="header-view-history__content-products"></div>

		</div>
	</div>
</div>