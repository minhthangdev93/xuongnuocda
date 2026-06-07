(function ($) {
	'use strict';

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
		var opt = $('input[name^="nuocda_168_landing_"]').first().attr('name');
		opt = opt ? opt.replace(/\[[^\]]+\].*$/, '') : 'nuocda_168_landing_home';
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
		}

		$(this).before(html);
	});
})(jQuery);
