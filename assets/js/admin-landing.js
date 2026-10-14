(function ($) {
	'use strict';

	function accordionStorageKey() {
		var tab = $('.nuocda-landing-form').data('tab') || 'home';
		return 'nuocda_landing_accordion_' + tab;
	}

	function saveOpenSections() {
		var open = [];
		$('.nuocda-admin-section.is-open').each(function (i) {
			open.push($(this).index('.nuocda-admin-section'));
		});
		try {
			sessionStorage.setItem(accordionStorageKey(), JSON.stringify(open));
		} catch (e) {
			/* ignore */
		}
	}

	function restoreOpenSections() {
		var raw;
		try {
			raw = sessionStorage.getItem(accordionStorageKey());
		} catch (e) {
			raw = null;
		}
		if (!raw) {
			return;
		}
		var open;
		try {
			open = JSON.parse(raw);
		} catch (e) {
			return;
		}
		if (!Array.isArray(open) || !open.length) {
			return;
		}
		$('.nuocda-admin-section').each(function (i) {
			var $sec = $(this);
			var isOpen = open.indexOf(i) !== -1;
			$sec.toggleClass('is-open', isOpen);
			$sec.find('.nuocda-admin-section__toggle').attr('aria-expanded', isOpen ? 'true' : 'false');
		});
	}

	function setSectionOpen($sec, open) {
		$sec.toggleClass('is-open', open);
		$sec.find('.nuocda-admin-section__toggle').attr('aria-expanded', open ? 'true' : 'false');
	}

	$(document).on('click', '.nuocda-admin-section__toggle', function (e) {
		e.preventDefault();
		var $sec = $(this).closest('.nuocda-admin-section');
		setSectionOpen($sec, !$sec.hasClass('is-open'));
		saveOpenSections();
	});

	$(document).on('click', '.nuocda-accordion-expand-all', function (e) {
		e.preventDefault();
		$('.nuocda-admin-section').each(function () {
			setSectionOpen($(this), true);
		});
		saveOpenSections();
	});

	$(document).on('click', '.nuocda-accordion-collapse-all', function (e) {
		e.preventDefault();
		$('.nuocda-admin-section').each(function () {
			setSectionOpen($(this), false);
		});
		saveOpenSections();
	});

	$(function () {
		restoreOpenSections();
	});

	function updatePreview($field, url) {
		var $preview = $field.siblings('.nuocda-image-preview');
		if (!$preview.length) {
			$preview = $field.closest('.nuocda-field--image').find('.nuocda-image-preview');
		}
		if (url) {
			$preview.attr('src', url).prop('hidden', false);
		} else {
			$preview.attr('src', '').prop('hidden', true);
		}
	}

	$(document).on('click', '.nuocda-upload-image', function (e) {
		e.preventDefault();
		var $wrap = $(this).closest('.nuocda-field--image');
		var $input = $wrap.find('.nuocda-image-url');
		var frame = wp.media({
			title: 'Chọn ảnh',
			button: { text: 'Dùng ảnh này' },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$input.val(attachment.url).trigger('change');
			updatePreview($input, attachment.url);
		});

		frame.open();
	});

	$(document).on('click', '.nuocda-remove-image', function (e) {
		e.preventDefault();
		var $input = $(this).closest('.nuocda-field--image').find('.nuocda-image-url');
		$input.val('');
		updatePreview($input, '');
	});

	$(document).on('change', '.nuocda-image-url', function () {
		updatePreview($(this), $(this).val());
	});

	$(document).on('click', '.nuocda-repeater-remove', function (e) {
		e.preventDefault();
		$(this).closest('.nuocda-repeater__row').remove();
	});

	$(document).on('click', '.nuocda-repeater-add', function (e) {
		e.preventDefault();
		var $repeater = $(this).closest('.nuocda-repeater');
		var type = $(this).data('type');
		var index = $repeater.find('.nuocda-repeater__row').length;
		var $form = $(this).closest('form.nuocda-landing-form');
		var optInput = $form
			.find('input[name^="nuocda_168_landing_"]:not([name^="nuocda_168_landing_galleries"]), textarea[name^="nuocda_168_landing_"]:not([name^="nuocda_168_landing_galleries"]), select[name^="nuocda_168_landing_"]')
			.first()
			.attr('name');
		var opt = optInput ? optInput.replace(/\[[^\]]+\].*$/, '') : 'nuocda_168_landing_home';
		var html = '';

		if (type === 'faq') {
			html =
				'<div class="nuocda-repeater__row">' +
				'<p class="nuocda-field"><label><strong>Câu hỏi</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[faq][items][' + index + '][q]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Trả lời</strong></label>' +
				'<textarea class="large-text" rows="3" name="' + opt + '[faq][items][' + index + '][a]"></textarea></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa</button></div>';
		} else if (type === 'stat') {
			html =
				'<div class="nuocda-repeater__row">' +
				'<p class="nuocda-field"><label><strong>Số</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[hero][stats][' + index + '][num]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Nhãn</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[hero][stats][' + index + '][label]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa dòng</button></div>';
		} else if (type === 'link') {
			html =
				'<div class="nuocda-repeater__row">' +
				'<p class="nuocda-field"><label><strong>Nhãn</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[links][items][' + index + '][label]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>URL</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[links][items][' + index + '][url]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa</button></div>';
		} else if (type === 'store-item') {
			html =
				'<div class="nuocda-repeater__row nuocda-repeater__row--card">' +
				'<p class="nuocda-field"><label><strong>Tên cửa hàng / đại lý</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[items][' + index + '][name]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Địa chỉ</strong></label>' +
				'<textarea class="large-text" rows="2" name="' + opt + '[items][' + index + '][address]"></textarea></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa điểm</button></div>';
		} else if (type === 'product') {
			html =
				'<div class="nuocda-repeater__row nuocda-repeater__row--card">' +
				'<p class="nuocda-field"><label><strong>Tên SP</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[products][items][' + index + '][name]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Mô tả</strong></label>' +
				'<textarea class="large-text" rows="2" name="' + opt + '[products][items][' + index + '][desc]"></textarea></p>' +
				'<p class="nuocda-field nuocda-field--image"><label><strong>Ảnh</strong></label>' +
				'<span class="nuocda-image-field"><input type="url" class="large-text nuocda-image-url" name="' + opt + '[products][items][' + index + '][img]" value="" />' +
				'<button type="button" class="button nuocda-upload-image">Chọn ảnh</button></span></p>' +
				'<p class="nuocda-field"><label><strong>Link</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[products][items][' + index + '][link]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa sản phẩm</button></div>';
		} else if (type === 'ops-stat') {
			html =
				'<div class="nuocda-repeater__row">' +
				'<p class="nuocda-field"><label><strong>Số</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[ops][stats][' + index + '][num]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Nhãn</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[ops][stats][' + index + '][label]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa dòng</button></div>';
		} else if (type === 'page-stat') {
			html =
				'<div class="nuocda-repeater__row">' +
				'<p class="nuocda-field"><label><strong>Số</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[stats][' + index + '][num]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Nhãn</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[stats][' + index + '][label]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa dòng</button></div>';
		} else if (type === 'review') {
			html =
				'<div class="nuocda-repeater__row nuocda-repeater__row--card">' +
				'<p class="nuocda-field"><label><strong>Số sao (1–5)</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[reviews][items][' + index + '][stars]" value="5" /></p>' +
				'<p class="nuocda-field"><label><strong>Nội dung</strong></label>' +
				'<textarea class="large-text" rows="3" name="' + opt + '[reviews][items][' + index + '][text]"></textarea></p>' +
				'<p class="nuocda-field"><label><strong>Tác giả / nguồn</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[reviews][items][' + index + '][author]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa</button></div>';
		} else if (type === 'channel-item') {
			html =
				'<div class="nuocda-repeater__row nuocda-repeater__row--card">' +
				'<p class="nuocda-field"><label><strong>Type (phone/zalo/email/quote/custom)</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[channels][items][' + index + '][type]" value="custom" /></p>' +
				'<p class="nuocda-field"><label><strong>Icon FA</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[channels][items][' + index + '][icon]" value="fa-check" /></p>' +
				'<p class="nuocda-field"><label><strong>Tiêu đề</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[channels][items][' + index + '][title]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Giá trị (dòng lớn)</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[channels][items][' + index + '][value]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Mô tả</strong></label>' +
				'<textarea class="large-text" rows="2" name="' + opt + '[channels][items][' + index + '][desc]"></textarea></p>' +
				'<p class="nuocda-field"><label><strong>Nút — Text</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[channels][items][' + index + '][btn]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>URL (trống = tự theo type)</strong></label>' +
				'<input type="text" class="large-text" name="' + opt + '[channels][items][' + index + '][url]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>CSS class</strong></label>' +
				'<input type="text" class="regular-text" name="' + opt + '[channels][items][' + index + '][class]" value="" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa thẻ</button></div>';
		} else if (
			type === 'highlight-item' ||
			type === 'home-highlight' ||
			type === 'tech-item' ||
			type === 'values-item' ||
			type === 'process-item' ||
			type === 'dept-item' ||
			type === 'commit-item' ||
			type === 'why-item'
		) {
			var iconPaths = {
				'highlight-item': '[intro][highlights]',
				'home-highlight': '[about_quick][highlights]',
				'tech-item': '[tech][items]',
				'values-item': '[values][items]',
				'process-item': '[process][items]',
				'dept-item': '[ops][departments]',
				'commit-item': '[commit][items]',
				'why-item': '[why][items]'
			};
			var iconHints = {
				'highlight-item': 'fa-industry',
				'home-highlight': 'fa-tint',
				'tech-item': 'fa-tint',
				'values-item': 'fa-eye',
				'process-item': 'fa-filter',
				'dept-item': 'fa-industry',
				'commit-item': 'fa-shield-alt',
				'why-item': 'fa-shield-alt'
			};
			var base = opt + iconPaths[type] + '[' + index + ']';
			var hint = iconHints[type] || 'fa-check';
			html =
				'<div class="nuocda-repeater__row nuocda-repeater__row--card">' +
				'<p class="nuocda-field"><label><strong>Tiêu đề</strong></label>' +
				'<input type="text" class="large-text" name="' + base + '[title]" value="" /></p>' +
				'<p class="nuocda-field"><label><strong>Mô tả</strong></label>' +
				'<textarea class="large-text" rows="2" name="' + base + '[desc]"></textarea></p>' +
				'<p class="nuocda-field"><label><strong>Icon FA (vd: ' + hint + ')</strong></label>' +
				'<input type="text" class="regular-text" name="' + base + '[icon]" value="' + hint + '" /></p>' +
				'<button type="button" class="button-link nuocda-repeater-remove">Xóa</button></div>';
		}

		$(this).before(html);
	});

	function galleryExistingIds($wrap) {
		var ids = {};
		$wrap.find('.nuocda-gallery-item').each(function () {
			ids[String($(this).data('id'))] = true;
		});
		return ids;
	}

	function galleryThumb(attachment) {
		if (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url) {
			return attachment.sizes.thumbnail.url;
		}
		if (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) {
			return attachment.sizes.medium.url;
		}
		return attachment.url;
	}

	function appendGalleryItem($list, inputName, attachment) {
		var id = String(attachment.id);
		var html =
			'<li class="nuocda-gallery-item" data-id="' + id + '">' +
			'<span class="nuocda-gallery-handle" title="Kéo để sắp xếp" aria-hidden="true">⋮⋮</span>' +
			'<img src="' + galleryThumb(attachment) + '" alt="" />' +
			'<input type="hidden" name="' + inputName + '" value="' + id + '" />' +
			'<button type="button" class="button-link nuocda-gallery-remove" aria-label="Xóa ảnh">&times;</button>' +
			'</li>';
		$list.append(html);
	}

	function initGallerySortable($list) {
		if (!$list.length || typeof $.fn.sortable !== 'function') {
			return;
		}

		if ($list.data('ui-sortable')) {
			$list.sortable('refresh');
			return;
		}

		$list.sortable({
			items: '.nuocda-gallery-item',
			cancel: '.nuocda-gallery-remove',
			placeholder: 'nuocda-gallery-placeholder',
			tolerance: 'pointer',
			opacity: 0.85,
			cursor: 'move',
			update: function () {
				$list.find('.nuocda-gallery-item').each(function (index) {
					$(this).attr('data-order', index + 1);
				});
			}
		});
	}

	function initAllGallerySortables() {
		$('.nuocda-gallery-list').each(function () {
			initGallerySortable($(this));
		});
	}

	initAllGallerySortables();

	$(document).on('click', '.nuocda-gallery-add', function (e) {
		e.preventDefault();
		var $btn = $(this);
		var $wrap = $btn.closest('.nuocda-field--gallery');
		var $list = $wrap.find('.nuocda-gallery-list');
		var inputName = $btn.data('input-name');
		var existing = galleryExistingIds($wrap);

		var frame = wp.media({
			title: 'Chọn ảnh thư viện',
			button: { text: 'Thêm vào thư viện' },
			multiple: true,
			library: { type: 'image' }
		});

		frame.on('select', function () {
			frame.state().get('selection').each(function (attachment) {
				attachment = attachment.toJSON();
				if (!attachment || !attachment.id) {
					return;
				}
				var id = String(attachment.id);
				if (existing[id]) {
					return;
				}
				existing[id] = true;
				appendGalleryItem($list, inputName, attachment);
			});
			initGallerySortable($list);
		});

		frame.open();
	});

	$(document).on('click', '.nuocda-gallery-remove', function (e) {
		e.preventDefault();
		var $list = $(this).closest('.nuocda-gallery-list');
		$(this).closest('.nuocda-gallery-item').remove();
		initGallerySortable($list);
	});

	$(document).on('click', '.nuocda-gallery-clear', function (e) {
		e.preventDefault();
		if (!window.confirm('Xóa hết ảnh đã chọn và dùng lại ảnh mặc định theo tên file?')) {
			return;
		}
		var $list = $(this).closest('.nuocda-field--gallery').find('.nuocda-gallery-list');
		$list.empty();
		initGallerySortable($list);
	});
})(jQuery);
