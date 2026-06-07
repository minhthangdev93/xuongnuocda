<?php
/**
 * SEO danh mục sản phẩm — title + mô tả meta, ghi đè Rank Math.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NUOCDA_CAT_SEO_TITLE_META', 'nuocda_cat_seo_title' );
define( 'NUOCDA_CAT_SEO_DESC_META', 'nuocda_cat_seo_description' );

/**
 * Lấy SEO title tùy chỉnh của danh mục.
 *
 * @param int $term_id Term ID.
 */
function nuocda_168_get_product_cat_seo_title( $term_id ) {
	$value = get_term_meta( (int) $term_id, NUOCDA_CAT_SEO_TITLE_META, true );
	return is_string( $value ) ? trim( $value ) : '';
}

/**
 * Lấy meta description tùy chỉnh của danh mục.
 *
 * @param int $term_id Term ID.
 */
function nuocda_168_get_product_cat_seo_description( $term_id ) {
	$value = get_term_meta( (int) $term_id, NUOCDA_CAT_SEO_DESC_META, true );
	return is_string( $value ) ? trim( $value ) : '';
}

/**
 * Term ID danh mục đang xem (archive).
 */
function nuocda_168_get_current_product_cat_id() {
	if ( ! is_product_taxonomy() ) {
		return 0;
	}

	$term = get_queried_object();
	if ( ! $term || empty( $term->term_id ) || 'product_cat' !== $term->taxonomy ) {
		return 0;
	}

	return (int) $term->term_id;
}

/**
 * Đồng bộ meta sang Rank Math (nếu có).
 *
 * @param int    $term_id Term ID.
 * @param string $title   SEO title.
 * @param string $desc    Meta description.
 */
function nuocda_168_sync_product_cat_rank_math_meta( $term_id, $title, $desc ) {
	if ( $title ) {
		update_term_meta( $term_id, 'rank_math_title', $title );
	} else {
		delete_term_meta( $term_id, 'rank_math_title' );
	}

	if ( $desc ) {
		update_term_meta( $term_id, 'rank_math_description', $desc );
	} else {
		delete_term_meta( $term_id, 'rank_math_description' );
	}

	// Open Graph / Twitter — dùng chung title & mô tả nếu chưa tách riêng.
	if ( $title ) {
		update_term_meta( $term_id, 'rank_math_facebook_title', $title );
		update_term_meta( $term_id, 'rank_math_twitter_title', $title );
	} else {
		delete_term_meta( $term_id, 'rank_math_facebook_title' );
		delete_term_meta( $term_id, 'rank_math_twitter_title' );
	}

	if ( $desc ) {
		update_term_meta( $term_id, 'rank_math_facebook_description', $desc );
		update_term_meta( $term_id, 'rank_math_twitter_description', $desc );
	} else {
		delete_term_meta( $term_id, 'rank_math_facebook_description' );
		delete_term_meta( $term_id, 'rank_math_twitter_description' );
	}
}

/**
 * Lưu SEO khi thêm/sửa danh mục.
 *
 * @param int $term_id Term ID.
 */
function nuocda_168_save_product_cat_seo( $term_id ) {
	if ( ! isset( $_POST['nuocda_cat_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nuocda_cat_seo_nonce'] ) ), 'nuocda_cat_seo_save' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return;
	}

	if ( ! current_user_can( 'manage_product_terms' ) ) {
		return;
	}

	$title = isset( $_POST['nuocda_cat_seo_title'] ) ? sanitize_text_field( wp_unslash( $_POST['nuocda_cat_seo_title'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$desc  = isset( $_POST['nuocda_cat_seo_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['nuocda_cat_seo_description'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	if ( $title ) {
		update_term_meta( $term_id, NUOCDA_CAT_SEO_TITLE_META, $title );
	} else {
		delete_term_meta( $term_id, NUOCDA_CAT_SEO_TITLE_META );
	}

	if ( $desc ) {
		update_term_meta( $term_id, NUOCDA_CAT_SEO_DESC_META, $desc );
	} else {
		delete_term_meta( $term_id, NUOCDA_CAT_SEO_DESC_META );
	}

	nuocda_168_sync_product_cat_rank_math_meta( $term_id, $title, $desc );
}
add_action( 'created_product_cat', 'nuocda_168_save_product_cat_seo' );
add_action( 'edited_product_cat', 'nuocda_168_save_product_cat_seo' );

/**
 * Form thêm danh mục — SEO.
 */
function nuocda_168_product_cat_add_seo_fields() {
	wp_nonce_field( 'nuocda_cat_seo_save', 'nuocda_cat_seo_nonce' );
	?>
	<div class="form-field nuocda-cat-seo-wrap">
		<h3><?php esc_html_e( 'SEO (ghi đè Rank Math)', 'oceanwp' ); ?></h3>
		<p>
			<label for="nuocda_cat_seo_title"><?php esc_html_e( 'Tiêu đề SEO', 'oceanwp' ); ?></label>
			<input type="text" name="nuocda_cat_seo_title" id="nuocda_cat_seo_title" value="" class="large-text" maxlength="70" />
		</p>
		<p class="description"><?php esc_html_e( 'Hiển thị trong thẻ <title> và kết quả tìm kiếm. Để trống = dùng mặc định Rank Math.', 'oceanwp' ); ?></p>
		<p>
			<label for="nuocda_cat_seo_description"><?php esc_html_e( 'Mô tả meta (ngắn)', 'oceanwp' ); ?></label>
			<textarea name="nuocda_cat_seo_description" id="nuocda_cat_seo_description" rows="3" class="large-text" maxlength="320"></textarea>
		</p>
		<p class="description"><?php esc_html_e( 'Mô tả ngắn cho meta description (~150–160 ký tự). Để trống = dùng mặc định Rank Math.', 'oceanwp' ); ?></p>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'nuocda_168_product_cat_add_seo_fields', 30 );

/**
 * Form sửa danh mục — SEO.
 *
 * @param WP_Term $term Term hiện tại.
 */
function nuocda_168_product_cat_edit_seo_fields( $term ) {
	$seo_title = nuocda_168_get_product_cat_seo_title( $term->term_id );
	$seo_desc  = nuocda_168_get_product_cat_seo_description( $term->term_id );

	if ( ! $seo_title ) {
		$seo_title = get_term_meta( $term->term_id, 'rank_math_title', true );
		$seo_title = is_string( $seo_title ) ? trim( $seo_title ) : '';
	}

	if ( ! $seo_desc ) {
		$seo_desc = get_term_meta( $term->term_id, 'rank_math_description', true );
		$seo_desc = is_string( $seo_desc ) ? trim( $seo_desc ) : '';
	}

	wp_nonce_field( 'nuocda_cat_seo_save', 'nuocda_cat_seo_nonce' );
	?>
	<tr class="form-field nuocda-cat-seo-wrap">
		<th scope="row" valign="top">
			<label><?php esc_html_e( 'SEO (ghi đè Rank Math)', 'oceanwp' ); ?></label>
		</th>
		<td>
			<p>
				<label for="nuocda_cat_seo_title"><strong><?php esc_html_e( 'Tiêu đề SEO', 'oceanwp' ); ?></strong></label><br />
				<input type="text" name="nuocda_cat_seo_title" id="nuocda_cat_seo_title" value="<?php echo esc_attr( $seo_title ); ?>" class="large-text" maxlength="70" />
			</p>
			<p class="description"><?php esc_html_e( 'Hiển thị trong thẻ <title> và kết quả tìm kiếm. Để trống = dùng mặc định Rank Math.', 'oceanwp' ); ?></p>
			<p>
				<label for="nuocda_cat_seo_description"><strong><?php esc_html_e( 'Mô tả meta (ngắn)', 'oceanwp' ); ?></strong></label><br />
				<textarea name="nuocda_cat_seo_description" id="nuocda_cat_seo_description" rows="3" class="large-text" maxlength="320"><?php echo esc_textarea( $seo_desc ); ?></textarea>
			</p>
			<p class="description"><?php esc_html_e( 'Mô tả ngắn cho meta description (~150–160 ký tự). Để trống = dùng mặc định Rank Math.', 'oceanwp' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'nuocda_168_product_cat_edit_seo_fields', 30 );

/**
 * CSS admin cho khối SEO.
 */
function nuocda_168_product_cat_seo_admin_head() {
	if ( ! function_exists( 'nuocda_168_is_product_cat_admin_screen' ) || ! nuocda_168_is_product_cat_admin_screen() ) {
		return;
	}
	?>
	<style>
		.nuocda-cat-seo-wrap h3 {
			margin: 0 0 12px;
			font-size: 14px;
		}

		.nuocda-cat-seo-wrap .large-text {
			width: 100%;
			max-width: 640px;
		}

		.nuocda-cat-seo-wrap .description {
			margin-top: 4px;
			color: #646970;
		}
	</style>
	<?php
}
add_action( 'admin_head-edit-tags.php', 'nuocda_168_product_cat_seo_admin_head' );
add_action( 'admin_head-term.php', 'nuocda_168_product_cat_seo_admin_head' );

/**
 * Ghi đè title Rank Math trên archive danh mục SP.
 */
function nuocda_168_filter_rank_math_cat_seo_title( $title ) {
	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return $title;
	}

	$custom = nuocda_168_get_product_cat_seo_title( $term_id );
	if ( $custom ) {
		return $custom;
	}

	return $title;
}
add_filter( 'rank_math/frontend/title', 'nuocda_168_filter_rank_math_cat_seo_title', 99 );

/**
 * Ghi đè meta description Rank Math.
 */
function nuocda_168_filter_rank_math_cat_seo_description( $description ) {
	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return $description;
	}

	$custom = nuocda_168_get_product_cat_seo_description( $term_id );
	if ( $custom ) {
		return $custom;
	}

	return $description;
}
add_filter( 'rank_math/frontend/description', 'nuocda_168_filter_rank_math_cat_seo_description', 99 );

/**
 * Open Graph — title.
 */
function nuocda_168_filter_rank_math_cat_og_title( $title ) {
	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return $title;
	}

	$custom = nuocda_168_get_product_cat_seo_title( $term_id );
	return $custom ? $custom : $title;
}
add_filter( 'rank_math/opengraph/facebook/og_title', 'nuocda_168_filter_rank_math_cat_og_title', 99 );
add_filter( 'rank_math/opengraph/twitter/twitter_title', 'nuocda_168_filter_rank_math_cat_og_title', 99 );

/**
 * Open Graph — description.
 */
function nuocda_168_filter_rank_math_cat_og_description( $description ) {
	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return $description;
	}

	$custom = nuocda_168_get_product_cat_seo_description( $term_id );
	return $custom ? $custom : $description;
}
add_filter( 'rank_math/opengraph/facebook/og_description', 'nuocda_168_filter_rank_math_cat_og_description', 99 );
add_filter( 'rank_math/opengraph/twitter/twitter_description', 'nuocda_168_filter_rank_math_cat_og_description', 99 );

/**
 * Fallback khi Rank Math không active.
 */
function nuocda_168_product_cat_seo_document_title( $title ) {
	if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
		return $title;
	}

	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return $title;
	}

	$custom = nuocda_168_get_product_cat_seo_title( $term_id );
	return $custom ? $custom : $title;
}
add_filter( 'pre_get_document_title', 'nuocda_168_product_cat_seo_document_title', 99 );

/**
 * Fallback meta description khi Rank Math không active.
 */
function nuocda_168_product_cat_seo_meta_tag() {
	if ( defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' ) ) {
		return;
	}

	$term_id = nuocda_168_get_current_product_cat_id();
	if ( ! $term_id ) {
		return;
	}

	$desc = nuocda_168_get_product_cat_seo_description( $term_id );
	if ( ! $desc ) {
		return;
	}

	printf(
		'<meta name="description" content="%s" />' . "\n",
		esc_attr( $desc )
	);
}
add_action( 'wp_head', 'nuocda_168_product_cat_seo_meta_tag', 1 );
