/**
 * Sticky header OceanWP — Nước Đá 168
 */
(function () {
	'use strict';

	function initStickyHeader() {
		var header = document.getElementById('site-header');

		if (!header) {
			return;
		}

		var stickyPoint = header.offsetTop + header.offsetHeight;
		var placeholder = document.createElement('div');
		placeholder.id = 'sticky-header-placeholder';

		window.addEventListener(
			'scroll',
			function () {
				if (window.scrollY > stickyPoint) {
					if (!header.classList.contains('my-sticky-active')) {
						header.classList.add('my-sticky-active');
						placeholder.style.height = header.offsetHeight + 'px';
						header.parentNode.insertBefore(placeholder, header);
					}
				} else {
					header.classList.remove('my-sticky-active');
					var existing = document.getElementById('sticky-header-placeholder');
					if (existing) {
						existing.remove();
					}
				}
			},
			{ passive: true }
		);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initStickyHeader);
	} else {
		initStickyHeader();
	}
})();
