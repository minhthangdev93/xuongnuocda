<?php
/**
 * Footer chính Nước Đá 168
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact = nuocda_168_get_contact();
$company = nuocda_168_get_company();
$stores  = nuocda_168_get_stores();
$logo    = get_custom_logo();
?>

<footer class="footer-168" id="footer-168">
	<div class="footer-168__wave" aria-hidden="true">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C400,60 800,0 1200,30 L1200,0 L0,0 Z" fill="#f4f8fb"/></svg>
	</div>

	<div class="container-168 footer-168__inner">

		<!-- Hàng 1: Thương hiệu, pháp lý, liên kết, báo giá -->
		<div class="footer-168__top">

			<div class="footer-168__brand">
				<?php if ( $logo ) : ?>
					<div class="footer-168__logo"><?php echo wp_kses_post( $logo ); ?></div>
				<?php else : ?>
					<a class="footer-168__logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>">Nước Đá Sạch 168</a>
				<?php endif; ?>
				<p class="footer-168__tagline">Cung cấp nước đá sạch, tinh khiết tại TP.HCM — giao hàng 24/7 cho nhà hàng, quán cafe, khách sạn và đại lý.</p>
				<div class="footer-168__chips">
					<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="footer-168__chip footer-168__chip--phone">
						<i class="fas fa-phone-alt" aria-hidden="true"></i>
						<span>Hotline <?php echo esc_html( $contact['hotline'] ); ?></span>
					</a>
					<a href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer" class="footer-168__chip footer-168__chip--zalo">
						<i class="fas fa-comment-dots" aria-hidden="true"></i>
						<span>Nhắn Zalo</span>
					</a>
				</div>
				<h4 class="footer-168__title footer-168__title--sub">Liên kết nhanh</h4>
				<ul class="footer-168__menu footer-168__menu--grid">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Trang chủ</a></li>
					<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">Giới thiệu</a></li>
					<li><a href="<?php echo esc_url( home_url( '/#xem-san-pham' ) ); ?>">Sản phẩm</a></li>
					<li><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">Liên hệ</a></li>
				</ul>
			</div>

			<div class="footer-168__col footer-168__legal">
				<h4 class="footer-168__title">Thông tin doanh nghiệp</h4>
				<dl class="footer-168__legal-list">
					<div class="footer-168__legal-row">
						<dt>Tên công ty</dt>
						<dd><?php echo esc_html( $company['name'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Tên giao dịch</dt>
						<dd><?php echo esc_html( $company['trade_name'] ); ?></dd>
					</div>
					<?php if ( ! empty( $company['tax_code'] ) ) : ?>
					<div class="footer-168__legal-row">
						<dt>Mã số thuế</dt>
						<dd><?php echo esc_html( $company['tax_code'] ); ?></dd>
					</div>
					<?php endif; ?>
					<div class="footer-168__legal-row">
						<dt>Trụ sở</dt>
						<dd><?php echo esc_html( $company['address'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Đại diện pháp luật</dt>
						<dd><?php echo esc_html( $company['representative'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Ngày cấp GPKD</dt>
						<dd><?php echo esc_html( $company['license_date'] ); ?></dd>
					</div>
				</dl>
			</div>

			<div class="footer-168__col footer-168__contact">
				<h4 class="footer-168__title">Liên hệ &amp; giờ làm việc</h4>
				<ul class="footer-168__list">
					<li>
						<i class="fas fa-envelope" aria-hidden="true"></i>
						<a href="mailto:<?php echo esc_attr( $contact['email'] ); ?>"><?php echo esc_html( $contact['email'] ); ?></a>
					</li>
					<li>
						<i class="fas fa-phone-alt" aria-hidden="true"></i>
						<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>">Hotline 24/7: <?php echo esc_html( $contact['hotline'] ); ?></a>
					</li>
					<li>
						<i class="fas fa-comment-dots" aria-hidden="true"></i>
						<a href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer">Nhắn Zalo</a>
					</li>
				</ul>
				<div class="footer-168__hours">
					<p><strong>Giờ mở cửa:</strong> Thứ 2 – Chủ Nhật, 5:00 – 20:00</p>
					<p class="footer-168__hours-note">Giao ngoài giờ — vui lòng gọi trước</p>
				</div>
			</div>

			<div class="footer-168__col footer-168__quote">
				<div class="footer-168__quote-card">
					<h4 class="footer-168__title">Nhận báo giá</h4>
					<p>Để lại số điện thoại, chúng tôi tư vấn nhanh trong 15 phút.</p>
					<form class="footer-168__form" method="post" novalidate>
						<div class="nuocda-form-hp" aria-hidden="true">
							<label for="footer-quote-hp">Website</label>
							<input type="text" name="website_url" id="footer-quote-hp" tabindex="-1" autocomplete="off" />
						</div>
						<input
							type="tel"
							name="phone"
							placeholder="Số điện thoại (VD: 0348226455)"
							inputmode="numeric"
							autocomplete="tel"
							maxlength="15"
							pattern="^(0|\+?84)(3|5|7|8|9)[0-9]{8}$"
							required
						/>
						<button type="submit">Gửi yêu cầu</button>
					</form>
				</div>
			</div>

		</div>

		<!-- Hàng 2: 12 cửa hàng bắt buộc -->
		<div class="footer-168__stores">
			<div class="footer-168__stores-head">
				<h4 class="footer-168__title">Hệ thống cửa hàng &amp; đại lý</h4>
				<p>12 điểm phục vụ tại TP.HCM — giao nước đá nhanh theo khu vực.</p>
			</div>
			<div class="footer-168__stores-grid">
				<?php foreach ( $stores as $store ) : ?>
				<div class="footer-168__store-item">
					<i class="fas fa-store" aria-hidden="true"></i>
					<div>
						<strong><?php echo esc_html( $store['name'] ); ?></strong>
						<span><?php echo esc_html( $store['address'] ); ?></span>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>

		<!-- Hàng 3: Bản quyền -->
		<div class="footer-168__bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $company['name'] ); ?>. All rights reserved.</p>
			<p class="footer-168__bottom-sub"><?php echo esc_html( $company['trade_name'] ); ?></p>
		</div>

	</div>
</footer>
