<?php
/**
 * Template part for displaying the secondary menu
 *
 * @package Motta
 */
?>

<?php
	if ( ! has_nav_menu( 'secondary-menu' ) ) {
		return;
	}

	if ( class_exists( '\Motta\Addons\Modules\Mega_Menu\Walker' ) ) {
		wp_nav_menu( apply_filters( 'motta_navigation_secondary_menu_content', array(
			'theme_location' 	=> 'secondary-menu',
			'container'      	=> 'nav',
			'container_id'   	=> 'secondary-navigation',
			'container_class'   => 'main-navigation secondary-navigation',
			'menu_class'     	=> 'nav-menu menu',
			'walker'			=> new \Motta\Addons\Modules\Mega_Menu\Walker()
		) ) );
	} else {
		wp_nav_menu( apply_filters( 'motta_navigation_secondary_menu_content', array(
			'theme_location' 	=> 'secondary-menu',
			'container'      	=> 'nav',
			'container_id'   	=> 'secondary-navigation',
			'container_class'   => 'main-navigation secondary-navigation',
			'menu_class'     	=> 'nav-menu menu',
		) ) );
	}
?>