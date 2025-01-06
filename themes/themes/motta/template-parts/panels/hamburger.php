<?php
/**
 * Template part for displaying the hamburger panel
 *
 * @package Motta
 */

$data_target = ( isset( $args['data_target'] ) && ! empty( $args['data_target'] ) ) ? $args['data_target'] : '';
$account_info = isset( $args['account_info'] ) ? $args['account_info'] : true;
$account_icon = '';
$account_name = esc_html__( 'Hello', 'motta' );
if( $account_info ) {
	if ( is_user_logged_in() )  {
		$account_icon = get_avatar( get_current_user_id(), 44 );
		$user = get_user_meta( get_current_user_id() );
		$account_name .= ! empty($user['nickname'][0])? ', ' . $user['nickname'][0] : '';
	} else {
		$account_icon = \Motta\Icon::get_svg( 'account' );
		$account_name .= ', ' . esc_html__( 'Sign in', 'motta' );
	}
}
$submenus_classes = isset( $args['open_submenus'] ) ? 'open-submenus-' . $args['open_submenus'] : '';
?>

<div id="<?php echo esc_attr( $data_target ) ?>" class="offscreen-panel offscreen-panel--side-left hamburger-panel">
	<div class="panel__backdrop"></div>
	<div class="panel__container">
		<?php echo \Motta\Icon::get_svg( 'close', 'ui', 'class=panel__button-close' ); ?>

		<div class="panel__header">
			<div class="header-category__box">
				<div class="header-category__box-image"></div>
				<div class="header-category__top">
					<span class="header-category__back">
						<?php echo \Motta\Icon::get_svg( 'left' ) . esc_html__( 'Main Menu', 'motta' ); ?>
					</span>
					<?php echo \Motta\Icon::get_svg( 'close', 'ui', 'class=panel__button-close' ); ?>
				</div>
				<div class="header-category__sub-title"></div>
			</div>
			<?php if( function_exists('wc_get_account_endpoint_url') && $account_info ) { ?>
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ) ?>" class="motta-button  motta-button-text hamburger-panel__name">
					<span class="motta-button__icon"><?php echo '' . $account_icon; ?></span>
					<span class="motta-button__text"><?php echo '' . $account_name; ?></span>
				</a>
			<?php } ?>
		</div>

		<div class="panel__content <?php echo esc_attr($submenus_classes); ?>">
			<?php \Motta\Header\Hamburger::items( $args ) ?>
		</div>
	</div>
</div>