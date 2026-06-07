<?php
/**
 * Trang chủ Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$uploads   = content_url( 'uploads/2025/12' );
$hero_bg   = 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_yyTfY0SS.webp';
$cta_bg    = 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_HFBGDQjw.webp';
$zalo_url  = 'https://zalo.me/0348226455';
$hotline   = '0348226455';

$products = array(
	array(
		'name'  => 'Đá Mi (Đá Nhỏ)',
		'desc'  => 'Lý tưởng cho trà sữa, cafe, nước ngọt.',
		'img'   => $uploads . '/Untitled-design-1.jpg',
		'link'  => home_url( '/nuoc-da-mi/' ),
	),
	array(
		'name'  => 'Đá Viên Bốn',
		'desc'  => 'Phù hợp nhà hàng, quán bia, giải khát.',
		'img'   => $uploads . '/Da-tam-tai-lang-168.jpg',
		'link'  => home_url( '/nuoc-da-bon/' ),
	),
	array(
		'name'  => 'Đá Tám (Đá Lớn)',
		'desc'  => 'Tan chậm, ướp lạnh hoặc uống bia.',
		'img'   => $uploads . '/Da-tam-tai-Lang-168-1.jpg',
		'link'  => home_url( '/nuoc-da-tam/' ),
	),
	array(
		'name'  => 'Đá Xay Nhuyễn',
		'desc'  => 'Ướp hải sản, sinh tố, đá bào chuyên nghiệp.',
		'img'   => $uploads . '/Da-xay-nhuyen-tai-lang-168-3.jpg',
		'link'  => home_url( '/nuoc-da-xay/' ),
	),
);

$why_us = array(
	array( 'icon' => 'fa-shield-alt', 'title' => 'Chuẩn an toàn', 'desc' => 'ISO 9001:2015 & HACCP Codex 2020 — quy trình sản xuất đạt chuẩn vệ sinh thực phẩm.' ),
	array( 'icon' => 'fa-truck', 'title' => 'Giao hàng 24/7', 'desc' => 'Xe tải lạnh GPS, giao nước đá nhanh khắp TP.HCM và vùng lân cận.' ),
	array( 'icon' => 'fa-industry', 'title' => 'Công nghệ hiện đại', 'desc' => 'Dây chuyền tự động, lọc RO — Ozone — UV, đóng gói khép kín.' ),
	array( 'icon' => 'fa-store', 'title' => 'Mạng lưới rộng', 'desc' => 'Hệ thống cửa hàng & đại lý phủ sóng, đáp ứng đơn hàng ổn định.' ),
);

$stats = array(
	array( 'num' => '30.000+', 'label' => 'Khách hàng tin dùng' ),
	array( 'num' => '100%', 'label' => 'Nước tinh khiết' ),
	array( 'num' => '24/7', 'label' => 'Hỗ trợ & giao hàng' ),
	array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
);

$stores = nuocda_168_get_stores();

$testimonials = array(
	array( 'stars' => 5, 'text' => 'Đá trong, tan chậm, giao đúng giờ mở quán. Team hỗ trợ Zalo phản hồi rất nhanh.', 'author' => 'Quán Cafe — Quận 3' ),
	array( 'stars' => 5, 'text' => 'Nhà hàng dùng đá viên bốn ổn định cả tháng, không lo thiếu hàng cuối tuần.', 'author' => 'Nhà Hàng — Quận 7' ),
	array( 'stars' => 5, 'text' => 'Hợp tác đại lý được hỗ trợ nguồn hàng và giá tốt, khách quay lại nhiều.', 'author' => 'Đại Lý — Bình Thạnh' ),
);

$uploads_2026 = content_url( 'uploads/2026/06' );

$factory_images = array();
for ( $i = 1; $i <= 12; $i++ ) {
	$factory_images[] = array(
		'src' => $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-' . $i . '.jpg',
		'alt' => sprintf( 'Hình ảnh nhà máy Nước Đá Sạch 168 — %d', $i ),
	);
}

$cert_images = array(
	array( 'src' => $uploads_2026 . '/chung-nhan-efc.jpg', 'caption' => 'Chứng nhận EFC' ),
	array( 'src' => $uploads_2026 . '/efc-international-certification.jpg', 'caption' => 'EFC International Certification' ),
	array( 'src' => $uploads_2026 . '/haccp-codex-2020.jpg', 'caption' => 'HACCP Codex 2020' ),
	array( 'src' => $uploads_2026 . '/ho-so-cong-bo-1.jpg', 'caption' => 'Hồ sơ công bố 1' ),
	array( 'src' => $uploads_2026 . '/ho-so-cong-bo-2.jpg', 'caption' => 'Hồ sơ công bố 2' ),
	array( 'src' => $uploads_2026 . '/ho-so-cong-bo-3.jpg', 'caption' => 'Hồ sơ công bố 3' ),
	array( 'src' => $uploads_2026 . '/khac-dau.jpg', 'caption' => 'Khắc dấu' ),
	array( 'src' => $uploads_2026 . '/sai-gon-stc.jpg', 'caption' => 'Sài Gòn STC' ),
	array( 'src' => $uploads_2026 . '/thong-bao-quan-ly-thue.jpg', 'caption' => 'Thông báo quản lý thuế' ),
);

$faqs = array(
	array( 'q' => 'Nước đá Nước Đá Sạch 168 có sạch không?', 'a' => 'Có. Nguồn nước qua lọc RO, Ozone, UV và đóng gói khép kín, kiểm soát chất lượng theo HACCP.' ),
	array( 'q' => 'Có giao hàng ban đêm không?', 'a' => 'Có. Hệ thống giao hàng hoạt động 24/7, kể cả ngoài giờ cao điểm.' ),
	array( 'q' => 'Có nhận đơn số lượng lớn không?', 'a' => 'Có. Phục vụ chuỗi F&B, khách sạn, sự kiện với sản lượng lớn và ổn định.' ),
	array( 'q' => 'Có hỗ trợ mở đại lý không?', 'a' => 'Có. Chúng tôi hỗ trợ nguồn hàng, quy trình vận hành và chính sách giá cho đối tác lâu dài.' ),
	array( 'q' => 'Làm sao để đặt hàng nhanh nhất?', 'a' => 'Gọi hotline 0348 226 455 hoặc nhắn Zalo — đội ngũ sẽ điều phối điểm giao gần nhất.' ),
	array( 'q' => 'Có giao toàn TP.HCM không?', 'a' => 'Có. Mạng lưới cửa hàng và xe giao phủ khắp TP.HCM, giao nhanh theo khu vực.' ),
);
?>

<div class="landing-168-wrapper h168-page">

<!-- 1. HERO -->
<section class="h168-hero">
	<img
		class="h168-hero__bg"
		src="<?php echo esc_url( $hero_bg ); ?>"
		alt=""
		width="1920"
		height="1080"
		fetchpriority="high"
		loading="eager"
		decoding="async"
	>
	<div class="h168-hero__overlay"></div>
	<div class="container-168 h168-hero__inner">
		<div class="h168-hero__content">
			<span class="h168-badge"><i class="fas fa-certificate" aria-hidden="true"></i> HACCP &amp; ISO 9001:2015</span>
			<h1 class="h168-hero__title">
				Nước Đá Sạch — Tinh Khiết
				<span class="h168-hero__title-accent">Giao TP.HCM 24/7</span>
			</h1>
			<p class="h168-hero__desc">Cung cấp nước đá sạch cho nhà hàng, quán cafe, quán ăn, khách sạn và đại lý. Sản xuất khép kín, giao nhanh, đúng hẹn.</p>
			<div class="h168-hero__actions">
				<a class="h168-btn h168-btn--primary" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-shopping-bag" aria-hidden="true"></i> Đặt hàng ngay</a>
				<a class="h168-btn h168-btn--ghost" href="#xem-san-pham"><i class="fas fa-cubes" aria-hidden="true"></i> Xem sản phẩm</a>
			</div>
			<div class="h168-hero__stats">
				<div class="h168-hero__stat"><strong>10+</strong><span>Năm kinh nghiệm</span></div>
				<div class="h168-hero__stat"><strong>30.000+</strong><span>Khách hàng</span></div>
				<div class="h168-hero__stat"><strong>24/7</strong><span>Giao hàng</span></div>
			</div>
		</div>
	</div>
	<div class="h168-hero__wave" aria-hidden="true">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 80" preserveAspectRatio="none"><path d="M0,40 C300,80 500,0 1200,40 L1200,80 L0,80 Z" fill="#f4f8fb"/></svg>
	</div>
</section>

<!-- 2. GIỚI THIỆU NHANH -->
<section class="h168-section h168-about">
	<div class="container-168 h168-about__grid">
		<div class="h168-about__media">
			<img src="<?php echo esc_url( $uploads . '/1-1.jpg' ); ?>" alt="Nhà máy Nước Đá Sạch 168" loading="lazy" />
			<div class="h168-about__badge"><span class="h168-about__badge-num">10+</span><span class="h168-about__badge-text">Năm kinh nghiệm</span></div>
		</div>
		<div class="h168-about__content">
			<span class="h168-label">Về Nước Đá Sạch 168</span>
			<h2 class="h168-heading">Chất lượng khẳng định thương hiệu nước đá sạch</h2>
			<p class="h168-lead">Tiên phong công nghệ lọc R.O và dây chuyền tự động hóa. Sản phẩm đạt chuẩn quốc tế, an toàn tuyệt đối cho người tiêu dùng.</p>
			<ul class="h168-commit-list">
				<li><i class="fas fa-tint" aria-hidden="true"></i><div><strong>Nước tinh khiết</strong><span>Nguồn nước xử lý kỹ, đá trong và sạch.</span></div></li>
				<li><i class="fas fa-box-open" aria-hidden="true"></i><div><strong>Đóng gói khép kín</strong><span>Không tiếp xúc tay trần, đạt chuẩn VSATTP.</span></div></li>
				<li><i class="fas fa-clock" aria-hidden="true"></i><div><strong>Giao hàng đúng hẹn</strong><span>Xe lạnh GPS, cam kết thời gian giao.</span></div></li>
			</ul>
			<a class="h168-link" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">Tìm hiểu thêm <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
		</div>
	</div>
</section>

<!-- 3. SẢN PHẨM -->
<section id="xem-san-pham" class="h168-section h168-section--alt h168-products">
	<div class="container-168">
		<div class="h168-section-head">
			<span class="h168-label">Sản phẩm</span>
			<h2 class="h168-heading">Nước đá cho mọi nhu cầu</h2>
			<p class="h168-section-desc">Đa dạng quy cách — sẵn sàng mở rộng thêm đá bi, đá tấm theo yêu cầu.</p>
		</div>
		<div class="h168-products__grid">
			<?php foreach ( $products as $product ) : ?>
			<article class="h168-product-card">
				<div class="h168-product-card__img">
					<img src="<?php echo esc_url( $product['img'] ); ?>" alt="<?php echo esc_attr( $product['name'] ); ?>" loading="lazy" />
				</div>
				<div class="h168-product-card__body">
					<h3><?php echo esc_html( $product['name'] ); ?></h3>
					<p><?php echo esc_html( $product['desc'] ); ?></p>
					<a class="h168-btn h168-btn--sm h168-btn--outline" href="<?php echo esc_url( $product['link'] ); ?>">Xem chi tiết</a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 4. TẠI SAO CHỌN -->
<section class="h168-section h168-why">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Lợi thế</span>
			<h2 class="h168-heading">Tại sao chọn chúng tôi?</h2>
		</div>
		<div class="h168-why__grid">
			<?php foreach ( $why_us as $item ) : ?>
			<div class="h168-why-card">
				<div class="h168-why-card__icon"><i class="fas <?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $item['title'] ); ?></h3>
				<p><?php echo esc_html( $item['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 5. THỐNG KÊ -->
<section class="h168-section h168-stats">
	<div class="container-168">
		<div class="h168-stats__grid">
			<?php foreach ( $stats as $stat ) : ?>
			<div class="h168-stat">
				<span class="h168-stat__num"><?php echo esc_html( $stat['num'] ); ?></span>
				<span class="h168-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 6. CTA -->
<section class="h168-section h168-cta" style="--h168-cta-bg: url('<?php echo esc_url( $cta_bg ); ?>')">
	<div class="h168-cta__overlay"></div>
	<div class="container-168 h168-cta__inner">
		<h2 class="h168-cta__title">Bạn cần nguồn cung cấp nước đá ổn định?</h2>
		<p class="h168-cta__desc">Nước Đá Sạch 168 cam kết chất lượng, giao nhanh và hỗ trợ 24/7 cho F&amp;B, khách sạn, đại lý.</p>
		<div class="h168-cta__actions">
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $hotline ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi 0348 226 455</a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> Nhắn Zalo</a>
		</div>
	</div>
</section>

<!-- 7. CỬA HÀNG -->
<section id="danh-sach-cua-hang" class="h168-section h168-section--alt h168-stores">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Hệ thống</span>
			<h2 class="h168-heading">Danh sách cửa hàng</h2>
			<p class="h168-section-desc">12 điểm phục vụ tại TP.HCM — tìm cửa hàng gần bạn nhất.</p>
		</div>
		<div class="h168-stores__grid">
			<?php foreach ( $stores as $index => $store ) : ?>
			<article class="h168-store-card">
				<div class="h168-store-card__icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $store['name'] ); ?></h3>
				<p><?php echo esc_html( $store['address'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 8. BẢN ĐỒ -->
<section class="h168-section h168-map">
	<div class="container-168">
		<div class="h168-section-head">
			<span class="h168-label">Phân phối</span>
			<h2 class="h168-heading">Bản đồ hệ thống phân phối</h2>
			<p class="h168-section-desc">Mạng lưới sản xuất và giao hàng phủ khắp TP.HCM, mở rộng đại lý toàn quốc.</p>
		</div>
		<div class="h168-map__embed">
			<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6705608821915!2d106.6669894!3d10.7719445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1e2f7c7b8f%3A0x678a1f879d7d1e8c!2zSOG6m10gMTY4LzkgTMOuIEJpbmggS-G6o24gQywgUGjGsOG7nW5nIDQsIFF14bqtbiA4LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701358823652!5m2!1svi!2s"
				width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"
				referrerpolicy="no-referrer-when-downgrade"
				title="Bản đồ Nước Đá Sạch 168"></iframe>
		</div>
	</div>
</section>

<!-- 9. ĐÁNH GIÁ -->
<section class="h168-section h168-section--alt h168-reviews">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Khách hàng</span>
			<h2 class="h168-heading">Khách hàng nói gì về Nước Đá Sạch 168</h2>
		</div>
		<div class="h168-reviews__grid">
			<?php foreach ( $testimonials as $review ) : ?>
			<blockquote class="h168-review-card">
				<div class="h168-review-card__stars" aria-label="<?php echo esc_attr( $review['stars'] . ' sao' ); ?>">
					<?php for ( $i = 0; $i < $review['stars']; $i++ ) : ?><i class="fas fa-star" aria-hidden="true"></i><?php endfor; ?>
				</div>
				<p>&ldquo;<?php echo esc_html( $review['text'] ); ?>&rdquo;</p>
				<cite><?php echo esc_html( $review['author'] ); ?></cite>
			</blockquote>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 10. HÌNH ẢNH NHÀ MÁY & CHỨNG NHẬN -->
<section class="h168-section h168-media" id="hinh-anh-nha-may">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Minh bạch &amp; tin cậy</span>
			<h2 class="h168-heading">Hình ảnh nhà máy &amp; chứng nhận</h2>
			<p class="h168-section-desc">Nước Đá Sạch 168 đầu tư hệ thống sản xuất hiện đại, quy trình kiểm soát chất lượng rõ ràng và đầy đủ hồ sơ chứng nhận liên quan.</p>
		</div>

		<div class="h168-media__tabs" role="tablist" aria-label="Hình ảnh nhà máy và chứng nhận">
			<button type="button" class="h168-media-tab is-active" role="tab" id="tab-factory" aria-selected="true" aria-controls="panel-factory" data-tab="factory">Nhà máy</button>
			<button type="button" class="h168-media-tab" role="tab" id="tab-cert" aria-selected="false" aria-controls="panel-cert" data-tab="cert">Chứng nhận</button>
		</div>

		<div class="h168-media__panels">
			<div class="h168-media-panel is-active" role="tabpanel" id="panel-factory" aria-labelledby="tab-factory" data-panel="factory">
				<div class="h168-factory-grid">
					<?php foreach ( $factory_images as $item ) : ?>
					<figure class="h168-factory-item">
						<button type="button" class="h168-factory-item__btn" data-lightbox-src="<?php echo esc_url( $item['src'] ); ?>" data-lightbox-alt="<?php echo esc_attr( $item['alt'] ); ?>">
							<img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" loading="lazy" />
							<span class="h168-factory-item__overlay" aria-hidden="true"><i class="fas fa-search-plus"></i></span>
						</button>
					</figure>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="h168-media-panel" role="tabpanel" id="panel-cert" aria-labelledby="tab-cert" data-panel="cert" hidden>
				<div class="h168-cert-grid">
					<?php foreach ( $cert_images as $item ) : ?>
					<figure class="h168-cert-item">
						<button type="button" class="h168-cert-item__btn" data-lightbox-src="<?php echo esc_url( $item['src'] ); ?>" data-lightbox-alt="<?php echo esc_attr( $item['caption'] ); ?>">
							<span class="h168-cert-item__frame">
								<img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_attr( $item['caption'] ); ?>" loading="lazy" />
							</span>
						</button>
						<figcaption><?php echo esc_html( $item['caption'] ); ?></figcaption>
					</figure>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="h168-lightbox" hidden aria-hidden="true">
		<div class="h168-lightbox__backdrop" data-lightbox-close></div>
		<div class="h168-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Xem ảnh">
			<button type="button" class="h168-lightbox__close" data-lightbox-close aria-label="Đóng"><i class="fas fa-times" aria-hidden="true"></i></button>
			<img src="" alt="" class="h168-lightbox__img" />
		</div>
	</div>
</section>

<!-- 11. FAQ -->
<section class="h168-section h168-section--alt h168-faq">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Hỏi đáp</span>
			<h2 class="h168-heading">Câu hỏi thường gặp</h2>
		</div>
		<div class="h168-faq__list">
			<?php foreach ( $faqs as $faq ) : ?>
			<details class="h168-faq__item">
				<summary><?php echo esc_html( $faq['q'] ); ?></summary>
				<p><?php echo esc_html( $faq['a'] ); ?></p>
			</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

</div>
