jQuery(document).ready(function ($) {
	"use strict";

	// Uploading files
	var file_frame_bg,
		$motta_page_header_bg_id              = $('#motta_page_header_bg_id'),
		$motta_page_header_bg                 = $('#motta_page_header_bg'),
		$motta_page_header_background_overlay = $('#motta_page_header_background_overlay'),
		$motta_page_header_textcolor          = $('#motta_page_header_textcolor'),
		$motta_page_header_textcolor_custom   = $('#motta_page_header_textcolor_custom'),
		$cat_page_header_bg = $motta_page_header_bg.find('.motta-cat-page-header-bg');

	$motta_page_header_bg.on('click', '.upload_images_button', function (event) {
		var $el = $(this);

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if (file_frame_bg) {
			file_frame_bg.open();
			return;
		}

		// Create the media frame.
		file_frame_bg = wp.media.frames.downloadable_file = wp.media({
			multiple: false
		});

		// When an image is selected, run a callback.
		file_frame_bg.on('select', function () {
			var selection = file_frame_bg.state().get('selection'),
				attachment_ids = $motta_page_header_bg_id.val();

			selection.map(function (attachment) {
				attachment = attachment.toJSON();

				if (attachment.id) {
					attachment_ids = attachment.id;

					$cat_page_header_bg.html('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment.url + '" width="auto" height="100px" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
				}

			});
			$motta_page_header_bg_id.val(attachment_ids);
		});


		// Finally, open the modal.
		file_frame_bg.open();
	});

	// Remove images.
	$motta_page_header_bg.on('click', 'a.delete', function () {
		$(this).closest('li.image').remove();

		var attachment_ids = '';

		$cat_page_header_bg.find('li.image').css('cursor', 'default').each(function () {
			var attachment_id = $(this).attr('data-attachment_id');
			attachment_ids = attachment_ids + attachment_id + ',';
		});

		$motta_page_header_bg_id.val(attachment_ids);

		return false;
	});

	// Text Color
	if( $motta_page_header_textcolor.val() == 'custom' ) {
		$motta_page_header_textcolor.closest( '.form-field' ).next().show();
	}

	$motta_page_header_textcolor.on( 'change', function () {
		if( $(this).val() == 'custom' ) {
			$(this).closest( '.form-field' ).next().slideDown();
		} else {
			$(this).closest( '.form-field' ).next().slideUp();
		}
	});

	// wpColorPicker
	$motta_page_header_background_overlay.wpColorPicker();
	$motta_page_header_textcolor_custom.wpColorPicker();
});
