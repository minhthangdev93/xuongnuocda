jQuery(document).ready(function($) {
    const messages = nuocdaAjax.messages || {};

    function normalizeVnPhone(phone) {
        const cleaned = String(phone).replace(/[^\d+]/g, '');

        if (/^\+?84\d{9}$/.test(cleaned)) {
            return '0' + cleaned.replace(/^\+?84/, '');
        }

        if (/^0\d{9}$/.test(cleaned)) {
            return cleaned;
        }

        return '';
    }

    function isValidVnPhone(phone) {
        const normalized = normalizeVnPhone(phone);
        return /^0(3|5|7|8|9)\d{8}$/.test(normalized);
    }

    function isValidEmail(email) {
        if (!email || !String(email).trim()) {
            return true;
        }
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).trim());
    }

    function showMessage(form, text, isSuccess, submitButton) {
        form.find('.form-message').remove();

        const messageContainer = $('<div>')
            .addClass('form-message')
            .addClass(isSuccess ? 'form-message--success' : 'form-message--error')
            .text(text);

        if (submitButton && submitButton.length) {
            submitButton.before(messageContainer);
        } else {
            form.append(messageContainer);
        }

        if (isSuccess && messageContainer[0]) {
            messageContainer[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function submitAjaxForm(form, action, submitButton, originalButtonText) {
        const formData = new FormData(form[0]);
        formData.append('action', action);
        formData.append('nonce', nuocdaAjax.nonce);

        submitButton.prop('disabled', true);
        if (submitButton.is('button')) {
            submitButton.text(messages.sending || 'Đang gửi...');
        } else {
            submitButton.html(messages.sending || 'Đang gửi...');
        }

        $.ajax({
            url: nuocdaAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                const isSuccess = response.success;
                const message = response.data && response.data.message ? response.data.message : '';

                if (isSuccess) {
                    form[0].reset();
                    form.find('.c168-field-error, .footer-168__field-error').removeClass('c168-field-error footer-168__field-error');
                }

                showMessage(form, message, isSuccess, submitButton);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showMessage(form, messages.network_error || 'Lỗi kết nối hoặc lỗi máy chủ. Vui lòng thử lại.', false, submitButton);
                console.error('AJAX Error:', textStatus, errorThrown);
            },
            complete: function() {
                submitButton.prop('disabled', false);
                if (submitButton.is('button')) {
                    submitButton.text(originalButtonText);
                } else {
                    submitButton.html(originalButtonText);
                }
            }
        });
    }

    $('.contact-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitButton = form.find('.contact-submit-btn');
        const originalButtonText = submitButton.text() || submitButton.html();
        const nameInput = form.find('input[name="name"]');
        const phoneInput = form.find('input[name="phone"]');
        const emailInput = form.find('input[name="email"]');

        form.find('.form-message').remove();
        form.find('.c168-field-error').removeClass('c168-field-error');

        if (!nameInput.val() || !String(nameInput.val()).trim()) {
            showMessage(form, 'Vui lòng nhập họ và tên.', false, submitButton);
            nameInput.addClass('c168-field-error').focus();
            return;
        }

        if (!phoneInput.val() || !String(phoneInput.val()).trim()) {
            showMessage(form, messages.phone_required || 'Vui lòng nhập số điện thoại.', false, submitButton);
            phoneInput.addClass('c168-field-error').focus();
            return;
        }

        if (!isValidVnPhone(phoneInput.val())) {
            showMessage(form, messages.phone_invalid || 'Số điện thoại không hợp lệ.', false, submitButton);
            phoneInput.addClass('c168-field-error').focus();
            return;
        }

        if (emailInput.length && !isValidEmail(emailInput.val())) {
            showMessage(form, 'Email không hợp lệ. Vui lòng kiểm tra lại.', false, submitButton);
            emailInput.addClass('c168-field-error').focus();
            return;
        }

        submitAjaxForm(form, 'nuocda_168_contact', submitButton, originalButtonText);
    });

    $('.footer-168__form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const submitButton = form.find('button[type="submit"]');
        const originalButtonText = submitButton.text();
        const phoneInput = form.find('input[name="phone"]');
        const phoneValue = phoneInput.val();

        form.find('.form-message').remove();
        phoneInput.removeClass('footer-168__field-error');

        if (!phoneValue || !String(phoneValue).trim()) {
            showMessage(form, messages.phone_required || 'Vui lòng nhập số điện thoại.', false, submitButton);
            phoneInput.addClass('footer-168__field-error').focus();
            return;
        }

        if (!isValidVnPhone(phoneValue)) {
            showMessage(form, messages.phone_invalid || 'Số điện thoại không hợp lệ.', false, submitButton);
            phoneInput.addClass('footer-168__field-error').focus();
            return;
        }

        submitAjaxForm(form, 'nuocda_168_footer_quote', submitButton, originalButtonText);
    });

    $('.footer-168__form input[name="phone"], .c168-form input, .c168-form select, .c168-form textarea').on('input change', function() {
        $(this).removeClass('c168-field-error footer-168__field-error');
        $(this).closest('form').find('.form-message').remove();
    });
});
