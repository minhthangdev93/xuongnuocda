<?php
/**
 * Trang Liên hệ Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s         = nuocda_168_get_landing_settings( 'contact' );
$defaults  = nuocda_168_landing_defaults_contact();
$contact   = nuocda_168_get_contact();
$company   = nuocda_168_get_company();
$stores    = nuocda_168_get_stores();

$hero_bg     = $s['hero']['bg'];
$hotline_fmt = $contact['hotline_display'];
$map_embed   = $s['map']['embed'];
$map_dir     = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( $company['address'] );
$service_areas = ! empty( $s['areas']['tags'] ) ? $s['areas']['tags'] : ( $defaults['areas']['tags'] ?? array() );
$faqs          = ! empty( $s['faq']['items'] ) ? $s['faq']['items'] : ( $defaults['faq']['items'] ?? array() );
$order_steps   = ! empty( $s['process']['items'] ) ? $s['process']['items'] : ( $defaults['process']['items'] ?? array() );

$customer_types = ! empty( $s['form']['customer_types'] ) ? $s['form']['customer_types'] : ( $defaults['form']['customer_types'] ?? array() );
$ice_types      = ! empty( $s['form']['ice_types'] ) ? $s['form']['ice_types'] : ( $defaults['form']['ice_types'] ?? array() );

$channel_items = ! empty( $s['channels']['items'] ) ? $s['channels']['items'] : ( $defaults['channels']['items'] ?? array() );
$quick_channels = array();
foreach ( $channel_items as $item ) {
	$type  = $item['type'] ?? 'custom';
	$title = $item['title'] ?? '';
	$value = $item['value'] ?? '';
	$btn   = $item['btn'] ?? '';
	$url   = $item['url'] ?? '';

	switch ( $type ) {
		case 'phone':
			$title = $title ? $title : ( $contact['hotline_label'] ?? '' );
			$value = $value ? $value : $hotline_fmt;
			$url   = $url ? $url : ( 'tel:' . $contact['hotline'] );
			break;
		case 'zalo':
			$value = $value ? $value : $hotline_fmt;
			$url   = $url ? $url : $contact['zalo'];
			$btn   = $btn ? $btn : ( $contact['zalo_label'] ?? '' );
			break;
		case 'email':
			$value = $value ? $value : $contact['email'];
			$url   = $url ? $url : ( 'mailto:' . $contact['email'] );
			break;
		case 'quote':
			$url = $url ? $url : '#c168-form';
			break;
	}

	$quick_channels[] = array(
		'icon'  => $item['icon'] ?? 'fa-check',
		'title' => $title,
		'value' => $value,
		'desc'  => $item['desc'] ?? '',
		'btn'   => $btn,
		'url'   => $url,
		'class' => $item['class'] ?? '',
	);
}

$form_url = trim( (string) ( $s['hero']['btn_form_url'] ?? '#c168-form' ) );
$form_href = ( $form_url && '#' === $form_url[0] ) ? esc_attr( $form_url ) : esc_url( $form_url );

$phone_placeholder = str_replace(
	'{hotline}',
	$contact['hotline'],
	(string) ( $s['form']['phone_placeholder'] ?? '' )
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
				<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( trim( ( $s['hero']['btn_phone_prefix'] ?? '' ) . ' ' . $hotline_fmt ) ); ?></a>
				<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['btn_zalo_text'] ?? '' ); ?></a>
				<a class="h168-btn h168-btn--ghost" href="<?php echo $form_href; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"><i class="fas fa-file-alt" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['btn_form_text'] ?? '' ); ?></a>
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
					<?php
					$ch_url  = $channel['url'];
					$ch_href = ( $ch_url && '#' === $ch_url[0] ) ? esc_attr( $ch_url ) : esc_url( $ch_url );
					?>
					<a class="h168-btn h168-btn--sm h168-btn--outline c168-channel-card__btn" href="<?php echo $ch_href; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" <?php echo ( strpos( $ch_url, 'http' ) === 0 ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $channel['btn'] ); ?></a>
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
					<?php foreach ( (array) ( $s['form']['bullets'] ?? array() ) as $bullet ) : ?>
					<li><i class="fas fa-check-circle" aria-hidden="true"></i> <?php echo esc_html( $bullet ); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="c168-form-intro__cta">
					<p><?php echo esc_html( $s['form']['priority_text'] ?? '' ); ?></p>
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
						<label for="c168-name"><?php echo esc_html( $s['form']['name_label'] ?? '' ); ?> <span>*</span></label>
						<input type="text" id="c168-name" name="name" placeholder="<?php echo esc_attr( $s['form']['name_placeholder'] ?? '' ); ?>" required />
					</div>

					<div class="c168-form__group c168-form__group--highlight">
						<label for="c168-phone"><?php echo esc_html( $s['form']['phone_label'] ?? '' ); ?> <span>*</span></label>
						<input type="tel" id="c168-phone" name="phone" placeholder="<?php echo esc_attr( $phone_placeholder ); ?>" inputmode="numeric" maxlength="15" required />
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-address"><?php echo esc_html( $s['form']['address_label'] ?? '' ); ?></label>
							<input type="text" id="c168-address" name="address" placeholder="<?php echo esc_attr( $s['form']['address_placeholder'] ?? '' ); ?>" />
						</div>
						<div class="c168-form__group">
							<label for="c168-email"><?php echo esc_html( $s['form']['email_label'] ?? '' ); ?></label>
							<input type="email" id="c168-email" name="email" placeholder="<?php echo esc_attr( $s['form']['email_placeholder'] ?? '' ); ?>" />
						</div>
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-customer-type"><?php echo esc_html( $s['form']['customer_type_label'] ?? '' ); ?></label>
							<select id="c168-customer-type" name="customer_type">
								<option value=""><?php echo esc_html( $s['form']['customer_type_placeholder'] ?? '' ); ?></option>
								<?php foreach ( $customer_types as $opt ) : ?>
								<option value="<?php echo esc_attr( $opt['value'] ?? '' ); ?>"><?php echo esc_html( $opt['label'] ?? '' ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="c168-form__group">
							<label for="c168-ice-type"><?php echo esc_html( $s['form']['ice_type_label'] ?? '' ); ?></label>
							<select id="c168-ice-type" name="ice_type">
								<option value=""><?php echo esc_html( $s['form']['ice_type_placeholder'] ?? '' ); ?></option>
								<?php foreach ( $ice_types as $opt ) : ?>
								<option value="<?php echo esc_attr( $opt['value'] ?? '' ); ?>"><?php echo esc_html( $opt['label'] ?? '' ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="c168-form__row">
						<div class="c168-form__group">
							<label for="c168-quantity"><?php echo esc_html( $s['form']['quantity_label'] ?? '' ); ?></label>
							<input type="text" id="c168-quantity" name="quantity" placeholder="<?php echo esc_attr( $s['form']['quantity_placeholder'] ?? '' ); ?>" />
						</div>
						<div class="c168-form__group">
							<label for="c168-delivery-time"><?php echo esc_html( $s['form']['delivery_label'] ?? '' ); ?></label>
							<input type="text" id="c168-delivery-time" name="delivery_time" placeholder="<?php echo esc_attr( $s['form']['delivery_placeholder'] ?? '' ); ?>" />
						</div>
					</div>

					<div class="c168-form__group">
						<label for="c168-message"><?php echo esc_html( $s['form']['message_label'] ?? '' ); ?></label>
						<textarea id="c168-message" name="message" rows="4" placeholder="<?php echo esc_attr( $s['form']['message_placeholder'] ?? '' ); ?>"></textarea>
					</div>

					<div class="c168-form__feedback" aria-live="polite"></div>
					<button type="submit" class="h168-btn h168-btn--primary contact-submit-btn c168-form__submit"><?php echo esc_html( $s['form']['submit_text'] ?? '' ); ?></button>
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
				<a class="h168-btn h168-btn--outline h168-btn--sm" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-map-marked-alt" aria-hidden="true"></i> <?php echo esc_html( $s['areas']['btn_text'] ?? '' ); ?></a>
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
						<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-store-card__link"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( $s['stores']['btn_call'] ?? '' ); ?></a>
						<a href="<?php echo esc_url( $maps_url ); ?>" target="_blank" rel="noopener noreferrer" class="c168-store-card__link"><i class="fas fa-directions" aria-hidden="true"></i> <?php echo esc_html( $s['stores']['btn_dir'] ?? '' ); ?></a>
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
				<p class="c168-map__address"><i class="fas fa-building" aria-hidden="true"></i> <?php echo esc_html( trim( ( $s['map']['hq_prefix'] ?? '' ) . ' ' . $company['address'] ) ); ?></p>
				<div class="c168-map__actions">
					<a class="h168-btn h168-btn--primary h168-btn--sm" href="<?php echo esc_url( $map_dir ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-directions" aria-hidden="true"></i> <?php echo esc_html( $s['map']['btn_dir'] ?? '' ); ?></a>
					<a class="h168-btn h168-btn--outline h168-btn--sm" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( $s['map']['btn_call'] ?? '' ); ?></a>
				</div>
			</div>
			<div class="c168-map__embed">
				<iframe src="<?php echo esc_url( $map_embed ); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php echo esc_attr( $s['map']['title'] ?? '' ); ?>"></iframe>
			</div>
		</div>
	</div>
</section>

<!-- 7. Quy trình đặt hàng -->
<section class="h168-section h168-section--alt c168-process">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['process']['label'] ?? '' ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['process']['heading'] ?? '' ); ?></h2>
		</div>
		<div class="c168-process__steps">
			<?php foreach ( $order_steps as $index => $step ) : ?>
			<article class="c168-process__step">
				<div class="c168-process__step-num"><?php echo esc_html( $index + 1 ); ?></div>
				<div class="c168-process__step-icon"><i class="fas <?php echo esc_attr( $step['icon'] ?? 'fa-check' ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $step['title'] ?? '' ); ?></h3>
				<p><?php echo esc_html( $step['desc'] ?? '' ); ?></p>
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
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( trim( ( $s['cta']['btn_phone_prefix'] ?? '' ) . ' ' . $hotline_fmt ) ); ?></a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> <?php echo esc_html( $s['cta']['btn_zalo_text'] ?? '' ); ?></a>
		</div>
	</div>
</section>

<?php if ( ! function_exists( 'nuocda_168_mt_contact_bar_active' ) || ! nuocda_168_mt_contact_bar_active() ) : ?>
<!-- Mobile sticky CTA (ẩn khi Minh Thắng Contact Bar đang bật) -->
<div class="c168-mobile-bar" aria-label="<?php echo esc_attr( $s['mobile']['aria'] ?? '' ); ?>">
	<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="c168-mobile-bar__call"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( $s['mobile']['btn_call'] ?? '' ); ?></a>
	<a href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer" class="c168-mobile-bar__zalo"><i class="fas fa-comment-dots" aria-hidden="true"></i> <?php echo esc_html( $s['mobile']['btn_zalo'] ?? '' ); ?></a>
</div>
<?php endif; ?>

</div>
