(function () {
	'use strict';

	function initMobileMenu() {
		if (!document.body.classList.contains('dropdown-mobile')) {
			return;
		}

		var dropdown = document.getElementById('mobile-dropdown');
		if (!dropdown) {
			return;
		}

		document.querySelectorAll('#mobile-dropdown .menu-item-has-children').forEach(function (item) {
			var link = item.querySelector(':scope > a');
			if (!link || link.querySelector('.dropdown-toggle')) {
				return;
			}
			var toggle = document.createElement('span');
			toggle.className = 'dropdown-toggle';
			toggle.setAttribute('tabindex', '0');
			link.appendChild(toggle);
		});

		document.addEventListener('click', function (event) {
			var menuBtn = event.target.closest('.mobile-menu');
			if (menuBtn) {
				event.preventDefault();
				dropdown.classList.toggle('show');
				document.body.classList.toggle('mobile-menu-open');
				menuBtn.classList.toggle('opened');
				return;
			}

			var subToggle = event.target.closest('#mobile-dropdown .dropdown-toggle');
			if (subToggle) {
				event.preventDefault();
				var parent = subToggle.closest('.menu-item-has-children');
				if (parent) {
					parent.classList.toggle('active');
				}
				return;
			}

			var parentLink = event.target.closest('#mobile-dropdown li.menu-item-has-children > a');
			if (parentLink && event.target.closest('.dropdown-toggle')) {
				return;
			}

			if (!event.target.closest('#mobile-dropdown') && dropdown.classList.contains('show')) {
				dropdown.classList.remove('show');
				document.body.classList.remove('mobile-menu-open');
				var openBtn = document.querySelector('.oceanwp-mobile-menu-icon a.mobile-menu.opened');
				if (openBtn) {
					openBtn.classList.remove('opened');
				}
			}
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMobileMenu);
	} else {
		initMobileMenu();
	}
})();
