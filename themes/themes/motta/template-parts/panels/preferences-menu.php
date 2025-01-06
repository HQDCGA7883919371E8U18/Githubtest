<?php
/**
 * Template part for displaying the preferences menu
 *
 * @package Motta
 */

?>
<nav class="preferences-menu">
	<div class="preferences-menu__heading"><?php esc_html_e( 'Preferences', 'motta' ); ?></div>
	<ul>
		<?php if( ! empty( $args['language'] ) ) : ?>
			<li class="preferences-menu__item motta-language">
				<a href="#" data-title="<?php esc_attr_e( 'Language', 'motta' ); ?>">
					<span class="motta-button motta-button--text">
						<span class="motta-button__icon">
							<?php echo \Motta\Icon::get_svg( 'language' ); ?>
						</span>
						<span class="motta-button__text">
							<?php echo esc_html( $args['language'] ); ?>
						</span>
					</span>
					<?php echo \Motta\Icon::get_svg( 'right' ); ?>
				</a>
				<?php \Motta\Helper::language_switcher(); ?>
			</li>
		<?php endif; ?>

		<?php if( ! empty( $args['currency'] ) ) : ?>
			<li class="preferences-menu__item motta-currency">
				<a href="#" data-title="<?php esc_attr_e( 'Currency', 'motta' ); ?>">
					<span class="motta-button motta-button--text">
						<span class="motta-button__icon">
							<?php echo \Motta\Icon::get_svg( 'currency' ); ?>
						</span>
						<span class="motta-button__text">
							<?php echo esc_html( $args['currency'] ); ?>
						</span>
					</span>
					<?php echo \Motta\Icon::get_svg( 'right' ); ?>
				</a>
				<?php \Motta\WooCommerce\Currency::currency_switcher(); ?>
			</li>
		<?php endif; ?>
	</ul>
</nav>