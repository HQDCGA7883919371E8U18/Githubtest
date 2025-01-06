<?php
/**
 * Template part for displaying the logo
 *
 * @package Motta
 */

$display = ( isset( $args['display'] ) && ! empty( $args['display'] ) ) ? $args['display'] : 'dark';
$show_title = isset( $args['title'] ) ? $args['title'] : true;
$logo_light = '';
if ( 'text' == $args['type'] ) {
	$logo = ! empty( $args['logo'] ) ? $args['logo'] : \Motta\Helper::get_option( 'logo_text' );
} elseif ( 'svg' == $args['type'] ) {
	$logo = ! empty( $args['logo'] ) ? $args['logo'] : \Motta\Helper::get_option( 'logo_svg' );
	$logo_light = ! empty( $args['logo_light'] ) ? $args['logo_light'] : '';

} else {
	$logo = ! empty( $args['logo'] ) ? $args['logo'] : \Motta\Helper::get_option( 'logo' );
	$logo_light = ! empty( $args['logo_light'] ) ? $args['logo_light'] : '';

	if ( empty( $logo ) ) {
		$logo = get_theme_file_uri( '/images/logo.svg' );
		$logo = 'dark' != $display ? get_theme_file_uri( '/images/logo-' . $display . '.svg' ) : $logo;

		if ( function_exists('is_account_page') && is_account_page() && ! is_user_logged_in() ) {
			$logo = get_theme_file_uri( '/images/logo-short.svg' );
		}
	}
}

$logo = apply_filters( 'motta_header_logo', $logo, $args['type'] );
$logo_light = apply_filters( 'motta_header_logo_light', $logo_light, $args['type'] );

?>
<div class="header-logo">
	<a href="<?php echo esc_url( home_url() ) ?>">
		<?php if ( $logo ) : ?>
			<?php if ( 'text' == $args['type'] ) : ?>
				<span class="header-logo__text"><?php echo esc_html( $logo ) ?></span>
			<?php elseif ( 'svg' == $args['type'] ) : ?>
				<?php if( ! empty( $logo_light ) ) : ?>
					<span class="header-logo__svg logo-light"><?php echo \Motta\Icon::sanitize_svg( $logo_light ); ?></span>
				<?php endif; ?>
				<span class="header-logo__svg logo-dark"><?php echo \Motta\Icon::sanitize_svg( $logo ); ?></span>
			<?php else : ?>
				<?php if( ! empty( $logo_light ) ) : ?>
					<img src="<?php echo esc_url( $logo_light ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>" class="logo-light">
				<?php endif; ?>
				<img src="<?php echo esc_url( $logo ); ?>" class="logo-dark" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<?php endif; ?>
		<?php endif; ?>
	</a>
	<?php if ($show_title) : ?>
	<?php \Motta\Header\Main::site_branding_title(); ?>
	<?php \Motta\Header\Main::site_branding_description(); ?>
	<?php endif ?>
</div>
