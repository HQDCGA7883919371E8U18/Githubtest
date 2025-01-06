jQuery( function( $ ) {
	'use strict';

	// Show/hide settings for post format when choose post format
	var $format = $( '#post-formats-select' ).find( 'input.post-format' ),
		$formatBox = $( '#post-format-settings' ),
		$box = $( '#display-settings' );

	$format.on( 'change', function () {
		var type = $format.filter( ':checked' ).val();

		handlePostFormatChanges( type );
	} );
	$format.filter( ':checked' ).trigger( 'change' );

	/**
	 * Handle post format change event.
	 */
	function handlePostFormatChanges( format ) {
		$formatBox.hide();
		if ( $formatBox.find( '.rwmb-field' ).hasClass( format ) ) {
			$formatBox.show();
		}

		$formatBox.find( '.rwmb-field' ).slideUp();
		$formatBox.find( '.' + format ).slideDown();
	}

	// Toggle spacing fields
	$( '#motta_content_top_spacing, #motta_content_bottom_spacing' ).on( 'change', function( event ) {
		if ( 'custom' === event.target.value ) {
			$( this ).closest( '.rwmb-field' ).next( '.custom-spacing' ).removeClass( 'hidden' );
		} else {
			$( this ).closest( '.rwmb-field' ).next( '.custom-spacing' ).addClass( 'hidden' );
		}
	} );

	// Toggle header background fields and text color fields
	$( '#header_layout' ).on( 'change', function( event ) {
		console.log(event.target.value);
		if ( 'v12' === event.target.value || 'page' === event.target.value ) {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-background-color' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-text-color' ).removeClass( 'hidden' );
		} else {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-background-color' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-text-color' ).addClass( 'hidden' );
		}
	} );

	// Toggle text color fields
	$( '#motta_header_background' ).on( 'change', function( event ) {
		if ( 'transparent' === event.target.value ) {
			$( this ).closest( '.rwmb-field' ).next( '.header-text-color' ).removeClass( 'hidden' );
		} else {
			$( this ).closest( '.rwmb-field' ).next( '.header-text-color' ).addClass( 'hidden' );
		}
	} );

	// Toggle logo fields
	$( '#header_logo_type' ).on( 'change', function( event ) {
		if ( 'image' === event.target.value ) {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-image' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-text' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-svg' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-width' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-height' ).removeClass( 'hidden' );
		} else if ( 'text' === event.target.value ) {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-text' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-image' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-svg' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-width' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-height' ).addClass( 'hidden' );
		} else if ( 'svg' === event.target.value ) {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-svg' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-image' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-text' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-width' ).removeClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-height' ).removeClass( 'hidden' );
		} else {
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-image' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-text' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-svg' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-width' ).addClass( 'hidden' );
			$( this ).closest( '.rwmb-meta-box' ).find( '.header-logo-height' ).addClass( 'hidden' );
		}
	} );

	// Toggle header sectoion fields
	$( '#header_layout' ).on( 'change', function( event ) {
		if ( 'page' === event.target.value ) {
			$( this ).closest( '.rwmb-meta-box' ).find( '.default-header-page' ).hide();
		} else {
			$( this ).closest( '.rwmb-meta-box' ).find( '.default-header-page' ).removeAttr('style');
		}
	} );

	// Toggle split content template fields
	$( '#page_template' ).on( 'change', function() {
		var template = $( this ).val();

		handlePageTemplateChanges( template );
	} );

	handlePageTemplateChanges( $( '#page_template' ).val() );

	// If this is blog page/shop page. This works with Gutenberg too.
	if ( ! $( '#page_template' ).length ) {
		$( '#motta_content_top_spacing, #motta_content_bottom_spacing, #header_layout, #motta_header_background, #header_logo_type' ).trigger( 'change' );
	}

	/**
	 * Handle page template changes.
	 *
	 * @param {string} template
	 */
	 function handlePageTemplateChanges( template ) {
		$( '#motta_content_top_spacing, #motta_content_bottom_spacing, #header_layout, #motta_header_background, #header_logo_type' ).trigger( 'change' );
	}

	/**
	 * This section for Gutenberg
	 */
	 if ( typeof window.wp.data !== 'undefined' ) {
		var editor = wp.data.select( 'core/editor' );

		if ( editor ) {
			var currentFormat = editor.getEditedPostAttribute( 'format' ),
				currentTemplate = editor.getEditedPostAttribute( 'template' ),
				firstFire = false;

			wp.data.subscribe( function() {
				var format = editor.getEditedPostAttribute( 'format' ),
					template = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );

				// Use this variable to run the theme check after editor loaded fully.
				if ( ! firstFire ) {
					handlePostFormatChanges( format );
					handlePageTemplateChanges( template );
					firstFire = true;
				}

				if ( currentFormat !== format ) {
					handlePostFormatChanges( format );
					currentFormat = format;
				}

				if ( currentTemplate !== template ) {
					handlePageTemplateChanges( template );
					currentTemplate = template;
				}
			} );

			// Run once again after page loaded to make sure all conditionals work correctly.
			$( window ).on( 'load', function() {
				handlePostFormatChanges( currentFormat );
				handlePageTemplateChanges( currentTemplate );
			} );
		}
	}

} );
