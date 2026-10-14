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
	register_setting( 'nuocda_168_landing_agents', 'nuocda_168_landing_agents', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_agents' ) );
	register_setting( 'nuocda_168_landing_footer', 'nuocda_168_landing_footer', array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_footer' ) );

	// Gallery dùng chung — đăng ký vào cả group home & about để lưu cùng form tab.
	$gallery_args = array( 'sanitize_callback' => 'nuocda_168_landing_sanitize_galleries' );
	register_setting( 'nuocda_168_landing_home', nuocda_168_landing_galleries_option_key(), $gallery_args );
	register_setting( 'nuocda_168_landing_about', nuocda_168_landing_galleries_option_key(), $gallery_args );
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
		array( 'jquery', 'jquery-ui-sortable' ),
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
 * Kích thước ảnh đề xuất theo loại gallery.
 *
 * @param string $key factory_ids|cert_ids.
 * @return string
 */
function nuocda_168_landing_gallery_size_hint( $key ) {
	if ( 'cert_ids' === $key ) {
		return __( '900×1200 px (tỷ lệ ~3:4 dọc) hoặc ảnh giấy tờ A4. Tối thiểu cạnh ngắn 800 px, JPG/PNG/WebP, dưới 500 KB/ảnh.', 'oceanwp' );
	}

	return __( '1280×960 px (tỷ lệ 4:3 ngang). Tối thiểu 1200×900 px, JPG/WebP, dưới 400 KB/ảnh.', 'oceanwp' );
}

/**
 * Render gallery chọn nhiều ảnh (attachment IDs).
 *
 * @param string $key   factory_ids|cert_ids.
 * @param string $label Field label.
 * @param string $help  Mô tả phụ.
 */
function nuocda_168_landing_field_gallery( $key, $label, $help = '' ) {
	$opt       = nuocda_168_landing_galleries_option_key();
	$galleries = nuocda_168_get_landing_galleries();
	$ids       = $galleries[ $key ] ?? array();
	$name      = $opt . '[' . $key . '][]';
	$flag      = $opt . '[' . ( 'cert_ids' === $key ? 'cert_present' : 'factory_present' ) . ']';
	$size_hint = nuocda_168_landing_gallery_size_hint( $key );
	?>
	<div class="nuocda-field nuocda-field--gallery" data-gallery-key="<?php echo esc_attr( $key ); ?>">
		<label><strong><?php echo esc_html( $label ); ?></strong></label>
		<?php if ( $help ) : ?>
			<p class="description"><?php echo esc_html( $help ); ?></p>
		<?php endif; ?>
		<p class="description nuocda-gallery-size-hint"><strong><?php esc_html_e( 'Kích thước ảnh:', 'oceanwp' ); ?></strong> <?php echo esc_html( $size_hint ); ?></p>
		<p class="description"><?php esc_html_e( 'Kéo thả ảnh để sắp xếp thứ tự hiển thị (trái → phải, trên → dưới).', 'oceanwp' ); ?></p>
		<input type="hidden" name="<?php echo esc_attr( $flag ); ?>" value="1" />
		<ul class="nuocda-gallery-list">
			<?php foreach ( $ids as $id ) : ?>
				<?php
				$id  = absint( $id );
				$src = $id ? wp_get_attachment_image_url( $id, 'thumbnail' ) : '';
				if ( ! $src ) {
					$src = $id ? wp_get_attachment_url( $id ) : '';
				}
				if ( ! $src ) {
					continue;
				}
				?>
				<li class="nuocda-gallery-item" data-id="<?php echo esc_attr( (string) $id ); ?>">
					<span class="nuocda-gallery-handle" title="<?php esc_attr_e( 'Kéo để sắp xếp', 'oceanwp' ); ?>" aria-hidden="true">⋮⋮</span>
					<img src="<?php echo esc_url( $src ); ?>" alt="" />
					<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( (string) $id ); ?>" />
					<button type="button" class="button-link nuocda-gallery-remove" aria-label="<?php esc_attr_e( 'Xóa ảnh', 'oceanwp' ); ?>">&times;</button>
				</li>
			<?php endforeach; ?>
		</ul>
		<p class="nuocda-gallery-actions">
			<button type="button" class="button nuocda-gallery-add" data-input-name="<?php echo esc_attr( $name ); ?>">
				<?php esc_html_e( 'Chọn / thêm ảnh', 'oceanwp' ); ?>
			</button>
			<button type="button" class="button-link nuocda-gallery-clear">
				<?php esc_html_e( 'Xóa hết (dùng ảnh mặc định theo tên file)', 'oceanwp' ); ?>
			</button>
		</p>
	</div>
	<?php
}

/**
 * Section thư viện ảnh dùng chung.
 *
 * @param bool $include_cert Có hiện gallery chứng nhận (tab trang chủ).
 */
function nuocda_168_landing_render_galleries_section( $include_cert = true ) {
	nuocda_168_landing_section_open( 'Thư viện ảnh nhà máy & chứng nhận' );
	echo '<p class="description">' . esc_html__( 'Dùng chung cho trang chủ và trang giới thiệu. Để trống = theme tự lấy ảnh theo tên file trong Media Library.', 'oceanwp' ) . '</p>';

	nuocda_168_landing_field_gallery(
		'factory_ids',
		'Ảnh nhà máy / vận hành',
		'Hiển thị tab Nhà máy (trang chủ) và section Hình ảnh nhà máy (giới thiệu).'
	);

	if ( $include_cert ) {
		nuocda_168_landing_field_gallery(
			'cert_ids',
			'Ảnh chứng nhận & hồ sơ',
			'Hiển thị tab Chứng nhận trên trang chủ.'
		);
	} else {
		echo '<p class="description">' . esc_html__( 'Ảnh chứng nhận chỉnh ở tab Trang chủ.', 'oceanwp' ) . '</p>';
	}

	nuocda_168_landing_section_close();
}

/**
 * Section box open (accordion — mặc định đóng).
 *
 * @param string $title Section title.
 * @param bool   $open  Mở sẵn section này.
 */
function nuocda_168_landing_section_open( $title, $open = false ) {
	$expanded = $open ? 'true' : 'false';
	$cls      = 'nuocda-admin-section' . ( $open ? ' is-open' : '' );

	echo '<div class="' . esc_attr( $cls ) . '">';
	echo '<button type="button" class="nuocda-admin-section__toggle" aria-expanded="' . esc_attr( $expanded ) . '">';
	echo '<span class="nuocda-admin-section__title">' . esc_html( $title ) . '</span>';
	echo '<span class="nuocda-admin-section__chevron" aria-hidden="true"></span>';
	echo '</button>';
	echo '<div class="nuocda-admin-section__body">';
}

/**
 * Section box close.
 */
function nuocda_168_landing_section_close() {
	echo '</div></div>';
}

/**
 * Tab trang chủ.
 */
/**
 * Helper — lấy list từ settings home, fallback defaults.
 *
 * @param array       $s        Settings.
 * @param string      $section  Section key (hoặc 'stats' cho list gốc).
 * @param string|null $list_key List key trong section; null nếu section là list.
 * @return array
 */
function nuocda_168_landing_home_list( $s, $section, $list_key = null ) {
	$defaults = nuocda_168_landing_defaults_home();

	if ( null === $list_key ) {
		if ( ! empty( $s[ $section ] ) && is_array( $s[ $section ] ) ) {
			return $s[ $section ];
		}
		return $defaults[ $section ] ?? array();
	}

	if ( ! empty( $s[ $section ][ $list_key ] ) && is_array( $s[ $section ][ $list_key ] ) ) {
		return $s[ $section ][ $list_key ];
	}

	return $defaults[ $section ][ $list_key ] ?? array();
}

/**
 * Tab trang chủ — toàn bộ text trang chủ.
 */
function nuocda_168_landing_render_tab_home( $s ) {
	$opt = 'nuocda_168_landing_home';
	settings_fields( 'nuocda_168_landing_home' );

	nuocda_168_landing_section_open( '1. Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề chính', $s['hero']['title'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title_accent]", 'Tiêu đề nhấn (dòng 2)', $s['hero']['title_accent'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả ngắn', $s['hero']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_primary_text]", 'Nút chính — Text', $s['hero']['btn_primary_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_primary_url]", 'Nút chính — URL (trống = Zalo Footer)', $s['hero']['btn_primary_url'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_secondary_text]", 'Nút phụ — Text', $s['hero']['btn_secondary_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_secondary_url]", 'Nút phụ — URL (vd: #xem-san-pham)', $s['hero']['btn_secondary_url'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="stat"><h3>' . esc_html__( 'Thống kê Hero', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_home_list( $s, 'hero', 'stats' ) as $i => $stat ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][num]", 'Số', $stat['num'] ?? '', false );
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][label]", 'Nhãn', $stat['label'] ?? '', false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa dòng', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="stat">' . esc_html__( '+ Thêm dòng', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '2. Giới thiệu nhanh' );
	nuocda_168_landing_field_image( "{$opt}[about_quick][image]", 'Ảnh', $s['about_quick']['image'] );
	nuocda_168_landing_field_text( "{$opt}[about_quick][image_alt]", 'Alt ảnh', $s['about_quick']['image_alt'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[about_quick][badge_num]", 'Badge ảnh — dòng 1', $s['about_quick']['badge_num'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[about_quick][badge_text]", 'Badge ảnh — dòng 2', $s['about_quick']['badge_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[about_quick][label]", 'Nhãn section', $s['about_quick']['label'] );
	nuocda_168_landing_field_text( "{$opt}[about_quick][heading]", 'Tiêu đề', $s['about_quick']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[about_quick][lead]", 'Mô tả', $s['about_quick']['lead'] );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'about_quick][highlights',
		'home-highlight',
		nuocda_168_landing_home_list( $s, 'about_quick', 'highlights' ),
		'Thẻ nổi bật',
		'Vd. Nước tinh khiết, Đóng gói khép kín…',
		'fa-tint'
	);
	nuocda_168_landing_field_text( "{$opt}[about_quick][link_text]", 'Link — Text', $s['about_quick']['link_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[about_quick][link_url]", 'Link — URL', $s['about_quick']['link_url'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '3. Sản phẩm nổi bật' );
	nuocda_168_landing_field_text( "{$opt}[products][label]", 'Nhãn section', $s['products']['label'] );
	nuocda_168_landing_field_text( "{$opt}[products][heading]", 'Tiêu đề', $s['products']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[products][desc]", 'Mô tả', $s['products']['desc'] );
	nuocda_168_landing_field_text( "{$opt}[products][link_label]", 'Nhãn nút mỗi SP', $s['products']['link_label'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="product"><h3>' . esc_html__( 'Danh sách sản phẩm', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_home_list( $s, 'products', 'items' ) as $i => $item ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[products][items][{$i}][name]", 'Tên SP', $item['name'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[products][items][{$i}][desc]", 'Mô tả', $item['desc'] ?? '', 2 );
		nuocda_168_landing_field_image( "{$opt}[products][items][{$i}][img]", 'Ảnh', $item['img'] ?? '' );
		nuocda_168_landing_field_text( "{$opt}[products][items][{$i}][link]", 'Link', $item['link'] ?? '' );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa sản phẩm', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="product">' . esc_html__( '+ Thêm sản phẩm', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '4. Tại sao chọn chúng tôi?' );
	nuocda_168_landing_field_text( "{$opt}[why][label]", 'Nhãn section', $s['why']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[why][heading]", 'Tiêu đề section', $s['why']['heading'] ?? '' );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'why][items',
		'why-item',
		nuocda_168_landing_home_list( $s, 'why', 'items' ),
		'Các thẻ lợi thế',
		'Mỗi thẻ: tiêu đề (vd. Chuẩn an toàn) và mô tả. Icon FA tùy chọn (vd. fa-shield-alt).',
		'fa-shield-alt'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '5. Thống kê' );
	echo '<div class="nuocda-repeater" data-template="page-stat"><h3>' . esc_html__( 'Các chỉ số', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_home_list( $s, 'stats' ) as $i => $stat ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[stats][{$i}][num]", 'Số', $stat['num'] ?? '', false );
		nuocda_168_landing_field_text( "{$opt}[stats][{$i}][label]", 'Nhãn', $stat['label'] ?? '', false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa dòng', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="page-stat">' . esc_html__( '+ Thêm dòng', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '6. Cửa hàng / Bản đồ' );
	nuocda_168_landing_field_text( "{$opt}[stores][label]", 'Cửa hàng — Nhãn', $s['stores']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[stores][heading]", 'Cửa hàng — Tiêu đề', $s['stores']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[stores][desc]", 'Cửa hàng — Mô tả', $s['stores']['desc'] ?? '' );
	echo '<p class="description">' . esc_html__( 'Danh sách cửa hàng chỉnh ở tab Đại lý.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_field_text( "{$opt}[map][label]", 'Bản đồ — Nhãn', $s['map']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[map][heading]", 'Bản đồ — Tiêu đề', $s['map']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[map][desc]", 'Bản đồ — Mô tả', $s['map']['desc'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[map][embed]", 'Google Maps embed URL', $s['map']['embed'] ?? '', 2 );
	nuocda_168_landing_field_text( "{$opt}[map][title]", 'Title iframe (SEO/a11y)', $s['map']['title'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '7. Đánh giá khách hàng' );
	nuocda_168_landing_field_text( "{$opt}[reviews][label]", 'Nhãn section', $s['reviews']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[reviews][heading]", 'Tiêu đề', $s['reviews']['heading'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="review"><h3>' . esc_html__( 'Các đánh giá', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_home_list( $s, 'reviews', 'items' ) as $i => $review ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[reviews][items][{$i}][stars]", 'Số sao (1–5)', (string) ( $review['stars'] ?? 5 ), false );
		nuocda_168_landing_field_textarea( "{$opt}[reviews][items][{$i}][text]", 'Nội dung', $review['text'] ?? '', 3 );
		nuocda_168_landing_field_text( "{$opt}[reviews][items][{$i}][author]", 'Tác giả / nguồn', $review['author'] ?? '' );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="review">' . esc_html__( '+ Thêm đánh giá', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '8. Hình ảnh nhà máy & chứng nhận (tiêu đề)' );
	nuocda_168_landing_field_text( "{$opt}[media][label]", 'Nhãn section', $s['media']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[media][heading]", 'Tiêu đề', $s['media']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[media][desc]", 'Mô tả', $s['media']['desc'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[media][tab_factory]", 'Tab — Nhà máy', $s['media']['tab_factory'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[media][tab_cert]", 'Tab — Chứng nhận', $s['media']['tab_cert'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[media][tabs_aria]", 'Aria-label tablist', $s['media']['tabs_aria'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_render_galleries_section( true );

	nuocda_168_landing_section_open( '9. FAQ' );
	nuocda_168_landing_field_text( "{$opt}[faq][label]", 'Nhãn section', $s['faq']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[faq][heading]", 'Tiêu đề', $s['faq']['heading'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="faq"><h3>' . esc_html__( 'Câu hỏi', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_home_list( $s, 'faq', 'items' ) as $i => $faq ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[faq][items][{$i}][q]", 'Câu hỏi', $faq['q'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[faq][items][{$i}][a]", 'Trả lời', $faq['a'] ?? '' );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="faq">' . esc_html__( '+ Thêm FAQ', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '10. CTA cuối trang' );
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'Tiêu đề', $s['cta']['title'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'Mô tả', $s['cta']['desc'] ?? '' );
	nuocda_168_landing_field_image( "{$opt}[cta][bg]", 'Ảnh nền', $s['cta']['bg'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_phone_prefix]", 'Nút gọi — tiền tố (trước SĐT)', $s['cta']['btn_phone_prefix'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_zalo_text]", 'Nút Zalo — Text', $s['cta']['btn_zalo_text'] ?? '' );
	echo '<p class="description">' . esc_html__( 'Số điện thoại & link Zalo lấy từ tab Footer.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();
}

/**
 * Helper — lấy list từ settings, fallback defaults about.
 *
 * @param array  $s        Settings.
 * @param string $section  Section key.
 * @param string $list_key List key.
 * @return array
 */
function nuocda_168_landing_about_list( $s, $section, $list_key ) {
	if ( ! empty( $s[ $section ][ $list_key ] ) && is_array( $s[ $section ][ $list_key ] ) ) {
		return $s[ $section ][ $list_key ];
	}

	$defaults = nuocda_168_landing_defaults_about();
	return $defaults[ $section ][ $list_key ] ?? array();
}

/**
 * Render repeater icon+title+desc.
 *
 * @param string $opt       Option name.
 * @param string $path      Path without trailing (vd: intro][highlights).
 * @param string $type      JS data-type.
 * @param array  $items     Items.
 * @param string $heading   Heading.
 * @param string $help      Help text.
 * @param string $icon_hint Icon placeholder.
 */
function nuocda_168_landing_render_icon_items_repeater( $opt, $path, $type, $items, $heading, $help = '', $icon_hint = 'fa-check' ) {
	echo '<div class="nuocda-repeater" data-template="' . esc_attr( $type ) . '"><h3>' . esc_html( $heading ) . '</h3>';
	if ( $help ) {
		echo '<p class="description">' . esc_html( $help ) . '</p>';
	}
	foreach ( $items as $i => $item ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[{$path}][{$i}][title]", 'Tiêu đề', $item['title'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[{$path}][{$i}][desc]", 'Mô tả', $item['desc'] ?? '', 2 );
		nuocda_168_landing_field_text( "{$opt}[{$path}][{$i}][icon]", 'Icon FA (vd: ' . $icon_hint . ')', $item['icon'] ?? $icon_hint, false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="' . esc_attr( $type ) . '">' . esc_html__( '+ Thêm', 'oceanwp' ) . '</button></div>';
}

/**
 * Tab giới thiệu — toàn bộ text trang /about-us/.
 */
function nuocda_168_landing_render_tab_about( $s ) {
	$opt = 'nuocda_168_landing_about';
	settings_fields( 'nuocda_168_landing_about' );

	nuocda_168_landing_section_open( '1. Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề H1', $s['hero']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả', $s['hero']['desc'], 4 );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_primary_text]", 'Nút chính — Text', $s['hero']['btn_primary_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_primary_url]", 'Nút chính — URL', $s['hero']['btn_primary_url'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_secondary_text]", 'Nút phụ — Text', $s['hero']['btn_secondary_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_secondary_url]", 'Nút phụ — URL', $s['hero']['btn_secondary_url'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="stat"><h3>' . esc_html__( 'Thống kê hero', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_about_list( $s, 'hero', 'stats' ) as $i => $stat ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][num]", 'Số', $stat['num'] ?? '', false );
		nuocda_168_landing_field_text( "{$opt}[hero][stats][{$i}][label]", 'Nhãn', $stat['label'] ?? '', false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa dòng', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="stat">' . esc_html__( '+ Thêm dòng', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '2. Chúng tôi là ai' );
	nuocda_168_landing_field_image( "{$opt}[intro][image]", 'Ảnh minh họa', $s['intro']['image'] );
	nuocda_168_landing_field_text( "{$opt}[intro][image_alt]", 'Alt ảnh', $s['intro']['image_alt'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[intro][badge_num]", 'Badge ảnh — dòng 1', $s['intro']['badge_num'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[intro][badge_text]", 'Badge ảnh — dòng 2', $s['intro']['badge_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[intro][label]", 'Nhãn section', $s['intro']['label'] );
	nuocda_168_landing_field_text( "{$opt}[intro][heading]", 'Tiêu đề', $s['intro']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[intro][lead]", 'Nội dung chính', $s['intro']['lead'], 5 );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'intro][highlights',
		'highlight-item',
		nuocda_168_landing_about_list( $s, 'intro', 'highlights' ),
		'Thẻ nổi bật',
		'Vd. Sản xuất khép kín, Kiểm soát chất lượng…',
		'fa-industry'
	);
	nuocda_168_landing_field_textarea( "{$opt}[intro][products]", 'Danh mục SP (mỗi dòng 1 mục)', implode( "\n", (array) ( $s['intro']['products'] ?? array() ) ), 6 );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '3. Tầm nhìn / sứ mệnh / giá trị' );
	nuocda_168_landing_field_text( "{$opt}[values][label]", 'Nhãn section', $s['values']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[values][heading]", 'Tiêu đề', $s['values']['heading'] );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'values][items',
		'values-item',
		nuocda_168_landing_about_list( $s, 'values', 'items' ),
		'Các thẻ giá trị',
		'',
		'fa-eye'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '4. Công nghệ & quy trình vận hành' );
	nuocda_168_landing_field_image( "{$opt}[tech][image]", 'Ảnh', $s['tech']['image'] );
	nuocda_168_landing_field_text( "{$opt}[tech][image_alt]", 'Alt ảnh', $s['tech']['image_alt'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[tech][label]", 'Nhãn section', $s['tech']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[tech][heading]", 'Tiêu đề', $s['tech']['heading'] );
	nuocda_168_landing_field_textarea( "{$opt}[tech][desc]", 'Mô tả', $s['tech']['desc'] );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'tech][items',
		'tech-item',
		nuocda_168_landing_about_list( $s, 'tech', 'items' ),
		'Thẻ công nghệ',
		'',
		'fa-tint'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '5. Quy trình kiểm soát chất lượng' );
	nuocda_168_landing_field_text( "{$opt}[process][label]", 'Nhãn section', $s['process']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[process][heading]", 'Tiêu đề', $s['process']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[process][desc]", 'Mô tả', $s['process']['desc'] ?? '' );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'process][items',
		'process-item',
		nuocda_168_landing_about_list( $s, 'process', 'items' ),
		'Các bước quy trình',
		'',
		'fa-filter'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '6. Chứng nhận & hồ sơ (tiêu đề)' );
	nuocda_168_landing_field_text( "{$opt}[certs][label]", 'Nhãn section', $s['certs']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[certs][heading]", 'Tiêu đề', $s['certs']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[certs][desc]", 'Mô tả', $s['certs']['desc'] ?? '' );
	echo '<p class="description">' . esc_html__( 'Ảnh chứng nhận chỉnh ở tab Trang chủ → Thư viện ảnh.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '7. Quy mô nhân sự & vận hành' );
	nuocda_168_landing_field_text( "{$opt}[ops][label]", 'Nhãn section', $s['ops']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[ops][heading]", 'Tiêu đề', $s['ops']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[ops][desc]", 'Mô tả', $s['ops']['desc'] ?? '', 4 );
	echo '<div class="nuocda-repeater" data-template="ops-stat"><h3>' . esc_html__( 'Thống kê vận hành', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_about_list( $s, 'ops', 'stats' ) as $i => $stat ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[ops][stats][{$i}][num]", 'Số', $stat['num'] ?? '', false );
		nuocda_168_landing_field_text( "{$opt}[ops][stats][{$i}][label]", 'Nhãn', $stat['label'] ?? '', false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa dòng', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="ops-stat">' . esc_html__( '+ Thêm dòng', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'ops][departments',
		'dept-item',
		nuocda_168_landing_about_list( $s, 'ops', 'departments' ),
		'Phòng ban / bộ phận',
		'',
		'fa-industry'
	);
	nuocda_168_landing_field_text( "{$opt}[ops][erp_title]", 'Banner ERP — Tiêu đề', $s['ops']['erp_title'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[ops][erp_desc]", 'Banner ERP — Mô tả', $s['ops']['erp_desc'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '8. Hệ thống phân phối & đại lý' );
	nuocda_168_landing_field_text( "{$opt}[distribution][label]", 'Nhãn section', $s['distribution']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[distribution][heading]", 'Tiêu đề', $s['distribution']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[distribution][lead]", 'Mô tả chính', $s['distribution']['lead'] ?? '', 4 );
	nuocda_168_landing_field_text( "{$opt}[distribution][hq_label]", 'Nhãn trụ sở', $s['distribution']['hq_label'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[distribution][hq_text]", 'Địa chỉ trụ sở', $s['distribution']['hq_text'] ?? '', 2 );
	nuocda_168_landing_field_text( "{$opt}[distribution][areas_heading]", 'Tiêu đề khu vực', $s['distribution']['areas_heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[distribution][areas]", 'Khu vực (mỗi dòng 1 mục)', implode( "\n", (array) ( $s['distribution']['areas'] ?? array() ) ), 5 );
	nuocda_168_landing_field_text( "{$opt}[distribution][btn_stores_text]", 'Nút cửa hàng — Text', $s['distribution']['btn_stores_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[distribution][btn_stores_url]", 'Nút cửa hàng — URL', $s['distribution']['btn_stores_url'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[distribution][btn_agent_text]", 'Nút đại lý — Text', $s['distribution']['btn_agent_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[distribution][btn_agent_url]", 'Nút đại lý — URL', $s['distribution']['btn_agent_url'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[distribution][map_embed]", 'Google Maps embed URL', $s['distribution']['map_embed'] ?? '', 2 );
	nuocda_168_landing_field_text( "{$opt}[distribution][map_caption]", 'Chú thích bản đồ', $s['distribution']['map_caption'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '9. Cam kết' );
	nuocda_168_landing_field_text( "{$opt}[commit][label]", 'Nhãn section', $s['commit']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[commit][heading]", 'Tiêu đề', $s['commit']['heading'] ?? '' );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'commit][items',
		'commit-item',
		nuocda_168_landing_about_list( $s, 'commit', 'items' ),
		'Các thẻ cam kết',
		'',
		'fa-shield-alt'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '10. Hình ảnh nhà máy (tiêu đề)' );
	nuocda_168_landing_field_text( "{$opt}[factory][label]", 'Nhãn section', $s['factory']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[factory][heading]", 'Tiêu đề', $s['factory']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[factory][desc]", 'Mô tả', $s['factory']['desc'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_render_galleries_section( false );

	nuocda_168_landing_section_open( '11. CTA cuối trang' );
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'Tiêu đề', $s['cta']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'Mô tả', $s['cta']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[cta][bg]", 'Ảnh nền', $s['cta']['bg'] );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_phone_prefix]", 'Nút gọi — tiền tố (trước SĐT)', $s['cta']['btn_phone_prefix'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_zalo_text]", 'Nút Zalo — Text', $s['cta']['btn_zalo_text'] ?? '' );
	echo '<p class="description">' . esc_html__( 'Số điện thoại & link Zalo lấy từ tab Footer.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();
}

/**
 * Tab liên hệ.
 */
/**
 * Helper — list từ settings contact, fallback defaults.
 *
 * @param array       $s        Settings.
 * @param string      $section  Section.
 * @param string|null $list_key List key.
 * @return array
 */
function nuocda_168_landing_contact_list( $s, $section, $list_key = null ) {
	$defaults = nuocda_168_landing_defaults_contact();

	if ( null === $list_key ) {
		if ( ! empty( $s[ $section ] ) && is_array( $s[ $section ] ) ) {
			return $s[ $section ];
		}
		return $defaults[ $section ] ?? array();
	}

	if ( ! empty( $s[ $section ][ $list_key ] ) && is_array( $s[ $section ][ $list_key ] ) ) {
		return $s[ $section ][ $list_key ];
	}

	return $defaults[ $section ][ $list_key ] ?? array();
}

/**
 * Format option pairs thành textarea (value|Label).
 *
 * @param array $items Items.
 * @return string
 */
function nuocda_168_landing_option_pairs_to_text( $items ) {
	$lines = array();
	foreach ( (array) $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$value = $item['value'] ?? '';
		$label = $item['label'] ?? '';
		if ( $label ) {
			$lines[] = $value ? ( $value . '|' . $label ) : $label;
		}
	}
	return implode( "\n", $lines );
}

/**
 * Tab liên hệ — toàn bộ text trang /contact-us/.
 */
function nuocda_168_landing_render_tab_contact( $s ) {
	$opt = 'nuocda_168_landing_contact';
	settings_fields( 'nuocda_168_landing_contact' );

	nuocda_168_landing_section_open( '1. Hero' );
	nuocda_168_landing_field_text( "{$opt}[hero][badge]", 'Badge', $s['hero']['badge'] );
	nuocda_168_landing_field_text( "{$opt}[hero][title]", 'Tiêu đề H1', $s['hero']['title'] );
	nuocda_168_landing_field_textarea( "{$opt}[hero][desc]", 'Mô tả', $s['hero']['desc'] );
	nuocda_168_landing_field_image( "{$opt}[hero][bg]", 'Ảnh nền Hero', $s['hero']['bg'] );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_phone_prefix]", 'Nút gọi — tiền tố', $s['hero']['btn_phone_prefix'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_zalo_text]", 'Nút Zalo — Text', $s['hero']['btn_zalo_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_form_text]", 'Nút form — Text', $s['hero']['btn_form_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[hero][btn_form_url]", 'Nút form — URL (vd: #c168-form)', $s['hero']['btn_form_url'] ?? '' );
	echo '<p class="description">' . esc_html__( 'SĐT & link Zalo lấy từ tab Footer.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '2. Liên hệ nhanh (4 thẻ)' );
	echo '<p class="description">' . esc_html__( 'Type: phone | zalo | email | quote | custom. Để trống title/value/btn/url thì tự lấy từ Footer (hotline, Zalo, email) theo type.', 'oceanwp' ) . '</p>';
	echo '<div class="nuocda-repeater" data-template="channel-item"><h3>' . esc_html__( 'Các thẻ kênh', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_contact_list( $s, 'channels', 'items' ) as $i => $item ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][type]", 'Type (phone/zalo/email/quote/custom)', $item['type'] ?? 'custom', false );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][icon]", 'Icon FA', $item['icon'] ?? 'fa-check', false );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][title]", 'Tiêu đề', $item['title'] ?? '' );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][value]", 'Giá trị (dòng lớn)', $item['value'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[channels][items][{$i}][desc]", 'Mô tả', $item['desc'] ?? '', 2 );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][btn]", 'Nút — Text', $item['btn'] ?? '' );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][url]", 'URL (trống = tự theo type)', $item['url'] ?? '' );
		nuocda_168_landing_field_text( "{$opt}[channels][items][{$i}][class]", 'CSS class', $item['class'] ?? '', false );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa thẻ', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="channel-item">' . esc_html__( '+ Thêm thẻ', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '3. Form đặt hàng / báo giá' );
	nuocda_168_landing_field_text( "{$opt}[form][label]", 'Nhãn section', $s['form']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][heading]", 'Tiêu đề', $s['form']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[form][desc]", 'Mô tả', $s['form']['desc'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[form][bullets]", 'Gạch đầu dòng (mỗi dòng 1 ý)', implode( "\n", (array) ( $s['form']['bullets'] ?? array() ) ), 4 );
	nuocda_168_landing_field_text( "{$opt}[form][priority_text]", 'Dòng ưu tiên gọi', $s['form']['priority_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][submit_text]", 'Nút gửi form', $s['form']['submit_text'] ?? '' );
	echo '<h3>' . esc_html__( 'Nhãn & placeholder các trường', 'oceanwp' ) . '</h3>';
	nuocda_168_landing_field_text( "{$opt}[form][name_label]", 'Họ tên — Label', $s['form']['name_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][name_placeholder]", 'Họ tên — Placeholder', $s['form']['name_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][phone_label]", 'SĐT — Label', $s['form']['phone_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][phone_placeholder]", 'SĐT — Placeholder ({hotline} = SĐT Footer)', $s['form']['phone_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][address_label]", 'Địa chỉ — Label', $s['form']['address_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][address_placeholder]", 'Địa chỉ — Placeholder', $s['form']['address_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][email_label]", 'Email — Label', $s['form']['email_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][email_placeholder]", 'Email — Placeholder', $s['form']['email_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][customer_type_label]", 'Loại KH — Label', $s['form']['customer_type_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][customer_type_placeholder]", 'Loại KH — Placeholder select', $s['form']['customer_type_placeholder'] ?? '' );
	nuocda_168_landing_field_textarea(
		"{$opt}[form][customer_types]",
		'Loại KH — Options (mỗi dòng: value|Label)',
		nuocda_168_landing_option_pairs_to_text( nuocda_168_landing_contact_list( $s, 'form', 'customer_types' ) ),
		8
	);
	nuocda_168_landing_field_text( "{$opt}[form][ice_type_label]", 'Loại đá — Label', $s['form']['ice_type_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][ice_type_placeholder]", 'Loại đá — Placeholder select', $s['form']['ice_type_placeholder'] ?? '' );
	nuocda_168_landing_field_textarea(
		"{$opt}[form][ice_types]",
		'Loại đá — Options (mỗi dòng: value|Label)',
		nuocda_168_landing_option_pairs_to_text( nuocda_168_landing_contact_list( $s, 'form', 'ice_types' ) ),
		8
	);
	nuocda_168_landing_field_text( "{$opt}[form][quantity_label]", 'Số lượng — Label', $s['form']['quantity_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][quantity_placeholder]", 'Số lượng — Placeholder', $s['form']['quantity_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][delivery_label]", 'Thời gian giao — Label', $s['form']['delivery_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][delivery_placeholder]", 'Thời gian giao — Placeholder', $s['form']['delivery_placeholder'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][message_label]", 'Ghi chú — Label', $s['form']['message_label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[form][message_placeholder]", 'Ghi chú — Placeholder', $s['form']['message_placeholder'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '4. Khu vực phục vụ' );
	nuocda_168_landing_field_text( "{$opt}[areas][label]", 'Nhãn section', $s['areas']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[areas][heading]", 'Tiêu đề', $s['areas']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[areas][desc]", 'Mô tả', $s['areas']['desc'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[areas][btn_text]", 'Nút kiểm tra khu vực', $s['areas']['btn_text'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[areas][tags]", 'Khu vực (mỗi dòng 1 quận)', implode( "\n", (array) ( $s['areas']['tags'] ?? array() ) ), 8 );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '5. Cửa hàng' );
	nuocda_168_landing_field_text( "{$opt}[stores][label]", 'Nhãn section', $s['stores']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[stores][heading]", 'Tiêu đề', $s['stores']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[stores][desc]", 'Mô tả', $s['stores']['desc'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[stores][btn_call]", 'Link gọi — Text', $s['stores']['btn_call'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[stores][btn_dir]", 'Link chỉ đường — Text', $s['stores']['btn_dir'] ?? '' );
	echo '<p class="description">' . esc_html__( 'Danh sách cửa hàng chỉnh ở tab Đại lý.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '6. Bản đồ' );
	nuocda_168_landing_field_text( "{$opt}[map][label]", 'Nhãn section', $s['map']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[map][heading]", 'Tiêu đề', $s['map']['heading'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[map][desc]", 'Mô tả', $s['map']['desc'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[map][embed]", 'Google Maps embed URL', $s['map']['embed'] ?? '', 2 );
	nuocda_168_landing_field_text( "{$opt}[map][title]", 'Title iframe', $s['map']['title'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[map][hq_prefix]", 'Tiền tố địa chỉ (vd: Trụ sở:)', $s['map']['hq_prefix'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[map][btn_dir]", 'Nút chỉ đường', $s['map']['btn_dir'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[map][btn_call]", 'Nút gọi điểm giao', $s['map']['btn_call'] ?? '' );
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '7. Quy trình đặt hàng' );
	nuocda_168_landing_field_text( "{$opt}[process][label]", 'Nhãn section', $s['process']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[process][heading]", 'Tiêu đề', $s['process']['heading'] ?? '' );
	nuocda_168_landing_render_icon_items_repeater(
		$opt,
		'process][items',
		'process-item',
		nuocda_168_landing_contact_list( $s, 'process', 'items' ),
		'Các bước',
		'',
		'fa-phone-alt'
	);
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '8. FAQ' );
	nuocda_168_landing_field_text( "{$opt}[faq][label]", 'Nhãn section', $s['faq']['label'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[faq][heading]", 'Tiêu đề', $s['faq']['heading'] ?? '' );
	echo '<div class="nuocda-repeater" data-template="faq"><h3>' . esc_html__( 'Câu hỏi', 'oceanwp' ) . '</h3>';
	foreach ( nuocda_168_landing_contact_list( $s, 'faq', 'items' ) as $i => $faq ) {
		echo '<div class="nuocda-repeater__row">';
		nuocda_168_landing_field_text( "{$opt}[faq][items][{$i}][q]", 'Câu hỏi', $faq['q'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[faq][items][{$i}][a]", 'Trả lời', $faq['a'] ?? '' );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="faq">' . esc_html__( '+ Thêm FAQ', 'oceanwp' ) . '</button></div>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( '9. CTA & thanh mobile' );
	nuocda_168_landing_field_text( "{$opt}[cta][title]", 'CTA — Tiêu đề', $s['cta']['title'] ?? '' );
	nuocda_168_landing_field_textarea( "{$opt}[cta][desc]", 'CTA — Mô tả', $s['cta']['desc'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_phone_prefix]", 'CTA — tiền tố gọi', $s['cta']['btn_phone_prefix'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[cta][btn_zalo_text]", 'CTA — nút Zalo', $s['cta']['btn_zalo_text'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[mobile][aria]", 'Mobile bar — aria-label', $s['mobile']['aria'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[mobile][btn_call]", 'Mobile bar — Gọi', $s['mobile']['btn_call'] ?? '' );
	nuocda_168_landing_field_text( "{$opt}[mobile][btn_zalo]", 'Mobile bar — Zalo', $s['mobile']['btn_zalo'] ?? '' );
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
	echo '<p class="description">' . esc_html__( 'Danh sách cửa hàng chỉnh ở tab Đại lý.', 'oceanwp' ) . '</p>';
	nuocda_168_landing_section_close();

	nuocda_168_landing_section_open( 'Bản quyền' );
	nuocda_168_landing_field_text( "{$opt}[bottom][copyright]", 'Dòng bản quyền (để trống = dùng tên công ty)', $s['bottom']['copyright'] );
	nuocda_168_landing_field_text( "{$opt}[bottom][subtitle]", 'Dòng phụ (để trống = dùng tên giao dịch)', $s['bottom']['subtitle'] );
	nuocda_168_landing_section_close();
}

/**
 * Tab Đại lý — danh sách cửa hàng / điểm phân phối dùng chung.
 *
 * @param array $s Settings.
 */
function nuocda_168_landing_render_tab_agents( $s ) {
	$opt   = 'nuocda_168_landing_agents';
	$items = ! empty( $s['items'] ) && is_array( $s['items'] )
		? $s['items']
		: ( nuocda_168_landing_defaults_agents()['items'] ?? array() );

	settings_fields( 'nuocda_168_landing_agents' );

	nuocda_168_landing_section_open( 'Danh sách cửa hàng & đại lý' );
	echo '<p class="description">' . esc_html__( 'Dùng chung cho trang chủ, liên hệ, footer và schema. Thêm / sửa / xóa từng điểm bên dưới.', 'oceanwp' ) . '</p>';
	echo '<div class="nuocda-repeater" data-template="store-item"><h3>' . esc_html__( 'Các điểm', 'oceanwp' ) . '</h3>';
	foreach ( $items as $i => $item ) {
		echo '<div class="nuocda-repeater__row nuocda-repeater__row--card">';
		nuocda_168_landing_field_text( "{$opt}[items][{$i}][name]", 'Tên cửa hàng / đại lý', $item['name'] ?? '' );
		nuocda_168_landing_field_textarea( "{$opt}[items][{$i}][address]", 'Địa chỉ', $item['address'] ?? '', 2 );
		echo '<button type="button" class="button-link nuocda-repeater-remove">' . esc_html__( 'Xóa điểm', 'oceanwp' ) . '</button></div>';
	}
	echo '<button type="button" class="button nuocda-repeater-add" data-type="store-item">' . esc_html__( '+ Thêm điểm', 'oceanwp' ) . '</button></div>';
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
		<p class="description"><?php esc_html_e( 'Chỉnh nội dung trang chủ, giới thiệu, liên hệ, đại lý và footer.', 'oceanwp' ); ?></p>

		<nav class="nav-tab-wrapper">
			<?php foreach ( nuocda_168_landing_pages() as $slug => $label ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'tab', $slug, $base_url ) ); ?>" class="nav-tab <?php echo $tab === $slug ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>

		<form method="post" action="options.php" class="nuocda-landing-form" data-tab="<?php echo esc_attr( $tab ); ?>">
			<div class="nuocda-accordion-toolbar">
				<div class="nuocda-accordion-toolbar__left">
					<button type="button" class="button nuocda-accordion-expand-all"><?php esc_html_e( 'Mở tất cả', 'oceanwp' ); ?></button>
					<button type="button" class="button nuocda-accordion-collapse-all"><?php esc_html_e( 'Đóng tất cả', 'oceanwp' ); ?></button>
					<span class="description"><?php esc_html_e( 'Bấm tiêu đề từng mục để mở/đóng.', 'oceanwp' ); ?></span>
				</div>
				<?php submit_button( __( 'Lưu cài đặt', 'oceanwp' ), 'primary', 'submit', false ); ?>
			</div>
			<?php
			if ( 'about' === $tab ) {
				nuocda_168_landing_render_tab_about( $settings );
			} elseif ( 'contact' === $tab ) {
				nuocda_168_landing_render_tab_contact( $settings );
			} elseif ( 'agents' === $tab ) {
				nuocda_168_landing_render_tab_agents( $settings );
			} elseif ( 'footer' === $tab ) {
				nuocda_168_landing_render_tab_footer( $settings );
			} else {
				nuocda_168_landing_render_tab_home( $settings );
			}
			?>
			<div class="nuocda-sticky-save">
				<?php submit_button( __( 'Lưu cài đặt', 'oceanwp' ), 'primary large', 'submit', false ); ?>
			</div>
		</form>
	</div>
	<?php
}
