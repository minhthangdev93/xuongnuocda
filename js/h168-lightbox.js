/**
 * Lightbox dùng chung — trang chủ & giới thiệu
 */
document.addEventListener('DOMContentLoaded', function () {
	const lightbox = document.querySelector('.h168-lightbox');
	if (!lightbox) {
		return;
	}

	// Đưa lightbox ra body để position:fixed hoạt động đúng trên mobile.
	if (lightbox.parentElement !== document.body) {
		document.body.appendChild(lightbox);
	}

	const lightboxImg = lightbox.querySelector('.h168-lightbox__img');

	function openLightbox(src, alt) {
		if (!lightboxImg) {
			return;
		}
		lightboxImg.src = src;
		lightboxImg.alt = alt || '';
		lightbox.hidden = false;
		lightbox.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
	}

	function closeLightbox() {
		if (!lightboxImg) {
			return;
		}
		lightbox.hidden = true;
		lightbox.setAttribute('aria-hidden', 'true');
		lightboxImg.src = '';
		document.body.style.overflow = '';
	}

	document.querySelectorAll('[data-lightbox-src]').forEach(function (trigger) {
		trigger.addEventListener('click', function (e) {
			e.preventDefault();
			openLightbox(
				trigger.getAttribute('data-lightbox-src'),
				trigger.getAttribute('data-lightbox-alt')
			);
		});
	});

	lightbox.querySelectorAll('[data-lightbox-close]').forEach(function (el) {
		el.addEventListener('click', closeLightbox);
	});

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && !lightbox.hidden) {
			closeLightbox();
		}
	});
});
