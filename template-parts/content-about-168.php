<?php
/**
 * Trang Giới thiệu Nước Đá 168 — Redesign 2026
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact        = nuocda_168_get_contact();
$company        = nuocda_168_get_company();
$factory_images = nuocda_168_get_factory_images();
$cert_images    = nuocda_168_get_cert_images();
$uploads_2026   = content_url( 'uploads/2026/06' );

$hero_bg  = $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-1.jpg';
$about_img = $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-4.jpg';
$tech_img  = $uploads_2026 . '/hinh-anh-nha-may-nuoc-da-168-5.jpg';
$cta_bg    = 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_HFBGDQjw.webp';

$hero_stats = array(
	array( 'num' => '10+', 'label' => 'Năm kinh nghiệm' ),
	array( 'num' => '30.000+', 'label' => 'Khách hàng / điểm bán' ),
	array( 'num' => '24/7', 'label' => 'Giao hàng' ),
	array( 'num' => '100%', 'label' => 'Quy trình khép kín' ),
);

$highlights = array(
	array( 'icon' => 'fa-industry', 'title' => 'Sản xuất khép kín', 'desc' => 'Dây chuyền tự động, hạn chế tiếp xúc trực tiếp trong đóng gói.' ),
	array( 'icon' => 'fa-microscope', 'title' => 'Kiểm soát chất lượng', 'desc' => 'QC giám sát từng công đoạn — nguồn nước, sản xuất, bảo quản.' ),
	array( 'icon' => 'fa-truck', 'title' => 'Giao hàng 24/7', 'desc' => 'Đội ngũ giao nhận và điều phối hỗ trợ khách F&B, khách sạn, đại lý.' ),
);

$values = array(
	array(
		'icon'  => 'fa-eye',
		'title' => 'Tầm nhìn',
		'desc'  => 'Trở thành hệ thống cung cấp nước đá sạch uy tín, chuyên nghiệp, đáp ứng nhu cầu ổn định cho khách hàng tại TP.HCM và các khu vực mở rộng.',
	),
	array(
		'icon'  => 'fa-bullseye',
		'title' => 'Sứ mệnh',
		'desc'  => 'Mang đến sản phẩm nước đá tinh khiết, an toàn, ổn định, góp phần nâng cao tiêu chuẩn sử dụng nước đá trong kinh doanh thực phẩm và đồ uống.',
	),
	array(
		'icon'  => 'fa-gem',
		'title' => 'Giá trị cốt lõi',
		'desc'  => 'Chất lượng, minh bạch, đúng hẹn, đồng hành lâu dài cùng khách hàng và đối tác đại lý.',
	),
);

$tech_points = array(
	array( 'icon' => 'fa-tint', 'title' => 'Lọc nước R.O', 'desc' => 'Nguồn nước đầu vào được xử lý qua hệ thống lọc R.O hiện đại trước khi làm đá.' ),
	array( 'icon' => 'fa-sun', 'title' => 'Ozone & UV', 'desc' => 'Kết hợp xử lý Ozone và tia UV giúp kiểm soát chất lượng nước an toàn hơn.' ),
	array( 'icon' => 'fa-cogs', 'title' => 'Dây chuyền tự động', 'desc' => 'Sản xuất và đóng gói trên dây chuyền tự động hóa, hạn chế tiếp xúc trực tiếp.' ),
	array( 'icon' => 'fa-clipboard-check', 'title' => 'Kiểm soát từng công đoạn', 'desc' => 'QC theo dõi chất lượng xuyên suốt — phù hợp đơn hàng số lượng lớn, giao ổn định.' ),
	array( 'icon' => 'fa-box', 'title' => 'Đóng gói & bảo quản', 'desc' => 'Quy trình bảo quản rõ ràng, sẵn sàng điều phối giao hàng theo khu vực.' ),
	array( 'icon' => 'fa-shipping-fast', 'title' => 'Giao số lượng lớn', 'desc' => 'Hệ thống vận hành đáp ứng nhà hàng, khách sạn, sự kiện và đại lý sỉ.' ),
);

$process_steps = array(
	array( 'icon' => 'fa-filter', 'title' => 'Lọc và xử lý nguồn nước', 'desc' => 'Nước đầu vào qua R.O, Ozone, UV trước khi đưa vào sản xuất.' ),
	array( 'icon' => 'fa-snowflake', 'title' => 'Làm đá hiện đại', 'desc' => 'Hệ thống làm đá tự động, đồng nhất chất lượng từng lô.' ),
	array( 'icon' => 'fa-search', 'title' => 'Kiểm tra chất lượng', 'desc' => 'Bộ phận QC giám sát và kiểm tra theo quy trình nội bộ.' ),
	array( 'icon' => 'fa-box-open', 'title' => 'Đóng gói & bảo quản', 'desc' => 'Đóng gói khép kín, bảo quản đúng chuẩn trước khi xuất kho.' ),
	array( 'icon' => 'fa-route', 'title' => 'Điều phối giao hàng', 'desc' => 'ERP hỗ trợ điều phối — giao đến khách hàng và đại lý đúng hẹn.' ),
);

$departments = array(
	array( 'icon' => 'fa-industry', 'name' => 'Sản xuất', 'desc' => 'Vận hành dây chuyền, đảm bảo sản lượng và chất lượng đồng nhất.' ),
	array( 'icon' => 'fa-tools', 'name' => 'Kỹ thuật', 'desc' => 'Bảo trì thiết bị, tối ưu hệ thống lọc và làm đá.' ),
	array( 'icon' => 'fa-microscope', 'name' => 'QC', 'desc' => 'Giám sát quy trình sản xuất và chất lượng sản phẩm độc lập.' ),
	array( 'icon' => 'fa-handshake', 'name' => 'Kinh doanh', 'desc' => 'Tư vấn sản phẩm, báo giá và chăm sóc khách hàng sỉ & lẻ.' ),
	array( 'icon' => 'fa-headset', 'name' => 'CSKH', 'desc' => 'Hỗ trợ đặt hàng, phản hồi nhanh qua hotline và Zalo.' ),
	array( 'icon' => 'fa-calculator', 'name' => 'Kế toán', 'desc' => 'Quản lý đối soát, hỗ trợ đại lý và khách hàng doanh nghiệp.' ),
	array( 'icon' => 'fa-truck', 'name' => 'Giao nhận', 'desc' => 'Lực lượng nòng cốt — giao 24/7 khắp TP.HCM và vùng lân cận.' ),
);

$ops_stats = array(
	array( 'num' => '100+', 'label' => 'Nhân sự' ),
	array( 'num' => '24/7', 'label' => 'Giao hàng' ),
	array( 'num' => '30.000+', 'label' => 'Khách hàng tin dùng' ),
);

$service_areas = array(
	'Quận 1, 3, 4, 5, 6, 7, 8',
	'Quận 10, 11, Tân Bình, Tân Phú',
	'Bình Thạnh, Gò Vấp, Phú Nhuận',
	'Bình Tân, Thủ Đức, Bình Chánh',
);

$commitments = array(
	array( 'icon' => 'fa-shield-alt', 'title' => 'Nước đá sạch, tinh khiết', 'desc' => 'Nguồn nước xử lý R.O — Ozone — UV, quy trình sản xuất khép kín.' ),
	array( 'icon' => 'fa-clock', 'title' => 'Giao nhanh, đúng hẹn', 'desc' => 'Điều phối linh hoạt, hỗ trợ giao 24/7 cho F&B và khách sạn.' ),
	array( 'icon' => 'fa-chart-line', 'title' => 'Nguồn cung ổn định', 'desc' => 'Đáp ứng khách sỉ, chuỗi cửa hàng và đơn hàng số lượng lớn.' ),
	array( 'icon' => 'fa-users', 'title' => 'Đồng hành đại lý', 'desc' => 'Hỗ trợ nguồn hàng, quy trình vận hành và hợp tác lâu dài.' ),
);

$products = array( 'Đá mi', 'Đá viên bốn', 'Đá tám', 'Đá xay nhuyễn', 'Đá bi', 'Đá tấm' );
?>

<div class="landing-168-wrapper a168-page h168-page">

<!-- 1. Hero -->
<section class="a168-hero" style="--a168-hero-bg: url('<?php echo esc_url( $hero_bg ); ?>')">
	<div class="a168-hero__overlay"></div>
	<div class="container-168 a168-hero__inner">
		<div class="a168-hero__content">
			<span class="h168-badge"><i class="fas fa-building" aria-hidden="true"></i> Về Nước Đá Sạch 168</span>
			<h1 class="a168-hero__title">Nước Đá Sạch 168, nguồn cung nước đá tinh khiết ổn định cho mọi nhu cầu</h1>
			<p class="a168-hero__desc">Chúng tôi cung cấp nước đá sạch, nước đá tinh khiết cho nhà hàng, quán ăn, quán cafe, khách sạn, doanh nghiệp và hệ thống đại lý tại TP.HCM.</p>
			<div class="a168-hero__actions">
				<a class="h168-btn h168-btn--primary" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><i class="fas fa-envelope" aria-hidden="true"></i> Liên hệ đặt hàng</a>
				<a class="h168-btn h168-btn--ghost" href="<?php echo esc_url( home_url( '/#xem-san-pham' ) ); ?>"><i class="fas fa-cubes" aria-hidden="true"></i> Xem sản phẩm</a>
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
			<img src="<?php echo esc_url( $about_img ); ?>" alt="Khu vực sản xuất Nước Đá Sạch 168" loading="lazy" width="640" height="480" />
			<div class="a168-intro__badge"><span class="a168-intro__badge-num">ISO</span><span class="a168-intro__badge-text">9001:2015 &amp; HACCP</span></div>
		</div>
		<div class="a168-intro__content">
			<span class="h168-label">Chúng tôi là ai?</span>
			<h2 class="h168-heading">Đơn vị sản xuất nước đá sạch có hệ thống thật</h2>
			<p class="h168-lead">Nước Đá Sạch 168 là đơn vị chuyên sản xuất và cung cấp nước đá sạch, nước đá tinh khiết cho khách hàng cá nhân, nhà hàng, quán cafe, khách sạn, bếp công nghiệp, sự kiện và hệ thống đại lý. Với kinh nghiệm nhiều năm trong ngành, chúng tôi tập trung xây dựng nguồn cung ổn định, quy trình sản xuất an toàn và dịch vụ giao hàng nhanh chóng.</p>
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
			<span class="h168-label">Định hướng</span>
			<h2 class="h168-heading">Tầm nhìn, sứ mệnh &amp; giá trị cốt lõi</h2>
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
			<img src="<?php echo esc_url( $tech_img ); ?>" alt="Hệ thống sản xuất nước đá Nước Đá Sạch 168" loading="lazy" width="640" height="480" />
		</div>
		<div class="a168-tech__content">
			<span class="h168-label">Năng lực sản xuất</span>
			<h2 class="h168-heading">Công nghệ &amp; quy trình vận hành hiện đại</h2>
			<p class="h168-section-desc">Hệ thống sản xuất được đầu tư bài bản — từ xử lý nguồn nước đến đóng gói và giao hàng — phù hợp khách hàng cần nguồn cung ổn định, lâu dài.</p>
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
			<span class="h168-label">Quy trình</span>
			<h2 class="h168-heading">Kiểm soát chất lượng từng công đoạn</h2>
			<p class="h168-section-desc">Mỗi viên đá trước khi đến tay khách hàng đều trải qua quy trình xử lý, sản xuất, kiểm tra và giao nhận rõ ràng.</p>
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
			<span class="h168-label">Minh bạch</span>
			<h2 class="h168-heading">Chứng nhận &amp; hồ sơ liên quan</h2>
			<p class="h168-section-desc">Hồ sơ, chứng nhận và tài liệu liên quan đến hoạt động sản xuất, kiểm soát chất lượng — bao gồm HACCP Codex 2020, EFC International Certification và các hồ sơ công bố.</p>
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
				<span class="h168-label">Tổ chức &amp; vận hành</span>
				<h2 class="h168-heading">Quy mô nhân sự &amp; hệ thống vận hành</h2>
				<p class="h168-section-desc">Đằng sau mỗi đơn hàng giao đúng hẹn là sự phối hợp của đội ngũ hơn 100 nhân sự và hệ thống quản lý ERP — từ tiếp nhận đơn, điều phối sản xuất, tồn kho đến giao nhận.</p>
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
				<h3><?php echo esc_html( $dept['name'] ); ?></h3>
				<p><?php echo esc_html( $dept['desc'] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
		<div class="a168-erp-banner">
			<i class="fas fa-database" aria-hidden="true"></i>
			<div>
				<strong>Ứng dụng ERP trong vận hành</strong>
				<p>Tiếp nhận đơn hàng, điều phối sản xuất, quản lý tồn kho và giao nhận được số hóa — nâng cao hiệu quả và giảm sai sót.</p>
			</div>
		</div>
	</div>
</section>

<!-- 8. Hệ thống phân phối -->
<section class="h168-section a168-distribution">
	<div class="container-168 a168-distribution__grid">
		<div class="a168-distribution__content">
			<span class="h168-label">Phân phối</span>
			<h2 class="h168-heading">Hệ thống phân phối &amp; đại lý</h2>
			<p class="h168-lead">Nước Đá Sạch 168 không ngừng mở rộng mạng lưới xưởng sản xuất, kho trung chuyển và đại lý nước đá tại nhiều khu vực trọng điểm. Hệ thống phân phối đa điểm giúp rút ngắn thời gian vận chuyển, đảm bảo nguồn cung ổn định cho khách hàng.</p>
			<p class="a168-distribution__note">Trụ sở: <?php echo esc_html( $company['address'] ); ?></p>
			<div class="a168-areas">
				<strong>Khu vực phục vụ chính tại TP.HCM:</strong>
				<ul>
					<?php foreach ( $service_areas as $area ) : ?>
					<li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php echo esc_html( $area ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="a168-distribution__actions">
				<a class="h168-btn h168-btn--primary h168-btn--sm" href="<?php echo esc_url( home_url( '/#danh-sach-cua-hang' ) ); ?>"><i class="fas fa-store" aria-hidden="true"></i> Xem danh sách cửa hàng</a>
				<a class="h168-btn h168-btn--outline h168-btn--sm" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><i class="fas fa-user-plus" aria-hidden="true"></i> Đăng ký làm đại lý</a>
			</div>
		</div>
		<div class="a168-distribution__map">
			<div class="a168-map-card">
				<iframe title="Bản đồ Nước Đá Sạch 168" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6705608821915!2d106.6669894!3d10.7719445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1e2f7c7b8f%3A0x678a1f879d7d1e8c!2zSOG6m10gMTY4LzkgTMOuIEJpbmggS-G6o24gQywgUGjGsOG7nW5nIDQsIFF14bqtbiA4LCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701358823652!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			<p class="a168-map-caption">12 cửa hàng &amp; đại lý tại TP.HCM — xem đầy đủ tại trang chủ hoặc footer.</p>
		</div>
	</div>
</section>

<!-- 9. Cam kết -->
<section class="h168-section h168-section--alt a168-commit">
	<div class="container-168">
		<div class="h168-section-head h168-section-head--center">
			<span class="h168-label">Cam kết</span>
			<h2 class="h168-heading">Cam kết với khách hàng &amp; đối tác</h2>
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
			<span class="h168-label">Thực tế</span>
			<h2 class="h168-heading">Hình ảnh nhà máy &amp; vận hành</h2>
			<p class="h168-section-desc">Hình ảnh thực tế khu vực sản xuất, dây chuyền và vận hành — minh bạch năng lực doanh nghiệp.</p>
		</div>
		<div class="a168-factory__grid">
			<?php foreach ( $factory_images as $item ) : ?>
			<figure class="a168-factory-card">
				<button type="button" class="a168-factory-card__btn" data-lightbox-src="<?php echo esc_url( $item['src'] ); ?>" data-lightbox-alt="<?php echo esc_attr( $item['alt'] ); ?>">
					<img src="<?php echo esc_url( $item['src'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>" loading="lazy" />
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
		<h2 class="h168-cta__title">Bạn cần nguồn cung nước đá sạch ổn định?</h2>
		<p class="h168-cta__desc">Liên hệ Nước Đá Sạch 168 để được tư vấn loại đá phù hợp, báo giá nhanh và điều phối giao hàng theo nhu cầu thực tế.</p>
		<div class="h168-cta__actions">
			<a class="h168-btn h168-btn--primary h168-btn--lg" href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>"><i class="fas fa-phone-alt" aria-hidden="true"></i> Gọi ngay: 0348 226 455</a>
			<a class="h168-btn h168-btn--zalo h168-btn--lg" href="<?php echo esc_url( $contact['zalo'] ); ?>" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> Liên hệ Zalo</a>
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
