<?php
/**
 * Footer chính Nước Đá 168
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s       = nuocda_168_get_landing_settings( 'footer' );
$stores  = nuocda_168_get_stores();
$logo    = get_custom_logo();

$copyright = $s['bottom']['copyright'] ?: $s['company']['name'];
$subtitle  = $s['bottom']['subtitle'] ?: $s['company']['trade_name'];
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
					<a class="footer-168__logo-text" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $s['brand']['fallback_name'] ); ?></a>
				<?php endif; ?>
				<p class="footer-168__tagline"><?php echo esc_html( $s['brand']['tagline'] ); ?></p>
				<div class="footer-168__chips">
					<a href="tel:<?php echo esc_attr( $s['contact']['hotline'] ); ?>" class="footer-168__chip footer-168__chip--phone">
						<i class="fas fa-phone-alt" aria-hidden="true"></i>
						<span>Hotline <?php echo esc_html( $s['contact']['hotline'] ); ?></span>
					</a>
					<a href="<?php echo esc_url( $s['contact']['zalo_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="footer-168__chip footer-168__chip--zalo">
						<i class="fas fa-comment-dots" aria-hidden="true"></i>
						<span><?php echo esc_html( $s['contact']['zalo_label'] ); ?></span>
					</a>
				</div>
				<p class="footer-168__title footer-168__title--sub"><?php echo esc_html( $s['links']['title'] ); ?></p>
				<ul class="footer-168__menu footer-168__menu--grid">
					<?php foreach ( $s['links']['items'] as $link ) : ?>
					<li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer-168__col footer-168__legal">
				<p class="footer-168__title"><?php echo esc_html( $s['company']['title'] ); ?></p>
				<dl class="footer-168__legal-list">
					<div class="footer-168__legal-row">
						<dt>Tên công ty</dt>
						<dd><?php echo esc_html( $s['company']['name'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Tên giao dịch</dt>
						<dd><?php echo esc_html( $s['company']['trade_name'] ); ?></dd>
					</div>
					<?php if ( ! empty( $s['company']['tax_code'] ) ) : ?>
					<div class="footer-168__legal-row">
						<dt>Mã số thuế</dt>
						<dd><?php echo esc_html( $s['company']['tax_code'] ); ?></dd>
					</div>
					<?php endif; ?>
					<div class="footer-168__legal-row">
						<dt>Trụ sở</dt>
						<dd><?php echo esc_html( $s['company']['address'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Đại diện pháp luật</dt>
						<dd><?php echo esc_html( $s['company']['representative'] ); ?></dd>
					</div>
					<div class="footer-168__legal-row">
						<dt>Ngày cấp GPKD</dt>
						<dd><?php echo esc_html( $s['company']['license_date'] ); ?></dd>
					</div>
				</dl>
			</div>

			<div class="footer-168__col footer-168__contact">
				<p class="footer-168__title"><?php echo esc_html( $s['contact']['title'] ); ?></p>
				<ul class="footer-168__list">
					<li>
						<i class="fas fa-envelope" aria-hidden="true"></i>
						<a href="mailto:<?php echo esc_attr( $s['contact']['email'] ); ?>"><?php echo esc_html( $s['contact']['email'] ); ?></a>
					</li>
					<li>
						<i class="fas fa-phone-alt" aria-hidden="true"></i>
						<a href="tel:<?php echo esc_attr( $s['contact']['hotline'] ); ?>"><?php echo esc_html( $s['contact']['hotline_label'] ); ?>: <?php echo esc_html( $s['contact']['hotline'] ); ?></a>
					</li>
					<li>
						<i class="fas fa-comment-dots" aria-hidden="true"></i>
						<a href="<?php echo esc_url( $s['contact']['zalo_url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $s['contact']['zalo_label'] ); ?></a>
					</li>
				</ul>
				<div class="footer-168__hours">
					<p><strong><?php echo esc_html( $s['contact']['hours_title'] ); ?></strong> <?php echo esc_html( $s['contact']['hours'] ); ?></p>
					<p class="footer-168__hours-note"><?php echo esc_html( $s['contact']['hours_note'] ); ?></p>
				</div>
			</div>

			<div class="footer-168__col footer-168__quote">
				<div class="footer-168__quote-card">
					<p class="footer-168__title"><?php echo esc_html( $s['quote']['title'] ); ?></p>
					<p><?php echo esc_html( $s['quote']['desc'] ); ?></p>
					<form class="footer-168__form" method="post" novalidate>
						<div class="nuocda-form-hp" aria-hidden="true">
							<label for="footer-quote-hp">Website</label>
							<input type="text" name="website_url" id="footer-quote-hp" tabindex="-1" autocomplete="off" />
						</div>
						<input
							type="tel"
							name="phone"
							placeholder="<?php echo esc_attr( $s['quote']['placeholder'] ); ?>"
							inputmode="numeric"
							autocomplete="tel"
							maxlength="15"
							pattern="^(0|\+?84)(3|5|7|8|9)[0-9]{8}$"
							required
						/>
						<button type="submit"><?php echo esc_html( $s['quote']['button'] ); ?></button>
					</form>
				</div>
			</div>

		</div>

		<!-- Hàng 2: Cửa hàng -->
		<div class="footer-168__stores">
			<div class="footer-168__stores-head">
				<p class="footer-168__title"><?php echo esc_html( $s['stores']['heading'] ); ?></p>
				<p><?php echo esc_html( $s['stores']['desc'] ); ?></p>
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
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $copyright ); ?>. All rights reserved.</p>
			<p class="footer-168__bottom-sub"><?php echo esc_html( $subtitle ); ?></p>
		</div>

	</div>
</footer>
