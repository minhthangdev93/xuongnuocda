/**
 * Sticky header OceanWP — Nước Đá 168
 * Tránh forced reflow: đọc geometry 1 lần, ghi DOM trong rAF.
 */
(function () {
	'use strict';

	function initStickyHeader() {
		var header = document.getElementById('site-header');

		if (!header) {
			return;
		}

		var stickyPoint = 0;
		var headerHeight = 0;
		var isStuck = false;
		var ticking = false;
		var placeholder = document.createElement('div');
		placeholder.id = 'sticky-header-placeholder';
		placeholder.setAttribute('aria-hidden', 'true');
		placeholder.style.display = 'none';
		placeholder.style.width = '100%';
		placeholder.style.pointerEvents = 'none';

		if (header.parentNode) {
			header.parentNode.insertBefore(placeholder, header);
		}

		function measure() {
			var rect = header.getBoundingClientRect();
			headerHeight = Math.round(rect.height) || header.offsetHeight || 74;
			stickyPoint = Math.round(window.scrollY + rect.top + headerHeight);
			placeholder.style.height = headerHeight + 'px';
		}

		function applySticky(shouldStick) {
			if (shouldStick === isStuck) {
				return;
			}
			isStuck = shouldStick;
			if (shouldStick) {
				header.classList.add('my-sticky-active');
				placeholder.style.display = 'block';
			} else {
				header.classList.remove('my-sticky-active');
				placeholder.style.display = 'none';
			}
		}

		function onScroll() {
			if (ticking) {
				return;
			}
			ticking = true;
			requestAnimationFrame(function () {
				ticking = false;
				applySticky(window.scrollY > stickyPoint);
			});
		}

		requestAnimationFrame(function () {
			measure();
			applySticky(window.scrollY > stickyPoint);
		});

		window.addEventListener('scroll', onScroll, { passive: true });

		var resizeTimer;
		window.addEventListener(
			'resize',
			function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function () {
					var wasStuck = isStuck;
					if (wasStuck) {
						header.classList.remove('my-sticky-active');
						placeholder.style.display = 'none';
						isStuck = false;
					}
					requestAnimationFrame(function () {
						measure();
						applySticky(window.scrollY > stickyPoint);
					});
				}, 120);
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
