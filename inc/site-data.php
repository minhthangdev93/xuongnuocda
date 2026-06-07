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
 * Ảnh nhà máy (gallery)
 */
function nuocda_168_get_factory_images() {
	$base  = content_url( 'uploads/2026/06' );
	$items = array();

	for ( $i = 1; $i <= 12; $i++ ) {
		$items[] = array(
			'src' => $base . '/hinh-anh-nha-may-nuoc-da-168-' . $i . '.jpg',
			'alt' => sprintf( 'Hình ảnh nhà máy Nước Đá Sạch 168 — %d', $i ),
		);
	}

	return $items;
}

/**
 * Ảnh chứng nhận & hồ sơ
 */
function nuocda_168_get_cert_images() {
	$base = content_url( 'uploads/2026/06' );

	return array(
		array( 'src' => $base . '/chung-nhan-efc.jpg', 'caption' => 'Chứng nhận EFC' ),
		array( 'src' => $base . '/efc-international-certification.jpg', 'caption' => 'EFC International Certification' ),
		array( 'src' => $base . '/haccp-codex-2020.jpg', 'caption' => 'HACCP Codex 2020' ),
		array( 'src' => $base . '/ho-so-cong-bo-1.jpg', 'caption' => 'Hồ sơ công bố 1' ),
		array( 'src' => $base . '/ho-so-cong-bo-2.jpg', 'caption' => 'Hồ sơ công bố 2' ),
		array( 'src' => $base . '/ho-so-cong-bo-3.jpg', 'caption' => 'Hồ sơ công bố 3' ),
		array( 'src' => $base . '/khac-dau.jpg', 'caption' => 'Khắc dấu' ),
		array( 'src' => $base . '/sai-gon-stc.jpg', 'caption' => 'Sài Gòn STC' ),
		array( 'src' => $base . '/thong-bao-quan-ly-thue.jpg', 'caption' => 'Thông báo quản lý thuế' ),
	);
}
