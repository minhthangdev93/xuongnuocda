<?php
/**
 * Bảo mật đánh giá sản phẩm WooCommerce — chống spam
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Đang gửi đánh giá sản phẩm?
 */
function nuocda_168_is_product_review_submission() {
	if ( empty( $_POST['comment_post_ID'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return false;
	}

	return 'product' === get_post_type( absint( wp_unslash( $_POST['comment_post_ID'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
}

/**
 * IP người gửi
 */
function nuocda_168_review_get_client_ip() {
	return function_exists( 'nuocda_168_get_client_ip' ) ? nuocda_168_get_client_ip() : 'unknown';
}

/**
 * Chặn gửi đánh giá spam
 *
 * @param string $message Thông báo hiển thị.
 */
function nuocda_168_review_spam_block( $message = '' ) {
	if ( empty( $message ) ) {
		$message = __( 'Không thể gửi đánh giá. Vui lòng thử lại.', 'oceanwp' );
	}

	wp_die(
		esc_html( $message ),
		esc_html__( 'Lỗi đánh giá', 'oceanwp' ),
		array(
			'response'  => 403,
			'back_link' => true,
		)
	);
}

/**
 * Thêm honeypot + time trap vào form đánh giá
 *
 * @param array $comment_form Form args.
 * @return array
 */
function nuocda_168_review_spam_add_fields( $comment_form ) {
	if ( ! is_user_logged_in() ) {
		$comment_form['comment_notes_before'] = '<p class="nuocda-review-note">' . esc_html__( 'Đánh giá từ khách chưa đăng nhập sẽ được kiểm duyệt trước khi hiển thị.', 'oceanwp' ) . '</p>';
	}
	$comment_form['fields']['nuocda_hp'] = '<p class="nuocda-review-hp" aria-hidden="true"><label for="nuocda_review_website">' . esc_html__( 'Website', 'oceanwp' ) . '</label><input type="text" name="nuocda_review_website" id="nuocda_review_website" value="" tabindex="-1" autocomplete="off" /></p>';
	$comment_form['fields']['nuocda_ts'] = '<input type="hidden" name="nuocda_review_time" value="' . esc_attr( (string) time() ) . '" />';

	return $comment_form;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'nuocda_168_review_spam_add_fields' );

/**
 * Kiểm tra spam trước khi lưu đánh giá
 *
 * @param array $commentdata Dữ liệu comment.
 * @return array
 */
function nuocda_168_review_spam_validate( $commentdata ) {
	if ( ! nuocda_168_is_product_review_submission() ) {
		return $commentdata;
	}

	if ( current_user_can( 'moderate_comments' ) ) {
		return $commentdata;
	}

	// Honeypot — bot hay điền trường ẩn.
	if ( ! empty( $_POST['nuocda_review_website'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		nuocda_168_review_spam_block();
	}

	// Time trap — chặn bot gửi quá nhanh hoặc token quá cũ.
	$submitted_at = isset( $_POST['nuocda_review_time'] ) ? absint( wp_unslash( $_POST['nuocda_review_time'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$elapsed      = time() - $submitted_at;

	if ( $submitted_at < 1 || $elapsed < 8 || $elapsed > 7200 ) {
		nuocda_168_review_spam_block( __( 'Vui lòng đọc sản phẩm và gửi đánh giá lại sau vài giây.', 'oceanwp' ) );
	}

	$ip       = nuocda_168_review_get_client_ip();
	$rate_key = 'nuocda_review_rate_' . md5( $ip );
	$count    = (int) get_transient( $rate_key );

	if ( $count >= 3 ) {
		nuocda_168_review_spam_block( __( 'Bạn đã gửi quá nhiều đánh giá. Vui lòng thử lại sau 1 giờ.', 'oceanwp' ) );
	}

	$content         = isset( $commentdata['comment_content'] ) ? (string) $commentdata['comment_content'] : '';
	$content_plain   = trim( wp_strip_all_tags( $content ) );
	$author          = isset( $commentdata['comment_author'] ) ? (string) $commentdata['comment_author'] : '';
	$author_email    = isset( $commentdata['comment_author_email'] ) ? (string) $commentdata['comment_author_email'] : '';
	$post_id         = isset( $commentdata['comment_post_ID'] ) ? absint( $commentdata['comment_post_ID'] ) : 0;

	if ( strlen( $content_plain ) < 10 ) {
		nuocda_168_review_spam_block( __( 'Nội dung đánh giá quá ngắn. Vui lòng mô tả rõ hơn trải nghiệm của bạn.', 'oceanwp' ) );
	}

	if ( preg_match_all( '/https?:\/\/|www\./i', $content ) > 1 ) {
		nuocda_168_review_spam_block( __( 'Đánh giá không được chứa quá nhiều liên kết.', 'oceanwp' ) );
	}

	if ( preg_match( '/https?:\/\/|www\./i', $author ) ) {
		nuocda_168_review_spam_block();
	}

	$spam_keywords = array( 'viagra', 'casino', 'porn', 'crypto', 'forex', 'cialis', 'slot', 'betting', 'loan' );
	$haystack      = strtolower( $content_plain . ' ' . $author . ' ' . $author_email );

	foreach ( $spam_keywords as $keyword ) {
		if ( false !== strpos( $haystack, $keyword ) ) {
			nuocda_168_review_spam_block();
		}
	}

	// Một IP chỉ đánh giá 1 lần / sản phẩm trong 24h.
	if ( $post_id > 0 ) {
		$recent = get_comments(
			array(
				'post_id'    => $post_id,
				'type'       => 'review',
				'author_ip'  => $ip,
				'date_query' => array(
					array(
						'after' => '24 hours ago',
					),
				),
				'number'     => 1,
			)
		);

		if ( ! empty( $recent ) ) {
			nuocda_168_review_spam_block( __( 'Bạn đã gửi đánh giá cho sản phẩm này gần đây.', 'oceanwp' ) );
		}
	}

	set_transient( $rate_key, $count + 1, HOUR_IN_SECONDS );

	// Khách chưa đăng nhập — chờ admin duyệt.
	if ( ! is_user_logged_in() ) {
		$commentdata['comment_approved'] = 0;
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'nuocda_168_review_spam_validate', 5 );
