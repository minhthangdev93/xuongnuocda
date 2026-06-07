<?php
/**
 * Trang chủ Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s       = nuocda_168_get_landing_settings( 'home' );
$contact = nuocda_168_get_contact();
$zalo_url  = $contact['zalo'];
$hotline   = $contact['hotline'];

$hero_bg   = $s['hero']['bg'];
$cta_bg    = $s['cta']['bg'];
$products  = $s['products']['items'];
$why_us    = $s['why']['items'];
$stats     = $s['stats'];
$stores    = nuocda_168_get_stores();
$testimonials = $s['reviews']['items'];

$factory_images = nuocda_168_get_factory_images();
$cert_images    = nuocda_168_get_cert_images();
$faqs           = $s['faq']['items'];
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
			<span class="h168-badge"><i class="fas fa-certificate" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['badge'] ); ?></span>
			<h1 class="h168-hero__title">
				<span class="h168-hero__title-main"><?php echo esc_html( $s['hero']['title'] ); ?></span>
				<span class="h168-hero__title-accent"><?php echo esc_html( $s['hero']['title_accent'] ); ?></span>
			</h1>
			<p class="h168-hero__desc"><?php echo esc_html( $s['hero']['desc'] ); ?></p>
			<div class="h168-hero__actions">
				<a class="h168-btn h168-btn--primary" href="<?php echo esc_url( $zalo_url ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-shopping-bag" aria-hidden="true"></i> Đặt hàng ngay</a>
				<a class="h168-btn h168-btn--ghost" href="#xem-san-pham"><i class="fas fa-cubes" aria-hidden="true"></i> Xem sản phẩm</a>
			</div>
			<div class="h168-hero__stats">
				<?php foreach ( $s['hero']['stats'] as $stat ) : ?>
				<div class="h168-hero__stat"><strong><?php echo esc_html( $stat['num'] ); ?></strong><span><?php echo esc_html( $stat['label'] ); ?></span></div>
				<?php endforeach; ?>
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
			<img src="<?php echo esc_url( $s['about_quick']['image'] ); ?>" alt="Nhà máy Nước Đá Sạch 168" loading="lazy" />
			<div class="h168-about__badge"><span class="h168-about__badge-num"><?php echo esc_html( $s['about_quick']['badge_num'] ); ?></span><span class="h168-about__badge-text"><?php echo esc_html( $s['about_quick']['badge_text'] ); ?></span></div>
		</div>
		<div class="h168-about__content">
			<span class="h168-label"><?php echo esc_html( $s['about_quick']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['about_quick']['heading'] ); ?></h2>
			<p class="h168-lead"><?php echo esc_html( $s['about_quick']['lead'] ); ?></p>
			<ul class="h168-commit-list">
				<li><i class="fas fa-tint" aria-hidden="true"></i><div><strong>Nước tinh khiết</strong><span>Nguồn nước xử lý kỹ, đá trong và sạch.</span></div></li>
				<li><i class="fas fa-box-open" aria-hidden="true"></i><div><strong>Đóng gói khép kín</strong><span>Không tiếp xúc tay trần, đạt chuẩn VSATTP.</span></div></li>
				<li><i class="fas fa-clock" aria-hidden="true"></i><div><strong>Giao hàng đúng hẹn</strong><span>Xe lạnh GPS, cam kết thời gian giao.</span></div></li>
			</ul>
			<a class="h168-link" href="<?php echo esc_url( $s['about_quick']['link_url'] ); ?>"><?php echo esc_html( $s['about_quick']['link_text'] ); ?> <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
		</div>
	</div>
</section>

<!-- 3. SẢN PHẨM -->
<section id="xem-san-pham" class="h168-section h168-section--alt h168-products">
	<div class="container-168">
		<div class="h168-section-head">
			<span class="h168-label"><?php echo esc_html( $s['products']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['products']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['products']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['why']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['why']['heading'] ); ?></h2>
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
		<h2 class="h168-cta__title"><?php echo esc_html( $s['cta']['title'] ); ?></h2>
		<p class="h168-cta__desc"><?php echo esc_html( $s['cta']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['stores']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['stores']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['stores']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['map']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['map']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['map']['desc'] ); ?></p>
		</div>
		<div class="h168-map__embed">
			<iframe
				src="<?php echo esc_url( $s['map']['embed'] ); ?>"
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
			<span class="h168-label"><?php echo esc_html( $s['reviews']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['reviews']['heading'] ); ?></h2>
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
			<span class="h168-label"><?php echo esc_html( $s['media']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['media']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['media']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['faq']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['faq']['heading'] ); ?></h2>
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
