<?php
/**
 * Trang Liên hệ Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s           = nuocda_168_get_landing_settings( 'contact' );
$contact     = nuocda_168_get_contact();
$company     = nuocda_168_get_company();
$stores      = nuocda_168_get_stores();

$hero_bg     = $s['hero']['bg'];
$hotline_fmt = '0348 226 455';
$map_embed   = $s['map']['embed'];
$map_dir     = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $company['address'] );
$service_areas = $s['areas']['tags'];
$faqs          = $s['faq']['items'];

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

?>

<div class="landing-168-wrapper c168-page h168-page">

<!-- 1. Hero -->
<section class="c168-hero" style="--c168-hero-bg: url('<?php echo esc_url( $hero_bg ); ?>')">
	<div class="c168-hero__overlay"></div>
	<div class="container-168 c168-hero__inner">
		<div class="c168-hero__content">
			<span class="h168-badge"><i class="fas fa-headset" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['badge'] ); ?></span>
			<h1 class="c168-hero__title"><?php echo esc_html( $s['hero']['title'] ); ?></h1>
			<p class="c168-hero__desc"><?php echo esc_html( $s['hero']['desc'] ); ?></p>
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
				<span class="h168-label"><?php echo esc_html( $s['form']['label'] ); ?></span>
				<h2 class="h168-heading"><?php echo esc_html( $s['form']['heading'] ); ?></h2>
				<p class="h168-section-desc"><?php echo esc_html( $s['form']['desc'] ); ?></p>
				<ul class="c168-form-intro__list">
					<?php foreach ( $s['form']['bullets'] as $bullet ) : ?>
					<li><i class="fas fa-check-circle" aria-hidden="true"></i> <?php echo esc_html( $bullet ); ?></li>
					<?php endforeach; ?>
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
				<span class="h168-label"><?php echo esc_html( $s['areas']['label'] ); ?></span>
				<h2 class="h168-heading"><?php echo esc_html( $s['areas']['heading'] ); ?></h2>
				<p class="h168-section-desc"><?php echo esc_html( $s['areas']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['stores']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['stores']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['stores']['desc'] ); ?></p>
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
				<span class="h168-label"><?php echo esc_html( $s['map']['label'] ); ?></span>
				<h2 class="h168-heading"><?php echo esc_html( $s['map']['heading'] ); ?></h2>
				<p class="h168-section-desc"><?php echo esc_html( $s['map']['desc'] ); ?></p>
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
			<span class="h168-label"><?php echo esc_html( $s['faq']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['faq']['heading'] ); ?></h2>
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
		<h2 class="h168-cta__title"><?php echo esc_html( $s['cta']['title'] ); ?></h2>
		<p class="h168-cta__desc"><?php echo esc_html( $s['cta']['desc'] ); ?></p>
		<div class="h168-cta__actions">
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay: <?php echo esc_html( $hotline_fmt ); ?></a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> Nhắn Zalo</a>
		</div>
	</div>
</section>

<?php if ( ! function_exists( 'nuocda_168_mt_contact_bar_active' ) || ! nuocda_168_mt_contact_bar_active() ) : ?>
<!-- Mobile sticky CTA (ẩn khi Minh Thắng Contact Bar đang bật) -->
<div class="c168-mobile-bar" aria-label="Liên hệ nhanh">
	<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-mobile-bar__call"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay</a>
	<a href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer" class="c168-mobile-bar__zalo"><i class="fas fa-comment-dots" aria-hidden="true"></i> Zalo</a>
</div>
<?php endif; ?>

</div>
