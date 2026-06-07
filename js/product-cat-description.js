/**
 * Mô tả danh mục — xem thêm / thu gọn.
 */
(function () {
	'use strict';

	function initBlock(block) {
		var content = block.querySelector('.nuocda-cat-description__content');
		var toggle = block.querySelector('.nuocda-cat-description__toggle');
		var moreLabel = block.querySelector('.nuocda-cat-description__toggle-more');
		var lessLabel = block.querySelector('.nuocda-cat-description__toggle-less');

		if (!content || !toggle) {
			return;
		}

		function needsToggle() {
			return content.scrollHeight > content.clientHeight + 2;
		}

		function setCollapsed(collapsed) {
			content.classList.toggle('is-collapsed', collapsed);
			toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');

			if (moreLabel) {
				moreLabel.hidden = !collapsed;
			}
			if (lessLabel) {
				lessLabel.hidden = collapsed;
			}
		}

		function refresh() {
			content.classList.add('is-collapsed');
			toggle.hidden = !needsToggle();

			if (toggle.hidden) {
				setCollapsed(false);
			} else {
				setCollapsed(true);
			}
		}

		toggle.addEventListener('click', function () {
			var collapsed = content.classList.contains('is-collapsed');
			setCollapsed(!collapsed);
		});

		refresh();
		window.addEventListener('resize', refresh);
	}

	document.querySelectorAll('.nuocda-cat-description').forEach(initBlock);
})();
