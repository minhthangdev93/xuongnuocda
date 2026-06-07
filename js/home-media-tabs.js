/**
 * Tab gallery trang chủ (lightbox: h168-lightbox.js)
 */
document.addEventListener('DOMContentLoaded', function () {
	const mediaSection = document.querySelector('.h168-media');
	if (!mediaSection) {
		return;
	}

	const tabs = mediaSection.querySelectorAll('.h168-media-tab');
	const panels = mediaSection.querySelectorAll('.h168-media-panel');

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			const target = tab.getAttribute('data-tab');

			tabs.forEach(function (item) {
				const isActive = item === tab;
				item.classList.toggle('is-active', isActive);
				item.setAttribute('aria-selected', isActive ? 'true' : 'false');
			});

			panels.forEach(function (panel) {
				const isActive = panel.getAttribute('data-panel') === target;
				panel.classList.toggle('is-active', isActive);
				panel.hidden = !isActive;
			});
		});
	});
});
