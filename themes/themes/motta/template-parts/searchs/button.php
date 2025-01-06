<?php
/**
 * Template part for displaying the search items
 *
 * @package Motta
 */

$class = isset($args['search_items_button_class']) && ! empty($args['search_items_button_class']) ? $args['search_items_button_class'] : '';
$search_items_button_display = isset($args['search_items_button_display']) && ! empty($args['search_items_button_display']) ? $args['search_items_button_display'] : '';

?>

<button class="header-search__button motta-button <?php echo esc_attr( $class ); ?>" type="submit" aria-label="<?php esc_attr__('Search Button', 'motta') ?>">
	<?php
		if ( $search_items_button_display !== 'icon' ) {
			esc_html_e( 'Search', 'motta' );
		} else {

			echo '<span class="motta-button__icon">' . \Motta\Icon::get_svg( 'search' ) . '</span>';
		}
	?>
</button>