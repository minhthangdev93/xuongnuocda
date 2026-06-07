<?php
/**
 * Validate & bảo mật form liên hệ / báo giá
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email nhận thông báo từ form
 */
function nuocda_168_get_notify_email() {
	return 'nuocdasach168h@gmail.com';
}

/**
 * Chuẩn hóa số điện thoại VN về dạng 0xxxxxxxxx
 *
 * @param string $phone Số thô từ form.
 * @return string Số đã chuẩn hóa hoặc rỗng nếu không hợp lệ.
 */
function nuocda_168_normalize_phone( $phone ) {
	$phone = preg_replace( '/[^\d+]/', '', (string) $phone );

	if ( preg_match( '/^\+?84(\d{9})$/', $phone, $matches ) ) {
		return '0' . $matches[1];
	}

	if ( preg_match( '/^0\d{9}$/', $phone ) ) {
		return $phone;
	}

	return '';
}

/**
 * Kiểm tra số điện thoại di động Việt Nam
 *
 * @param string $phone Số thô từ form.
 * @return bool
 */
function nuocda_168_validate_phone( $phone ) {
	$normalized = nuocda_168_normalize_phone( $phone );

	if ( empty( $normalized ) ) {
		return false;
	}

	return (bool) preg_match( '/^0(3|5|7|8|9)\d{8}$/', $normalized );
}

/**
 * Kiểm tra nonce, honeypot và giới hạn tần suất gửi
 *
 * @param string $rate_key Khóa transient theo loại form.
 * @param int    $limit    Số lần gửi tối đa trong 1 giờ.
 * @return true|WP_Error
 */
function nuocda_168_form_security_check( $rate_key, $limit = 5 ) {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'nuocda-168-contact-nonce' ) ) {
		return new WP_Error( 'invalid_nonce', 'Lỗi bảo mật. Vui lòng tải lại trang.' );
	}

	// Honeypot — bot thường điền trường ẩn.
	if ( ! empty( $_POST['website_url'] ) ) {
		return new WP_Error( 'spam_detected', 'Không thể gửi yêu cầu. Vui lòng thử lại.' );
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key  = 'nuocda_form_' . $rate_key . '_' . md5( $ip );
	$count = (int) get_transient( $key );

	if ( $count >= $limit ) {
		return new WP_Error( 'rate_limit', 'Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau 1 giờ.' );
	}

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );

	return true;
}

/**
 * Gửi email thông báo HTML
 *
 * @param string $subject Tiêu đề.
 * @param string $body    Nội dung HTML.
 * @param string $reply   Email reply-to (tùy chọn).
 * @return bool
 */
function nuocda_168_send_notification_email( $subject, $body, $reply = '' ) {
	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: "Website Nước Đá 168" <nuocdasach168h@gmail.com>',
	);

	if ( is_email( $reply ) ) {
		$headers[] = 'Reply-To: ' . $reply;
	}

	return wp_mail( nuocda_168_get_notify_email(), $subject, $body, $headers );
}
