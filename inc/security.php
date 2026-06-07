<?php
/**
 * Bảo mật website — chống brute force, dò user, lộ phiên bản, REST abuse.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Số lần đăng nhập sai tối đa trước khi khóa tạm thời. */
define( 'NUOCDA_LOGIN_MAX_ATTEMPTS', 5 );

/** Thời gian khóa đăng nhập (giây). */
define( 'NUOCDA_LOGIN_LOCKOUT_SECONDS', 900 );

/**
 * IP client (dùng chung cho rate limit).
 */
function nuocda_168_get_client_ip() {
	$ip = '';

	if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$parts = explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
		$ip    = trim( $parts[0] );
	} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
	}

	return $ip ? $ip : 'unknown';
}

/**
 * Khóa transient theo IP.
 */
function nuocda_168_login_lockout_key( $ip = '' ) {
	if ( ! $ip ) {
		$ip = nuocda_168_get_client_ip();
	}

	return 'nuocda_login_fail_' . md5( $ip );
}

/**
 * 1. Tắt XML-RPC — chống brute force / DDoS qua xmlrpc.php.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

/**
 * 2. Gỡ thông tin thừa trong <head>.
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

/**
 * 3. Ẩn phiên bản WordPress.
 */
add_filter( 'the_generator', '__return_empty_string' );

/**
 * Gỡ query ?ver= khi trùng phiên bản WP (tránh lộ version).
 */
function nuocda_168_strip_wp_version_query( $src ) {
	if ( ! is_string( $src ) || '' === $src ) {
		return $src;
	}

	$wp_version = get_bloginfo( 'version' );
	if ( $wp_version && false !== strpos( $src, 'ver=' . $wp_version ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'nuocda_168_strip_wp_version_query', 9999 );
add_filter( 'script_loader_src', 'nuocda_168_strip_wp_version_query', 9999 );

/**
 * 4. Chặn dò username qua ?author= và /author/slug/.
 */
function nuocda_168_block_user_enumeration_canonical( $redirect, $request ) {
	if ( is_string( $request ) && preg_match( '/\?author=([0-9]*)(\/*)/i', $request ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}

	return $redirect;
}
add_filter( 'redirect_canonical', 'nuocda_168_block_user_enumeration_canonical', 10, 2 );

function nuocda_168_block_author_archives() {
	if ( is_author() && ! is_user_logged_in() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'nuocda_168_block_author_archives', 1 );

/**
 * 5. Ẩn REST API users với khách (chống dò username).
 */
function nuocda_168_restrict_rest_users_endpoint( $endpoints ) {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}

	unset( $endpoints['/wp/v2/users'] );
	unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );

	return $endpoints;
}
add_filter( 'rest_endpoints', 'nuocda_168_restrict_rest_users_endpoint', 99 );

/**
 * 6. Security headers HTTP.
 */
function nuocda_168_send_security_headers() {
	if ( headers_sent() || is_admin() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'X-XSS-Protection: 0' );
	header( 'Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()' );

	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
	}
}
add_action( 'send_headers', 'nuocda_168_send_security_headers' );

/**
 * 7. Giới hạn đăng nhập sai — chống brute force wp-login.php.
 */
function nuocda_168_track_failed_login() {
	$key   = nuocda_168_login_lockout_key();
	$count = (int) get_transient( $key );
	set_transient( $key, $count + 1, NUOCDA_LOGIN_LOCKOUT_SECONDS );
}
add_action( 'wp_login_failed', 'nuocda_168_track_failed_login' );

function nuocda_168_block_locked_out_login( $user, $username, $password ) {
	if ( empty( $username ) && empty( $password ) ) {
		return $user;
	}

	$key   = nuocda_168_login_lockout_key();
	$count = (int) get_transient( $key );

	if ( $count >= NUOCDA_LOGIN_MAX_ATTEMPTS ) {
		return new WP_Error(
			'nuocda_login_locked',
			sprintf(
				/* translators: %d: minutes */
				esc_html__( 'Đã vượt quá số lần đăng nhập. Vui lòng thử lại sau %d phút.', 'oceanwp' ),
				(int) ceil( NUOCDA_LOGIN_LOCKOUT_SECONDS / 60 )
			)
		);
	}

	return $user;
}
add_filter( 'authenticate', 'nuocda_168_block_locked_out_login', 30, 3 );

function nuocda_168_clear_login_lockout_on_success( $user_login, $user ) {
	unset( $user_login, $user );
	delete_transient( nuocda_168_login_lockout_key() );
}
add_action( 'wp_login', 'nuocda_168_clear_login_lockout_on_success', 10, 2 );

/**
 * Thông báo đăng nhập chung — không tiết lộ user/pass sai.
 */
function nuocda_168_generic_login_error() {
	return esc_html__( 'Thông tin đăng nhập không đúng. Vui lòng thử lại.', 'oceanwp' );
}
add_filter( 'login_errors', 'nuocda_168_generic_login_error' );

/**
 * 8. Tắt Application Passwords (không dùng REST app login).
 */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/**
 * 9. Ẩn trình sửa theme/plugin trong admin.
 */
function nuocda_168_disable_file_editor_menu() {
	if ( ! is_admin() ) {
		return;
	}

	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
}
add_action( 'admin_menu', 'nuocda_168_disable_file_editor_menu', 999 );

/**
 * Chặn truy cập trực tiếp URL editor.
 */
function nuocda_168_block_file_editor_access() {
	if ( ! is_admin() ) {
		return;
	}

	$script = isset( $_SERVER['SCRIPT_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( false !== strpos( $script, 'theme-editor.php' ) || false !== strpos( $script, 'plugin-editor.php' ) ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}
add_action( 'admin_init', 'nuocda_168_block_file_editor_access' );

/**
 * 10. Không cho index trang đăng nhập.
 */
function nuocda_168_login_noindex() {
	echo '<meta name="robots" content="noindex,nofollow" />' . "\n";
}
add_action( 'login_head', 'nuocda_168_login_noindex' );

/**
 * 11. Chặn thực thi PHP trong thư mục uploads (filter upload).
 */
function nuocda_168_block_dangerous_uploads( $file ) {
	$dangerous = array( 'php', 'php3', 'php4', 'php5', 'phtml', 'phar', 'cgi', 'pl', 'asp', 'aspx', 'jsp', 'exe', 'sh', 'bat' );
	$ext       = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

	if ( in_array( $ext, $dangerous, true ) ) {
		$file['error'] = esc_html__( 'Loại tệp không được phép vì lý do bảo mật.', 'oceanwp' );
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'nuocda_168_block_dangerous_uploads' );

/**
 * 12. Giảm thông tin lộ trong response REST cho khách.
 */
function nuocda_168_rest_authentication_guard( $result ) {
	if ( ! empty( $result ) || is_user_logged_in() ) {
		return $result;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( false !== strpos( $request_uri, '/wp/v2/users' ) ) {
		return new WP_Error(
			'rest_forbidden',
			esc_html__( 'Bạn không có quyền truy cập tài nguyên này.', 'oceanwp' ),
			array( 'status' => 403 )
		);
	}

	return $result;
}
add_filter( 'rest_authentication_errors', 'nuocda_168_rest_authentication_guard', 99 );
