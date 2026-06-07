<?php
/**
 * Trang Liên hệ Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact = nuocda_168_get_contact();
$company = nuocda_168_get_company();
$stores  = nuocda_168_get_stores();
$uploads = content_url( 'uploads/2026/06' );

$hero_bg     = $uploads . '/hinh-anh-nha-may-nuoc-da-168-6.jpg';
$hotline_fmt = '0348 226 455';
$map_embed   = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6705608821915!2d106.6669894!3d10.7719445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1e2f7c7b8f%3A0x678a1f879d7d1e8c!2zSOG6m10gMTY4LzkgTMOuIEJpbmggS-G6o24gQywgUGjGsOG7nW5nIDQsIFF14bqtbiA4LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701358823652!5m2!1svi!2s';
$map_dir     = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $company['address'] );

$quick_channels = array(
	array(
		'icon'  => 'fa-phone-alt',
		'title' => 'Hotline 24/7',
		'value' => $hotline_fmt,
		'desc'  => 'Gọi nhanh để đặt nước đá hoặc cần giao gấp',
		'btn'   => 'Gọi ngay',
		'url'   => 'tel:' . $contact['hotline'],
		'class' => 'c168-channel-card--phone',
	),
	array(
		'icon'  => 'fa-comment-dots',
		'title' => 'Zalo đặt hàng',
		'value' => $hotline_fmt,
		'desc'  => 'Gửi vị trí, loại đá và số lượng qua Zalo',
		'btn'   => 'Nhắn Zalo',
		'url'   => $contact['zalo'],
		'class' => 'c168-channel-card--zalo',
	),
	array(
		'icon'  => 'fa-envelope',
		'title' => 'Email hợp tác',
		'value' => $contact['email'],
		'desc'  => 'Dành cho khách sỉ, doanh nghiệp, đối tác đại lý',
		'btn'   => 'Gửi email',
		'url'   => 'mailto:' . $contact['email'],
		'class' => 'c168-channel-card--email',
	),
	array(
		'icon'  => 'fa-file-invoice',
		'title' => 'Hỗ trợ báo giá',
		'value' => 'Nhận báo giá nhanh',
		'desc'  => 'Tư vấn loại đá phù hợp theo nhu cầu sử dụng',
		'btn'   => 'Gửi yêu cầu',
		'url'   => '#c168-form',
		'class' => 'c168-channel-card--quote',
	),
);

$service_areas = array(
	'Quận 1', 'Quận 2', 'Quận 3', 'Quận 4', 'Quận 5', 'Quận 6',
	'Quận 7', 'Quận 8', 'Quận 9', 'Tân Bình', 'Tân Phú',
	'Bình Thạnh', 'Gò Vấp', 'Bình Tân', 'Các khu vực lân cận',
);

$customer_types = array(
	'ca-nhan'     => 'Cá nhân',
	'cafe'        => 'Quán cafe',
	'nha-hang'    => 'Nhà hàng',
	'khach-san'   => 'Khách sạn',
	'doanh-nghiep' => 'Doanh nghiệp',
	'dai-ly'      => 'Đại lý',
);

$ice_types = array(
	'da-mi'       => 'Đá mi',
	'da-vien-bon' => 'Đá viên bốn',
	'da-tam'      => 'Đá tám',
	'da-xay'      => 'Đá xay nhuyễn',
	'da-bi'       => 'Đá bi',
	'da-tam-sheet' => 'Đá tấm',
	'tu-van'      => 'Chưa rõ — cần tư vấn',
);

$order_steps = array(
	array( 'icon' => 'fa-phone-alt', 'title' => 'Liên hệ hotline / Zalo', 'desc' => 'Gửi nhu cầu, loại đá, số lượng và địa chỉ giao.' ),
	array( 'icon' => 'fa-comments', 'title' => 'Tư vấn & báo giá', 'desc' => 'Xác nhận sản phẩm phù hợp, chi phí và thời gian giao.' ),
	array( 'icon' => 'fa-route', 'title' => 'Điều phối đơn hàng', 'desc' => 'Sắp xếp điểm giao / xe giao phù hợp với khu vực.' ),
	array( 'icon' => 'fa-truck', 'title' => 'Giao nước đá tận nơi', 'desc' => 'Giao đúng địa chỉ, đúng thời gian đã xác nhận.' ),
);

$faqs = array(
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
?>

<div class="landing-168-wrapper c168-page h168-page">

<!-- 1. Hero -->
<section class="c168-hero" style="--c168-hero-bg: url('<?php echo esc_url( $hero_bg ); ?>')">
	<div class="c168-hero__overlay"></div>
	<div class="container-168 c168-hero__inner">
		<div class="c168-hero__content">
			<span class="h168-badge"><i class="fas fa-headset" aria-hidden="true"></i> Liên hệ Nước Đá Sạch 168</span>
			<h1 class="c168-hero__title">Liên hệ đặt nước đá sạch &amp; nhận báo giá nhanh</h1>
			<p class="c168-hero__desc">Nước Đá Sạch 168 sẵn sàng hỗ trợ đặt hàng, báo giá nước đá sạch, điều phối giao hàng và tư vấn hợp tác đại lý tại TP.HCM.</p>
			<div class="c168-hero__actions">
				<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay: <?php echo esc_html( $hotline_fmt ); ?></a>
				<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> Nhắn Zalo</a>
				<a class="h168-btn h168-btn--ghost" href="#c168-form"><i class="fas fa-file-alt" aria-hidden="true"></i> Gửi yêu cầu báo giá</a>
			</div>
		</div>
	</div>
	<div class="c168-hero__wave" aria-hidden="true">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C400,60 800,0 1200,30 L1200,60 L0,60 Z" fill="#f4f8fb"/></svg>
	</div>
</section>

<!-- 2. Liên hệ nhanh -->
<section class="h168-section c168-channels">
	<div class="container-168">
		<div class="c168-channels__grid">
			<?php foreach ( $quick_channels as $channel ) : ?>
			<article class="c168-channel-card <?php echo esc_attr( $channel['class'] ); ?>">
				<div class="c168-channel-card__icon"><i class="fas <?php echo esc_attr( $channel['icon'] ); ?>" aria-hidden="true"></i></div>
				<div class="c168-channel-card__body">
					<h2 class="c168-channel-card__title"><?php echo esc_html( $channel['title'] ); ?></h2>
					<p class="c168-channel-card__value"><?php echo esc_html( $channel['value'] ); ?></p>
					<p class="c168-channel-card__desc"><?php echo esc_html( $channel['desc'] ); ?></p>
					<a class="h168-btn h168-btn--sm h168-btn--outline c168-channel-card__btn" href="<?php echo esc_url( $channel['url'] ); ?>" <?php echo ( strpos( $channel['url'], 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $channel['btn'] ); ?></a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 3. Form đặt hàng / báo giá -->
<section class="h168-section h168-section--alt c168-form-section" id="c168-form">
	<div class="container-168">
		<div class="c168-form-layout">
			<div class="c168-form-intro">
				<span class="h168-label">Đặt hàng &amp; báo giá</span>
				<h2 class="h168-heading">Gửi yêu cầu đặt nước đá / nhận báo giá</h2>
				<p class="h168-section-desc">Vui lòng để lại thông tin, đội ngũ Nước Đá Sạch 168 sẽ liên hệ lại để xác nhận loại đá, số lượng, địa chỉ giao và thời gian giao phù hợp.</p>
				<ul class="c168-form-intro__list">
					<li><i class="fas fa-check-circle" aria-hidden="true"></i> Phục vụ nhà hàng, cafe, khách sạn, sự kiện, đại lý</li>
					<li><i class="fas fa-check-circle" aria-hidden="true"></i> Giao hàng &amp; hỗ trợ 24/7 tại TP.HCM</li>
					<li><i class="fas fa-check-circle" aria-hidden="true"></i> Đá mi, đá viên bốn, đá tám, đá xay nhuyễn…</li>
				</ul>
				<div class="c168-form-intro__cta">
					<p>Ưu tiên gọi nhanh:</p>
					<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-form-intro__phone"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( $hotline_fmt ); ?></a>
				</div>
			</div>
			<div class="c168-form-card">
				<form class="contact-form c168-form" method="post" novalidate>
					<div class="nuocda-form-hp" aria-hidden="true">
						<label for="c168-form-hp">Website</label>
						<input type="text" name="website_url" id="c168-form-hp" tabindex="-1" autocomplete="off" />
					</div>

					<div class="c168-form__group">
						<label for="c168-name">Họ và tên <span>*</span></label>
						<input type="text" id="c168-name" name="name" placeholder="Nhập họ tên người liên hệ" required />
					</div>

					<div class="c168-form__group c168-form__group--highlight">
						<label for="c168-phone">Số điện thoại <span>*</span></label>
						<input type="tel" id="c168-phone" name="phone" placeholder="Nhập số điện thoại để tư vấn nhanh (VD: 0348226455)" inputmode="numeric" maxlength="15" required />
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-address">Khu vực / địa chỉ giao hàng</label>
							<input type="text" id="c168-address" name="address" placeholder="VD: Quận 7, đường Nguyễn Văn Linh" />
						</div>
						<div class="c168-form__group">
							<label for="c168-email">Email (nếu có)</label>
							<input type="email" id="c168-email" name="email" placeholder="Email doanh nghiệp / đại lý" />
						</div>
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-customer-type">Loại khách hàng</label>
							<select id="c168-customer-type" name="customer_type">
								<option value="">— Chọn loại khách hàng —</option>
								<?php foreach ( $customer_types as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="c168-form__group">
							<label for="c168-ice-type">Loại đá cần đặt</label>
							<select id="c168-ice-type" name="ice_type">
								<option value="">— Chọn loại đá —</option>
								<?php foreach ( $ice_types as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-quantity">Số lượng dự kiến</label>
							<input type="text" id="c168-quantity" name="quantity" placeholder="VD: 50 bao / ngày, 2 tấn / tuần" />
						</div>
						<div class="c168-form__group">
							<label for="c168-delivery-time">Thời gian cần giao</label>
							<input type="text" id="c168-delivery-time" name="delivery_time" placeholder="VD: Giao sáng 6h hằng ngày, gấp tối nay" />
						</div>
					</div>

					<div class="c168-form__group">
						<label for="c168-message">Nội dung ghi chú</label>
						<textarea id="c168-message" name="message" rows="4" placeholder="Ghi chú thêm về nhu cầu, lịch giao, hợp tác đại lý…"></textarea>
					</div>

					<div class="c168-form__feedback" aria-live="polite"></div>
					<button type="submit" class="h168-btn h168-btn--primary contact-submit-btn c168-form__submit">Gửi yêu cầu báo giá</button>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- 4. Khu vực phục vụ -->
<section class="h168-section c168-areas">
	<div class="container-168">
		<div class="c168-areas__inner">
			<div class="c168-areas__content">
				<span class="h168-label">Phục vụ</span>
				<h2 class="h168-heading">Khu vực giao nước đá tại TP.HCM</h2>
				<p class="h168-section-desc">Nếu khu vực của bạn chưa có trong danh sách, vui lòng liên hệ hotline để được kiểm tra điểm giao gần nhất.</p>
				<a class="h168-btn h168-btn--outline h168-btn--sm" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-map-marked-alt" aria-hidden="true"></i> Kiểm tra khu vực giao hàng</a>
			</div>
			<div class="c168-areas__tags">
				<?php foreach ( $service_areas as $area ) : ?>
				<span class="c168-area-tag"><?php echo esc_html( $area ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- 5. Cửa hàng & điểm phân phối -->
<section class="h168-section h168-section--alt c168-stores">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Hệ thống</span>
			<h2 class="h168-heading">Hệ thống cửa hàng &amp; điểm phân phối</h2>
			<p class="h168-section-desc">12 điểm phục vụ tại TP.HCM — liên hệ điểm gần nhất để đặt nước đá nhanh.</p>
		</div>
		<div class="c168-stores__grid">
			<?php foreach ( $stores as $store ) :
				$maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $store['address'] );
				?>
			<article class="c168-store-card">
				<div class="c168-store-card__icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></div>
				<div class="c168-store-card__body">
					<h3><?php echo esc_html( $store['name'] ); ?></h3>
					<p><?php echo esc_html( $store['address'] ); ?></p>
					<div class="c168-store-card__actions">
						<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-store-card__link"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi đặt hàng</a>
						<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="c168-store-card__link"><i class="fas fa-directions" aria-hidden="true"></i> Chỉ đường</a>
					</div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 6. Bản đồ -->
<section class="h168-section c168-map">
	<div class="container-168">
		<div class="c168-map__grid">
			<div class="c168-map__content">
				<span class="h168-label">Vị trí</span>
				<h2 class="h168-heading">Bản đồ hệ thống phân phối</h2>
				<p class="h168-section-desc">Nước Đá Sạch 168 phục vụ nhiều khu vực tại TP.HCM và các vùng lân cận.</p>
				<p class="c168-map__address"><i class="fas fa-building" aria-hidden="true"></i> Trụ sở: <?php echo esc_html( $company['address'] ); ?></p>
				<div class="c168-map__actions">
					<a class="h168-btn h168-btn--primary h168-btn--sm" href="<?php echo esc_url( $map_dir ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-directions" aria-hidden="true"></i> Xem chỉ đường</a>
					<a class="h168-btn h168-btn--outline h168-btn--sm" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Liên hệ điểm giao gần nhất</a>
				</div>
			</div>
			<div class="c168-map__embed">
				<iframe src="<?php echo esc_url( $map_embed ); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ Nước Đá Sạch 168"></iframe>
			</div>
		</div>
	</div>
</section>

<!-- 7. Quy trình đặt hàng -->
<section class="h168-section h168-section--alt c168-process">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Quy trình</span>
			<h2 class="h168-heading">Quy trình đặt nước đá nhanh chóng</h2>
		</div>
		<div class="c168-process__steps">
			<?php foreach ( $order_steps as $index => $step ) : ?>
			<article class="c168-process__step">
				<div class="c168-process__step-num"><?php echo esc_html( $index + 1 ); ?></div>
				<div class="c168-process__step-icon"><i class="fas <?php echo esc_attr( $step['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $step['title'] ); ?></h3>
				<p><?php echo esc_html( $step['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 8. FAQ -->
<section class="h168-section c168-faq">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Hỏi đáp</span>
			<h2 class="h168-heading">Câu hỏi thường gặp khi liên hệ</h2>
		</div>
		<div class="c168-faq__list">
			<?php foreach ( $faqs as $faq ) : ?>
			<details class="c168-faq__item">
				<summary><?php echo esc_html( $faq['q'] ); ?></summary>
				<p><?php echo esc_html( $faq['a'] ); ?></p>
			</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 9. CTA cuối -->
<section class="h168-section h168-cta c168-cta" style="--h168-cta-bg: url('<?php echo esc_url( $hero_bg ); ?>')">
	<div class="h168-cta__overlay"></div>
	<div class="container-168 h168-cta__inner">
		<h2 class="h168-cta__title">Cần nước đá sạch giao nhanh hôm nay?</h2>
		<p class="h168-cta__desc">Gọi ngay Nước Đá Sạch 168 để được tư vấn loại đá phù hợp, báo giá nhanh và điều phối giao hàng theo khu vực.</p>
		<div class="h168-cta__actions">
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay: <?php echo esc_html( $hotline_fmt ); ?></a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> Nhắn Zalo</a>
		</div>
	</div>
</section>

<!-- Mobile sticky CTA -->
<div class="c168-mobile-bar" aria-label="Liên hệ nhanh">
	<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-mobile-bar__call"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay</a>
	<a href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer" class="c168-mobile-bar__zalo"><i class="fas fa-comment-dots" aria-hidden="true"></i> Zalo</a>
</div>

</div>
