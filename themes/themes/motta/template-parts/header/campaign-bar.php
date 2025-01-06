<?php
/**
 * Template part for displaying the campaign bar
 *
 * @package Motta
 */

?>
<div id="campaign-bar" class="campaign-bar campaign-bar--<?php echo \Motta\Helper::get_option( 'campaign_bar_position' ); ?>">
	<div class="campaign-bar__container container">
		<?php \Motta\Header\Campaign_Bar::campaign_items( $args ); ?>
	</div>
</div>