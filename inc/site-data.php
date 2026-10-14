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
 * Fallback liên hệ mặc định (không đọc option — tránh vòng lặp với defaults footer).
 *
 * @return array{hotline:string,zalo:string,email:string,hotline_label:string,zalo_label:string}
 */
function nuocda_168_get_contact_defaults() {
	return array(
		'hotline'       => '0348226455',
		'zalo'          => 'https://zalo.me/0348226455',
		'email'         => 'nuocdasach168h@gmail.com',
		'hotline_label' => 'Hotline 24/7',
		'zalo_label'    => 'Nhắn Zalo',
	);
}

/**
 * Chuẩn hóa số điện thoại (chỉ còn chữ số).
 *
 * @param string $phone Raw phone.
 * @return string
 */
function nuocda_168_normalize_phone_digits( $phone ) {
	return preg_replace( '/\D+/', '', (string) $phone );
}

/**
 * Format SĐT hiển thị (VD: 0348 226 455).
 *
 * @param string $phone Phone digits or raw.
 * @return string
 */
function nuocda_168_format_hotline_display( $phone ) {
	$digits = nuocda_168_normalize_phone_digits( $phone );

	if ( preg_match( '/^(0\d{3})(\d{3})(\d{3})$/', $digits, $matches ) ) {
		return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3];
	}

	if ( preg_match( '/^(0\d{2})(\d{3})(\d{4})$/', $digits, $matches ) ) {
		return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3];
	}

	return $digits ? $digits : (string) $phone;
}

/**
 * Email liên hệ chính — dùng thống nhất trên toàn site (từ tab Footer).
 */
function nuocda_168_get_site_email() {
	return nuocda_168_get_contact()['email'];
}

/**
 * Tên thương hiệu hiển thị
 */
function nuocda_168_get_brand_name() {
	return 'Nước Đá Sạch 168';
}

/**
 * Số điện thoại E.164 cho schema (vd. +84348226455)
 */
function nuocda_168_format_phone_e164( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );

	if ( preg_match( '/^84(\d{9})$/', $digits, $matches ) ) {
		return '+84' . $matches[1];
	}

	if ( preg_match( '/^0(\d{9})$/', $digits, $matches ) ) {
		return '+84' . $matches[1];
	}

	return '';
}

/**
 * FAQ trang chủ — dùng chung template + schema
 */
function nuocda_168_get_home_faqs() {
	if ( function_exists( 'nuocda_168_get_landing_settings' ) ) {
		$items = nuocda_168_get_landing_settings( 'home' )['faq']['items'] ?? array();
		if ( ! empty( $items ) ) {
			return $items;
		}
	}

	$hotline_fmt = nuocda_168_get_contact()['hotline_display'];

	return array(
		array(
			'q' => 'Nước đá Nước Đá Sạch 168 có sạch không?',
			'a' => 'Có. Nguồn nước qua lọc RO, Ozone, UV và đóng gói khép kín, kiểm soát chất lượng theo HACCP.',
		),
		array(
			'q' => 'Có giao hàng ban đêm không?',
			'a' => 'Có. Hệ thống giao hàng hoạt động 24/7, kể cả ngoài giờ cao điểm.',
		),
		array(
			'q' => 'Có nhận đơn số lượng lớn không?',
			'a' => 'Có. Phục vụ chuỗi F&B, khách sạn, sự kiện với sản lượng lớn và ổn định.',
		),
		array(
			'q' => 'Có hỗ trợ mở đại lý không?',
			'a' => 'Có. Chúng tôi hỗ trợ nguồn hàng, quy trình vận hành và chính sách giá cho đối tác lâu dài.',
		),
		array(
			'q' => 'Làm sao để đặt hàng nhanh nhất?',
			'a' => 'Gọi hotline ' . $hotline_fmt . ' hoặc nhắn Zalo — đội ngũ sẽ điều phối điểm giao gần nhất.',
		),
		array(
			'q' => 'Có giao toàn TP.HCM không?',
			'a' => 'Có. Mạng lưới cửa hàng và xe giao phủ khắp TP.HCM, giao nhanh theo khu vực.',
		),
	);
}

/**
 * FAQ trang liên hệ — dùng chung template + schema
 */
function nuocda_168_get_contact_faqs() {
	if ( function_exists( 'nuocda_168_get_landing_settings' ) ) {
		$items = nuocda_168_get_landing_settings( 'contact' )['faq']['items'] ?? array();
		if ( ! empty( $items ) ) {
			return $items;
		}
	}

	$contact     = nuocda_168_get_contact();
	$hotline_fmt = $contact['hotline_display'];

	return array(
		array(
			'q' => 'Tôi cần đặt nước đá gấp thì liên hệ kênh nào nhanh nhất?',
			'a' => 'Gọi hotline ' . $hotline_fmt . ' hoặc nhắn Zalo — đội ngũ sẽ tiếp nhận và điều phối ngay.',
		),
		array(
			'q' => 'Nước Đá Sạch 168 có giao ban đêm không?',
			'a' => 'Có. Hệ thống giao hàng và hỗ trợ hoạt động 24/7, kể cả ngoài giờ cao điểm.',
		),
		array(
			'q' => 'Tôi muốn lấy giá sỉ thì cần cung cấp thông tin gì?',
			'a' => 'Vui lòng cung cấp số điện thoại, khu vực giao, loại đá, sản lượng dự kiến và loại hình kinh doanh (nhà hàng, cafe, đại lý…).',
		),
		array(
			'q' => 'Có hỗ trợ giao cho nhà hàng, quán cafe hằng ngày không?',
			'a' => 'Có. Chúng tôi phục vụ khách hàng cố định với nguồn cung ổn định và lịch giao linh hoạt.',
		),
		array(
			'q' => 'Có nhận hợp tác đại lý nước đá không?',
			'a' => 'Có. Liên hệ hotline hoặc gửi form — chúng tôi tư vấn chính sách nguồn hàng và hợp tác lâu dài.',
		),
		array(
			'q' => 'Khu vực của tôi chưa có trong danh sách thì có giao không?',
			'a' => 'Vui lòng gọi hotline để kiểm tra điểm giao gần nhất. Hệ thống phân phối đa điểm tại TP.HCM và vùng lân cận.',
		),
	);
}

/**
 * Thông tin liên hệ nhanh — ưu tiên tab Footer (Nước Đá 168 → Footer).
 *
 * @return array{hotline:string,hotline_display:string,zalo:string,email:string,hotline_label:string,zalo_label:string}
 */
function nuocda_168_get_contact() {
	$defaults = nuocda_168_get_contact_defaults();
	$contact  = $defaults;

	if ( function_exists( 'nuocda_168_get_landing_settings' ) ) {
		$footer_contact = nuocda_168_get_landing_settings( 'footer' )['contact'] ?? array();

		if ( is_array( $footer_contact ) ) {
			if ( ! empty( $footer_contact['hotline'] ) ) {
				$contact['hotline'] = nuocda_168_normalize_phone_digits( $footer_contact['hotline'] );
			}

			if ( ! empty( $footer_contact['zalo_url'] ) ) {
				$contact['zalo'] = esc_url_raw( $footer_contact['zalo_url'] );
			}

			if ( ! empty( $footer_contact['email'] ) && is_email( $footer_contact['email'] ) ) {
				$contact['email'] = sanitize_email( $footer_contact['email'] );
			}

			if ( ! empty( $footer_contact['hotline_label'] ) ) {
				$contact['hotline_label'] = sanitize_text_field( $footer_contact['hotline_label'] );
			}

			if ( ! empty( $footer_contact['zalo_label'] ) ) {
				$contact['zalo_label'] = sanitize_text_field( $footer_contact['zalo_label'] );
			}
		}
	}

	if ( '' === $contact['hotline'] ) {
		$contact['hotline'] = $defaults['hotline'];
	}

	if ( '' === $contact['zalo'] ) {
		$contact['zalo'] = $defaults['zalo'];
	}

	if ( '' === $contact['email'] ) {
		$contact['email'] = $defaults['email'];
	}

	$contact['hotline_display'] = nuocda_168_format_hotline_display( $contact['hotline'] );

	return $contact;
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
 * Danh sách cửa hàng & đại lý — lấy từ tab admin Đại lý (fallback defaults).
 *
 * @return array
 */
function nuocda_168_get_stores() {
	if ( function_exists( 'nuocda_168_get_landing_settings' ) ) {
		$settings = nuocda_168_get_landing_settings( 'agents' );
		if ( ! empty( $settings['items'] ) && is_array( $settings['items'] ) ) {
			return $settings['items'];
		}
	}

	if ( function_exists( 'nuocda_168_landing_defaults_agents' ) ) {
		$defaults = nuocda_168_landing_defaults_agents();
		return $defaults['items'] ?? array();
	}

	return array();
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

		$width  = 1280;
		$height = 960;

		if ( $id > 0 ) {
			$meta = wp_get_attachment_metadata( $id );
			if ( ! empty( $meta['width'] ) ) {
				$width = absint( $meta['width'] );
			}
			if ( ! empty( $meta['height'] ) ) {
				$height = absint( $meta['height'] );
			}
		}

		$item = array(
			'src'        => $src,
			$label_key   => $definition[ $label_key ],
			'file'       => $file,
			'attachment' => $id,
			'width'      => $width,
			'height'     => $height,
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
 *
 * Ưu tiên danh sách chọn trong admin (Nước Đá 168 → Trang chủ / Giới thiệu).
 * Nếu chưa chọn → fallback theo tên file trong Media Library.
 */
function nuocda_168_get_factory_images() {
	if ( function_exists( 'nuocda_168_get_landing_galleries' ) && function_exists( 'nuocda_168_landing_items_from_attachment_ids' ) ) {
		$galleries = nuocda_168_get_landing_galleries();
		$from_ids  = nuocda_168_landing_items_from_attachment_ids(
			$galleries['factory_ids'],
			'Hình ảnh nhà máy Nước Đá Sạch 168'
		);

		if ( $from_ids ) {
			return $from_ids;
		}
	}

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
 * Ưu tiên danh sách chọn trong admin. Chưa chọn → tìm theo tên file trong Media Library.
 */
function nuocda_168_get_cert_images() {
	if ( function_exists( 'nuocda_168_get_landing_galleries' ) && function_exists( 'nuocda_168_landing_items_from_attachment_ids' ) ) {
		$galleries = nuocda_168_get_landing_galleries();
		$from_ids  = nuocda_168_landing_items_from_attachment_ids(
			$galleries['cert_ids'],
			'Chứng nhận Nước Đá Sạch 168'
		);

		if ( $from_ids ) {
			return $from_ids;
		}
	}

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
