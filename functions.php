<?php
/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

require_once get_stylesheet_directory() . '/inc/site-data.php';
require_once get_stylesheet_directory() . '/inc/form-helpers.php';
require_once get_stylesheet_directory() . '/inc/review-spam.php';
require_once get_stylesheet_directory() . '/inc/performance.php';

/**
 * Script tab gallery trang chủ
 */
function nuocda_168_enqueue_home_scripts() {
	if ( ! is_front_page() && ! is_page_template( 'templates/page-trang-chu-168.php' ) ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	wp_enqueue_script( 'nuocda-h168-lightbox' );
	wp_enqueue_script(
		'nuocda-home-media-tabs',
		get_stylesheet_directory_uri() . '/js/home-media-tabs.js',
		array( 'nuocda-h168-lightbox' ),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_home_scripts' );

/**
 * Script trang Giới thiệu
 */
function nuocda_168_enqueue_about_scripts() {
	if ( ! is_page_template( 'templates/page-gioi-thieu-168.php' ) ) {
		return;
	}

	wp_enqueue_script( 'nuocda-h168-lightbox' );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_about_scripts' );

/**
 * Lightbox dùng chung — đăng ký trước home tabs
 */
function nuocda_168_enqueue_shared_scripts() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	wp_register_script(
		'nuocda-h168-lightbox',
		get_stylesheet_directory_uri() . '/js/h168-lightbox.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_shared_scripts', 5 );

/**
 * Footer tùy chỉnh Nước Đá 168
 */
function nuocda_168_register_footer() {
	remove_action( 'ocean_footer', 'oceanwp_footer_template' );
	add_action( 'ocean_footer', 'nuocda_168_render_footer' );
}
add_action( 'after_setup_theme', 'nuocda_168_register_footer', 20 );

function nuocda_168_render_footer() {
	get_template_part( 'template-parts/footer', '168' );
}

// Tắt Gutenberg Editor hoàn toàn
add_filter('use_block_editor_for_post', '__return_false', 10);

/**
 * Tắt floating bar "Thêm vào giỏ hàng" trên trang chi tiết SP
 */
add_filter( 'theme_mod_ocean_woo_display_floating_bar', function () {
	return 'off';
} );

/**
 * Ẩn icon giỏ hàng trong header (desktop + mobile + dropdown)
 */
add_filter( 'theme_mod_ocean_woo_menu_icon_visibility', function () {
	return 'disabled';
} );

/**
 * Tắt mini cart sidebar OceanWP (không hiện "Cart" ở chân trang)
 */
add_filter( 'theme_mod_ocean_woo_add_mobile_mini_cart', '__return_false' );

add_action( 'wp_loaded', function () {
	if ( class_exists( 'OceanWP_WooCommerce_Config' ) ) {
		remove_action( 'wp_footer', array( OceanWP_WooCommerce_Config::instance(), 'get_mini_cart_sidebar' ) );
	}
}, 20 );

add_action( 'after_setup_theme', function () {
	remove_action( 'ocean_before_mobile_icon_inner', 'oceanwp_mobile_cart_icon_medium_header', 10 );
	remove_action( 'ocean_before_mobile_icon_inner', 'oceanwp_mobile_cart_icon_not_medium_header', 10 );
	remove_action( 'ocean_header_inner_left_content', 'oceanwp_mobile_cart_icon', 1 );
	remove_action( 'ocean_header_inner_right_content', 'oceanwp_mobile_cart_icon', 99 );
}, 99 );

/**
 * CSS dự phòng — ẩn cart sidebar/overlay nếu còn sót HTML
 */
add_action( 'wp_enqueue_scripts', function () {
	$css = '#oceanwp-cart-sidebar-wrap,.owp-cart-overlay,.current-shop-items-dropdown{display:none!important;visibility:hidden!important;}';
	wp_add_inline_style( 'nuocda-design-system', $css );
}, 30 );

/**
 * Bỏ mô tả mặc định trên trang /san-pham/
 */
add_action( 'init', function () {
	remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
} );

/**
 * Tiêu đề bài viết liên quan trên trang chi tiết tin tức
 */
add_filter( 'ocean_single_related_posts', function () {
	return __( 'Bài viết liên quan', 'oceanwp' );
} );

/**
 * Page header & breadcrumb — toàn bộ xử lý trong child theme (không sửa OceanWP parent)
 */
function nuocda_168_page_header_template() {
	get_template_part( 'partials/page-header' );
}

add_action( 'after_setup_theme', function () {
	remove_action( 'ocean_page_header', 'oceanwp_page_header_template' );
	add_action( 'ocean_page_header', 'nuocda_168_page_header_template' );
}, 20 );

add_filter( 'oceanwp_single_post_header_template', function () {
	return 'partials/page-header';
} );

/**
 * Tiêu đề page header trang chi tiết tin tức: "Tin tức" thay cho "Blog"
 */
add_filter( 'ocean_title', function ( $title ) {
	if ( is_singular( 'post' ) && 'post-title' !== get_theme_mod( 'ocean_blog_single_page_header_title', 'blog' ) ) {
		return __( 'Tin tức', 'oceanwp' );
	}

	return $title;
}, 20 );

/**
 * Sản phẩm không có giá (0 đ) — hiển thị CTA Zalo thay vì giá
 */
function nuocda_168_product_needs_zalo_quote( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}

	if ( $product->is_type( 'variable' ) ) {
		$min = $product->get_variation_price( 'min', true );
		return '' === $min || (float) $min <= 0;
	}

	$price = $product->get_price();
	return '' === $price || null === $price || (float) $price <= 0;
}

function nuocda_168_get_zalo_quote_html() {
	$contact = nuocda_168_get_contact();

	return sprintf(
		'<a href="%1$s" class="nuocda-zalo-price-cta" target="_blank" rel="noopener noreferrer"><i class="fas fa-comment-dots" aria-hidden="true"></i> %2$s</a>',
		esc_url( $contact['zalo'] ),
		esc_html__( 'Báo giá nhanh qua Zalo', 'oceanwp' )
	);
}

/**
 * Kiểm tra loop sản phẩm tương tự trên trang chi tiết
 */
function nuocda_168_is_related_product_loop() {
	return 'related' === wc_get_loop_prop( 'name' );
}

/**
 * Card sản phẩm tùy chỉnh — shop / danh mục / sản phẩm tương tự
 */
function nuocda_168_use_custom_product_card() {
	if ( nuocda_168_is_related_product_loop() ) {
		return true;
	}

	if ( ! is_shop() && ! is_product_taxonomy() && ! is_post_type_archive( 'product' ) ) {
		return false;
	}

	$loop_name = wc_get_loop_prop( 'name' );

	return ! $loop_name || 'products' === $loop_name;
}

/**
 * Grid card sản phẩm — dùng cho loop-start.php
 */
function nuocda_168_should_use_product_grid() {
	return nuocda_168_use_custom_product_card();
}

/**
 * CTA đặt hàng trên trang chi tiết — thay cho Thêm vào giỏ hàng
 */
function nuocda_168_single_product_cta() {
	$contact = nuocda_168_get_contact();
	?>
	<div class="nuocda-single-cta">
		<a href="<?php echo esc_url( $contact['zalo'] ); ?>" class="nuocda-single-cta__zalo" target="_blank" rel="noopener noreferrer">
			<i class="fas fa-comment-dots" aria-hidden="true"></i>
			<?php esc_html_e( 'Nhắn Zalo đặt hàng', 'oceanwp' ); ?>
		</a>
		<a href="tel:<?php echo esc_attr( $contact['hotline'] ); ?>" class="nuocda-single-cta__phone">
			<i class="fas fa-phone-alt" aria-hidden="true"></i>
			<?php esc_html_e( 'Gọi Hotline', 'oceanwp' ); ?>
		</a>
	</div>
	<?php
}
/**
Remove all possible fields
 **/
function wc_remove_checkout_fields($fields)
{
    // Billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    // Shipping fields
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_phone']);
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_first_name']);
    unset($fields['shipping']['shipping_last_name']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    // Order fields
    // unset( $fields['order']['order_comments'] );
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');

add_filter('woocommerce_checkout_fields', 'misha_email_first');

function misha_email_first($checkout_fields)
{
    $checkout_fields['billing']['billing_first_name']['priority'] = 1;
    $checkout_fields['billing']['billing_phone']['priority'] = 2;
    $checkout_fields['billing']['billing_email']['priority'] = 3;
    $checkout_fields['billing']['billing_address_1']['priority'] = 4;
    return $checkout_fields;
}


add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields($fields)
{
    $fields['billing']['billing_first_name']['label'] = 'Tên người dùng: ';
    $fields['billing']['billing_phone']['label'] = 'Số Di Động: ';
    $fields['billing']['billing_email']['label'] = 'Email: ';
    $fields['billing']['billing_address_1']['label'] = 'Địa chỉ:';
    $fields['order']['order_comments']['label'] = 'Thời gian giao hàng tốt nhất:';
    return $fields;
}
/**
 * Tùy chỉnh Placeholder cho các trường Thanh toán trong WooCommerce.
 */
add_filter('woocommerce_checkout_fields', 'custom_change_checkout_placeholders_vi');

function custom_change_checkout_placeholders_vi($fields)
{
    // 1. Thay đổi Placeholder cho trường Địa chỉ (billing_address_1)
    // Trường này nằm trong nhóm 'billing' (thông tin thanh toán/người mua)
    $fields['billing']['billing_address_1']['placeholder'] = 'Nhập địa chỉ nhận hàng';

    // 2. Thay đổi Placeholder cho trường Ghi chú Đơn hàng (order_comments)
    // Trường này nằm trong nhóm 'order'
    $fields['order']['order_comments']['placeholder'] = 'Các yêu cầu khác (nếu có)';

    return $fields;
}
/**
 * =========================================================
 * XỬ LÝ FORM LIÊN HỆ BẰNG WORDPRESS AJAX VÀ WP_MAIL()
 * Yêu cầu: Đảm bảo form HTML có class="contact-form"
 * và các trường input có thuộc tính name="name", name="email", name="phone", name="message".
 * =========================================================
 */

// 1. Đăng ký và đưa script AJAX vào trang web
function nuocda_168_enqueue_scripts() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_script(
		'nuocda-168-contact-js',
		get_stylesheet_directory_uri() . '/js/contact-ajax.js',
		array( 'jquery' ),
		$version,
		true
	);

    // Truyền dữ liệu cần thiết từ PHP sang JavaScript
    wp_localize_script( 'nuocda-168-contact-js', 'nuocdaAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'nuocda-168-contact-nonce' ),
        'messages' => array(
            'phone_invalid'   => 'Số điện thoại không hợp lệ. Vui lòng nhập 10 số (bắt đầu 03, 05, 07, 08 hoặc 09).',
            'phone_required'  => 'Vui lòng nhập số điện thoại.',
            'sending'         => 'Đang gửi...',
            'network_error'   => 'Lỗi kết nối hoặc lỗi máy chủ. Vui lòng thử lại.',
        ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_scripts' );


// 2. Hàm xử lý logic gửi email (PHP)
function nuocda_168_handle_contact_form() {
    $security = nuocda_168_form_security_check( 'contact', 5 );
    if ( is_wp_error( $security ) ) {
        wp_send_json_error( array( 'message' => $security->get_error_message() ) );
    }

    $name           = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $phone          = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
    $email          = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $address        = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';
    $customer_type  = isset( $_POST['customer_type'] ) ? sanitize_text_field( wp_unslash( $_POST['customer_type'] ) ) : '';
    $ice_type       = isset( $_POST['ice_type'] ) ? sanitize_text_field( wp_unslash( $_POST['ice_type'] ) ) : '';
    $quantity       = isset( $_POST['quantity'] ) ? sanitize_text_field( wp_unslash( $_POST['quantity'] ) ) : '';
    $delivery_time  = isset( $_POST['delivery_time'] ) ? sanitize_text_field( wp_unslash( $_POST['delivery_time'] ) ) : '';
    $message        = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

    if ( empty( $name ) ) {
        wp_send_json_error( array( 'message' => 'Vui lòng nhập họ và tên.' ) );
    }

    if ( empty( $phone ) || ! nuocda_168_validate_phone( $phone ) ) {
        wp_send_json_error( array( 'message' => 'Số điện thoại không hợp lệ. Vui lòng nhập 10 số (bắt đầu 03, 05, 07, 08 hoặc 09).' ) );
    }

    if ( ! empty( $email ) && ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Email không hợp lệ. Vui lòng kiểm tra lại.' ) );
    }

    $phone_display = nuocda_168_normalize_phone( $phone );
    $subject       = 'YÊU CẦU ĐẶT NƯỚC ĐÁ / BÁO GIÁ — SĐT: ' . $phone_display;

    $customer_labels = array(
        'ca-nhan'      => 'Cá nhân',
        'cafe'         => 'Quán cafe',
        'nha-hang'     => 'Nhà hàng',
        'khach-san'    => 'Khách sạn',
        'doanh-nghiep' => 'Doanh nghiệp',
        'dai-ly'       => 'Đại lý',
    );
    $ice_labels = array(
        'da-mi'        => 'Đá mi',
        'da-vien-bon'  => 'Đá viên bốn',
        'da-tam'       => 'Đá tám',
        'da-xay'       => 'Đá xay nhuyễn',
        'da-bi'        => 'Đá bi',
        'da-tam-sheet' => 'Đá tấm',
        'tu-van'       => 'Chưa rõ — cần tư vấn',
    );

    $customer_display = ( $customer_type && isset( $customer_labels[ $customer_type ] ) ) ? $customer_labels[ $customer_type ] : $customer_type;
    $ice_display      = ( $ice_type && isset( $ice_labels[ $ice_type ] ) ) ? $ice_labels[ $ice_type ] : $ice_type;

    $body_content = '
        <h2>Yêu cầu đặt nước đá / báo giá</h2>
        <p><strong>Họ và Tên:</strong> ' . esc_html( $name ) . '</p>
        <p><strong>Số Điện Thoại:</strong> ' . esc_html( $phone_display ) . '</p>
        <p><strong>Email:</strong> ' . esc_html( $email ? $email : '—' ) . '</p>
        <p><strong>Khu vực / Địa chỉ giao:</strong> ' . esc_html( $address ? $address : '—' ) . '</p>
        <p><strong>Loại khách hàng:</strong> ' . esc_html( $customer_display ? $customer_display : '—' ) . '</p>
        <p><strong>Loại đá:</strong> ' . esc_html( $ice_display ? $ice_display : '—' ) . '</p>
        <p><strong>Số lượng dự kiến:</strong> ' . esc_html( $quantity ? $quantity : '—' ) . '</p>
        <p><strong>Thời gian cần giao:</strong> ' . esc_html( $delivery_time ? $delivery_time : '—' ) . '</p>
        <hr>
        <h3>Ghi chú:</h3>
        <p>' . ( $message ? nl2br( esc_html( $message ) ) : '—' ) . '</p>
        <p><em>Gửi từ trang: ' . esc_html( wp_get_referer() ? wp_get_referer() : home_url( '/' ) ) . '</em></p>
        <p><em>Thời gian: ' . esc_html( wp_date( 'd/m/Y H:i:s' ) ) . '</em></p>
    ';

    $reply_to = is_email( $email ) ? $email : '';
    $sent     = nuocda_168_send_notification_email( $subject, $body_content, $reply_to );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Cảm ơn bạn, Nước Đá Sạch 168 sẽ liên hệ lại trong thời gian sớm nhất.' ) );
    }

    wp_send_json_error( array( 'message' => 'Lỗi hệ thống: Không thể gửi email. Vui lòng gọi hotline 0348226455.' ) );
}
add_action( 'wp_ajax_nuocda_168_contact', 'nuocda_168_handle_contact_form' );
add_action( 'wp_ajax_nopriv_nuocda_168_contact', 'nuocda_168_handle_contact_form' );

/**
 * Form báo giá footer — chỉ nhận số điện thoại
 */
function nuocda_168_handle_footer_quote() {
    $security = nuocda_168_form_security_check( 'footer_quote', 8 );
    if ( is_wp_error( $security ) ) {
        wp_send_json_error( array( 'message' => $security->get_error_message() ) );
    }

    $phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';

    if ( empty( $phone ) ) {
        wp_send_json_error( array( 'message' => 'Vui lòng nhập số điện thoại.' ) );
    }

    if ( ! nuocda_168_validate_phone( $phone ) ) {
        wp_send_json_error( array( 'message' => 'Số điện thoại không hợp lệ. Vui lòng nhập 10 số (bắt đầu 03, 05, 07, 08 hoặc 09).' ) );
    }

    $phone_display = nuocda_168_normalize_phone( $phone );
    $page_url      = wp_get_referer() ? wp_get_referer() : home_url( '/' );
    $subject       = 'YÊU CẦU BÁO GIÁ FOOTER — SĐT: ' . $phone_display;

    $body_content = '
        <h2>Yêu cầu báo giá từ footer</h2>
        <p><strong>Số điện thoại:</strong> ' . esc_html( $phone_display ) . '</p>
        <p><strong>Trang gửi:</strong> ' . esc_html( $page_url ) . '</p>
        <p><strong>Thời gian:</strong> ' . esc_html( wp_date( 'd/m/Y H:i:s' ) ) . '</p>
    ';

    $sent = nuocda_168_send_notification_email( $subject, $body_content );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Cảm ơn bạn! Chúng tôi sẽ gọi lại trong 15 phút.' ) );
    }

    wp_send_json_error( array( 'message' => 'Không thể gửi yêu cầu. Vui lòng gọi hotline 0348226455.' ) );
}
add_action( 'wp_ajax_nuocda_168_footer_quote', 'nuocda_168_handle_footer_quote' );
add_action( 'wp_ajax_nopriv_nuocda_168_footer_quote', 'nuocda_168_handle_footer_quote' );

/**
 * Tắt comment trên toàn bộ website TRỪ Sản phẩm (WooCommerce Products)
 * Author: An Nam Discovery Custom
 */

// 1. Đóng form comment trên tất cả các loại bài, TRỪ 'product'
function annam_disable_comments_except_woocommerce( $open, $post_id ) {
    $post = get_post( $post_id );

    // Nếu là 'product' (Sản phẩm/Tour) -> Giữ nguyên (để khách Review)
    if ( $post->post_type == 'product' ) {
        return $open;
    }

    // Các trường hợp khác (Bài viết tin tức, Trang, Media...) -> Tắt
    return false;
}
add_filter( 'comments_open', 'annam_disable_comments_except_woocommerce', 20, 2 );
add_filter( 'pings_open', 'annam_disable_comments_except_woocommerce', 20, 2 );

// 2. Ẩn luôn các comment cũ đã hiển thị trên bài viết tin tức (nếu có)
function annam_hide_existing_comments_non_product( $comments, $post_id ) {
    $post = get_post( $post_id );

    // Nếu không phải sản phẩm -> Trả về rỗng (ẩn sạch)
    if ( $post->post_type != 'product' ) {
        return array();
    }

    return $comments;
}
add_filter( 'comments_array', 'annam_hide_existing_comments_non_product', 10, 2 );

// 3. Xóa tính năng "Hỗ trợ comment" khi tạo bài viết mới (trừ Product)
add_action('admin_init', function () {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        // Bỏ qua nếu là product
        if ($post_type == 'product') continue;

        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

/**
 * Tin tức: đổi "Continue Reading" / link bình luận đóng thành "Xem chi tiết".
 */
function nuocda_168_post_continue_reading( $text ) {
	return 'Xem chi tiết';
}
add_filter( 'ocean_post_continue_reading', 'nuocda_168_post_continue_reading' );

function nuocda_168_remove_blog_comments_meta( $sections ) {
	if ( ! is_array( $sections ) ) {
		return $sections;
	}

	return array_values( array_diff( $sections, array( 'comments' ) ) );
}
add_filter( 'ocean_blog_entry_meta', 'nuocda_168_remove_blog_comments_meta' );
add_filter( 'ocean_blog_single_meta', 'nuocda_168_remove_blog_comments_meta' );

function nuocda_168_remove_single_comments_section( $sections ) {
	if ( ! is_array( $sections ) ) {
		return $sections;
	}

	return array_values( array_diff( $sections, array( 'single_comments' ) ) );
}
add_filter( 'ocean_blog_single_elements_positioning', 'nuocda_168_remove_single_comments_section' );

/**
 * Tin tức: bỏ sidebar ở trang lưu trữ và chi tiết bài viết.
 */
function nuocda_168_is_blog_archive_context() {
	return is_home()
		|| is_category()
		|| is_tag()
		|| is_date()
		|| is_author();
}

function nuocda_168_blog_full_width_layout( $class ) {
	if ( is_singular( 'post' ) || nuocda_168_is_blog_archive_context() ) {
		return 'full-width';
	}

	return $class;
}
add_filter( 'ocean_post_layout_class', 'nuocda_168_blog_full_width_layout' );

function nuocda_168_blog_full_width_meta( $meta ) {
	if ( is_singular( 'post' ) || nuocda_168_is_blog_archive_context() ) {
		return 'full-width';
	}

	return $meta;
}
add_filter( 'ocean_post_layout_meta_value', 'nuocda_168_blog_full_width_meta' );

/**
 * PHẦN 2: BẢO MẬT WEBSITE (SECURITY)
 * Các thiết lập an toàn cơ bản chống tấn công tự động
 */

// 1. Tắt XML-RPC (Chống DDoS và Brute Force)
add_filter('xmlrpc_enabled', '__return_false');
remove_action('wp_head', 'rsd_link');

// 2. Ẩn phiên bản WordPress khỏi mã nguồn (Chống lộ lỗ hổng)
function annam_remove_version() {
    return '';
}
add_filter('the_generator', 'annam_remove_version');

// 3. Chặn hacker dò tìm tên đăng nhập (User Enumeration) qua link ?author=1
function annam_block_user_enumeration($redirect, $request) {
    // Nếu phát hiện đường dẫn có chứa ?author=...
    if (preg_match('/\?author=([0-9]*)(\/*)/i', $request)) {
        wp_redirect(home_url(), 301); // Chuyển hướng về trang chủ ngay lập tức
        exit;
    }
    return $redirect;
}
add_filter('redirect_canonical', 'annam_block_user_enumeration', 10, 2);

/* ==========================================================================
 * KẾT THÚC: CODE TÙY CHỈNH
 * ========================================================================== */