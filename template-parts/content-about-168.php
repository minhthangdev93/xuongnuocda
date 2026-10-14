<?php
/**
 * Trang Giới thiệu Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s              = nuocda_168_get_landing_settings( 'about' );
$contact        = nuocda_168_get_contact();
$factory_images = nuocda_168_get_factory_images();
$cert_images    = nuocda_168_get_cert_images();
$defaults       = nuocda_168_landing_defaults_about();

$hero_bg    = $s['hero']['bg'];
$about_img  = $s['intro']['image'];
$tech_img   = $s['tech']['image'];
$cta_bg     = $s['cta']['bg'];
$hero_stats = ! empty( $s['hero']['stats'] ) ? $s['hero']['stats'] : ( $defaults['hero']['stats'] ?? array() );
$highlights = ! empty( $s['intro']['highlights'] ) ? $s['intro']['highlights'] : ( $defaults['intro']['highlights'] ?? array() );
$values     = ! empty( $s['values']['items'] ) ? $s['values']['items'] : ( $defaults['values']['items'] ?? array() );
$tech_points = ! empty( $s['tech']['items'] ) ? $s['tech']['items'] : ( $defaults['tech']['items'] ?? array() );
$process_steps = ! empty( $s['process']['items'] ) ? $s['process']['items'] : ( $defaults['process']['items'] ?? array() );
$ops_stats     = ! empty( $s['ops']['stats'] ) ? $s['ops']['stats'] : ( $defaults['ops']['stats'] ?? array() );
$departments   = ! empty( $s['ops']['departments'] ) ? $s['ops']['departments'] : ( $defaults['ops']['departments'] ?? array() );
$service_areas = ! empty( $s['distribution']['areas'] ) ? $s['distribution']['areas'] : ( $defaults['distribution']['areas'] ?? array() );
$commitments   = ! empty( $s['commit']['items'] ) ? $s['commit']['items'] : ( $defaults['commit']['items'] ?? array() );
$products      = ! empty( $s['intro']['products'] ) ? $s['intro']['products'] : ( $defaults['intro']['products'] ?? array() );

$hq_text = trim( (string) ( $s['distribution']['hq_text'] ?? '' ) );
if ( '' === $hq_text && function_exists( 'nuocda_168_get_company' ) ) {
	$hq_text = nuocda_168_get_company()['address'] ?? '';
}

$hero_primary_url   = trim( (string) ( $s['hero']['btn_primary_url'] ?? '' ) );
$hero_secondary_url = trim( (string) ( $s['hero']['btn_secondary_url'] ?? '' ) );
$hero_primary_href  = ( $hero_primary_url && '#' === $hero_primary_url[0] ) ? esc_attr( $hero_primary_url ) : esc_url( $hero_primary_url );
$hero_secondary_href = ( $hero_secondary_url && '#' === $hero_secondary_url[0] ) ? esc_attr( $hero_secondary_url ) : esc_url( $hero_secondary_url );
?>

<div class="landing-168-wrapper a168-page h168-page">

<!-- 1. Hero -->
<section class="a168-hero" style="--a168-hero-bg: url('<?php echo esc_url( $hero_bg ); ?>')">
	<div class="a168-hero__overlay"></div>
	<div class="container-168 a168-hero__inner">
		<div class="a168-hero__content">
			<span class="h168-badge"><i class="fas fa-building" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['badge'] ); ?></span>
			<h1 class="a168-hero__title"><?php echo esc_html( $s['hero']['title'] ); ?></h1>
			<p class="a168-hero__desc"><?php echo esc_html( $s['hero']['desc'] ); ?></p>
			<div class="a168-hero__actions">
				<a class="h168-btn h168-btn--primary" href="<?php echo $hero_primary_href; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"><i class="fas fa-envelope" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['btn_primary_text'] ); ?></a>
				<a class="h168-btn h168-btn--ghost" href="<?php echo $hero_secondary_href; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"><i class="fas fa-cubes" aria-hidden="true"></i> <?php echo esc_html( $s['hero']['btn_secondary_text'] ); ?></a>
			</div>
			<div class="a168-hero__stats">
				<?php foreach ( $hero_stats as $stat ) : ?>
				<div class="a168-hero__stat">
					<strong><?php echo esc_html( $stat['num'] ); ?></strong>
					<span><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="a168-hero__wave" aria-hidden="true">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C400,60 800,0 1200,30 L1200,60 L0,60 Z" fill="#ffffff"/></svg>
	</div>
</section>

<!-- 2. Chúng tôi là ai -->
<section class="h168-section a168-intro">
	<div class="container-168 a168-intro__grid">
		<div class="a168-intro__media">
			<img src="<?php echo esc_url( $about_img ); ?>" alt="<?php echo esc_attr( $s['intro']['image_alt'] ); ?>" loading="lazy" width="640" height="480" />
			<div class="a168-intro__badge"><span class="a168-intro__badge-num"><?php echo esc_html( $s['intro']['badge_num'] ); ?></span><span class="a168-intro__badge-text"><?php echo esc_html( $s['intro']['badge_text'] ); ?></span></div>
		</div>
		<div class="a168-intro__content">
			<span class="h168-label"><?php echo esc_html( $s['intro']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['intro']['heading'] ); ?></h2>
			<p class="h168-lead"><?php echo esc_html( $s['intro']['lead'] ); ?></p>
			<div class="a168-highlights">
				<?php foreach ( $highlights as $item ) : ?>
				<div class="a168-highlight">
					<div class="a168-highlight__icon"><i class="fas <?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i></div>
					<div>
						<strong><?php echo esc_html( $item['title'] ); ?></strong>
						<span><?php echo esc_html( $item['desc'] ); ?></span>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="a168-products-pills">
				<?php foreach ( $products as $product ) : ?>
				<span><?php echo esc_html( $product ); ?></span>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- 3. Tầm nhìn, sứ mệnh, giá trị -->
<section class="h168-section h168-section--alt a168-values">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['values']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['values']['heading'] ); ?></h2>
		</div>
		<div class="a168-values__grid">
			<?php foreach ( $values as $card ) : ?>
			<article class="a168-value-card">
				<div class="a168-value-card__icon"><i class="fas <?php echo esc_attr( $card['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $card['title'] ); ?></h3>
				<p><?php echo esc_html( $card['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 4. Năng lực sản xuất & công nghệ -->
<section class="h168-section a168-tech">
	<div class="container-168 a168-tech__grid">
		<div class="a168-tech__media">
			<img src="<?php echo esc_url( $tech_img ); ?>" alt="<?php echo esc_attr( $s['tech']['image_alt'] ); ?>" loading="lazy" width="640" height="480" />
		</div>
		<div class="a168-tech__content">
			<span class="h168-label"><?php echo esc_html( $s['tech']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['tech']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['tech']['desc'] ); ?></p>
			<div class="a168-tech__list">
				<?php foreach ( $tech_points as $point ) : ?>
				<div class="a168-tech__item">
					<div class="a168-tech__item-icon"><i class="fas <?php echo esc_attr( $point['icon'] ); ?>" aria-hidden="true"></i></div>
					<div>
						<strong><?php echo esc_html( $point['title'] ); ?></strong>
						<p><?php echo esc_html( $point['desc'] ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- 5. Quy trình kiểm soát chất lượng -->
<section class="h168-section h168-section--alt a168-process">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['process']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['process']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['process']['desc'] ); ?></p>
		</div>
		<div class="a168-process__steps">
			<?php foreach ( $process_steps as $index => $step ) : ?>
			<article class="a168-process__step">
				<div class="a168-process__step-num"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
				<div class="a168-process__step-icon"><i class="fas <?php echo esc_attr( $step['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $step['title'] ); ?></h3>
				<p><?php echo esc_html( $step['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 6. Chứng nhận & hồ sơ -->
<section class="h168-section a168-certs" id="chung-nhan">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['certs']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['certs']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['certs']['desc'] ); ?></p>
		</div>
		<div class="a168-certs__grid">
			<?php foreach ( $cert_images as $item ) : ?>
			<figure class="a168-cert-card">
				<button type="button" class="a168-cert-card__btn" data-lightbox-src="<?php echo esc_url( $item['src'] ); ?>" data-lightbox-alt="<?php echo esc_attr( $item['caption'] ); ?>">
					<span class="a168-cert-card__frame">
						<img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_attr( $item['caption'] ); ?>" loading="lazy" />
					</span>
				</button>
				<figcaption><?php echo esc_html( $item['caption'] ); ?></figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 7. Quy mô nhân sự & vận hành -->
<section class="h168-section h168-section--alt a168-ops">
	<div class="container-168">
		<div class="a168-ops__head">
			<div class="a168-ops__intro">
				<span class="h168-label"><?php echo esc_html( $s['ops']['label'] ); ?></span>
				<h2 class="h168-heading"><?php echo esc_html( $s['ops']['heading'] ); ?></h2>
				<p class="h168-section-desc"><?php echo esc_html( $s['ops']['desc'] ); ?></p>
			</div>
			<div class="a168-ops__stats">
				<?php foreach ( $ops_stats as $stat ) : ?>
				<div class="a168-ops__stat">
					<strong><?php echo esc_html( $stat['num'] ); ?></strong>
					<span><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="a168-ops__grid">
			<?php foreach ( $departments as $dept ) : ?>
			<article class="a168-dept-card">
				<div class="a168-dept-card__icon"><i class="fas <?php echo esc_attr( $dept['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $dept['title'] ); ?></h3>
				<p><?php echo esc_html( $dept['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
		<div class="a168-erp-banner">
			<i class="fas fa-database" aria-hidden="true"></i>
			<div>
				<strong><?php echo esc_html( $s['ops']['erp_title'] ); ?></strong>
				<p><?php echo esc_html( $s['ops']['erp_desc'] ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- 8. Hệ thống phân phối -->
<section class="h168-section a168-distribution">
	<div class="container-168 a168-distribution__grid">
		<div class="a168-distribution__content">
			<span class="h168-label"><?php echo esc_html( $s['distribution']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['distribution']['heading'] ); ?></h2>
			<p class="h168-lead"><?php echo esc_html( $s['distribution']['lead'] ); ?></p>
			<?php if ( $hq_text ) : ?>
			<p class="a168-distribution__note"><?php echo esc_html( trim( $s['distribution']['hq_label'] . ' ' . $hq_text ) ); ?></p>
			<?php endif; ?>
			<div class="a168-areas">
				<strong><?php echo esc_html( $s['distribution']['areas_heading'] ); ?></strong>
				<ul>
					<?php foreach ( $service_areas as $area ) : ?>
					<li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php echo esc_html( $area ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="a168-distribution__actions">
				<a class="h168-btn h168-btn--primary h168-btn--sm" href="<?php echo esc_url( $s['distribution']['btn_stores_url'] ); ?>"><i class="fas fa-store" aria-hidden="true"></i> <?php echo esc_html( $s['distribution']['btn_stores_text'] ); ?></a>
				<a class="h168-btn h168-btn--outline h168-btn--sm" href="<?php echo esc_url( $s['distribution']['btn_agent_url'] ); ?>"><i class="fas fa-user-plus" aria-hidden="true"></i> <?php echo esc_html( $s['distribution']['btn_agent_text'] ); ?></a>
			</div>
		</div>
		<div class="a168-distribution__map">
			<div class="a168-map-card">
				<iframe title="<?php echo esc_attr( $s['distribution']['heading'] ); ?>" src="<?php echo esc_url( $s['distribution']['map_embed'] ); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			<p class="a168-map-caption"><?php echo esc_html( $s['distribution']['map_caption'] ); ?></p>
		</div>
	</div>
</section>

<!-- 9. Cam kết -->
<section class="h168-section h168-section--alt a168-commit">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['commit']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['commit']['heading'] ); ?></h2>
		</div>
		<div class="a168-commit__grid">
			<?php foreach ( $commitments as $item ) : ?>
			<article class="a168-commit-card">
				<div class="a168-commit-card__icon"><i class="fas <?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i></div>
				<h3><?php echo esc_html( $item['title'] ); ?></h3>
				<p><?php echo esc_html( $item['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 10. Gallery nhà máy -->
<section class="h168-section a168-factory">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label"><?php echo esc_html( $s['factory']['label'] ); ?></span>
			<h2 class="h168-heading"><?php echo esc_html( $s['factory']['heading'] ); ?></h2>
			<p class="h168-section-desc"><?php echo esc_html( $s['factory']['desc'] ); ?></p>
		</div>
		<div class="a168-factory__grid">
			<?php foreach ( $factory_images as $item ) : ?>
			<figure class="a168-factory-card">
				<button type="button" class="a168-factory-card__btn" data-lightbox-src="<?php echo esc_url( $item['src'] ); ?>" data-lightbox-alt="<?php echo esc_attr( $item['alt'] ); ?>">
					<img
						src="<?php echo esc_url( $item['src'] ); ?>"
						alt="<?php echo esc_attr( $item['alt'] ); ?>"
						width="<?php echo absint( $item['width'] ?? 1280 ); ?>"
						height="<?php echo absint( $item['height'] ?? 960 ); ?>"
						loading="lazy"
						decoding="async"
					/>
					<span class="a168-factory-card__overlay" aria-hidden="true"><i class="fas fa-search-plus"></i></span>
				</button>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- 11. CTA -->
<section class="h168-section h168-cta a168-cta" style="--h168-cta-bg: url('<?php echo esc_url( $cta_bg ); ?>')">
	<div class="h168-cta__overlay"></div>
	<div class="container-168 h168-cta__inner">
		<h2 class="h168-cta__title"><?php echo esc_html( $s['cta']['title'] ); ?></h2>
		<p class="h168-cta__desc"><?php echo esc_html( $s['cta']['desc'] ); ?></p>
		<div class="h168-cta__actions">
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> <?php echo esc_html( trim( $s['cta']['btn_phone_prefix'] . ' ' . $contact['hotline_display'] ) ); ?></a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> <?php echo esc_html( $s['cta']['btn_zalo_text'] ); ?></a>
		</div>
	</div>
</section>

<!-- Lightbox -->
<div class="h168-lightbox" hidden aria-hidden="true">
	<div class="h168-lightbox__backdrop" data-lightbox-close></div>
	<div class="h168-lightbox__dialog" role="dialog" aria-modal="true" aria-label="Xem ảnh">
		<button type="button" class="h168-lightbox__close" data-lightbox-close aria-label="Đóng"><i class="fas fa-times" aria-hidden="true"></i></button>
		<img src="" alt="" class="h168-lightbox__img" />
	</div>
</div>

</div>
