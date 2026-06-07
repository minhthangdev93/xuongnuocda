<?php
/**
 * Admin — Cài đặt trang landing.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Đăng ký menu admin.
 */
function nuocda_168_landing_admin_menu() {
	add_menu_page(
		__( 'Cài đặt Nước Đá 168', 'oceanwp' ),
		__( 'Nước Đá 168', 'oceanwp' ),
		'manage_options',
		'nuocda-168-landing',
		'nuocda_168_landing_render_admin_page',
		'dashicons-admin-home',
		58
	);
}
add_action( 'admin_menu', 'nuocda_168_landing_admin_menu' );

/**
 * Register settings.
 */
function nuocda_168_landing_register_settings() {
	register_setting( 'nuocda_168_landing_home', 'nuocda_168_landing_home', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_home' ) );
	register_setting( 'nuocda_168_landing_about', 'nuocda_168_landing_about', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_about' ) );
	register_setting( 'nuocda_168_landing_contact', 'nuocda_168_landing_contact', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_contact' ) );
	register_setting( 'nuocda_168_landing_footer', 'nuocda_168_landing_footer', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_footer' ) );
}
add_action( 'admin_init', 'nuocda_168_landing_register_settings' );

/**
 * Assets admin.
 */
function nuocda_168_landing_admin_assets( $hook ) {
	if ( 'toplevel_page_nuocda-168-landing' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'nuocda-landing-admin',
		get_stylesheet_directory_uri() . '/assets/css/admin-landing.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_script(
		'nuocda-landing-admin',
		get_stylesheet_directory_uri() . '/assets/js/admin-landing.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'nuocda_168_landing_admin_assets' );

/**
 * Render field text.
 */
function nuocda_168_landing_field_text( $name, $label, $value, $wide = true ) {
	?>
	<p class="nuocda-field">
		<label for="<?php echo esc_attr( $name ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<input type="text" class="<?php echo $wide ? 'large-text' : 'regular-text'; ?>" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" />
	</p>
	<?php
}

/**
 * Render textarea.
 */
function nuocda_168_landing_field_textarea( $name, $label, $value, $rows = 3 ) {
	?>
	<p class="nuocda-field">
		<label for="<?php echo esc_attr( $name ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<textarea class="large-text" rows="<?php echo esc_attr( (string) $rows ); ?>" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
	</p>
	<?php
}

/**
 * Render image URL + media picker.
 */
function nuocda_168_landing_field_image( $name, $label, $value ) {
	?>
	<p class="nuocda-field nuocda-field--image">
		<label for="<?php echo esc_attr( $name ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<span class="nuocda-image-field">
			<input type="url" class="large-text nuocda-image-url" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_url( $value ); ?>" placeholder="https://..." />
			<button type="button" class="button nuocda-upload-image"><?php esc_html_e( 'Chọn ảnh', 'oceanwp' ); ?></button>
			<button type="button" class="button-link nuocda-remove-image"><?php esc_html_e( 'Xóa', 'oceanwp' ); ?></button>
		</span>
		<?php if ( $value ) : ?>
			<img src="<?php echo esc_url( $value ); ?>" alt="" class="nuocda-image-preview" />
		<?php else : ?>
			<img src="" alt="" class="nuocda-image-preview" hidden />
		<?php endif; ?>
	</p>
	<?php
}

/**
 * Section box open.
 */
function nuocda_168_landing_section_open( $title ) {
	echo '<div class="nuocda-admin-section"><h2>' . esc_html( $title ) . '</h2>';
}

/**
 * Section box close.
 */
function nuocda_168_landing_section_close() {
	echo '</div>';
}

/**
 * Tab trang chủ.
 */
function nuocda_168_landing_render_tab_home( $s ) {
	$opt = 'nuocda_168_landing_home';
	settings_fields( 'nuocda_168_landing_home' );

	nuocda_168_landing_section_open( 'Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề chính', $s['hero']['title'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title_accent]", 'Tiêu đề nhấn (dòng 2)', $s['hero']['title_accent'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả ngắn', $s['hero']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	echo '<div class="nuocda-repeater" data-template="stat">';
	echo '<h3>Thống kê Hero</h3>';
	foreach ( $s['hero']['stats'] as $i => $stat ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][num]", 'Số', $stat['num'], false );
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][label]", 'Nhãn', $stat['label'], false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa dòng', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="stat">' . esc_html__( '+ Thêm dòng', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Giới thiệu nhanh' );
	nuocda_168_landing_field_image( "{$opt}[about_quick][image]", 'Ảnh', $s['about_quick']['image'] );
	nuocda_168_landing_field_text( "{$opt}[about_quick][label]", 'Nhãn section', $s['about_quick']['label'] );
	nuocda_168_landing_field_text( "{$opt}[about_quick][heading]", 'Tiêu đề', $s['about_quick']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[about_quick][lead]", 'Mô tả', $s['about_quick']['lead'] );
	nuocda_168_landing_field_text( "{$opt}[about_quick][link_url]", 'Link "Tìm hiểu thêm"', $s['about_quick']['link_url'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Sản phẩm nổi bật' );
	nuocda_168_landing_field_text( "{$opt}[products][label]", 'Nhãn section', $s['products']['label'] );
	nuocda_168_landing_field_text( "{$opt}[products][heading]", 'Tiêu đề', $s['products']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[products][desc]", 'Mô tả', $s['products']['desc'] );
	echo '<div class="nuocda-repeater" data-template="product"><h3>Danh sách sản phẩm</h3>';
	foreach ( $s['products']['items'] as $i => $item ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[products][items][{$i}][name]", 'Tên SP', $item['name'] );
		nuocda_168_landing_field_textarea( "{$opt}[products][items][{$i}][desc]", 'Mô tả', $item['desc'], 2 );
		nuocda_168_landing_field_image( "{$opt}[products][items][{$i}][img]", 'Ảnh', $item['img'] );
		nuocda_168_landing_field_text( "{$opt}[products][items][{$i}][link]", 'Link', $item['link'] );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa sản phẩm', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="product">' . esc_html__( '+ Thêm sản phẩm', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Tại sao chọn / CTA / Bản đồ / FAQ' );
	nuocda_168_landing_field_text( "{$opt}[why][heading]", 'Tiêu đề "Tại sao chọn"', $s['why']['heading'] );
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'CTA — Tiêu đề', $s['cta']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'CTA — Mô tả', $s['cta']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[cta][bg]", 'CTA — Ảnh nền', $s['cta']['bg'] );
	nuocda_168_landing_field_textarea( "{$opt}[map][embed]", 'Google Maps embed URL', $s['map']['embed'], 2 );
	echo '<div class="nuocda-repeater" data-template="faq"><h3>FAQ</h3>';
	foreach ( $s['faq']['items'] as $i => $faq ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[faq][items][{$i}][q]", 'Câu hỏi', $faq['q'] );
		nuocda_168_landing_field_textarea( "{$opt}[faq][items][{$i}][a]", 'Trả lời', $faq['a'] );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="faq">' . esc_html__( '+ Thêm FAQ', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();
}

/**
 * Tab giới thiệu.
 */
function nuocda_168_landing_render_tab_about( $s ) {
	$opt = 'nuocda_168_landing_about';
	settings_fields( 'nuocda_168_landing_about' );

	nuocda_168_landing_section_open( 'Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề H1', $s['hero']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả', $s['hero']['desc'], 4 );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Chúng tôi là ai' );
	nuocda_168_landing_field_image( "{$opt}[intro][image]", 'Ảnh minh họa', $s['intro']['image'] );
	nuocda_168_landing_field_text( "{$opt}[intro][label]", 'Nhãn section', $s['intro']['label'] );
	nuocda_168_landing_field_text( "{$opt}[intro][heading]", 'Tiêu đề', $s['intro']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[intro][lead]", 'Nội dung chính', $s['intro']['lead'], 5 );
	nuocda_168_landing_field_textarea( "{$opt}[intro][products]", 'Danh mục SP (mỗi dòng 1 mục)', implode( "\n", $s['intro']['products'] ), 6 );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Tầm nhìn / Công nghệ / CTA' );
	nuocda_168_landing_field_text( "{$opt}[values][heading]", 'Tiêu đề giá trị', $s['values']['heading'] );
	echo '<div class="nuocda-repeater" data-template="icon-item"><h3>3 thẻ giá trị</h3>';
	foreach ( $s['values']['items'] as $i => $item ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[values][items][{$i}][icon]", 'Icon FA (vd: fa-eye)', $item['icon'], false );
		nuocda_168_landing_field_text( "{$opt}[values][items][{$i}][title]", 'Tiêu đề', $item['title'] );
		nuocda_168_landing_field_textarea( "{$opt}[values][items][{$i}][desc]", 'Mô tả', $item['desc'] );
		echo '</div>';
	}
	echo '</div>';
	nuocda_168_landing_field_image( "{$opt}[tech][image]", 'Ảnh công nghệ', $s['tech']['image'] );
	nuocda_168_landing_field_text( "{$opt}[tech][heading]", 'Tiêu đề công nghệ', $s['tech']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[tech][desc]", 'Mô tả công nghệ', $s['tech']['desc'] );
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'CTA cuối trang — Tiêu đề', $s['cta']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'CTA — Mô tả', $s['cta']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[cta][bg]", 'CTA — Ảnh nền', $s['cta']['bg'] );
	nuocda_168_landing_section_close();
}

/**
 * Tab liên hệ.
 */
function nuocda_168_landing_render_tab_contact( $s ) {
	$opt = 'nuocda_168_landing_contact';
	settings_fields( 'nuocda_168_landing_contact' );

	nuocda_168_landing_section_open( 'Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề H1', $s['hero']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả', $s['hero']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Form & Khu vực' );
	nuocda_168_landing_field_text( "{$opt}[form][heading]", 'Tiêu đề form', $s['form']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[form][desc]", 'Mô tả form', $s['form']['desc'] );
	nuocda_168_landing_field_textarea( "{$opt}[form][bullets]", 'Gạch đầu dòng (mỗi dòng 1 ý)', implode( "\n", $s['form']['bullets'] ), 4 );
	nuocda_168_landing_field_text( "{$opt}[areas][heading]", 'Tiêu đề khu vực phục vụ', $s['areas']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[areas][tags]", 'Khu vực (mỗi dòng 1 quận)', implode( "\n", $s['areas']['tags'] ), 8 );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Bản đồ / FAQ / CTA' );
	nuocda_168_landing_field_textarea( "{$opt}[map][embed]", 'Google Maps embed URL', $s['map']['embed'], 2 );
	echo '<div class="nuocda-repeater" data-template="faq"><h3>FAQ</h3>';
	foreach ( $s['faq']['items'] as $i => $faq ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[faq][items][{$i}][q]", 'Câu hỏi', $faq['q'] );
		nuocda_168_landing_field_textarea( "{$opt}[faq][items][{$i}][a]", 'Trả lời', $faq['a'] );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="faq">' . esc_html__( '+ Thêm FAQ', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'CTA cuối — Tiêu đề', $s['cta']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'CTA — Mô tả', $s['cta']['desc'] );
	nuocda_168_landing_section_close();
}

/**
 * Tab footer.
 */
function nuocda_168_landing_render_tab_footer( $s ) {
	$opt = 'nuocda_168_landing_footer';
	settings_fields( 'nuocda_168_landing_footer' );

	nuocda_168_landing_section_open( 'Thương hiệu' );
	nuocda_168_landing_field_text( "{$opt}[brand][fallback_name]", 'Tên thương hiệu (khi chưa có logo)', $s['brand']['fallback_name'] );
	nuocda_168_landing_field_textarea( "{$opt}[brand][tagline]", 'Slogan / mô tả ngắn', $s['brand']['tagline'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Liên kết nhanh' );
	nuocda_168_landing_field_text( "{$opt}[links][title]", 'Tiêu đề nhóm liên kết', $s['links']['title'] );
	echo '<div class="nuocda-repeater" data-template="link"><h3>Danh sách liên kết</h3>';
	foreach ( $s['links']['items'] as $i => $item ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[links][items][{$i}][label]", 'Nhãn', $item['label'] );
		nuocda_168_landing_field_text( "{$opt}[links][items][{$i}][url]", 'URL', $item['url'] );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="link">' . esc_html__( '+ Thêm liên kết', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Thông tin doanh nghiệp' );
	nuocda_168_landing_field_text( "{$opt}[company][title]", 'Tiêu đề section', $s['company']['title'] );
	nuocda_168_landing_field_text( "{$opt}[company][name]", 'Tên công ty', $s['company']['name'] );
	nuocda_168_landing_field_text( "{$opt}[company][trade_name]", 'Tên giao dịch', $s['company']['trade_name'] );
	nuocda_168_landing_field_text( "{$opt}[company][tax_code]", 'Mã số thuế (để trống nếu chưa có)', $s['company']['tax_code'] );
	nuocda_168_landing_field_textarea( "{$opt}[company][address]", 'Trụ sở', $s['company']['address'] );
	nuocda_168_landing_field_text( "{$opt}[company][representative]", 'Đại diện pháp luật', $s['company']['representative'] );
	nuocda_168_landing_field_text( "{$opt}[company][license_date]", 'Ngày cấp GPKD', $s['company']['license_date'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Liên hệ & giờ làm việc' );
	nuocda_168_landing_field_text( "{$opt}[contact][title]", 'Tiêu đề section', $s['contact']['title'] );
	nuocda_168_landing_field_text( "{$opt}[contact][hotline]", 'Hotline (số, không khoảng trắng)', $s['contact']['hotline'] );
	nuocda_168_landing_field_text( "{$opt}[contact][hotline_label]", 'Nhãn hotline', $s['contact']['hotline_label'] );
	nuocda_168_landing_field_text( "{$opt}[contact][email]", 'Email', $s['contact']['email'] );
	nuocda_168_landing_field_text( "{$opt}[contact][zalo_url]", 'Link Zalo', $s['contact']['zalo_url'] );
	nuocda_168_landing_field_text( "{$opt}[contact][zalo_label]", 'Nhãn Zalo', $s['contact']['zalo_label'] );
	nuocda_168_landing_field_text( "{$opt}[contact][hours_title]", 'Tiêu đề giờ mở cửa', $s['contact']['hours_title'] );
	nuocda_168_landing_field_text( "{$opt}[contact][hours]", 'Giờ mở cửa', $s['contact']['hours'] );
	nuocda_168_landing_field_textarea( "{$opt}[contact][hours_note]", 'Ghi chú giờ giao', $s['contact']['hours_note'] );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Form báo giá & cửa hàng' );
	nuocda_168_landing_field_text( "{$opt}[quote][title]", 'Tiêu đề form báo giá', $s['quote']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[quote][desc]", 'Mô tả form', $s['quote']['desc'] );
	nuocda_168_landing_field_text( "{$opt}[quote][placeholder]", 'Placeholder ô số điện thoại', $s['quote']['placeholder'] );
	nuocda_168_landing_field_text( "{$opt}[quote][button]", 'Nút gửi', $s['quote']['button'] );
	nuocda_168_landing_field_text( "{$opt}[stores][heading]", 'Tiêu đề danh sách cửa hàng', $s['stores']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[stores][desc]", 'Mô tả danh sách cửa hàng', $s['stores']['desc'] );
	echo '<p class="description">' . esc_html__( 'Danh sách 12 cửa hàng lấy từ dữ liệu chung site (site-data.php).', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Bản quyền' );
	nuocda_168_landing_field_text( "{$opt}[bottom][copyright]", 'Dòng bản quyền (để trống = dùng tên công ty)', $s['bottom']['copyright'] );
	nuocda_168_landing_field_text( "{$opt}[bottom][subtitle]", 'Dòng phụ (để trống = dùng tên giao dịch)', $s['bottom']['subtitle'] );
	nuocda_168_landing_section_close();
}

/**
 * Trang admin chính.
 */
function nuocda_168_landing_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'home'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! isset( nuocda_168_landing_pages()[ $tab ] ) ) {
		$tab = 'home';
	}

	$settings = nuocda_168_get_landing_settings( $tab );
	$base_url = admin_url( 'admin.php?page=nuocda-168-landing' );
	?>
	<div class="wrap nuocda-landing-admin">
		<h1><?php esc_html_e( 'Cài đặt trang landing', 'oceanwp' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Chỉnh nội dung trang chủ, giới thiệu, liên hệ và footer. Danh sách cửa hàng chi tiết lấy từ dữ liệu chung site.', 'oceanwp' ); ?></p>

		<nav class="nav-tab-wrapper">
			<?php foreach ( nuocda_168_landing_pages() as $slug => $label ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'tab', $slug, $base_url ) ); ?>" class="nav-tab <?php echo $tab === $slug ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>

		<form method="post" action="options.php" class="nuocda-landing-form">
			<?php
			if ( 'about' === $tab ) {
				nuocda_168_landing_render_tab_about( $settings );
			} elseif ( 'contact' === $tab ) {
				nuocda_168_landing_render_tab_contact( $settings );
			} elseif ( 'footer' === $tab ) {
				nuocda_168_landing_render_tab_footer( $settings );
			} else {
				nuocda_168_landing_render_tab_home( $settings );
			}
			submit_button( __( 'Lưu cài đặt', 'oceanwp' ) );
			?>
		</form>
	</div>
	<?php
}
