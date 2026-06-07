<?php
/**
 * Tối ưu tốc độ — Lighthouse (mobile & desktop)
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bỏ tối ưu frontend khi Customizer preview — tránh treo loading vòng tròn.
 */
function nuocda_168_skip_frontend_optimizations() {
	if ( is_customize_preview() ) {
		return true;
	}

	// Fallback: customize manager có thể chưa sẵn sàng ở hook init sớm.
	if ( ! empty( $_GET['customize_preview'] ) || ! empty( $_POST['customize_preview'] ) ) {
		return true;
	}

	if ( ! empty( $_REQUEST['customize_messenger_channel'] ) ) {
		return true;
	}

	return false;
}

/**
 * Trang dùng template full-width tùy chỉnh (không page header OceanWP)
 */
function nuocda_168_is_custom_landing_template() {
	return is_front_page()
		|| is_page_template( 'templates/page-trang-chu-168.php' )
		|| is_page_template( 'templates/page-gioi-thieu-168.php' )
		|| is_page_template( 'templates/page-lien-he-168.php' );
}

/**
 * Trang cần asset WooCommerce
 */
function nuocda_168_needs_woocommerce_assets() {
	if ( ! function_exists( 'is_woocommerce' ) ) {
		return false;
	}

	return is_woocommerce() || is_cart() || is_checkout() || is_account_page();
}

/**
 * CSS modules theo ngữ cảnh trang — giảm render-blocking
 *
 * Lưu ý: 02-global.css gộp từ 02-layout + 03-components + 04-footer + 10-sticky-header.
 * Khi sửa các file nguồn, cần build lại bundle (xem script trong README hoặc chạy lại merge).
 */
function nuocda_168_get_css_modules() {
	$css_dir = get_stylesheet_directory_uri() . '/assets/css/';

	$modules = array(
		'nuocda-design-system' => $css_dir . '01-design-system.css',
		'nuocda-global'        => $css_dir . '02-global.css',
	);

	if ( is_front_page() || is_page_template( 'templates/page-trang-chu-168.php' ) ) {
		$modules['nuocda-home'] = $css_dir . '05-home.css';
	}

	if ( is_page_template( 'templates/page-gioi-thieu-168.php' ) ) {
		$modules['nuocda-about'] = $css_dir . '06-about.css';
	}

	if ( is_page_template( 'templates/page-lien-he-168.php' ) ) {
		$modules['nuocda-contact'] = $css_dir . '07-contact.css';
	}

	if ( nuocda_168_needs_woocommerce_assets() ) {
		$modules['nuocda-woocommerce'] = $css_dir . '08-woocommerce.css';
	}

	if ( ! nuocda_168_is_custom_landing_template() ) {
		$modules['nuocda-page-header'] = $css_dir . '09-page-header.css';
	}

	return $modules;
}

/**
 * Enqueue CSS có điều kiện
 */
function nuocda_168_enqueue_conditional_styles() {
	$theme    = wp_get_theme();
	$version  = $theme->get( 'Version' );
	$modules  = nuocda_168_get_css_modules();
	$previous = array( 'nuocda-local-fonts' );

	foreach ( $modules as $handle => $url ) {
		wp_enqueue_style( $handle, $url, $previous, $version );
		$previous = array( $handle );
	}

	wp_enqueue_style( 'child-style', get_stylesheet_uri(), $previous, $version );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_conditional_styles', 20 );

/**
 * Tắt tính năng OceanWP không dùng trên landing pages
 */
function nuocda_168_ocean_performance_mods( $value ) {
	if ( nuocda_168_is_custom_landing_template() ) {
		return 'disabled';
	}

	return $value;
}

add_filter( 'theme_mod_ocean_performance_lightbox', 'nuocda_168_ocean_performance_mods' );
add_filter( 'theme_mod_ocean_performance_scroll_effect', 'nuocda_168_ocean_performance_mods' );
add_filter( 'theme_mod_ocean_performance_custom_select', 'nuocda_168_ocean_performance_mods' );
add_filter( 'ocean_menu_search_style', 'nuocda_168_ocean_performance_mods' );

add_filter( 'ocean_display_scroll_up_button', function ( $show ) {
	return nuocda_168_is_custom_landing_template() ? false : $show;
} );

/**
 * Gỡ style theo URL (wc-blocks, widgets.css…)
 */
function nuocda_168_dequeue_styles_by_src_fragment( $fragments ) {
	global $wp_styles;

	if ( ! isset( $wp_styles->queue ) ) {
		return;
	}

	foreach ( $wp_styles->queue as $handle ) {
		if ( empty( $wp_styles->registered[ $handle ]->src ) ) {
			continue;
		}

		$src = $wp_styles->registered[ $handle ]->src;

		foreach ( $fragments as $fragment ) {
			if ( false !== strpos( $src, $fragment ) ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
				break;
			}
		}
	}
}

/**
 * Gỡ CSS/JS không cần trên frontend
 */
function nuocda_168_dequeue_bloat() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wc-blocks-style' );
	wp_dequeue_style( 'wc-blocks-vendors-style' );
	wp_deregister_style( 'wc-blocks-style' );
	wp_deregister_style( 'wc-blocks-vendors-style' );
	wp_dequeue_style( 'widgets' );
	wp_dequeue_style( 'wp-widgets' );
	wp_deregister_style( 'widgets' );
	wp_dequeue_style( 'oceanwp-blog-headers' );
	wp_dequeue_style( 'simple-line-icons' );

	wp_dequeue_script( 'wc-order-attribution' );
	wp_dequeue_script( 'sourcebuster-js' );
	wp_dequeue_script( 'imagesloaded' );
	wp_dequeue_script( 'ow-flickity' );
	wp_dequeue_script( 'oceanwp-slider' );
	wp_dequeue_script( 'ow-magnific-popup' );
	wp_dequeue_script( 'oceanwp-lightbox' );
	wp_dequeue_script( 'oceanwp-scroll-effect' );
	wp_dequeue_script( 'oceanwp-select' );
	wp_dequeue_script( 'oceanwp-scroll-top' );

	wp_dequeue_script( 'oceanwp-woo-mini-cart' );
	wp_dequeue_style( 'oceanwp-woo-mini-cart' );
	wp_dequeue_style( 'oceanwp-woo-mini-cart-rtl' );
	wp_dequeue_script( 'wc-cart-fragments' );

	if ( nuocda_168_is_custom_landing_template() ) {
		wp_dequeue_script( 'oceanwp-woocommerce-custom-features' );
	}

	if ( ! nuocda_168_needs_woocommerce_assets() ) {
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'oceanwp-woocommerce' );
		wp_dequeue_style( 'oceanwp-woocommerce-rtl' );
		wp_dequeue_style( 'oceanwp-woo-star-font' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'oceanwp-woocommerce-custom-features' );
	}

	nuocda_168_dequeue_styles_by_src_fragment(
		array(
			'/wc-blocks.css',
			'/wc-blocks-vendors',
			'/widgets.css',
		)
	);

	if ( nuocda_168_is_custom_landing_template() ) {
		global $wp_styles, $wp_scripts;

		if ( isset( $wp_styles->queue ) ) {
			foreach ( $wp_styles->queue as $handle ) {
				if ( 0 === strpos( $handle, 'elementor' ) ) {
					wp_dequeue_style( $handle );
				}
			}
		}

		if ( isset( $wp_scripts->queue ) ) {
			foreach ( $wp_scripts->queue as $handle ) {
				if ( 0 === strpos( $handle, 'elementor' ) ) {
					wp_dequeue_script( $handle );
				}
			}
		}
	}

	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_dequeue_bloat', 9999 );
add_action( 'wp_enqueue_scripts', 'nuocda_168_dequeue_bloat', 100000 );

/**
 * jQuery xuống footer + defer — không chặn render
 */
function nuocda_168_optimize_jquery() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() || ! wp_script_is( 'jquery', 'registered' ) ) {
		return;
	}

	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_optimize_jquery', 1 );

/**
 * Bỏ jquery-migrate — giảm blocking JS
 */
function nuocda_168_remove_jquery_migrate( $scripts ) {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() || ! isset( $scripts->registered['jquery'] ) ) {
		return;
	}

	$jquery = $scripts->registered['jquery'];

	if ( ! empty( $jquery->deps ) ) {
		$jquery->deps = array_diff( $jquery->deps, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_default_scripts', 'nuocda_168_remove_jquery_migrate' );

/**
 * Defer script không chặn render
 */
function nuocda_168_defer_scripts( $tag, $handle, $src ) {
	if ( nuocda_168_skip_frontend_optimizations() ) {
		return $tag;
	}

	if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
		return $tag;
	}

	$defer_exact = array(
		'jquery',
		'jquery-core',
		'nuocda-h168-lightbox',
		'nuocda-home-media-tabs',
		'nuocda-sticky-header',
		'nuocda-mobile-menu-lite',
		'imagesloaded',
		'ow-flickity',
		'oceanwp-slider',
		'oceanwp-lightbox',
		'ow-magnific-popup',
		'oceanwp-scroll-top',
		'oceanwp-scroll-effect',
		'oceanwp-select',
		'oceanwp-woocommerce-custom-features',
		'oceanwp-woo-mini-cart',
		'wc-order-attribution',
		'sourcebuster-js',
	);

	$defer_prefixes = array(
		'oceanwp-',
		'ow-',
		'nuocda-',
		'wc-',
	);

	if ( in_array( $handle, $defer_exact, true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}

	foreach ( $defer_prefixes as $prefix ) {
		if ( 0 === strpos( $handle, $prefix ) && 'oceanwp-style' !== $handle ) {
			return str_replace( ' src', ' defer src', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'nuocda_168_defer_scripts', 10, 3 );

/**
 * CSS không critical — tải async (giảm render-blocking)
 */
function nuocda_168_async_styles( $html, $handle, $href, $media ) {
	if ( nuocda_168_skip_frontend_optimizations() ) {
		return $html;
	}

	$blocking_handles = array( 'nuocda-header-lite', 'nuocda-local-fonts', 'nuocda-design-system' );

	if ( is_page_template( 'templates/page-gioi-thieu-168.php' ) ) {
		$blocking_handles[] = 'nuocda-about';
	}

	if ( is_page_template( 'templates/page-lien-he-168.php' ) ) {
		$blocking_handles[] = 'nuocda-contact';
	}

	if ( nuocda_168_needs_woocommerce_assets() ) {
		$blocking_handles[] = 'nuocda-woocommerce';
	}

	if ( in_array( $handle, $blocking_handles, true ) ) {
		return $html;
	}

	$async_handles = array(
		'oceanwp-style',
		'font-awesome',
		'simple-line-icons',
		'nuocda-home',
		'nuocda-about',
		'nuocda-contact',
		'nuocda-woocommerce',
		'nuocda-page-header',
		'child-style',
		'woocommerce-general',
		'woocommerce-layout',
		'woocommerce-smallscreen',
		'oceanwp-woocommerce',
		'oceanwp-woo-star-font',
		'oceanwp-woo-mini-cart',
		'elementor-frontend',
		'elementor-global',
	);

	if ( function_exists( 'nuocda_168_is_home_landing' ) && nuocda_168_is_home_landing() ) {
		$async_handles[] = 'nuocda-global';
	}

	if ( ! in_array( $handle, $async_handles, true ) && 0 !== strpos( $handle, 'oceanwp-google-font-' ) ) {
		return $html;
	}

	$async = '<link rel="stylesheet" id="' . esc_attr( $handle ) . '-css" href="' . esc_url( $href ) . '" media="print" onload="this.media=\'all\'">' . "\n";
	$async .= '<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '"></noscript>';

	return $async;
}
add_filter( 'style_loader_tag', 'nuocda_168_async_styles', 10, 4 );

/**
 * CSS critical tối thiểu — header/layout khi oceanwp-style async
 */
function nuocda_168_critical_css() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() ) {
		return;
	}

	$is_home = function_exists( 'nuocda_168_is_home_landing' ) && nuocda_168_is_home_landing();
	?>
	<style id="nuocda-critical-css">
		:root{--main-color:#021b42;--accent-color:#00c3ff;--accent-hover:#009acd;--white:#fff;--radius-pill:50px;--btn-min-height:52px;--shadow-accent:0 4px 14px rgba(0,195,255,.35)}
		body{margin:0;background:#fff;color:#333;font-family:"Inter",system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif}
		#site-header,.oceanwp-mobile-menu-icon,#site-navigation-wrap{visibility:visible}
		.container-168{box-sizing:border-box;width:100%;max-width:1280px;margin:0 auto;padding-left:clamp(18px,4.5vw,28px);padding-right:clamp(18px,4.5vw,28px)}
		<?php if ( $is_home ) : ?>
		.h168-hero{position:relative;min-height:clamp(520px,88vh,760px);display:flex;align-items:center;background:#021b42;overflow:hidden}
		.h168-hero__bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;z-index:0}
		.h168-hero__overlay{position:absolute;inset:0;background:linear-gradient(115deg,rgba(2,27,66,.92),rgba(2,27,66,.72) 45%,rgba(0,80,130,.55));z-index:1}
		.h168-hero__inner{position:relative;z-index:2;width:100%;padding:40px 0 80px}
		.h168-hero__content{max-width:720px}
		.h168-hero__title{font-family:"Montserrat",system-ui,sans-serif;font-size:clamp(1.5rem,3.2vw,2.5rem);font-weight:800;line-height:1.15;color:#fff;margin:0 0 20px}
		.h168-hero__title-main{display:block;white-space:nowrap}
		.h168-hero__title-accent{display:block;color:#00c3ff;font-size:.92em;margin-top:6px}
		.h168-hero__desc{font-size:clamp(1.0625rem,2.5vw,1.35rem);color:rgba(255,255,255,.9);line-height:1.75;margin:0 0 32px;max-width:580px}
		.h168-hero__actions{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:32px}
		.h168-badge{display:inline-flex;align-items:center;gap:10px;padding:10px 18px;border-radius:50px;background:rgba(0,195,255,.15);border:1px solid rgba(0,195,255,.35);color:#b8ecff;font-size:.875rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:24px}
		.h168-btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:52px;padding:16px 32px;border-radius:50px;font-weight:700;font-size:1rem;text-decoration:none;border:2px solid transparent}
		.h168-btn--primary{background:#00c3ff;color:#fff;box-shadow:0 4px 14px rgba(0,195,255,.35)}
		.h168-btn--ghost{background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.45)}
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'nuocda_168_critical_css', 1 );

/**
 * Gỡ emoji, embed, heartbeat frontend
 */
function nuocda_168_disable_wp_bloat() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter( 'emoji_svg_url', '__return_false' );

	if ( ! is_admin() ) {
		wp_deregister_script( 'wp-embed' );
	}
}
add_action( 'init', 'nuocda_168_disable_wp_bloat' );

add_action( 'init', function () {
	if ( ! is_admin() && ! nuocda_168_skip_frontend_optimizations() ) {
		wp_deregister_script( 'heartbeat' );
	}
}, 1 );

remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

/**
 * Resource hints — preconnect / dns-prefetch
 */
function nuocda_168_resource_hints( $urls, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://www.googletagmanager.com';
		$urls[] = 'https://www.google-analytics.com';
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'nuocda_168_resource_hints', 10, 2 );

/**
 * Preload LCP — ảnh hero mobile/desktop (ưu tiên cao nhất)
 */
function nuocda_168_preload_lcp_image() {
	if ( ! function_exists( 'nuocda_168_is_home_landing' ) || ! nuocda_168_is_home_landing() ) {
		return;
	}

	$settings = nuocda_168_get_landing_settings( 'home' );
	$hero_url = ! empty( $settings['hero']['bg'] ) ? $settings['hero']['bg'] : '';

	if ( ! $hero_url || ! function_exists( 'nuocda_168_get_hero_image_data' ) ) {
		return;
	}

	$hero = nuocda_168_get_hero_image_data( $hero_url );
	$type = $hero['type'];

	if ( ! empty( $hero['mobile'] ) ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $hero['mobile'] ) . '" fetchpriority="high" media="(max-width: 767px)" type="' . esc_attr( $type ) . '">' . "\n";
	}

	if ( ! empty( $hero['desktop'] ) && $hero['desktop'] !== $hero['mobile'] ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $hero['desktop'] ) . '" fetchpriority="high" media="(min-width: 768px)" type="' . esc_attr( $type ) . '">' . "\n";
	} elseif ( ! empty( $hero['mobile'] ) ) {
		echo '<link rel="preload" as="image" href="' . esc_url( $hero['mobile'] ) . '" fetchpriority="high" media="(min-width: 768px)" type="' . esc_attr( $type ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'nuocda_168_preload_lcp_image', 0 );

/**
 * Ảnh: decoding async; lazy cho ảnh không phải LCP
 */
function nuocda_168_optimize_image_attributes( $attr, $attachment, $size ) {
	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
	}

	if ( function_exists( 'is_product' ) && is_product() ) {
		static $product_lcp_done = false;

		if ( ! $product_lcp_done && in_array( $size, array( 'woocommerce_single', 'full', 'large' ), true ) ) {
			$product_lcp_done        = true;
			$attr['loading']         = 'eager';
			$attr['fetchpriority']   = 'high';
			return $attr;
		}
	}

	if ( empty( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'nuocda_168_optimize_image_attributes', 10, 3 );

/**
 * Analytics tải sau khi trang sẵn sàng — không chặn LCP
 */
function nuocda_168_deferred_analytics() {
	if ( is_admin() ) {
		return;
	}
	?>
	<script>
	(function () {
		function loadAnalytics() {
			if (window.nuocdaAnalyticsLoaded) return;
			window.nuocdaAnalyticsLoaded = true;

			var gtagScript = document.createElement('script');
			gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-3MPN7TKPM8';
			gtagScript.async = true;
			document.head.appendChild(gtagScript);

			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			window.gtag = gtag;
			gtag('js', new Date());
			gtag('config', 'G-3MPN7TKPM8');

			(function(w,d,s,l,i){
				w[l]=w[l]||[];
				w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
				var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s), dl=l!=='dataLayer'?'&l='+l:'';
				j.async=true;
				j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
				f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-TDG62HNV');
		}

		var events = ['scroll', 'click', 'keydown', 'touchstart'];
		function onFirstInteraction() {
			loadAnalytics();
			events.forEach(function (name) {
				document.removeEventListener(name, onFirstInteraction, { passive: true });
			});
		}
		events.forEach(function (name) {
			document.addEventListener(name, onFirstInteraction, { passive: true, once: false });
		});
		setTimeout(loadAnalytics, 8000);
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'nuocda_168_deferred_analytics', 5 );

/**
 * Sticky header — script riêng, defer
 */
function nuocda_168_enqueue_sticky_header() {
	if ( is_admin() ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	wp_enqueue_script(
		'nuocda-sticky-header',
		get_stylesheet_directory_uri() . '/js/sticky-header.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_sticky_header' );

/**
 * Tải script nhẹ sau khi trang ổn định — giảm main-thread lúc load
 */
function nuocda_168_deferred_frontend_scripts() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() ) {
		return;
	}

	$theme_version = wp_get_theme()->get( 'Version' );

	$contact_config = wp_json_encode(
		array(
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'nuocda-168-contact-nonce' ),
			'messages' => array(
				'phone_invalid'  => 'Số điện thoại không hợp lệ. Vui lòng nhập 10 số (bắt đầu 03, 05, 07, 08 hoặc 09).',
				'phone_required' => 'Vui lòng nhập số điện thoại.',
				'sending'        => 'Đang gửi...',
				'network_error'  => 'Lỗi kết nối hoặc lỗi máy chủ. Vui lòng thử lại.',
			),
		)
	);

	$contact_src = get_stylesheet_directory_uri() . '/js/contact-ajax.js?ver=' . rawurlencode( $theme_version );
	?>
	<script>
	(function () {
		var contactSrc = <?php echo wp_json_encode( $contact_src ); ?>;
		var contactLoaded = false;

		function loadScript(src) {
			var s = document.createElement('script');
			s.src = src;
			s.defer = true;
			document.body.appendChild(s);
		}

		function loadContactScript() {
			if (contactLoaded) return;
			contactLoaded = true;
			window.nuocdaAjax = <?php echo $contact_config; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;
			loadScript(contactSrc);
		}

		function watchContactForms() {
			var forms = document.querySelectorAll('.footer-168__form, .contact-form');
			if (!forms.length) return;

			if (!('IntersectionObserver' in window)) {
				loadContactScript();
				return;
			}

			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						loadContactScript();
						observer.disconnect();
					}
				});
			}, { rootMargin: '240px 0px' });

			forms.forEach(function (form) {
				observer.observe(form);
			});
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', watchContactForms);
		} else {
			watchContactForms();
		}
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'nuocda_168_deferred_frontend_scripts', 4 );
