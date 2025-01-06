<?php
/**
 * Template part for displaying the primary menu
 *
 * @package Motta
 */
?>

<?php
	if ( ! has_nav_menu( 'primary-menu' ) ) {
		return;
	}

	$container_class = 'main-navigation primary-navigation';
	$container_class .= isset( $args['container_class'] ) && $args['container_class'] ? $args['container_class'] : '';

	$menu_class = isset( $args['menu_class'] ) && $args['menu_class'] ? 'nav-menu menu' : 'menu';

	if ( isset( $args['mega_menu'] ) && $args['mega_menu'] && class_exists( '\Motta\Addons\Modules\Mega_Menu\Walker' ) ) {
		wp_nav_menu( apply_filters( 'motta_navigation_primary_menu_content', array(
			'theme_location' 	=> 'primary-menu',
			'container'      	=> 'nav',
			'container_class'   => $container_class,
			'menu_class'     	=> $menu_class,
			'walker'			=> new \Motta\Addons\Modules\Mega_Menu\Walker()
		) ) );
	} else {
		wp_nav_menu( apply_filters( 'motta_navigation_primary_menu_content', array(
			'theme_location' 	=> 'primary-menu',
			'container'      	=> 'nav',
			'container_class'   => $container_class,
			'menu_class'     	=> $menu_class,
		) ) );
	}
?>