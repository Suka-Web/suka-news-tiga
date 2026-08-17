( function () {
	'use strict';

	const categoryToggle = document.querySelector( '.category-toggle' );

	if ( categoryToggle ) {
		categoryToggle.addEventListener( 'click', function () {
			const isExpanded = categoryToggle.getAttribute( 'aria-expanded' ) === 'true';
			const categoryItems = document.querySelectorAll( '.category-list__extra' );
			const moreLabel = categoryToggle.querySelector( '.category-toggle__more' );
			const lessLabel = categoryToggle.querySelector( '.category-toggle__less' );

			categoryItems.forEach( function ( item ) {
				item.hidden = isExpanded;
			} );

			categoryToggle.setAttribute( 'aria-expanded', String( ! isExpanded ) );
			moreLabel.hidden = ! isExpanded;
			lessLabel.hidden = isExpanded;
		} );
	}

	const loadMoreButton = document.querySelector( '.load-more-news' );
	const newsFeedList = document.querySelector( '#news-feed-list' );

	if ( loadMoreButton && newsFeedList && window.sukaNewsSatu ) {
		loadMoreButton.addEventListener( 'click', async function () {
			const formData = new FormData();
			formData.append( 'action', 'suka_news_satu_load_more' );
			formData.append( 'nonce', loadMoreButton.dataset.nonce );
			formData.append( 'page', loadMoreButton.dataset.page );

			loadMoreButton.disabled = true;
			loadMoreButton.textContent = window.sukaNewsSatu.loadingText;

			try {
				const response = await fetch( window.sukaNewsSatu.ajaxUrl, {
					method: 'POST',
					body: formData,
				} );
				const result = await response.json();

				if ( ! response.ok || ! result.success ) {
					throw new Error( 'Load more request failed.' );
				}

				newsFeedList.insertAdjacentHTML( 'beforeend', result.data.html );
				loadMoreButton.dataset.page = result.data.nextPage;

				if ( ! result.data.hasMore ) {
					loadMoreButton.remove();
					return;
				}

				loadMoreButton.disabled = false;
				loadMoreButton.textContent = window.sukaNewsSatu.loadMoreText;
			} catch ( error ) {
				loadMoreButton.disabled = false;
				loadMoreButton.textContent = window.sukaNewsSatu.errorText;
			}
		} );
	}

	const homeSlider = document.querySelector( '.home-main-slider' );
	const homeSlides = document.querySelectorAll( '.home-slider-slide' );
	const homeThumbs = document.querySelectorAll( '.home-slider-thumb' );

	if ( homeSlider && homeSlides.length > 1 ) {
		let activeSlide = 0;
		const intervalMs = parseInt( homeSlider.dataset.sliderInterval || '5000', 10 );

		function showSlide( index ) {
			activeSlide = ( index + homeSlides.length ) % homeSlides.length;
			homeSlides.forEach( function ( slide, slideIndex ) {
				slide.classList.toggle( 'is-active', slideIndex === activeSlide );
			} );
			homeThumbs.forEach( function ( thumb, slideIndex ) {
				thumb.classList.toggle( 'is-active', slideIndex === activeSlide );
			} );
		}

		let sliderTimer = setInterval( function () {
			showSlide( activeSlide + 1 );
		}, intervalMs );

		homeThumbs.forEach( function ( thumb ) {
			thumb.addEventListener( 'click', function () {
				clearInterval( sliderTimer );
				showSlide( parseInt( thumb.dataset.slide || '0', 10 ) );
				sliderTimer = setInterval( function () {
					showSlide( activeSlide + 1 );
				}, intervalMs );
			} );
		} );
	}

	const navigation = document.querySelector( '.header-navigation' );
	const menuToggle = document.querySelector( '.menu-toggle' );
	const menuPanel = document.querySelector( '.primary-menu-panel' );
	const submenuParents = document.querySelectorAll( '.primary-menu .menu-item-has-children' );

	submenuParents.forEach( function ( menuItem ) {
		const submenu = menuItem.querySelector( ':scope > .sub-menu' );
		const menuLink = menuItem.querySelector( ':scope > a' );

		if ( ! submenu || ! menuLink ) {
			return;
		}

		const submenuButton = document.createElement( 'button' );
		const submenuId = 'submenu-' + Math.random().toString( 36 ).slice( 2, 9 );
		const expandLabel = window.sukaNewsSatu ? window.sukaNewsSatu.expandSubmenu : 'Buka submenu';
		const collapseLabel = window.sukaNewsSatu ? window.sukaNewsSatu.collapseSubmenu : 'Tutup submenu';
		submenu.id = submenuId;
		submenuButton.type = 'button';
		submenuButton.className = 'submenu-toggle';
		submenuButton.setAttribute( 'aria-expanded', 'false' );
		submenuButton.setAttribute( 'aria-controls', submenuId );
		submenuButton.setAttribute( 'aria-label', expandLabel );
		submenuButton.innerHTML = '<span aria-hidden="true"></span>';
		menuItem.insertBefore( submenuButton, submenu );

		submenuButton.addEventListener( 'click', function () {
			const isOpen = submenuButton.getAttribute( 'aria-expanded' ) === 'true';
			submenuButton.setAttribute( 'aria-expanded', String( ! isOpen ) );
			submenuButton.setAttribute( 'aria-label', isOpen ? expandLabel : collapseLabel );
			menuItem.classList.toggle( 'submenu-open', ! isOpen );
		} );
	} );

	function closeMobileMenu() {
		if ( ! menuToggle || ! menuPanel ) {
			return;
		}

		menuToggle.setAttribute( 'aria-expanded', 'false' );
		menuPanel.classList.remove( 'is-open' );
		submenuParents.forEach( function ( menuItem ) {
			const button = menuItem.querySelector( ':scope > .submenu-toggle' );
			menuItem.classList.remove( 'submenu-open' );
			if ( button ) {
				button.setAttribute( 'aria-expanded', 'false' );
			}
		} );
	}

	if ( menuToggle && menuPanel ) {
		menuToggle.addEventListener( 'click', function () {
			const isOpen = menuToggle.getAttribute( 'aria-expanded' ) === 'true';
			menuToggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
			menuPanel.classList.toggle( 'is-open', ! isOpen );
		} );

		document.addEventListener( 'click', function ( event ) {
			if ( window.innerWidth <= 900 && ! event.target.closest( '.primary-navigation' ) ) {
				closeMobileMenu();
			}
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' && menuPanel.classList.contains( 'is-open' ) ) {
				closeMobileMenu();
				menuToggle.focus();
			}
		} );

		window.addEventListener( 'resize', function () {
			if ( window.innerWidth > 900 ) {
				closeMobileMenu();
			}
		} );
	}

	if ( navigation ) {
		const placeholder = document.createElement( 'div' );
		placeholder.className = 'header-navigation-placeholder';
		navigation.parentNode.insertBefore( placeholder, navigation );

		let navigationTop = placeholder.getBoundingClientRect().top + window.scrollY;

		function updateStickyNavigation() {
			if ( window.innerWidth <= 900 ) {
				navigation.classList.remove( 'is-fixed' );
				placeholder.style.height = '0px';
				return;
			}

			const shouldFix = window.scrollY >= navigationTop;

			navigation.classList.toggle( 'is-fixed', shouldFix );
			placeholder.style.height = shouldFix ? navigation.offsetHeight + 'px' : '0px';
		}

		window.addEventListener( 'scroll', updateStickyNavigation, { passive: true } );
		window.addEventListener( 'resize', function () {
			navigationTop = placeholder.getBoundingClientRect().top + window.scrollY;
			updateStickyNavigation();
		} );
		updateStickyNavigation();
	}
}() );
