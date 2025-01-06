<?php
/**
 * Template part for displaying the page header
 *
 * @package Motta
 */

?>

<div id="page-header" class="<?php \Motta\Page_Header::classes('page-header')  ?>">
	<div class="container clearfix">
		<?php do_action('motta_before_page_header_content'); ?>
		<div class="page-header__content">
			<?php do_action('motta_page_header_content'); ?>
		</div>
		<?php do_action('motta_after_page_header_content'); ?>
	</div>
</div>