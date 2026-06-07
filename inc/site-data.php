<?php
/**
 * Dữ liệu dùng chung — công ty, cửa hàng, liên hệ
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Thông tin liên hệ nhanh
 */
function nuocda_168_get_contact() {
	return array(
		'hotline' => '0348226455',
		'zalo'    => 'https://zalo.me/0348226455',
		'email'   => '168@xuongnuocda.com',
	);
}

/**
 * Thông tin pháp lý công ty
 */
function nuocda_168_get_company() {
	return array(
		'name'           => 'CÔNG TY TNHH SẢN XUẤT NƯỚC ĐÁ 168',
		'trade_name'     => '168 ICE PRODUCTION COMPANY LIMITED',
		'tax_code'       => '', // Cập nhật mã số thuế khi có
		'address'        => 'Số 219 đường Ba Tơ, Phường 7, Quận 8, Thành phố Hồ Chí Minh',
		'representative' => 'Trần Quang Đà',
		'license_date'   => '12/01/2024',
	);
}

/**
 * Danh sách cửa hàng & đại lý
 */
function nuocda_168_get_stores() {
	return array(
		array( 'name' => 'Cửa Hàng Nước Đá 1', 'address' => '277 Nguyễn Văn Đậu, P. Bình Lợi Trung, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Nước Đá 2', 'address' => '551B Âu Cơ, P. Bảy Hiền, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Nước Đá 3', 'address' => '888/2 Đ. Tân Kỳ Tân Quý, P. Bình Hưng Hòa, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Nước Đá Số 4', 'address' => '7C Phan Huy Ích, P. Tân Sơn, Q. Tân Bình, TP. HCM' ),
		array( 'name' => 'Cửa Hàng Nước Đá Sạch 168 Số 5', 'address' => '204 Nam Kỳ Khởi Nghĩa, P. Xuân Hòa, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Nước Đá Số 6', 'address' => '27/56B Đ. Vĩnh Khánh, P. Khánh Hội, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Nước Đá Tinh Khiết Số 7', 'address' => '280 Trịnh Quang Nghị, P. Bình Đông, Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Đá Lạnh Số 8', 'address' => '197 Tây Hòa, P. Phước Long, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Bán Và Mua Nước Đá Sạch Số 9', 'address' => '276/9 Đ. Thống Nhất, P. An Hội Đông, TP. Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Bán Sỉ Nước Đá Số 10', 'address' => '947 Đ. Nguyễn Ảnh Thủ, KP8, Trung Mỹ Tây, Hồ Chí Minh' ),
		array( 'name' => 'Cửa Hàng Cung Cấp Nước Đá Số 11', 'address' => '326 Tân Phước, P. Diên Hồng, Hồ Chí Minh' ),
		array( 'name' => 'Đại Lý Nước Đá Sạch', 'address' => '121 Nguyễn Đình Chiểu, Phường 4, Bàn Cờ, Hồ Chí Minh, Việt Nam' ),
	);
}

/**
 * Thư mục uploads ưu tiên khi tìm ảnh (production có thể khác local)
 */
function nuocda_168_get_media_folders() {
	$folders = array( '2026/06', '2025/12' );

	return apply_filters( 'nuocda_168_media_folders', $folders );
}

/**
 * Chuẩn hóa tên file để so khớp (không phân biệt hoa/thường)
 */
function nuocda_168_normalize_file_stem( $filename ) {
	$basename = basename( (string) $filename );

	return strtolower( pathinfo( $basename, PATHINFO_FILENAME ) );
}

/**
 * Tìm file trong thư mục uploads — Linux phân biệt chữ hoa/thường
 */
function nuocda_168_locate_upload_file( $folder, $filename ) {
	$upload = wp_upload_dir();
	$folder = trim( (string) $folder, '/' );
	$dir    = $upload['basedir'] . '/' . $folder;

	if ( ! is_dir( $dir ) ) {
		return '';
	}

	$basename   = basename( $filename );
	$exact_path = $dir . '/' . $basename;

	if ( is_file( $exact_path ) ) {
		return $upload['baseurl'] . '/' . $folder . '/' . $basename;
	}

	$stem_lower  = nuocda_168_normalize_file_stem( $filename );
	$extensions  = array( 'jpg', 'jpeg', 'png', 'webp' );
	$dir_entries = scandir( $dir );

	if ( ! is_array( $dir_entries ) ) {
		return '';
	}

	foreach ( $dir_entries as $entry ) {
		if ( '.' === $entry || '..' === $entry ) {
			continue;
		}

		$entry_path = $dir . '/' . $entry;

		if ( ! is_file( $entry_path ) ) {
			continue;
		}

		if ( nuocda_168_normalize_file_stem( $entry ) !== $stem_lower ) {
			continue;
		}

		$ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION ) );

		if ( in_array( $ext, $extensions, true ) ) {
			return $upload['baseurl'] . '/' . $folder . '/' . $entry;
		}
	}

	return '';
}

/**
 * Tìm URL ảnh trong Media Library theo tên file (không cần đúng folder)
 */
function nuocda_168_get_attachment_url_by_basename( $basename ) {
	$stem = nuocda_168_normalize_file_stem( $basename );

	if ( '' === $stem ) {
		return '';
	}

	$cache_key = 'nuocda168_media_' . md5( $stem );
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		return $cached;
	}

	global $wpdb;

	$like = '%' . $wpdb->esc_like( $stem ) . '%';
	$file = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT pm.meta_value
			FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '_wp_attached_file'
			AND LOWER(pm.meta_value) LIKE %s
			AND p.post_type = 'attachment'
			AND p.post_status = 'inherit'
			ORDER BY p.ID DESC
			LIMIT 1",
			$like
		)
	);

	if ( ! $file ) {
		set_transient( $cache_key, '', HOUR_IN_SECONDS );
		return '';
	}

	$upload = wp_upload_dir();
	$url    = trailingslashit( $upload['baseurl'] ) . ltrim( $file, '/' );

	set_transient( $cache_key, $url, HOUR_IN_SECONDS );

	return $url;
}

/**
 * Resolve URL ảnh upload — Media Library → file trên disk
 *
 * @param string $filename Tên file, ví dụ chung-nhan-EFC.jpg
 * @param int    $attachment_id ID attachment WP (ưu tiên nếu có)
 */
function nuocda_168_resolve_media_url( $filename, $attachment_id = 0 ) {
	if ( $attachment_id > 0 ) {
		$url = wp_get_attachment_url( $attachment_id );

		if ( $url ) {
			return $url;
		}
	}

	$filename = ltrim( $filename, '/' );

	$from_library = nuocda_168_get_attachment_url_by_basename( $filename );

	if ( $from_library ) {
		return $from_library;
	}

	foreach ( nuocda_168_get_media_folders() as $folder ) {
		$url = nuocda_168_locate_upload_file( $folder, $filename );

		if ( $url ) {
			return $url;
		}
	}

	return '';
}

/**
 * Build danh sách ảnh từ định nghĩa file + caption
 */
function nuocda_168_build_media_items( $definitions, $label_key = 'caption' ) {
	$items = array();

	foreach ( $definitions as $definition ) {
		$file = $definition['file'];
		$id   = isset( $definition['id'] ) ? (int) $definition['id'] : 0;
		$src  = nuocda_168_resolve_media_url( $file, $id );

		if ( ! $src ) {
			continue;
		}

		$item = array(
			'src'         => $src,
			$label_key    => $definition[ $label_key ],
			'file'        => $file,
			'attachment'  => $id,
		);

		if ( isset( $definition['alt'] ) ) {
			$item['alt'] = $definition['alt'];
		}

		$items[] = $item;
	}

	return $items;
}

/**
 * Ảnh nhà máy (gallery)
 */
function nuocda_168_get_factory_images() {
	$definitions = array();

	for ( $i = 1; $i <= 12; $i++ ) {
		$definitions[] = array(
			'file'    => 'hinh-anh-nha-may-nuoc-da-168-' . $i . '.jpg',
			'caption' => sprintf( 'Hình ảnh nhà máy Nước Đá Sạch 168 — %d', $i ),
			'alt'     => sprintf( 'Hình ảnh nhà máy Nước Đá Sạch 168 — %d', $i ),
		);
	}

	$items = nuocda_168_build_media_items( $definitions, 'caption' );

	foreach ( $items as &$item ) {
		if ( ! empty( $item['alt'] ) ) {
			continue;
		}

		$item['alt'] = $item['caption'];
	}

	return $items;
}

/**
 * Ảnh chứng nhận & hồ sơ
 *
 * Upload qua Thư viện Media — theme tự tìm theo tên file.
 * Có thể gán 'id' => 123 (ID attachment) nếu tên file khác hoàn toàn.
 */
function nuocda_168_get_cert_images() {
	$definitions = array(
		array( 'file' => 'chung-nhan-EFC.jpg', 'caption' => 'Chứng nhận EFC' ),
		array( 'file' => 'efc-international-certification.jpg', 'caption' => 'EFC International Certification' ),
		array( 'file' => 'haccp-codex-2020.jpg', 'caption' => 'HACCP Codex 2020' ),
		array( 'file' => 'ho-so-cong-bo-1.jpg', 'caption' => 'Hồ sơ công bố 1' ),
		array( 'file' => 'ho-so-cong-bo-2.jpg', 'caption' => 'Hồ sơ công bố 2' ),
		array( 'file' => 'ho-so-cong-bo-3.jpg', 'caption' => 'Hồ sơ công bố 3' ),
		array( 'file' => 'khac-dau.jpg', 'caption' => 'Khắc dấu' ),
		array( 'file' => 'sai-gon-stc.jpg', 'caption' => 'Sài Gòn STC' ),
		array( 'file' => 'thong-bao-quan-ly-thue.jpg', 'caption' => 'Thông báo quản lý thuế' ),
	);

	return nuocda_168_build_media_items( $definitions, 'caption' );
}
