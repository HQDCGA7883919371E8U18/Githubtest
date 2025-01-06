(function ($) {
	'use strict';

	var motta = motta || {};

	motta.init = function () {
		motta.$body   = $(document.body),
		motta.$window = $(window),
		motta.$header = $('#site-header');

		// Elements
		this.toggleOffCanvas();
		this.toggleModals();
		this.mottaMore();

		// Header
		this.focusSearchField();
		this.clickCategorySearch();
		this.clickSearchAdaptive();
		this.clickHamburgerMenu();
		this.clickCategoryMenu();
		this.hoverPrimaryMenu();
		this.clickHeaderDropdown();
		this.recentlyViewedProducts();
		this.stickyHeader();
		this.instanceSearch();
		this.tabMegaMenu();

		// Blog Sidebar
		this.postsSliderWidget();

		// Blog
		this.trendingPosts();
		this.featuredPosts();
		this.loadMorePosts();
		this.postFound();

		// Single Blog
		this.showEntryMetaShare();
		this.entryGallerySlider();

		// Product Notification
		this.addedToWishlistNotice();
		this.addedToCompareNotice();

		// Cart
        this.productQuantityNumber();
		this.updateQuantityAuto();
		this.openMiniCartPanel();
		this.productPopupATC();

		// Product Card
		this.productCardHoverSlider();
		this.productCardHoverZoom();
		this.productAttribute();
		this.productQuickView();
		this.addCompare();

		// Account
		this.loginTabs();

		this.productLoaded();

		// Preferences
		this.preferences();

		// add to cart AJAX
		this.addToCartSingleAjax();
		this.CrossSellsProductCarousel();

		// Back to top
		this.backToTop();

		this.storeCategories();

		// Fibo Search
		this.fiboSearch();

		// Product
		this.buttonPrint();
        this.copyLink();
		this.historyBack();
	};

	/**
	 * Toggle off-screen panels
	 */
	motta.toggleOffCanvas = function() {
		$( document.body ).on( 'click', '[data-toggle="off-canvas"]', function( event ) {
			var target = '#' + $( this ).data( 'target' );

			if ( $( target ).hasClass( 'offscreen-panel--open' ) ) {
				motta.closeOffCanvas( target );
			} else if ( motta.openOffCanvas( target ) ) {
				event.preventDefault();
			}
		} ).on( 'click', '.offscreen-panel .panel__button-close, .offscreen-panel .panel__backdrop, .offscreen-panel .sidebar__backdrop', function( event ) {
			event.preventDefault();

			motta.closeOffCanvas( this );
		} ).on( 'keyup', function ( e ) {
			if ( e.keyCode === 27 ) {
				motta.closeOffCanvas();
			}
		} );
	};

	/**
	 * Open off canvas panel.
	 * @param string target Target selector.
	 */
	motta.openOffCanvas = function( target ) {
		var $target = $( target );
		$target = $target.length ? $target : $('.offscreen-panel[data-id="' + target + '"]' );
		if ( !$target.length ) {
			var target = target.replace( '#', '');
			$target = $('.offscreen-panel[data-id="' + target + '"]' );
		}
		if ( !$target.length ) {
			return false;
		}

		var widthScrollBar = window.innerWidth - $('#page').width();
		if( $('#page').width() < 767 ) {
			widthScrollBar = 0;
		}
		$(document.body).css({'padding-right': widthScrollBar, 'overflow': 'hidden'});

		$target.fadeIn();
		$target.addClass( 'offscreen-panel--open' );

		$( document.body ).addClass( 'offcanvas-opened ' + $target.attr( 'id' ) + '-opened' ).trigger( 'motta_off_canvas_opened', [$target] );

		return true;
	}

	/**
	 * Close off canvas panel.
	 * @param DOM target
	 */
	motta.closeOffCanvas = function( target ) {
		if ( !target ) {
			$( '.offscreen-panel' ).each( function() {
				var $panel = $( this );

				if ( ! $panel.hasClass( 'offscreen-panel--open' ) ) {
					return;
				}

				$panel.removeClass( 'offscreen-panel--open' ).fadeOut();
				$( document.body ).removeClass( $panel.attr( 'id' ) + '-opened' );
			} );
		} else {
			target = $( target ).closest( '.offscreen-panel' );
			target.removeClass( 'offscreen-panel--open' ).fadeOut();

			$( document.body ).removeClass( target.attr( 'id' ) + '-opened' );
		}

		$(document.body).removeAttr('style');

		$( document.body ).removeClass( 'offcanvas-opened' ).trigger( 'motta_off_canvas_closed', [target] );
	}

	/**
	 * Toggle modals.
	 */
	 motta.toggleModals = function() {
		$( document.body ).on( 'click', '[data-toggle="modal"]', function( event ) {
			var target = '#' + $( this ).data( 'target' );

			if ( $( target ).hasClass( 'modal--open' ) ) {
				motta.closeModal( target );
			} else if ( motta.openModal( target ) ) {
				event.preventDefault();
			}
		} ).on( 'click', '.modal .modal__button-close, .modal .modal__backdrop', function( event ) {
			event.preventDefault();

			motta.closeModal( this );
		} ).on( 'keyup', function ( e ) {
			if ( e.keyCode === 27 ) {
				motta.closeModal();
			}
		} );
	};

	/**
	 * Open a modal.
	 *
	 * @param string target
	 */
	motta.openModal = function( target ) {
		var $target = $( target );

		$target = $target.length ? $target : $('.modal[data-id="' + target + '"]' );
		if ( !$target.length ) {
			var target = target.replace( '#', '');
			$target = $('.modal[data-id="' + target + '"]' );
		}

		if ( !$target.length ) {
			return false;
		}

		var widthScrollBar = window.innerWidth - $('#page').width();
		if( $('#page').width() < 767 ) {
			widthScrollBar = 0;
		}
		$(document.body).css({'padding-right': widthScrollBar, 'overflow': 'hidden'});

		$target.fadeIn();
		$target.addClass( 'modal--open' );

		$( document.body ).addClass( 'modal-opened ' + $target.attr( 'id' ) + '-opened' ).trigger( 'motta_modal_opened', [$target] );

		return true;
	}

	/**
	 * Close a modal.
	 *
	 * @param string target
	 */
	motta.closeModal = function( target ) {
		if ( !target ) {
			$( '.modal' ).removeClass( 'modal--open' ).fadeOut();

			$( '.modal' ).each( function() {
				var $modal = $( this );

				if ( ! $modal.hasClass( 'modal--open' ) ) {
					return;
				}

				$modal.removeClass( 'modal--open' ).fadeOut();
				$( document.body ).removeClass( $modal.attr( 'id' ) + '-opened' );
			} );
		} else {
			target = $( target ).closest( '.modal' );
			target.removeClass( 'modal--open' ).fadeOut();

			$( document.body ).removeClass( target.attr( 'id' ) + '-opened' );
		}

		$(document.body).removeAttr('style');

		$( document.body ).removeClass( 'modal-opened' ).trigger( 'motta_modal_closed', [target] );
	}

	/**
	 * Motta More
	 */
	motta.mottaMore = function () {
		$( document.body ).on( 'click', '.motta-more__button', function(e) {
			e.preventDefault();

			var $settings = $(this).closest( '.motta-more' ).data( 'settings' ),
				$more     = $settings.more,
				$less     = $settings.less;

			if( $(this).hasClass( 'less' ) ) {
				$(this).removeClass( 'less' );
				$(this).siblings( '.motta-more__content' ).slideUp().removeClass( 'show' );
				$(this).text( $more )
			} else {
				$(this).addClass( 'less' );
				$(this).siblings( '.motta-more__content' ).slideDown().addClass( 'show' );
				$(this).text( $less )
			}
		});


	}

	/**
	 * Open trending post when focus on search field
	 */
	 motta.focusSearchField = function() {
		$( '.header-search .header-search__field' ).on( 'focus', function() {
			var $field = $( this );
			var $trendingSearches = $field.closest( '.header-search' ).find( '.header-search__trending--outside' );

			$field.closest('.header-search__form').addClass( 'header-search__form--focused' );

			if ( ! $field.closest('.header-search__form').hasClass( 'searched' ) ) {
				$trendingSearches.addClass( 'header-search__trending--open' );
			}
			$field.addClass( 'header-search--focused' );

			$field.closest('.header-search__form').find('.header-search__results').removeClass( 'hidden' );

			$( window ).one( 'scroll', function() {
				$field.trigger('blur');
			} );
		} );

		$( '#search-modal .search-modal__field' ).on( 'focus', function() {
			$( '#search-modal').find('.header-search__results').removeClass( 'hidden' );
			if ( ! $(this).closest('.search-modal__form').hasClass( 'searched' ) ) {
				$( '#search-modal').find('.header-search__trending').addClass( 'header-search__trending--open' );
			}
		} );

		$( document.body ).on( 'click', '.header-search__trending-label, .header-search__categories-label', function() {
			$( '.header-search__trending--outside' ).removeClass( 'header-search__trending--open' );
			$('.header-search__form').removeClass( 'header-search__form--focused' );
		}).on( 'click', 'div', function( event ) {
			var $target = $( event.target );

			if ( $target.is( '.header-search' ) || $target.closest( '.header-search' ).length || $target.closest( '.search-modal__form' ).length ) {
				return;
			}

			$( '.header-search__trending--outside' ).removeClass( 'header-search__trending--open' );
			$( '.header-search' ).removeClass( 'header-search--focused' );
			$('.header-search__form').removeClass( 'header-search__form--focused' );

			$( '.header-search').find('.header-search__results').addClass( 'hidden' );
		} );

		var width = $( '.header-search--form' ).data('width');

		if ( width ) {
			motta.$window.on('resize', function () {
				if (motta.$window.width() > 1300) {
					$( '.header-search--form' ).css('max-width', width);
				} else {
					$( '.header-search--form' ).removeAttr("style");
				}

			}).trigger('resize');
		}
	};

	/**
	 * Open category list
	 */
	motta.clickCategorySearch = function() {
		if ( ! mottaData.header_search_type ) {
			return;
		}

		if ( mottaData.header_search_type == 'adaptive' && mottaData.post_type == 'post' ) {
			return;
		}

		$( '.header-search__categories-label' ).on( 'click', function() {
			$( this ).closest('.header-search__form').find('.header-search__categories').addClass( 'header-search__categories--open' );
			$( this ).closest('.header-search__form').addClass( 'categories--open' );
		});

		$( document.body ).on( 'click', '.header-search__categories-close', function() {
			$(this).closest('.header-search__categories').removeClass('header-search__categories--open');
			$('.header-search__form').removeClass( 'categories--open' );
		}).on( 'click', 'div', function( event ) {
			var $target = $( event.target );

			if ( $target.is( '.header-search' ) || $target.closest( '.header-search' ).length ) {
				return;
			}

			$( '.header-search__categories' ).removeClass('header-search__categories--open');
			$( '.header-search__form' ).removeClass( 'categories--open' );
		} );

		$( '.header-search__categories a' ).on( 'click', function(e) {
			e.preventDefault();

			$( '.header-search__categories a' ).removeClass('active');
			$(this).addClass('active');

			var cat = $(this).attr('data-slug'),
				text = $(this).text();

			$(this).closest('.header-search__form').find('input.category-name').val(cat);
			$(this).closest('.header-search__categories').removeClass('header-search__categories--open');
			$('.header-search__form').removeClass( 'categories--open' );
			$('.header-search__form').find('.header-search__categories-label').find('.header-search__categories-text').text(text);

			var $categoryWidth = $('.header-search__categories-label').is(":visible") ? $('.header-search__categories-label').outerWidth(true) : 0,
				$dividerWidth = $('.header-search__divider').is(":visible") ? $('.header-search__divider').outerWidth(true) : 0;

			if (motta.$body.hasClass('rtl')) {
				$(this).closest('.header-search__form').find('.close-search-results').css('left', $categoryWidth + $dividerWidth + 10);
			} else {
				$(this).closest('.header-search__form').find('.close-search-results').css('right', $categoryWidth + $dividerWidth + 10);
			}
		});

		$(window).on( 'load', function() {
			var cat = $('.header-search__form').find('input.category-name').val();

			if( cat ) {
				var item = $('.header-search__categories').find('a[data-slug="'+cat+'"]');
				$( '.header-search__categories a' ).removeClass('active');
				item.addClass('active');
			}
		});
	};

	/**
	 * Open search adaptive
	 */
	motta.clickSearchAdaptive = function() {
		$( '.header-search--icon' ).on( 'click', '.header-search__icon', function() {
			$( this ).closest('.header-search--icon').addClass( 'header-search--icon-open' );
		});

		$( document.body ).on( 'click', 'div', function( event ) {
			var $target = $( event.target );

			if ( $target.is( '.header-search--icon' ) || $target.closest( '.header-search--icon' ).length ) {
				return;
			}

			$( '.header-search--icon' ).removeClass( 'header-search--icon-open' );
		} );
	};

	/**
	 * Posts Slider Widget.
	 */
	motta.postsSliderWidget = function () {
		if (typeof Swiper === 'undefined') {
			return;
		}

		var container = $('.posts-slider-widget .swiper-container'),
			options = {
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
					renderBullet: function(index, className) {
						return '<span class="' + className + '"></span>';
					},
				},
				watchOverflow: true,
				navigation: {
					nextEl: container.find('.motta-swiper-button-next'),
					prevEl: container.find('.motta-swiper-button-prev'),
				},
				on: {
					init: function () {
						this.$el.css('opacity', 1);
					}
				},
				breakpoints: {
					0: {
						slidesPerView: 1,
						slidesPerGroup: 1,
						spaceBetween: 60,
					},
					600: {
						slidesPerView: 2,
						spaceBetween: 40,
					},
					992: {
						slidesPerView: 1,
						slidesPerGroup: 1,
						spaceBetween: 60,
					}
				}
			};

		new Swiper(container, options);
	};

	// Single Blog
	motta.showEntryMetaShare = function () {
		motta.$body.on( 'click', '.entry-meta__share', function() {
			if( $(this).hasClass('active') ) {
				$(this).removeClass('active');
			} else {
				$(this).addClass('active');
			}
		});

		$(document).on("click", function(e) {
			if( $(e.target).is('.entry-meta__share') === false ) {
				$('.entry-meta__share').removeClass('active');
			}
		});
	};

	motta.entryGallerySlider = function () {
		if (typeof Swiper === 'undefined') {
			return;
		}

		var container = $('.single-post .entry-gallery.swiper-container'),
			options = {
				slidesPerView: 1,
				slidesPerGroup: 1,
				pagination: {
					el: ".motta-swiper-pagination",
					clickable: true,
					renderBullet: function(index, className) {
						return '<span class="' + className + '"></span>';
					},
				},
				navigation: {
					nextEl: container.find('.motta-swiper-button-next'),
					prevEl: container.find('.motta-swiper-button-prev'),
				},
				on: {
					init: function () {
						this.$el.css('opacity', 1);
					}
				},
			};

		new Swiper(container, options);
	};

	/**
	 * Trending Posts
	 */
	 motta.trendingPosts = function () {
		if (typeof Swiper === 'undefined') {
			return;
		}

		if ( !$('#trending-posts').hasClass('trending-posts--layout-2') ) {
			return;
		}

		$('.trending-posts__items').find('.hentry').addClass('swiper-slide');

		var $container = $('.trending-posts__items .swiper-container'),
			options = {
				navigation: {
					nextEl: $container.parent().find('.motta-swiper-button-next'),
					prevEl: $container.parent().find('.motta-swiper-button-prev'),
				},
				watchOverflow: true,
				on: {
					init: function () {
						this.$el.css('opacity', 1);
					}
				},
			};

		new Swiper($container, options);
	};

	/**
	 * Featured Posts
	 */
	motta.featuredPosts = function () {
		if (typeof Swiper === 'undefined') {
			return;
		}

		var carousel = null;
		var $window = $( window );
		var	$container = $( '.featured-posts__container' );

		if ( $container.length == 0 ) {
			return;
		}

		var	columns = $( '#motta-featured-posts' ).data( 'columns' ),
			options = {
				navigation: {
					nextEl: $container.parent().find( '.motta-swiper-button-next' ),
					prevEl: $container.parent().find( '.motta-swiper-button-prev' ),
				},
				watchOverflow: true,
				on: {
					init: function () {
						this.$el.css('opacity', 1);
					}
				},
				breakpoints: {
					0: {
						slidesPerView: 2,
						slidesPerGroup: 1,
						spaceBetween: 24,
					},
					600: {
						slidesPerView: 3,
						spaceBetween: 24,
					},
					992: {
						slidesPerView: columns,
						slidesPerGroup: 1,
						spaceBetween: 24,
					}
				}
			};

		// Init on window size larger than 768, otherwise destroy it.
		function conditionalInit() {
			if ( $window.width() >= 768 ) {
				$container.addClass('swiper-container');
				$container.find('.featured-posts__wrapper').addClass('swiper-wrapper');

				if ( ! carousel ) {
					carousel = new Swiper( $container, options );
				}
			} else if ( carousel ) {
				carousel.destroy();
				carousel = null;

				$container.removeClass('swiper-container');
				$container.find('.featured-posts__wrapper').removeClass('swiper-wrapper');
			}
		}

		conditionalInit();

		$window.on( 'load resize', function() {
			conditionalInit();
		} );
	};

	/**
	 * Ajax load more posts.
	 */
	motta.loadMorePosts = function() {
		$( document.body ).on( 'click', '.navigation.next-posts-navigation a', function( event ) {
			event.preventDefault();

			var $el = $( this ),
				$posts = $el.closest('#main'),
				currentPosts = $posts.children('.hentry').length,
				$navigation = $el.closest( '.navigation' ),
				url = $el.attr( 'href' ),
				$found = $('.motta-posts-found');

			if ( $el.closest('.next-posts-navigation').hasClass( 'loading' ) ) {
				return;
			}

			$el.closest('.next-posts-navigation').addClass( 'loading' );

			$.get( url, function( response ) {
				var $content = $( '#main', response ),
					$posts = $( '.hentry', $content ),
					numberPosts = $posts.length + currentPosts,
					$nav = $( '.next-posts-navigation', $content );

				$posts.each( function( index, post ) {
					$( post ).css( 'animation-delay', index * 100 + 'ms' );
				} );

				// Check if posts are wrapped or not.
				if ( $navigation.siblings( '.motta-posts__list' ).length ) {
					$posts.appendTo( $navigation.siblings( '.motta-posts__list' ) );
				} else {
					$posts.insertBefore( $found );
				}

				$posts.addClass( 'animated mottaFadeInUp' );

				if ( $nav.length ) {
					$el.replaceWith( $( 'a', $nav ) );
				} else {
					$navigation.fadeOut();
				}

				$navigation.removeClass( 'loading' );

				$found.find('.current-post').html(' ' + numberPosts);

				motta.postFound();

				if ( mottaData.blog_nav_ajax_url_change ) {
					window.history.pushState( null, '', url );
				}
			} );
		} );
	};

	motta.postFound = function (el) {
		var $found = $('.motta-posts-found__inner'),
			$foundEls = $found.find('.count-bar'),
			$current = $found.find('.current-post').html(),
			$total = $found.find('.found-post').html(),
			pecent = ($current / $total) * 100;

		$foundEls.css('width', pecent + '%');
	}

	motta.addedToWishlistNotice = function () {
		if (typeof mottaData.added_to_wishlist_notice === 'undefined' || !$.fn.notify) {
			return;
		}

		motta.$body.on('added_to_wishlist', function (e, $el_wrap) {
			var content = $el_wrap.data('product_title');
			getaddedToWishlistNotice(content);
			return false;
		});

		function getaddedToWishlistNotice($content) {

			$content += ' ' + mottaData.added_to_wishlist_notice.added_to_wishlist_text;

			$content += '<a href="' + mottaData.added_to_wishlist_notice.wishlist_view_link + '" class="btn-button">' + mottaData.added_to_wishlist_notice.wishlist_view_text + '</a>';


			var $checkIcon = '<span class="motta-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>',
				$closeIcon = '<span class="motta-svg-icon svg-active"><svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1L1 14M1 1L14 14" stroke="#A0A0A0" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';

			$.notify.addStyle('motta', {
				html: '<div>' + $checkIcon + $content + $closeIcon + '</div>'
			});
			$.notify('&nbsp', {
				autoHideDelay: mottaData.added_to_wishlist_notice.wishlist_notice_auto_hide,
				className: 'success',
				style: 'motta',
				showAnimation: 'fadeIn',
				hideAnimation: 'fadeOut'
			});
		}
	}

	motta.addedToCompareNotice = function () {
		if (typeof mottaData.added_to_compare_notice === 'undefined' || !$.fn.notify) {
			return;
		}

		motta.$body.on('added_to_compare', function (e, $el_wrap) {
			var content = $el_wrap.data('product_title');
			getaddedToCompareNotice(content);
			return false;
		});

		function getaddedToCompareNotice($content) {

			$content += ' ' + mottaData.added_to_compare_notice.added_to_compare_text;

			$content += '<a href="' + mottaData.added_to_compare_notice.compare_view_link + '" class="btn-button">' + mottaData.added_to_compare_notice.compare_view_text + '</a>';


			var $checkIcon = '<span class="motta-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>',
				$closeIcon = '<span class="motta-svg-icon svg-active"><svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1L1 14M1 1L14 14" stroke="#A0A0A0" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';

			$.notify.addStyle('motta', {
				html: '<div>' + $checkIcon + $content + $closeIcon + '</div>'
			});
			$.notify('&nbsp', {
				autoHideDelay: mottaData.added_to_compare_notice.compare_notice_auto_hide,
				className: 'success',
				style: 'motta',
				showAnimation: 'fadeIn',
				hideAnimation: 'fadeOut'
			});
		}
	}

	/**
	 * Change product quantity
	 */
	motta.productQuantityNumber = function () {
		motta.$body.on('click', '.motta-qty-button', function (e) {
			e.preventDefault();

			var $this = $(this),
				$qty = $this.siblings('.qty'),
				current = 0,
				min = parseFloat($qty.attr('min')),
				max = parseFloat($qty.attr('max')),
				step = parseFloat($qty.attr('step'));

			if ($qty.val() !== '') {
				current = parseFloat($qty.val());
			} else if ($qty.attr('placeholder') !== '') {
				current = parseFloat($qty.attr('placeholder'))
			}

			min = min ? min : 0;
			max = max ? max : current + 1;

			if ($this.hasClass('decrease') && current > min) {
				$qty.val(current - step);
				$qty.trigger('change');
			}
			if ($this.hasClass('increase') && current < max) {
				$qty.val(current + step);
				$qty.trigger('change');
			}
		});
	};

	motta.updateQuantityAuto = function() {
		var debounceTimeout = null;
		$( document.body ).on( 'change', '.woocommerce-mini-cart .qty', function() {
			var $this = $(this);
			if ( debounceTimeout ) {
				clearTimeout( debounceTimeout );
			}

			debounceTimeout = setTimeout( function() {
				motta.updateCartAJAX( $this );
			}, 500 );

		} );
	};

	motta.updateCartAJAX = function ($qty) {
		var $row = $qty.closest('.woocommerce-mini-cart-item'),
		key = $row.find('a.remove').data('cart_item_key'),
		nonce = $row.find('.woocommerce-mini-cart-item__qty').data('nonce'),
		ajax_url = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'update_cart_item');
		if ($.fn.block) {
			$row.block({
				message: null,
				overlayCSS: {
					opacity: 0.6,
					background: '#fff'
				}
			});
		}

		$.post(
			ajax_url, {
				cart_item_key: key,
				qty: $qty.val(),
				security: nonce
			}, function (response) {
				if (!response || !response.fragments) {
					return;
				}

				if ($.fn.unblock) {
					$row.unblock();
				}

				$( document.body ).trigger( 'added_to_cart', [response.fragments, response.cart_hash] );

				if( $('.single-product div.product').find('.motta-free-shipping-bar').length && $(response.fragments['div.widget_shopping_cart_content']).length && $(response.fragments['div.widget_shopping_cart_content']).find('.motta-free-shipping-bar').length ) {
					$('.single-product div.product').find('.motta-free-shipping-bar').replaceWith($(response.fragments['div.widget_shopping_cart_content']).find('.motta-free-shipping-bar'));
				}

			}).fail(function () {
			if ($.fn.unblock) {
				$row.unblock();
			}

			return;
		});
	};

	/**
	 * Open Mini Cart
	 */
	motta.openMiniCartPanel = function () {
		if (typeof mottaData.added_to_cart_notice === 'undefined') {
			return;
		}

		if (mottaData.added_to_cart_notice.added_to_cart_notice_layout !== 'mini') {
			return;
		}

		var product_title = '';
		$(document.body).on('adding_to_cart', function (event, $thisbutton) {
			if ( mottaData.added_to_cart_notice.header_cart_icon_behaviour === 'panel' ) {
                product_title = '1';
            } else {
				product_title = '2';
			}
		});

		$(document.body)
			.on('added_to_cart wc_fragments_refreshed', function () {
				if (product_title === '1') {
					motta.openOffCanvas( '#cart-panel' );
				}

				if(product_title === '2') {
					$('html, body').animate({ scrollTop: 0 }, 800);

                    setTimeout(function() {
                        $('.header-cart .header-button-dropdown').trigger( 'click' );
                    }, 900);
				}
			});

	};

	/**
	 * Toggle product popup add to cart
	 */
	motta.productPopupATC = function () {
		if (typeof mottaData.added_to_cart_notice === 'undefined') {
			return;
		}

		if (mottaData.added_to_cart_notice.added_to_cart_notice_layout != 'popup') {
			return;
		}

		var $modal = $('#motta-popup-add-to-cart'),
			$product = $modal.find('.product-modal-content'),
			$recomended = $product.find('.motta-product-popup-atc__recommendation');

		if ($modal.length < 1) {
			return
		}

		var $product_item_id = 0,
			$product_id = 0;
		$(document.body).on('adding_to_cart', function (event, $thisbutton) {
			$product_item_id = $product_id = 0;
			if (typeof $thisbutton.data('product_id') !== 'undefined') {
				$product_id = $thisbutton.data('product_id');
				$product_item_id = '0,' + $product_id;
			}

			$product_id = typeof($product_id) === 'undefined' ? 0 : $product_id;

			if ($product_id === 0 && $thisbutton.closest('form.cart').length) {
				var $cartForm = $thisbutton.closest('form.cart');
				$product_id = $cartForm.find('.motta_product_id').val();

				$product_item_id = $product_id;

				if ($cartForm.hasClass('variations_form') && $cartForm.find('.single_variation_wrap .variation_id').length > 0) {
					$product_item_id = $cartForm.find('.single_variation_wrap .variation_id').val();
				}

				if ($cartForm.hasClass('grouped_form')) {
					$product_item_id = 0;
					$cartForm.find('.woocommerce-grouped-product-list-item').each(function () {
						if ($(this).find('.quantity .input-text').val() > 0) {
							var $id = $(this).attr('id');
							$id = $id.replace('product-', '');
							$product_item_id += ',' + $id;
						}
					});
				}
			}

		});

		$(document.body).on('wc_fragments_loaded', function () {
			if ($product_item_id && $product_id) {
				getProductPopupContent($product_id, $product_item_id);
				$product_item_id = 0;
				$product_id = 0;
			}
		});

		$(document.body).on('wc_fragments_refreshed', function () {
			if ($product_item_id && $product_id) {
				getProductPopupContent($product_id, $product_item_id);
				$product_item_id = 0;
				$product_id = 0;
			}

		});

		function getProductPopupContent($product_id, $product_item_id) {
			var $item_ids = $product_item_id.split(',');
			for (var i = 0; i < $item_ids.length; ++i) {
				$product.find('.mini-cart-item-' + $item_ids[i]).addClass('active');
			}

			$product.find('.woocommerce-mini-cart-item').not('.active').remove();
			$product.find('.woocommerce-mini-cart-item').find('.woocommerce-mini-cart-item__qty, .woocommerce-mini-cart-item__remove').remove();

			motta.openModal($modal);

			if ( ! $recomended.hasClass('loaded') ) {

				$recomended.removeClass('active').removeClass('hidden').addClass('loading');

				$.ajax({
					url: mottaData.ajax_url.toString().replace('%%endpoint%%', 'motta_product_popup_recommended'),
					type: 'POST',
					data: {
						nonce: mottaData.nonce,
						product_id: $product_id
					},
					success: function (response) {
						if (!response || response.data === '') {
							$recomended.addClass('hidden');
							return;
						}
						$recomended.html(response.data);
						productsCarousel($recomended);
						$recomended.removeClass('loading');
						$recomended.addClass('active');

					}
				})
			} else {
				if ( ! $recomended.hasClass('has-carousel') ) {
					productsCarousel($recomended);
					$recomended.addClass('has-carousel');
				}
			}

		}

		function productsCarousel($selector) {
			if ($selector.length < 1) {
				return;
			}

			var $products = $selector.find('ul.products');

			if ($products.length < 1) {
				return;
			}

			$products.find('li.product').addClass('swiper-slide');
			$products.after('<div class="swiper-pagination"></div>');
			new Swiper( $selector.find('.linked-products-carousel').get(0), {
				loop: false,
				autoplay: false,
				speed: 800,
				watchSlidesVisibility: true,
				slidesPerView: 4,
				navigation: {
					nextEl: $selector.find('.motta-swiper-button-next'),
					prevEl: $selector.find('.motta-swiper-button-prev'),
				},
				pagination: {
					el: $selector.find('.swiper-pagination'),
					type: 'bullets',
					clickable: true,
				},
				on: {
					init: function () {
						this.$el.css('opacity', 1);
					}
				},
				spaceBetween: 20,
				breakpoints: {
					300: {
						slidesPerView: mottaData.mobile_product_columns == '' ? 2 : mottaData.mobile_product_columns,
						slidesPerGroup: mottaData.mobile_product_columns == '' ? 2 : mottaData.mobile_product_columns,
						spaceBetween: 16,
					},
					768: {
						slidesPerView: 3,
					},
					1200: {
						slidesPerView: 4,
					}
				}
			});
		};
	};

	/**
	 * Click Hamburger Menu
	 */
	motta.clickHamburgerMenu = function() {
		var $menu = $('#hamburger-panel, #mobile-menu-panel, #category-menu-panel, #mobile-header-v11-menu-panel, #mobile-header-v12-menu-panel');
		$menu.find( 'ul.menu > li.menu-item-has-children > a' ).find('.motta-svg-icon--select-arrow').remove();
		$menu.find( 'ul.menu > li.menu-item-has-children' ).append( '<button class="motta-button motta-button--text motta-button--small toggle-submenu"><span class="motta-svg-icon icon-arrow"><svg viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span></button' );
		$menu.find( 'ul.menu > li.menu-item-has-children > ul.sub-menu > li.menu-item-has-children > a, ul.menu > li.menu-item-has-children > ul.sub-menu li.menu-item--type-label h6' ).append( '<span class="motta-svg-icon icon-minus"><svg viewBox="0 0 32 32"><path d="M26.667 13.333v5.333h-21.333v-5.333h21.333z"></path></svg></span>' );
		$menu.find( 'ul.menu > li.menu-item-has-children > ul.sub-menu > li.menu-item-has-children > a, ul.menu > li.menu-item-has-children > ul.sub-menu li.menu-item--type-label h6' ).append( '<span class="motta-svg-icon icon-plus"><svg viewBox="0 0 32 32"><path d="M26.667 13.333h-8v-8h-5.333v8h-8v5.333h8v8h5.333v-8h8z"></path></svg></span>' );

		// Add class menu sub item in hamburget menu
		$menu.find('ul.menu > li.menu-item-has-children > ul.sub-menu li.menu-item--type-label').nextUntil('.menu-item--type-label').addClass('menu-sub-item');

		$('#mobile-menu-panel').find('.panel__content.open-submenus-both').find('.menu-item-has-children > a').addClass('open-submenus');

		$menu.on( 'click', 'ul.menu > li.menu-item-has-children > .toggle-submenu, ul.menu > li.menu-item-has-children > .open-submenus', function( e ) {
			var $this = $(this).parent().find('> a');

			var title = $this.data('title'),
				imageUrl = $this.data('image');

				$this.closest($menu).find('.header-category__sub-title').html(title);

			if ( $this.data('image') ) {
				$menu.find('.header-category__box-image').css('background-image', 'url(' + imageUrl + ')');
				$menu.find('.header-category__box').addClass('has-image');
			} else {
				$menu.find('.header-category__box-image').removeAttr("style");
			}

			$this.closest($menu).find('.panel__container').addClass('motta-open');

			$this.closest('li.menu-item-has-children').addClass('motta-open');
		} ).on( 'click', '.header-category__back', function( e ) {
			$(this).closest($menu).find('.panel__container').removeClass('motta-open');
			$(this).closest($menu).find('li.menu-item-has-children').removeClass('motta-open');
			$(this).closest($menu).find('.preferences-menu__item').removeClass('motta-open');
		} ).on( 'click', 'ul.menu > li.menu-item-has-children > ul.sub-menu > li.menu-item-has-children > a', function( e ) {
			e.preventDefault();

			var $item = $( this ).closest('li.menu-item-has-children');

			$item.toggleClass( 'active' ).siblings().removeClass( 'active' );

			// If this is sub-menu item
			if ( $item.closest( 'ul' ).hasClass( 'sub-menu' ) ) {
				$item.children( 'ul' ).slideToggle();
				$item.siblings().find( 'ul' ).slideUp();
			}
		} ).on( 'click', 'ul.menu > li.menu-item-has-children > ul.sub-menu li.menu-item--type-label', function( e ) {
			e.preventDefault();

			$(this).toggleClass('active').siblings().removeClass('active');

			$(this).nextAll().each( function() {
				if ($(this).filter('.menu-item--type-label').length) {
				   return false;
				}

				$(this).filter('li.menu-sub-item').slideToggle(200);
			});
		} ).on( 'click', '.preferences-menu__item > a', function(e) {
			e.preventDefault();

			$(this).closest($menu).find('.header-category__sub-title').html($(this).data('title'));
			$(this).closest($menu).find('.panel__container').addClass('motta-open');
			$(this).parent().addClass('motta-open');
		});
	}

	/**
	 * Click Category Menu
	 */
	motta.clickCategoryMenu = function() {
		var $menu = $('.header-category-menu');

		// Add icon arrow
		if ( $menu.hasClass('header-category--icon') ) {
			$menu.find( 'ul.menu > li.menu-item-has-children > a' )
				.append( '<span class="motta-svg-icon icon-arrow"><svg viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span>' );
		}
		if ( $menu.hasClass('header-category--both') ) {
			$menu.find( '.motta-button--subtle + .header-category__content ul.menu > li.menu-item-has-children > a, .motta-button--text + .header-category__content ul.menu > li.menu-item-has-children > a' )
				.append( '<span class="motta-svg-icon icon-arrow"><svg viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span>' );
		}

		// Hover line in show sub menu
		$menu.find('ul.menu > li.menu-item-has-children')
			.mouseenter(function() {
				$menu.find('ul.menu').addClass('motta-hover');
			})
			.mouseleave(function() {
				$menu.find('ul.menu').removeClass('motta-hover');
		});

		// Click category menu content
		$menu.on( 'click', '.header-category__title', function( e ) {
			if ( $(this).closest($menu).hasClass('header-category--open') ) {
				return;
			}

			$(this).closest($menu).toggleClass('motta-open');
		} );

		$( document.body ).on( 'click', 'div', function( e ) {
			if ( $('.header-category-menu').hasClass('header-category--open') ) {
				return;
			}

			var $target = $( e.target );

			if ( $target.is( $menu ) || $target.closest( $menu ).length ) {
				return;
			}

			$menu.removeClass('motta-open');
		} );


		// Position left of mega menu container full width
		if ( $menu.find('.header-category__content .mega-menu-container').hasClass('full-width') ) {
			$('.header-category__content .mega-menu-container.full-width').append('<div class="motta-container-full-width-hover"></div>');

			var $content = $menu.find('.header-category__content'),
				pLeft = $content.offset().left,
				pLeft = pLeft - $(window).scrollLeft(),
				wContent = $content.width(),
				position = -pLeft - wContent;

			$menu.find('.motta-container-full-width-hover').css('left', position);
		}
	}

	/**
	 * Hover Primary Menu
	 */
	motta.hoverPrimaryMenu = function() {
		var $menu 		= $('.site-header .primary-navigation, .site-header .secondary-navigation'),
			$wpadminbar = $('#wpadminbar').is(":visible") ? $('#wpadminbar').outerHeight(true) : 0,
			$campaign 	= $('#campaign-bar').is(":visible") ? $('#campaign-bar').outerHeight(true) : 0,
			$topbar 	= $('#topbar').is(":visible") ? $('#topbar').outerHeight(true) : 0,
			$height 	= $('#site-header').outerHeight(true) + $wpadminbar + $campaign + $topbar;

		$menu.append('<div class="motta-primary-menu-overlay"></div>');
		$menu.find('.motta-primary-menu-overlay').css( 'top', $height );

		$menu.find('ul.menu > li.menu-item-has-children')
			.mouseenter(function() {
				$menu.find('.motta-primary-menu-overlay').addClass('motta-hover');
			})
			.mouseleave(function() {
				$menu.find('.motta-primary-menu-overlay').removeClass('motta-hover');
		});

		motta.$window.scroll(function () {
			var scroll = motta.$window.scrollTop();
			$menu.find('.motta-primary-menu-overlay').css( 'top', $height - scroll );
		});

	}

	motta.recentlyViewedProducts = function () {
		motta.$body.find( '.header-view-history' ).each( function () {
			var $el = $( this ),
				found = true;

			$el.on( 'click', '.header-view-history__title',  function ( e ) {
				e.preventDefault();

				$el.toggleClass('motta-open');

				if ( found ) {
					loadAjaxRecently( $el );
					found = false;
				}
			});


		});

		$( document.body ).on( 'click', 'div', function( e ) {
			var $view_history = motta.$body.find( '.header-view-history' ),
				$target = $( e.target );


			if ( $target.is( $view_history ) || $target.closest( $view_history ).length ) {
				return;
			}

			$view_history.removeClass( 'motta-open' );
		} );

        function loadAjaxRecently( $selector ) {
            var $recently = $selector.find( '.header-view-history__content-products' ),
				ajax_url = mottaData.ajax_url.toString().replace( '%%endpoint%%', 'motta_recently_viewed_products' );

            if ( ajax_url == '') {
                return;
            }

            $.post(
                ajax_url,
                {
                    nonce: mottaData.nonce,
                },
                function ( response ) {
                    $recently.html( response );

					motta.productCardHoverSlider();

					$recently.addClass( 'swiper-container' );
					if ( $recently.find( '.products' ) ) {
                        $selector.find( '.products' ).addClass( 'swiper-wrapper' );
                    }

					if ( ! $recently.find('ul.products li').hasClass('no-products') ) {
						getProductCarousel( $recently );
					}

					$selector.addClass('products-loaded')
					$selector.find('.motta-pagination--loading').remove();

                }
            );
        }

		function getProductCarousel( $els ) {
            var $selector = $els,
                $slider_container = $selector.find( 'ul.products' );

			if ( $selector.find('div').hasClass('no-products') ) {
				return;
			}

			$selector.addClass( 'swiper-container' );

			$selector.find( '.products' ).removeClass( 'product-card-layout-2' );
			$selector.find( '.products' ).removeClass( 'product-card-layout-3' );
			$selector.find( '.products' ).removeClass( 'product-card-layout-4' );
			$selector.find( '.products' ).removeClass( 'product-card-layout-5' );

			if ( $selector.find( '.products' ) ) {
				$selector.find( '.products' ).addClass( 'swiper-wrapper' );
				$selector.find( '.products' ).addClass( 'product-card-layout-1 product-card-layout-recently' );
			}

			$selector.parent().append( '<span class="motta-svg-icon swiper-button motta-swiper-button-prev motta-swiper-button"><svg viewBox="0 0 32 32"><path d="M20.58 2.58l2.84 2.84-10.6 10.58 10.6 10.58-2.84 2.84-13.4-13.42z"></path></svg></span>' );
			$selector.parent().append( '<span class="motta-svg-icon swiper-button motta-swiper-button-next motta-swiper-button"><svg viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span>' );

			$slider_container.find( 'li.product' ).addClass( 'swiper-slide' );

			var options = {
				loop: false,
				autoplay: false,
				speed: 800,
				watchOverflow: true,
				lazy: true,
				slidesPerView: 7,
				breakpoints: {}
			};

			options.navigation = {
				nextEl: $selector.parent().find('.motta-swiper-button-next'),
				prevEl: $selector.parent().find('.motta-swiper-button-prev'),
			}

			new Swiper( $selector, options );
        };
	};

	/**
	 * Click Header Dropdown
	 */
	motta.clickHeaderDropdown = function() {
		var $header = $('.site-header');
		var $cart_width = $('.site-header').find( '.header-cart a').width()/2 - 5;

		$header.find('.dropdown-content').append('<div class="dropdown-after"></div>');
		$header.find('.dropdown-after').css( 'right', $cart_width + 'px' );

		$header.on( 'click', '.header-button-dropdown', function( e ) {
			e.preventDefault();
			if( ! $(this).parent().find('.dropdown-content').hasClass('motta-open') ) {
				$('.dropdown-content').removeClass('motta-open');
			}
			$(this).parent().find('.dropdown-content').toggleClass('motta-open');
		} );

		$( document.body ).on( 'click', function( e ) {
			var $target = $( e.target ),
				$content = $('.header-button-dropdown').parent();

			if ( $target.is( $content ) || $target.closest( $content ).length ) {
				return;
			}

			$header.find('.dropdown-content').removeClass('motta-open');
		} );
	}

	/**
	 * Sticky header
	 */
	 motta.stickyHeader = function () {
		if ( ! mottaData.sticky_header ) {
			return;
		}

		var $headerMinimized = $('#site-header-minimized'),
			$headerSection = motta.$header.find('.site-header__section.motta-header-sticky'),
			$headerDesktop = motta.$header.find('.site-header__desktop').find('.header-sticky'),
			$headerMobile = motta.$header.find('.site-header__mobile').find('.header-mobile-sticky'),
			heightHeaderDesktop = $headerDesktop.length ? $headerDesktop.outerHeight() : 0,
			heightHeaderMobile = $headerMobile.length ? $headerMobile.outerHeight() : 0,
			header 		= motta.$header.outerHeight(true),
			hBody 		= motta.$body.outerHeight(true),
			campaign 	= $('#campaign-bar').is(":visible") ? $('#campaign-bar').height() : 0,
			topbar 		= $('#topbar').is(":visible") ? $('#topbar').height() : 0,
			scrollTop 	= header + campaign + topbar + 200;
			if ( 'up' === mottaData.sticky_header_on ) {
				if( $headerDesktop.length ) {
					var stickyHeader = new Headroom( $headerDesktop.get(0), {
						offset: scrollTop
					});

					stickyHeader.init();
				}

				if( $headerMobile.length ) {
					var stickyHeaderMobile = new Headroom( $headerMobile.get(0), {
						offset: scrollTop
					});

					stickyHeaderMobile.init();
				}
			} else {
				motta.$window.on('scroll', function () {
					sticky(scrollTop);
				});
			}

		var $sticky_menu = motta.$header.find('.header-sticky .header-category-menu');

		if ( $sticky_menu.hasClass('header-category--open') ) {
			$sticky_menu.removeClass('header-category--open motta-open');
		}

		$( document.body ).on( 'click', 'div', function( e ) {
			if ( $sticky_menu.hasClass('motta-open') ) {
				var $target = $( e.target );

				if ( $target.is( $sticky_menu ) || $target.closest( $sticky_menu ).length ) {
					return;
				}

				$sticky_menu.removeClass('motta-open');
			}
		} );

		function header_search() {
			$('.header-search__trending--outside').removeClass( 'header-search__trending--open' );
			$('.header-search').removeClass( 'header-search--focused' );
			$('.header-search__form').removeClass( 'header-search__form--focused' );

			$('.header-search__categories').removeClass( 'header-search__categories--open' );
			$('.header-search__form').removeClass( 'categories--open' );

			$('.header-search__results').addClass( 'hidden' );
		}

		/**
		 * Private function for sticky header
		 */
		function sticky(scrollTop) {
			var scroll 		= motta.$window.scrollTop();

			if (hBody <= scrollTop + motta.$window.height()) {
				return;
			}

			if (scroll > scrollTop) {
				$headerSection.addClass('minimized');

				if (motta.$window.width() > 992) {
					$headerMinimized.css('height', heightHeaderDesktop);
				} else {
					$headerMinimized.css('height', heightHeaderMobile);
				}

				header_search();

			} else {
				$headerSection.removeClass('minimized');

				$headerMinimized.removeAttr('style');
			}
		}
	};

	/**
	 * Product instance search
	 */
	 motta.instanceSearch = function () {
		if (mottaData.header_ajax_search != '1') {
			return;
		}

		var $modal = $('#search-modal, .header-search');

		var xhr = null,
			searchCache = {},
			$form = $modal.find('form');

		$modal.on('keyup', '.header-search__field, .search-modal__field', function (e) {
			var valid = false,
			$search = $(this);

			if (typeof e.which == 'undefined') {
				valid = true;
			} else if (typeof e.which == 'number' && e.which > 0) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if (!valid) {
				return;
			}

			if (xhr) {
				xhr.abort();
			}

			var $categoryWidth 	= $('.header-search__categories-label').is(":visible") ? $('.header-search__categories-label').outerWidth(true) : 0,
				$dividerWidth 	= $('.header-search__divider').is(":visible") ? $('.header-search__divider').outerWidth(true) : 0,
				$spacing 		= $categoryWidth + $dividerWidth + 10;

				if ( $('.header-search__container > div:first-child').hasClass('header-search__categories-label') ) {
					$spacing = 10;
				}

			if (motta.$body.hasClass('rtl')) {
				$modal.find('.close-search-results').css('left', $spacing);
			} else {
				$modal.find('.close-search-results').css('right', $spacing);
			}

			$modal.find('.header-search__trending').removeClass('header-search__trending--open');

			$modal.find('.result-list-found, .result-list-not-found').html('');

			var $currentForm = $search.closest('.header-search__form, .search-modal__form');

			if ($search.val().length < 2) {
				$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length');
			}

			search($currentForm);
		}).on('click', '.header-search__categories-container a', function () {
			if (xhr) {
				xhr.abort();
			}

			$modal.find('.result-list-found').html('');
			var $currentForm = $(this).closest('.header-search__form');

			search($currentForm);
		}).on('focusout', '.header-search__field, .search-modal__field', function () {
			var $search = $(this),
				$currentForm = $search .closest('.header-search__form, .search-modal__form');

			if ($search.val().length < 2) {
				$currentForm.removeClass('searching searched actived found-products found-no-product invalid-length');
			}
		});

		$modal.on('click', '.close-search-results', function (e) {
			e.preventDefault();
			$modal.find('.header-search__field, .search-modal__field').val('');
			$modal.find('.header-search__form, .search-modal__form').removeClass('searching searched actived found-products found-no-product invalid-length');

			$modal.find('.result-list-found').html('');
		});

		/**
		 * Private function for search
		 */
		function search($currentForm) {
			var $search = $currentForm.find('input.header-search__field, input.search-modal__field'),
				keyword = $search.val(),
				cat = 0,
				$results = $currentForm.find('.search-results');

			if ($currentForm.find('input.category-name').length > 0) {
				cat = $currentForm.find('input.category-name').val();
			}

			if (keyword.trim().length < 2) {
				$currentForm.removeClass('searching found-products found-no-product').addClass('invalid-length');
				return;
			}

			$currentForm.removeClass('found-products found-no-product').addClass('searching');

			var keycat = keyword + cat,
				url = $form.attr('action') + '?' + $form.serialize();

			if (keycat in searchCache) {
				var result = searchCache[keycat];

				$currentForm.removeClass('searching');
				$currentForm.addClass('found-products');
				$results.html(result.products);


				$(document.body).trigger('motta_ajax_search_request_success', [$results]);

				$currentForm.removeClass('invalid-length');
				$currentForm.addClass('searched actived');
			} else {
				var data = {
						'term': keyword,
						'cat': cat,
						'ajax_search_number': mottaData.header_search_number,
						'search_type': $currentForm.find('input.header-search__post-type, input.search-modal__post-type').val()
					},
					ajax_url = mottaData.ajax_url.toString().replace('%%endpoint%%', 'motta_instance_search_form');

				xhr = $.post(
					ajax_url,
					data,
					function (response) {
						var $products = response.data;

						$currentForm.removeClass('searching');
						$currentForm.addClass('found-products');
						$results.html($products);
						$currentForm.removeClass('invalid-length');

						$(document.body).trigger('motta_ajax_search_request_success', [$results]);

						// Cache
						searchCache[keycat] = {
							found: true,
							products: $products
						};

						$currentForm.addClass('searched actived');

					}
				);
			}
		}

		$( '.site-header .header-search__field' ).on( 'input', function() {
			var value = $(this).val();

			$( '.site-header .header-search__field' ).val(value);
		} );
	}

	/**
	 * Tab mega menu
	 */
	motta.tabMegaMenu = function () {
		var $menu = $('.site-header .main-navigation, #hamburger-panel, #mobile-menu-panel, #mobile-header-v11-menu-panel, #mobile-header-v12-menu-panel');

		$menu.on( 'mouseover', '.mega-menu--behavior-hover .mega-menu__tablist > li > a', function() {
			megaMenuContent($(this));
		});

		$menu.on( 'click', '.mega-menu--behavior-click .mega-menu__tablist > li > a', function( e ) {
			e.preventDefault();
			megaMenuContent($(this));
		});

		/**
		 * Tab mega menu content
		 */
		function megaMenuContent($this) {
			var $heading = $this.parent();

			if( ! $this.hasClass('active') ) {
				var $data = $heading.data( 'tab' );

				$menu.find('.mega-menu__tablist > li').removeClass( 'active' );
				$heading.addClass( 'active' );

				$heading.parent().siblings( '.mega-menu__panellist' ).find( '.mega-menu__tabpanel' ).removeClass( 'active' );
				$heading.parent().siblings( '.mega-menu__panellist' ).find( '[data-tabpanel="' + $data + '"]' ).addClass( 'active' );
			}
		}
	}

	motta.productCardHoverSlider = function () {
		var $selector = motta.$body.find('ul.products .product-thumbnails--slider'),
			options = {
				observer: true,
				observeParents: true,
				loop: false,
				autoplay: false,
				speed: 800,
				watchOverflow: true,
				lazy: true,
				breakpoints: {}
			};

		$selector.find('.woocommerce-loop-product__link').addClass('swiper-slide');

		setTimeout(function () {
			$selector.each(function () {
				options.navigation = {
					nextEl: $(this).find('.motta-product-card-swiper-next'),
					prevEl: $(this).find('.motta-product-card-swiper-prev'),
				}
				new Swiper($(this), options);
			});
		}, 200);

	};

	/**
	 * Product thumbnail zoom.
	 */
	motta.productCardHoverZoom = function () {
		if ( typeof mottaData.product_card_hover === 'undefined' || ! $.fn.zoom ) {
			return;
		}

		if (mottaData.product_card_hover !== 'zoom') {
			return;
		}

		var $seletor = motta.$body.find('ul.products .product-thumbnail-zoom');
		$seletor.each(function () {
			var $el = $(this);

			$el.zoom({
				url: $el.attr('data-zoom_image')
			});
		});
	};

	// Product Attribute
	motta.productAttribute = function () {
        motta.$body.on('click', '.product-variation-item--attrs', function (e) {
            e.preventDefault();
            $(this).siblings('.product-variation-item--attrs').removeClass('selected');
            $(this).addClass('selected');
            var variations= $(this).data('product_variations'),
                $mainImages = $(this).closest('.product-inner').find('.woocommerce-LoopProduct-link').first(),
                $image = $mainImages.find('img').first(),
				$price = $(this).closest('.product-inner').find('.price');

            $mainImages.addClass('image-loading');

			if (variations.img_src && variations.img_src != 'undefined') {
            	$image.attr('src', variations.img_src);
			}
            if (variations.img_srcset && variations.img_srcset != 'undefined') {
                $image.attr('srcset', variations.img_srcset);
            }

			if (variations.price && variations.price != 'undefined') {
            	$price.replaceWith(variations.price);
			}

			if( variations.img_zoom_src && variations.img_zoom_src != 'undefined' ) {
				$mainImages.find('.zoomImg').attr('src', variations.img_zoom_src);
			}

            $image.load(function () {
                $mainImages.removeClass('image-loading');
            });
        });

		motta.$body.on('mouseover', '.product-variation-items', function (e) {
            e.preventDefault();
            $(this).closest('.product-inner').find('.product-thumbnail').addClass('hover-swatch');
        }).on('mouseout', '.product-variation-items', function (e) {
            e.preventDefault();
			$(this).closest('.product-inner').find('.product-thumbnail').removeClass('hover-swatch');
        });
    }

	/**
	 * Quick view modal.
	 */
	motta.productQuickView = function() {
		$( document.body ).on( 'click', '.motta-button--quickview', function( event ) {
			event.preventDefault();

			var $el = $( this ),
				product_id = $el.data( 'id' ),
				$target = $( '#' + $el.data( 'target' ) ),
				$container = $target.find( '.woocommerce' ),
				ajax_url = mottaData.ajax_url.toString().replace('%%endpoint%%', 'product_quick_view');

			$target.removeClass( 'modal--open' );
			$target.addClass( 'loading' );
			$container.find( '.product-quickview' ).html( '' );

			$.post(
				ajax_url,
				{
					action    : 'motta_get_product_quickview',
					product_id: product_id,
					security  : mottaData.product_quickview_nonce
				},
				function( response ) {
					$container.find( '.product-quickview' ).replaceWith( response.data );

					if ( response.success ) {
						update_quickview();
					}

					$target.removeClass( 'loading' );
					$target.addClass( 'modal--open' );

					motta.addToCartSingleAjax();

					motta.$body.trigger( 'motta_product_quick_view_loaded' );

					if ( $container.find('.deal-expire-countdown').length > 0) {
						$(document.body).trigger('motta_countdown', [$('.deal-expire-countdown')]);
					}
				}
			).fail( function() {
				window.location.herf = $el.attr( 'href' );
			} );

			/**
			 * Update quick view common elements.
			 */
			function update_quickview() {
				var $product = $container.find( '.product-quickview' ),
					$gallery = $product.find( '.woocommerce-product-gallery' ),
					$variations = $product.find( '.variations_form' );

				update_product_gallery();
				$gallery.on( 'motta_update_product_gallery_on_quickview', function(){
					update_product_gallery();
				});

				// Variations form.
				if (typeof wc_add_to_cart_variation_params !== 'undefined') {

					$variations.each(function () {
						variation_change();
						$(this).wc_variation_form();
					});
				}

				$( document.body ).trigger( 'init_variation_swatches');
			}

			/**
			 * Update quick view common elements.
			 */
			function update_product_gallery() {
				var $product = $container.find( '.product-quickview' ),
					$gallery = $product.find( '.woocommerce-product-gallery' );

				// Prevent clicking on gallery image link.
				$gallery.on( 'click', '.woocommerce-product-gallery__image a', function( event ) {
					event.preventDefault();
				} );

				// Init flex slider.
				if ( $gallery.find( '.woocommerce-product-gallery__image' ).length > 1 ) {
					$gallery.flexslider( {
						selector      : '.woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image',
						animation     : 'slide',
						animationLoop : false,
						animationSpeed: 500,
						controlNav    : true,
						directionNav  : true,
						prevText      : '<span class="motta-svg-icon motta-svg-icon--arrow-left-long"><svg width="24" height="24" aria-hidden="true" role="img" focusable="false" viewBox="0 0 32 32"><path d="M20.58 2.58l2.84 2.84-10.6 10.58 10.6 10.58-2.84 2.84-13.4-13.42z"></path></svg></span>',
						nextText      : '<span class="motta-svg-icon motta-svg-icon--arrow-right-long"><svg width="24" height="24" aria-hidden="true" role="img" focusable="false" viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span>',
						slideshow     : false,
						start         : function() {
							$gallery.css( 'opacity', 1 );
						},
					} );
				} else {
					$gallery.css( 'opacity', 1 );
				}

				$gallery.append( '<a class="product-image__link" href="' + $product.find( '.product_title a' ).attr( 'href' ) + '"></a>' );
			}

			/**
			 * Variations Change
			 */
			function variation_change() {
				var $price = $( '.product-quickview .variations-attribute-change .price' ).html(),
					$stock = $( '.product-quickview .variations-attribute-change .stock' ).html();

				$('.product-quickview .variations_form').on( 'show_variation', function () {
					var $container = $(this).closest( '.product-quickview' ).find( '.variations-attribute-change' ),
						$price_new = $(this).find( '.woocommerce-variation-price .price' ).html(),
						$stock_new = $(this).find( '.woocommerce-variation-availability .stock' ).html();

					$container.find( '.price' ).html( $price_new );
					$container.find( '.stock' ).html( $stock_new );
				});

				$('.product-quickview .variations_form').on( 'hide_variation', function () {
					var $container = $(this).closest( '.product-quickview' ).find( '.variations-attribute-change' );

					$container.find( '.price' ).html( $price );
					$container.find( '.stock' ).html( $stock );
				});
			}
		});
	}

	// add class compare when loading
    motta.addCompare = function () {
        motta.$body.on('click', 'a.compare:not(.added)', function (e) {
            e.preventDefault();

            var $el = $(this);
            $el.addClass('loading');

            $el.closest('.product-inner').find('.compare:not(.loading)').trigger('click');

            if ($(this).hasClass('added')) {
				$el.removeClass('loading');
            } else {
				setTimeout(function () {
                    $el.removeClass('loading');
                }, 2000);
			}
        });
    };

	// Account
	motta.loginTabs = function () {
		$( '.woocommerce-account__heading' ).on('click', 'h2', function (e) {
			e.preventDefault();
			var $heading = $(this).parent();

			if( ! $(this).hasClass('active') ) {
				var $data = $(this).data( 'tab' );

				$heading.find( 'h2' ).removeClass( 'active' );
				$(this).addClass( 'active' );

				$heading.siblings( '.woocommerce-account__form' ).find( '.woocommerce-form' ).removeClass( 'active' );
				$heading.siblings( '.woocommerce-account__form' ).find( '.' + $data ).addClass(  'active' );
			}
		});

		$( '.motta-create-account' ).on( 'click', 'a', function (e) {
			e.preventDefault();
			$(this).closest( '.woocommerce-account__summary' ).find( 'h2[data-tab="register"]' ).trigger( 'click' );
		});

		$( '.motta-sign-in' ).on( 'click', 'a', function (e) {
			e.preventDefault();
			$(this).closest( '.woocommerce-account__summary' ).find( 'h2[data-tab="login"]' ).trigger( 'click' );
		});

		if ( typeof mottaData.show_text !== 'undefined' && typeof mottaData.hide_text !== 'undefined') {
			$( '.woocommerce-account__summary .show-password-input' ).text( mottaData.show_text );

			$( '.woocommerce-account__summary .show-password-input' ).on( 'click', function (e) {
				e.preventDefault();
				if( $(this).hasClass( 'display-password' ) ) {
					$( '.woocommerce-account__summary .show-password-input' ).text( mottaData.hide_text );
				} else {
					$( '.woocommerce-account__summary .show-password-input' ).text( mottaData.show_text );
				}
			});
		}

		var $hash = window.location.hash;

		if ($hash === "#register") {
			$('.woocommerce-account__heading .register').trigger('click');

			$('html, body').animate({
				scrollTop: $( $hash ).offset().top - 300
			}, 300);
		}
	}

	motta.productLoaded = function () {
		motta.$window.on( 'motta_products_loaded', function( event, products ) {
			setTimeout( function() {
				products.removeClass( 'animated mottaFadeInUp' );
			}, 1500 );

			motta.productCardHoverSlider();
		});
	};

	// Preferences
	motta.preferences = function () {
		var $preferences = $( '.preferences-modal' );

		if ( $.fn.select2 ) {
			$preferences.find( '.language_select' ).select2( {
				width                  : '100%',
				minimumResultsForSearch: 5,
				selectionCssClass      : 'motta-input--default',
				dropdownCssClass	   : 'language-select',
				dropdownParent         : $preferences.find( '.language_select' ).parent()
			} );

			$preferences.find( '.currency_select' ).select2( {
				width                  : '100%',
				minimumResultsForSearch: 5,
				selectionCssClass      : 'motta-input--default',
				dropdownCssClass	   : 'currency-select',
				dropdownParent         : $preferences.find( '.currency_select' ).parent()
			} );
		}

		$preferences.on( 'change', '.preferences_select', function() {
			if( $(this).hasClass( 'language_select' ) ) {
				$(this).closest( 'form' ).attr( 'action', $(this).val() );
			}
		});


		$( '.update-preferences' ).on( 'click', function(e) {
			var $form = $(this).closest( 'form' ),
				url   = $form.attr( 'action' );

			$form.find( '.language_select' ).prop('disabled', true);

			if( url.indexOf( '?' ) != -1 ) {
				e.preventDefault();
				window.location.href = url + '&' + $form.serialize();
			}
		});
	};

    motta.addToCartSingleAjax = function () {
		var $selector = $('div.product, #motta-sticky-add-to-cart, .motta-elementor-add-to-cart');

		if ($selector.length < 1) {
			return;
		}

		if (!$selector.hasClass('product-add-to-cart-ajax')) {
			return;
		}

		$selector.find('form.cart').on('click', '.single_add_to_cart_button', function (e) {
			var $el = $(this),
				$cartForm = $el.closest('form.cart');

			if ($el.closest('.product').hasClass('product-type-external')) {
				return;
			}

			if ($cartForm.hasClass('buy-now-clicked')) {
				return;
			}

			if ($el.is('.disabled')) {
				return;
			}

			if ($cartForm.length > 0) {
				e.preventDefault();
			} else {
				return;
			}

			motta.addToCartFormAJAX($el, $cartForm, $el);
		});

	};

	motta.addToCartFormAJAX = function ($cartButton, $cartForm, $cartButtonLoading) {

		if ($cartButton.data('requestRunning')) {
			return;
		}

		$cartButton.data('requestRunning', true);

		var found = false;

		$cartButtonLoading.addClass('loading');
		if (found) {
			return;
		}
		found = true;

		var formData = $cartForm.serializeArray(),
			formAction = $cartForm.attr('action');

		if ($cartButton.val() != '') {
			formData.push({name: $cartButton.attr('name'), value: $cartButton.val()});
		}

		$(document.body).trigger('adding_to_cart', [$cartButton, formData]);

		$.ajax({
			url: formAction,
			method: 'post',
			data: formData,
			error: function (response) {
				window.location = formAction;
			},
			success: function (response) {
				if (!response) {
					window.location = formAction;
				}

				if (typeof wc_add_to_cart_params !== 'undefined') {
					if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
						window.location = wc_add_to_cart_params.cart_url;
						return;
					}
				}

                var $message = '',
					className = 'info';
				if ($(response).find('.woocommerce-notices-wrapper .woocommerce-message').length || $(response).find('.woocommerce-notices-wrapper .wc-block-components-notice-banner.is-success').length ) {
					$(document.body).trigger('wc_fragment_refresh');

					if( $('.single-product div.product').find('.motta-free-shipping-bar').length && $(response).find('div.product .motta-free-shipping-bar').length ) {
						$('.single-product div.product').find('.motta-free-shipping-bar').replaceWith($(response).find('div.product .motta-free-shipping-bar'));
					}

				} else {
					if (!$.fn.notify) {
						return;
					}

					var $checkIcon = '<span class="motta-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>',
						$closeIcon = '<span class="motta-svg-icon svg-active"><svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1L1 14M1 1L14 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';

					if ($(response).find('.woocommerce-notices-wrapper .woocommerce-error').length > 0) {
						$message = $(response).find('.woocommerce-notices-wrapper .woocommerce-error').html();
						className = 'error';
						$checkIcon = '<span class="motta-svg-icon message-icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g data-name="1" id="_1"><path d="M257,461.46c-114,0-206.73-92.74-206.73-206.73S143,48,257,48s206.73,92.74,206.73,206.73S371,461.46,257,461.46ZM257,78C159.55,78,80.27,157.28,80.27,254.73S159.55,431.46,257,431.46s176.73-79.28,176.73-176.73S354.45,78,257,78Z"/><path d="M342.92,358a15,15,0,0,1-10.61-4.39L160.47,181.76a15,15,0,1,1,21.21-21.21L353.53,332.4A15,15,0,0,1,342.92,358Z"/><path d="M171.07,358a15,15,0,0,1-10.6-25.6L332.31,160.55a15,15,0,0,1,21.22,21.21L181.68,353.61A15,15,0,0,1,171.07,358Z"/></g></svg></span>';
					} else if ($(response).find('.woocommerce-notices-wrapper .woocommerce-info').length > 0) {
						$message = $(response).find('.woocommerce-notices-wrapper .woocommerce-info').html();
					} else if ($(response).find('.woocommerce-notices-wrapper .wc-block-components-notice-banner.is-error').length) {
						className = 'error';
						$message = $(response).find('.woocommerce-notices-wrapper .wc-block-components-notice-banner.is-error .wc-block-components-notice-banner__content').html();
						$checkIcon = '<span class="motta-svg-icon message-icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g data-name="1" id="_1"><path d="M257,461.46c-114,0-206.73-92.74-206.73-206.73S143,48,257,48s206.73,92.74,206.73,206.73S371,461.46,257,461.46ZM257,78C159.55,78,80.27,157.28,80.27,254.73S159.55,431.46,257,431.46s176.73-79.28,176.73-176.73S354.45,78,257,78Z"/><path d="M342.92,358a15,15,0,0,1-10.61-4.39L160.47,181.76a15,15,0,1,1,21.21-21.21L353.53,332.4A15,15,0,0,1,342.92,358Z"/><path d="M171.07,358a15,15,0,0,1-10.6-25.6L332.31,160.55a15,15,0,0,1,21.22,21.21L181.68,353.61A15,15,0,0,1,171.07,358Z"/></g></svg></span>';
					} else if ($(response).find('.woocommerce-notices-wrapper .wc-block-components-notice-banner').length > 0) {
						$message = $(response).find('.woocommerce-notices-wrapper .wc-block-components-notice-banner .wc-block-components-notice-banner__content').html();
					}

					$.notify.addStyle('motta', {
						html: '<div>' + $checkIcon + '<ul class="message-box">' + $message + '</ul>' + $closeIcon + '</div>'
					});

					$.notify('&nbsp', {
						autoHideDelay: 5000,
						className: className,
						style: 'motta',
						showAnimation: 'fadeIn',
						hideAnimation: 'fadeOut'
					});
				}

				$cartButton.data('requestRunning', false);
				$cartButton.removeClass('loading');
				$cartButtonLoading.removeClass('loading');
				found = false;

			}
		});
	};

	/**
	 * Back to top icon
	 */
	motta.backToTop = function () {
		var $scrollTop = $('#gotop');

		motta.$window.on('scroll', function () {
			if (motta.$window.scrollTop() > motta.$window.height()) {
				$scrollTop.addClass('show-scroll');
			} else {
				$scrollTop.removeClass('show-scroll');
			}
		});

		motta.$body.on('click', '#gotop', function (e) {
			e.preventDefault();

			$('html, body').animate({scrollTop: 0}, 800);
		});
	};

	/**
     * Related Product Carousel.
     */
	motta.CrossSellsProductCarousel = function () {
        var $related = $('.woocommerce-cart .cross-sells');

        if ( !$related.length ) {
            return;
        }

        var $products = $related.find('ul.products');

        $products.wrap('<div class="related-product__carousel"></div>');
        $products.after('<span class="motta-svg-icon swiper-button motta-swiper-button-prev motta-swiper-button"><svg viewBox="0 0 32 32"><path d="M20.58 2.58l2.84 2.84-10.6 10.58 10.6 10.58-2.84 2.84-13.4-13.42z"></path></svg></span>');
        $products.after('<span class="motta-svg-icon swiper-button motta-swiper-button-next motta-swiper-button"><svg viewBox="0 0 32 32"><path d="M11.42 29.42l-2.84-2.84 10.6-10.58-10.6-10.58 2.84-2.84 13.4 13.42z"></path></svg></span>');
        $products.after('<div class="swiper-pagination"></div>');
        $products.wrap('<div class="swiper-container linked-products-carousel" style="opacity: 0;"></div>');
        $products.addClass('swiper-wrapper');
        $products.find('li.product').addClass('swiper-slide');

        var $spaceBetween = $products.hasClass('product-card-layout-3') || $products.hasClass('product-card-layout-5') ? 24 : 0;

        var options = {
            loop: false,
            autoplay: false,
            speed: 800,
            watchSlidesVisibility: true,
            watchOverflow: true,
            slidesPerView: 5,
            navigation: {
                nextEl: $related.find('.motta-swiper-button-next'),
                prevEl: $related.find('.motta-swiper-button-prev'),
            },
            pagination: {
                el: $related.find('.swiper-pagination'),
                type: 'bullets',
                clickable: true,
            },
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            spaceBetween: 0,
            breakpoints: {
                300: {
                    slidesPerView: mottaData.mobile_product_columns == '' ? 2 : mottaData.mobile_product_columns,
                    slidesPerGroup: mottaData.mobile_product_columns == '' ? 2 : mottaData.mobile_product_columns,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: $spaceBetween,
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: $spaceBetween,
                }
            }
        };

        new Swiper( $related.find('.linked-products-carousel'), options );
    }

	motta.storeCategories = function() {
		setTimeout(function() {
			$('.dokan-store-sidebar .cat-drop-stack ul .children').addClass('dropdown').removeAttr('style');
		}, 300);
	}

	motta.fiboSearch = function() {
		motta.$header.on('click', '.fibo-search-icon', function(e){
			e.preventDefault();
			var $searchModal = $('#fibo-search-modal').find('.js-dgwt-wcas-enable-mobile-form');

			if ($searchModal.length) {
				$searchModal[0].click();
			}
		});
	}

	motta.historyBack = function () {
        var $history= motta.$body.find('.motta-button--history');
		if ( ! $history.length) {
			return;
		}

        motta.$body.on('click', '.motta-button--history', function (e) {
            if (document.referrer != '') {
                e.preventDefault();

                window.history.go(-1);
                $(window).on('popstate', function (e) {
                    window.location.reload(true);
                });
            }

        });
    };

	 /**
     * Button Print
     */
	 motta.buttonPrint = function () {
        $( '.motta-button--product-print' ).on( 'click', function() {
            window.print();
        });
    }

    /**
     * Copy link
     */
    motta.copyLink = function () {
        $( '.motta-copylink__button' ).on( 'click', function(e) {
            e.preventDefault();
            var $button = $(this).closest('form').find('.motta-copylink__link');
            $button.select();
            document.execCommand('copy');
        });
    }

	/**
	 * Document ready
	 */
	$(function () {
		motta.init();
	});

})(jQuery);