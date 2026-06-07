(function () {
	'use strict';

	var config = window.nuocdaAjax || {};
	var messages = config.messages || {};

	function normalizeVnPhone(phone) {
		var cleaned = String(phone).replace(/[^\d+]/g, '');

		if (/^\+?84\d{9}$/.test(cleaned)) {
			return '0' + cleaned.replace(/^\+?84/, '');
		}

		if (/^0\d{9}$/.test(cleaned)) {
			return cleaned;
		}

		return '';
	}

	function isValidVnPhone(phone) {
		return /^0(3|5|7|8|9)\d{8}$/.test(normalizeVnPhone(phone));
	}

	function isValidEmail(email) {
		if (!email || !String(email).trim()) {
			return true;
		}
		return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).trim());
	}

	function showMessage(form, text, isSuccess, submitButton) {
		var existing = form.querySelector('.form-message');
		if (existing) {
			existing.remove();
		}

		var messageContainer = document.createElement('div');
		messageContainer.className = 'form-message ' + (isSuccess ? 'form-message--success' : 'form-message--error');
		messageContainer.textContent = text;

		if (submitButton) {
			submitButton.parentNode.insertBefore(messageContainer, submitButton);
		} else {
			form.appendChild(messageContainer);
		}

		if (isSuccess) {
			messageContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
		}
	}

	function setButtonLoading(button, loadingText) {
		button.disabled = true;
		button.dataset.nuocdaOriginalText = button.textContent;
		button.textContent = loadingText;
	}

	function resetButton(button, originalText) {
		button.disabled = false;
		button.textContent = originalText || button.dataset.nuocdaOriginalText || '';
	}

	function submitAjaxForm(form, action, submitButton, originalButtonText) {
		var formData = new FormData(form);
		formData.append('action', action);
		formData.append('nonce', config.nonce);

		setButtonLoading(submitButton, messages.sending || 'Đang gửi...');

		fetch(config.ajaxurl, {
			method: 'POST',
			body: formData,
			credentials: 'same-origin'
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (response) {
				var isSuccess = !!response.success;
				var message = response.data && response.data.message ? response.data.message : '';

				if (isSuccess) {
					form.reset();
					form.querySelectorAll('.c168-field-error, .footer-168__field-error').forEach(function (el) {
						el.classList.remove('c168-field-error', 'footer-168__field-error');
					});
				}

				showMessage(form, message, isSuccess, submitButton);
			})
			.catch(function () {
				showMessage(form, messages.network_error || 'Lỗi kết nối hoặc lỗi máy chủ. Vui lòng thử lại.', false, submitButton);
			})
			.finally(function () {
				resetButton(submitButton, originalButtonText);
			});
	}

	function handleContactSubmit(event) {
		event.preventDefault();

		var form = event.currentTarget;
		var submitButton = form.querySelector('.contact-submit-btn');
		var originalButtonText = submitButton ? submitButton.textContent : '';
		var nameInput = form.querySelector('input[name="name"]');
		var phoneInput = form.querySelector('input[name="phone"]');
		var emailInput = form.querySelector('input[name="email"]');

		form.querySelectorAll('.form-message').forEach(function (el) {
			el.remove();
		});
		form.querySelectorAll('.c168-field-error').forEach(function (el) {
			el.classList.remove('c168-field-error');
		});

		if (!nameInput || !nameInput.value.trim()) {
			showMessage(form, 'Vui lòng nhập họ và tên.', false, submitButton);
			if (nameInput) {
				nameInput.classList.add('c168-field-error');
				nameInput.focus();
			}
			return;
		}

		if (!phoneInput || !phoneInput.value.trim()) {
			showMessage(form, messages.phone_required || 'Vui lòng nhập số điện thoại.', false, submitButton);
			if (phoneInput) {
				phoneInput.classList.add('c168-field-error');
				phoneInput.focus();
			}
			return;
		}

		if (!isValidVnPhone(phoneInput.value)) {
			showMessage(form, messages.phone_invalid || 'Số điện thoại không hợp lệ.', false, submitButton);
			phoneInput.classList.add('c168-field-error');
			phoneInput.focus();
			return;
		}

		if (emailInput && !isValidEmail(emailInput.value)) {
			showMessage(form, 'Email không hợp lệ. Vui lòng kiểm tra lại.', false, submitButton);
			emailInput.classList.add('c168-field-error');
			emailInput.focus();
			return;
		}

		submitAjaxForm(form, 'nuocda_168_contact', submitButton, originalButtonText);
	}

	function handleFooterSubmit(event) {
		event.preventDefault();

		var form = event.currentTarget;
		var submitButton = form.querySelector('button[type="submit"]');
		var originalButtonText = submitButton ? submitButton.textContent : '';
		var phoneInput = form.querySelector('input[name="phone"]');
		var phoneValue = phoneInput ? phoneInput.value : '';

		form.querySelectorAll('.form-message').forEach(function (el) {
			el.remove();
		});

		if (phoneInput) {
			phoneInput.classList.remove('footer-168__field-error');
		}

		if (!phoneValue.trim()) {
			showMessage(form, messages.phone_required || 'Vui lòng nhập số điện thoại.', false, submitButton);
			if (phoneInput) {
				phoneInput.classList.add('footer-168__field-error');
				phoneInput.focus();
			}
			return;
		}

		if (!isValidVnPhone(phoneValue)) {
			showMessage(form, messages.phone_invalid || 'Số điện thoại không hợp lệ.', false, submitButton);
			if (phoneInput) {
				phoneInput.classList.add('footer-168__field-error');
				phoneInput.focus();
			}
			return;
		}

		submitAjaxForm(form, 'nuocda_168_footer_quote', submitButton, originalButtonText);
	}

	function clearFieldError(event) {
		event.currentTarget.classList.remove('c168-field-error', 'footer-168__field-error');
		var form = event.currentTarget.closest('form');
		if (form) {
			form.querySelectorAll('.form-message').forEach(function (el) {
				el.remove();
			});
		}
	}

	function init() {
		document.querySelectorAll('.contact-form').forEach(function (form) {
			form.addEventListener('submit', handleContactSubmit);
		});

		document.querySelectorAll('.footer-168__form').forEach(function (form) {
			form.addEventListener('submit', handleFooterSubmit);
		});

		document.querySelectorAll('.footer-168__form input[name="phone"], .c168-form input, .c168-form select, .c168-form textarea').forEach(function (field) {
			field.addEventListener('input', clearFieldError);
			field.addEventListener('change', clearFieldError);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
