<?php
/**
 * Template part for displaying Preferences
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Motta
 */
?>
<?php $items = (array) \Motta\Theme::get_prop( 'modals' ); ?>
<?php if( in_array( 'preferences', $items ) ) : ?>
<div id="preferences-modal" class="preferences-modal modal">
	<div class="modal__backdrop"></div>
	<div class="modal__preferences">
		<div class="modal__header">
			<div class="modal__heading"><?php echo esc_html__( 'Preferences', 'motta' ); ?></div>
			<div class="modal__button-close"><?php echo \Motta\Icon::get_svg( 'close' ); ?></div>
		</div>

		<div class="modal__content">
			<form class="motta-preferences" method="get">
				<p class="form-row-preferences language_field" id="language_field">
					<?php \Motta\Helper::language_switcher( 'select' ); ?>
				</p>

				<p class="form-row-preferences currency_field" id="currency_field">
					<?php \Motta\WooCommerce\Currency::currency_switcher( 'select' ); ?>
				</p>
				<button type="submit" class="button update-preferences"><?php esc_html_e( 'Update', 'motta' ); ?></button>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>