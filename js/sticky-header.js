/**
 * Sticky header — chỉ gắn class bóng đổ, không đổi position (CSS sticky).
 * Tránh forced reflow + CLS do fixed/placeholder.
 */
(function () {
	'use strict';

	function initStickyHeader() {
		var header = document.getElementById('site-header');
		if (!header || !('IntersectionObserver' in window)) {
			return;
		}

		var sentinel = document.createElement('div');
		sentinel.id = 'sticky-header-sentinel';
		sentinel.setAttribute('aria-hidden', 'true');
		sentinel.style.cssText = 'position:absolute;top:0;left:0;width:1px;height:1px;pointer-events:none;opacity:0;';

		if (header.parentNode) {
			header.parentNode.insertBefore(sentinel, header);
		}

		var observer = new IntersectionObserver(
			function (entries) {
				var entry = entries[0];
				if (!entry) {
					return;
				}
				if (entry.isIntersecting) {
					header.classList.remove('is-stuck', 'my-sticky-active');
				} else {
					header.classList.add('is-stuck', 'my-sticky-active');
				}
			},
			{ rootMargin: '-1px 0px 0px 0px', threshold: 0 }
		);

		observer.observe(sentinel);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initStickyHeader);
	} else {
		initStickyHeader();
	}
})();
