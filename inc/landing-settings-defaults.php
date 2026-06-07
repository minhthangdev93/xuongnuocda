<?php
/**
 * Giá trị mặc định cài đặt trang landing.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defaults trang chủ.
 */
function nuocda_168_landing_defaults_home() {
	$uploads = content_url( 'uploads/2025/12' );

	return array(
		'hero'            => array(
			'badge'        => 'HACCP & ISO 9001:2015',
			'title'        => 'Nước Đá Sạch — Tinh Khiết',
			'title_accent' => 'Giao TP.HCM 24/7',
			'desc'         => 'Cung cấp nước đá sạch cho nhà hàng, quán cafe, quán ăn, khách sạn và đại lý. Sản xuất khép kín, giao nhanh, đúng hẹn.',
			'bg'           => 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_yyTfY0SS.webp',
			'stats'        => array(
				array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
				array( 'num' => '30.000+', 'label' => 'Khách hàng' ),
				array( 'num' => '24/7', 'label' => 'Giao hàng' ),
			),
		),
		'about_quick'     => array(
			'image'      => $uploads . '/1-1.jpg',
			'badge_num'  => '10+',
			'badge_text' => 'Năm kinh nghiệm',
			'label'      => 'Về Nước Đá Sạch 168',
			'heading'    => 'Chất lượng khẳng định thương hiệu nước đá sạch',
			'lead'       => 'Tiên phong công nghệ lọc R.O và dây chuyền tự động hóa. Sản phẩm đạt chuẩn quốc tế, an toàn tuyệt đối cho người tiêu dùng.',
			'link_url'   => home_url( '/about-us/' ),
			'link_text'  => 'Tìm hiểu thêm',
		),
		'products'        => array(
			'label'   => 'Sản phẩm',
			'heading' => 'Nước đá cho mọi nhu cầu',
			'desc'    => 'Đa dạng quy cách — sẵn sàng mở rộng thêm đá bi, đá tấm theo yêu cầu.',
			'items'   => array(
				array( 'name' => 'Đá Mi (Đá Nhỏ)', 'desc' => 'Lý tưởng cho trà sữa, cafe, nước ngọt.', 'img' => $uploads . '/Untitled-design-1.jpg', 'link' => home_url( '/nuoc-da-mi/' ) ),
				array( 'name' => 'Đá Viên Bốn', 'desc' => 'Phù hợp nhà hàng, quán bia, giải khát.', 'img' => $uploads . '/Da-tam-tai-lang-168.jpg', 'link' => home_url( '/nuoc-da-bon/' ) ),
				array( 'name' => 'Đá Tám (Đá Lớn)', 'desc' => 'Tan chậm, ướp lạnh hoặc uống bia.', 'img' => $uploads . '/Da-tam-tai-Lang-168-1.jpg', 'link' => home_url( '/nuoc-da-tam/' ) ),
				array( 'name' => 'Đá Xay Nhuyễn', 'desc' => 'Ướp hải sản, sinh tố, đá bào chuyên nghiệp.', 'img' => $uploads . '/Da-xay-nhuyen-tai-lang-168-3.jpg', 'link' => home_url( '/nuoc-da-xay/' ) ),
			),
		),
		'why'             => array(
			'label'   => 'Lợi thế',
			'heading' => 'Tại sao chọn chúng tôi?',
			'items'   => array(
				array( 'icon' => 'fa-shield-alt', 'title' => 'Chuẩn an toàn', 'desc' => 'ISO 9001:2015 & HACCP Codex 2020 — quy trình sản xuất đạt chuẩn vệ sinh thực phẩm.' ),
				array( 'icon' => 'fa-truck', 'title' => 'Giao hàng 24/7', 'desc' => 'Xe tải lạnh GPS, giao nước đá nhanh khắp TP.HCM và vùng lân cận.' ),
				array( 'icon' => 'fa-industry', 'title' => 'Công nghệ hiện đại', 'desc' => 'Dây chuyền tự động, lọc RO — Ozone — UV, đóng gói khép kín.' ),
				array( 'icon' => 'fa-store', 'title' => 'Mạng lưới rộng', 'desc' => 'Hệ thống cửa hàng & đại lý phủ sóng, đáp ứng đơn hàng ổn định.' ),
			),
		),
		'stats'           => array(
			array( 'num' => '30.000+', 'label' => 'Khách hàng tin dùng' ),
			array( 'num' => '100%', 'label' => 'Nước tinh khiết' ),
			array( 'num' => '24/7', 'label' => 'Hỗ trợ & giao hàng' ),
			array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
		),
		'cta'             => array(
			'title' => 'Bạn cần nguồn cung cấp nước đá ổn định?',
			'desc'  => 'Nước Đá Sạch 168 cam kết chất lượng, giao nhanh và hỗ trợ 24/7 cho F&B, khách sạn, đại lý.',
			'bg'    => 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_HFBGDQjw.webp',
		),
		'stores'          => array(
			'label'   => 'Hệ thống',
			'heading' => 'Danh sách cửa hàng',
			'desc'    => '12 điểm phục vụ tại TP.HCM — tìm cửa hàng gần bạn nhất.',
		),
		'map'             => array(
			'label'   => 'Phân phối',
			'heading' => 'Bản đồ hệ thống phân phối',
			'desc'    => 'Mạng lưới sản xuất và giao hàng phủ khắp TP.HCM, mở rộng đại lý toàn quốc.',
			'embed'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6705608821915!2d106.6669894!3d10.7719445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1e2f7c7b8f%3A0x678a1f879d7d1e8c!2zSOG6m10gMTY4LzkgTMOuIEJpbmggS-G6o24gQywgUGjGsOG7nW5nIDQsIFF14bqtbiA4LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701358823652!5m2!1svi!2s',
		),
		'reviews'         => array(
			'label'   => 'Khách hàng',
			'heading' => 'Khách hàng nói gì về Nước Đá Sạch 168',
			'items'   => array(
				array( 'stars' => 5, 'text' => 'Đá trong, tan chậm, giao đúng giờ mở quán. Team hỗ trợ Zalo phản hồi rất nhanh.', 'author' => 'Quán Cafe — Quận 3' ),
				array( 'stars' => 5, 'text' => 'Nhà hàng dùng đá viên bốn ổn định cả tháng, không lo thiếu hàng cuối tuần.', 'author' => 'Nhà Hàng — Quận 7' ),
				array( 'stars' => 5, 'text' => 'Hợp tác đại lý được hỗ trợ nguồn hàng và giá tốt, khách quay lại nhiều.', 'author' => 'Đại Lý — Bình Thạnh' ),
			),
		),
		'media'           => array(
			'label'   => 'Minh bạch & tin cậy',
			'heading' => 'Hình ảnh nhà máy & chứng nhận',
			'desc'    => 'Nước Đá Sạch 168 đầu tư hệ thống sản xuất hiện đại, quy trình kiểm soát chất lượng rõ ràng và đầy đủ hồ sơ chứng nhận liên quan.',
		),
		'faq'             => array(
			'label'   => 'Hỏi đáp',
			'heading' => 'Câu hỏi thường gặp',
			'items'   => array(
				array( 'q' => 'Nước đá Nước Đá Sạch 168 có sạch không?', 'a' => 'Có. Nguồn nước qua lọc RO, Ozone, UV và đóng gói khép kín, kiểm soát chất lượng theo HACCP.' ),
				array( 'q' => 'Có giao hàng ban đêm không?', 'a' => 'Có. Hệ thống giao hàng hoạt động 24/7, kể cả ngoài giờ cao điểm.' ),
				array( 'q' => 'Có nhận đơn số lượng lớn không?', 'a' => 'Có. Phục vụ chuỗi F&B, khách sạn, sự kiện với sản lượng lớn và ổn định.' ),
				array( 'q' => 'Có hỗ trợ mở đại lý không?', 'a' => 'Có. Chúng tôi hỗ trợ nguồn hàng, quy trình vận hành và chính sách giá cho đối tác lâu dài.' ),
				array( 'q' => 'Làm sao để đặt hàng nhanh nhất?', 'a' => 'Gọi hotline 0348 226 455 hoặc nhắn Zalo — đội ngũ sẽ điều phối điểm giao gần nhất.' ),
				array( 'q' => 'Có giao toàn TP.HCM không?', 'a' => 'Có. Mạng lưới cửa hàng và xe giao phủ khắp TP.HCM, giao nhanh theo khu vực.' ),
			),
		),
	);
}

/**
 * Defaults trang giới thiệu.
 */
function nuocda_168_landing_defaults_about() {
	$uploads_2026 = content_url( 'uploads/2026/06' );

	return array(
		'hero'       => array(
			'badge'  => 'Về Nước Đá Sạch 168',
			'title'  => 'Nước Đá Sạch 168, nguồn cung nước đá tinh khiết ổn định cho mọi nhu cầu',
			'desc'   => 'Chúng tôi cung cấp nước đá sạch, nước đá tinh khiết cho nhà hàng, quán ăn, quán cafe, khách sạn, doanh nghiệp và hệ thống đại lý tại TP.HCM.',
			'bg'     => $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-1.jpg',
			'stats'  => array(
				array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
				array( 'num' => '30.000+', 'label' => 'Khách hàng / điểm bán' ),
				array( 'num' => '24/7', 'label' => 'Giao hàng' ),
				array( 'num' => '100%', 'label' => 'Quy trình khép kín' ),
			),
		),
		'intro'      => array(
			'image'    => $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-4.jpg',
			'label'    => 'Chúng tôi là ai?',
			'heading'  => 'Đơn vị sản xuất nước đá sạch có hệ thống thật',
			'lead'     => 'Nước Đá Sạch 168 là đơn vị chuyên sản xuất và cung cấp nước đá sạch, nước đá tinh khiết cho khách hàng cá nhân, nhà hàng, quán cafe, khách sạn, bếp công nghiệp, sự kiện và hệ thống đại lý. Với kinh nghiệm nhiều năm trong ngành, chúng tôi tập trung xây dựng nguồn cung ổn định, quy trình sản xuất an toàn và dịch vụ giao hàng nhanh chóng.',
			'highlights' => array(
				array( 'icon' => 'fa-industry', 'title' => 'Sản xuất khép kín', 'desc' => 'Dây chuyền tự động, hạn chế tiếp xúc trực tiếp trong đóng gói.' ),
				array( 'icon' => 'fa-microscope', 'title' => 'Kiểm soát chất lượng', 'desc' => 'QC giám sát từng công đoạn — nguồn nước, sản xuất, bảo quản.' ),
				array( 'icon' => 'fa-truck', 'title' => 'Giao hàng 24/7', 'desc' => 'Đội ngũ giao nhận và điều phối hỗ trợ khách F&B, khách sạn, đại lý.' ),
			),
			'products' => array( 'Đá mi', 'Đá viên bốn', 'Đá tám', 'Đá xay nhuyễn', 'Đá bi', 'Đá tấm' ),
		),
		'values'     => array(
			'label'   => 'Định hướng',
			'heading' => 'Tầm nhìn, sứ mệnh & giá trị cốt lõi',
			'items'   => array(
				array( 'icon' => 'fa-eye', 'title' => 'Tầm nhìn', 'desc' => 'Trở thành hệ thống cung cấp nước đá sạch uy tín, chuyên nghiệp, đáp ứng nhu cầu ổn định cho khách hàng tại TP.HCM và các khu vực mở rộng.' ),
				array( 'icon' => 'fa-bullseye', 'title' => 'Sứ mệnh', 'desc' => 'Mang đến sản phẩm nước đá tinh khiết, an toàn, ổn định, góp phần nâng cao tiêu chuẩn sử dụng nước đá trong kinh doanh thực phẩm và đồ uống.' ),
				array( 'icon' => 'fa-gem', 'title' => 'Giá trị cốt lõi', 'desc' => 'Chất lượng, minh bạch, đúng hẹn, đồng hành lâu dài cùng khách hàng và đối tác đại lý.' ),
			),
		),
		'tech'       => array(
			'image'   => $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-5.jpg',
			'label'   => 'Năng lực sản xuất',
			'heading' => 'Công nghệ & quy trình vận hành hiện đại',
			'desc'    => 'Hệ thống sản xuất được đầu tư bài bản — từ xử lý nguồn nước đến đóng gói và giao hàng — phù hợp khách hàng cần nguồn cung ổn định, lâu dài.',
		),
		'cta'        => array(
			'title' => 'Bạn cần nguồn cung nước đá sạch ổn định?',
			'desc'  => 'Liên hệ Nước Đá Sạch 168 để được tư vấn loại đá phù hợp, báo giá nhanh và điều phối giao hàng theo nhu cầu thực tế.',
			'bg'    => 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_HFBGDQjw.webp',
		),
	);
}

/**
 * Defaults trang liên hệ.
 */
function nuocda_168_landing_defaults_contact() {
	$uploads = content_url( 'uploads/2026/06' );

	return array(
		'hero'       => array(
			'badge' => 'Liên hệ Nước Đá Sạch 168',
			'title' => 'Liên hệ đặt nước đá sạch & nhận báo giá nhanh',
			'desc'  => 'Nước Đá Sạch 168 sẵn sàng hỗ trợ đặt hàng, báo giá nước đá sạch, điều phối giao hàng và tư vấn hợp tác đại lý tại TP.HCM.',
			'bg'    => $uploads . '/hinh-anh-nha-may-nuoc-da-168-6.jpg',
		),
		'form'       => array(
			'label'   => 'Đặt hàng & báo giá',
			'heading' => 'Gửi yêu cầu đặt nước đá / nhận báo giá',
			'desc'    => 'Vui lòng để lại thông tin, đội ngũ Nước Đá Sạch 168 sẽ liên hệ lại để xác nhận loại đá, số lượng, địa chỉ giao và thời gian giao phù hợp.',
			'bullets' => array(
				'Phục vụ nhà hàng, cafe, khách sạn, sự kiện, đại lý',
				'Giao hàng & hỗ trợ 24/7 tại TP.HCM',
				'Đá mi, đá viên bốn, đá tám, đá xay nhuyễn…',
			),
		),
		'areas'      => array(
			'label'   => 'Phục vụ',
			'heading' => 'Khu vực giao nước đá tại TP.HCM',
			'desc'    => 'Nếu khu vực của bạn chưa có trong danh sách, vui lòng liên hệ hotline để được kiểm tra điểm giao gần nhất.',
			'tags'    => array(
				'Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6',
				'Quận 7', 'Quận 8', 'Quận 9', 'Tân Bình', 'Tân Phú',
				'Bình Thạnh', 'Gò Vấp', 'Bình Tân', 'Các khu vực lân cận',
			),
		),
		'stores'     => array(
			'label'   => 'Hệ thống',
			'heading' => 'Hệ thống cửa hàng & điểm phân phối',
			'desc'    => '12 điểm phục vụ tại TP.HCM — liên hệ điểm gần nhất để đặt nước đá nhanh.',
		),
		'map'        => array(
			'label'   => 'Vị trí',
			'heading' => 'Bản đồ hệ thống phân phối',
			'desc'    => 'Nước Đá Sạch 168 phục vụ nhiều khu vực tại TP.HCM và các vùng lân cận.',
			'embed'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6705608821915!2d106.6669894!3d10.7719445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1e2f7c7b8f%3A0x678a1f879d7d1e8c!2zSOG6m10gMTY4LzkgTMOuIEJpbmggS-G6o24gQywgUGjGsOG7nW5nIDQsIFF14bqtbiA4LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701358823652!5m2!1svi!2s',
		),
		'faq'        => array(
			'label'   => 'Hỏi đáp',
			'heading' => 'Câu hỏi thường gặp khi liên hệ',
			'items'   => array(
				array( 'q' => 'Tôi cần đặt nước đá gấp thì liên hệ kênh nào nhanh nhất?', 'a' => 'Gọi hotline 0348 226 455 hoặc nhắn Zalo — đội ngũ sẽ tiếp nhận và điều phối ngay.' ),
				array( 'q' => 'Nước Đá Sạch 168 có giao ban đêm không?', 'a' => 'Có. Hệ thống giao hàng và hỗ trợ hoạt động 24/7, kể cả ngoài giờ cao điểm.' ),
				array( 'q' => 'Tôi muốn lấy giá sỉ thì cần cung cấp thông tin gì?', 'a' => 'Vui lòng cung cấp số điện thoại, khu vực giao, loại đá, sản lượng dự kiến và loại hình kinh doanh (nhà hàng, cafe, đại lý…).' ),
				array( 'q' => 'Có hỗ trợ giao cho nhà hàng, quán cafe hằng ngày không?', 'a' => 'Có. Chúng tôi phục vụ khách hàng cố định với nguồn cung ổn định và lịch giao linh hoạt.' ),
				array( 'q' => 'Có nhận hợp tác đại lý nước đá không?', 'a' => 'Có. Liên hệ hotline hoặc gửi form — chúng tôi tư vấn chính sách nguồn hàng và hợp tác lâu dài.' ),
				array( 'q' => 'Khu vực của tôi chưa có trong danh sách thì có giao không?', 'a' => 'Vui lòng gọi hotline để kiểm tra điểm giao gần nhất. Hệ thống phân phối đa điểm tại TP.HCM và vùng lân cận.' ),
			),
		),
		'cta'        => array(
			'title' => 'Cần nước đá sạch giao nhanh hôm nay?',
			'desc'  => 'Gọi ngay Nước Đá Sạch 168 để được tư vấn loại đá phù hợp, báo giá nhanh và điều phối giao hàng theo khu vực.',
		),
	);
}

/**
 * Defaults footer.
 */
function nuocda_168_landing_defaults_footer() {
	$contact = nuocda_168_get_contact();
	$company = nuocda_168_get_company();

	return array(
		'brand'   => array(
			'fallback_name' => nuocda_168_get_brand_name(),
			'tagline'       => 'Cung cấp nước đá sạch, tinh khiết tại TP.HCM — giao hàng 24/7 cho nhà hàng, quán cafe, khách sạn và đại lý.',
		),
		'links'   => array(
			'title' => 'Liên kết nhanh',
			'items' => array(
				array( 'label' => 'Trang chủ', 'url' => home_url( '/' ) ),
				array( 'label' => 'Giới thiệu', 'url' => home_url( '/about-us/' ) ),
				array( 'label' => 'Sản phẩm', 'url' => home_url( '/#xem-san-pham' ) ),
				array( 'label' => 'Liên hệ', 'url' => home_url( '/lien-he/' ) ),
			),
		),
		'company' => array(
			'title'          => 'Thông tin doanh nghiệp',
			'name'           => $company['name'],
			'trade_name'     => $company['trade_name'],
			'tax_code'       => $company['tax_code'],
			'address'        => $company['address'],
			'representative' => $company['representative'],
			'license_date'   => $company['license_date'],
		),
		'contact' => array(
			'title'         => 'Liên hệ & giờ làm việc',
			'hotline'       => $contact['hotline'],
			'hotline_label' => 'Hotline 24/7',
			'email'         => $contact['email'],
			'zalo_url'      => $contact['zalo'],
			'zalo_label'    => 'Nhắn Zalo',
			'hours_title'   => 'Giờ mở cửa:',
			'hours'         => 'Thứ 2 – Chủ Nhật, 5:00 – 20:00',
			'hours_note'    => 'Giao ngoài giờ — vui lòng gọi trước',
		),
		'quote'   => array(
			'title'       => 'Nhận báo giá',
			'desc'        => 'Để lại số điện thoại, chúng tôi tư vấn nhanh trong 15 phút.',
			'placeholder' => 'Số điện thoại (VD: 0348226455)',
			'button'      => 'Gửi yêu cầu',
		),
		'stores'  => array(
			'heading' => 'Hệ thống cửa hàng & đại lý',
			'desc'    => '12 điểm phục vụ tại TP.HCM — giao nước đá nhanh theo khu vực.',
		),
		'bottom'  => array(
			'copyright' => '',
			'subtitle'  => '',
		),
	);
}
