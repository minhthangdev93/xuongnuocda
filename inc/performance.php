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
 */
function nuocda_168_get_css_modules() {
	$css_dir = get_stylesheet_directory_uri() . '/assets/css/';

	$modules = array(
		'nuocda-design-system' => $css_dir . '01-design-system.css',
		'nuocda-layout'        => $css_dir . '02-layout.css',
		'nuocda-components'    => $css_dir . '03-components.css',
		'nuocda-footer'        => $css_dir . '04-footer.css',
		'nuocda-sticky-header' => $css_dir . '10-sticky-header.css',
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
	$previous = array( 'oceanwp-style' );

	foreach ( $modules as $handle => $url ) {
		wp_enqueue_style( $handle, $url, $previous, $version );
		$previous = array( $handle );
	}

	wp_enqueue_style( 'child-style', get_stylesheet_uri(), $previous, $version );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_conditional_styles', 20 );

/**
 * Font fallback — tránh rơi về serif khi Google Font chưa tải xong
 */
function nuocda_168_typography_fallback() {
	$fallback = 'var(--font-sans-fallback)';
	$body     = get_theme_mod( 'body_typography', array() );
	$headings = get_theme_mod( 'headings_typography', array() );

	$body_font = ! empty( $body['font-family'] ) ? $body['font-family'] : '';
	$head_font = ! empty( $headings['font-family'] ) ? $headings['font-family'] : $body_font;

	$css  = 'body, .c168-page, .h168-page, .a168-page, .footer-168, .nuocda-page-header { font-family: ';
	$css .= $body_font ? '"' . esc_attr( $body_font ) . '", ' . $fallback : $fallback;
	$css .= '; }';

	$css .= 'h1, h2, h3, h4, h5, h6 { font-family: ';
	$css .= $head_font ? '"' . esc_attr( $head_font ) . '", ' . $fallback : 'inherit';
	$css .= '; }';

	wp_add_inline_style( 'nuocda-design-system', $css );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_typography_fallback', 25 );

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
	if ( is_admin() ) {
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
	if ( is_admin() || ! wp_script_is( 'jquery', 'registered' ) ) {
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
	if ( is_admin() || ! isset( $scripts->registered['jquery'] ) ) {
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
	if ( false !== strpos( $tag, ' defer' ) || false !== strpos( $tag, ' async' ) ) {
		return $tag;
	}

	$defer_exact = array(
		'jquery',
		'jquery-core',
		'nuocda-168-contact-js',
		'nuocda-h168-lightbox',
		'nuocda-home-media-tabs',
		'nuocda-sticky-header',
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
	$async_handles = array(
		'oceanwp-style',
		'font-awesome',
		'simple-line-icons',
		'nuocda-layout',
		'nuocda-components',
		'nuocda-footer',
		'nuocda-sticky-header',
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
	if ( is_admin() ) {
		return;
	}
	?>
	<style id="nuocda-critical-css">
		body{margin:0;background:#fff;color:#333}
		#site-header,.oceanwp-mobile-menu-icon,#site-navigation-wrap{visibility:visible}
		.container-168{max-width:1280px;margin:0 auto;padding:0 24px}
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
	if ( ! is_admin() ) {
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
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = 'https://fonts.gstatic.com';
		$urls[] = 'https://www.googletagmanager.com';
		$urls[] = 'https://www.google-analytics.com';
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'nuocda_168_resource_hints', 10, 2 );

/**
 * Preload LCP — ảnh hero trang chủ
 */
function nuocda_168_preload_lcp_image() {
	if ( ! is_front_page() && ! is_page_template( 'templates/page-trang-chu-168.php' ) ) {
		return;
	}

	$hero = 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_yyTfY0SS.webp';
	echo '<link rel="preload" as="image" href="' . esc_url( $hero ) . '" fetchpriority="high" type="image/webp">' . "\n";
}
add_action( 'wp_head', 'nuocda_168_preload_lcp_image', 2 );

/**
 * Preload Font Awesome — tránh icon flash khi CSS async
 */
function nuocda_168_preload_fontawesome() {
	$fa = get_template_directory_uri() . '/assets/fonts/fontawesome/css/all.min.css';

	if ( get_theme_mod( 'ocean_performance_fontawesome', 'enabled' ) === 'disabled' ) {
		return;
	}

	echo '<link rel="preload" as="style" href="' . esc_url( $fa ) . '">' . "\n";
}
add_action( 'wp_head', 'nuocda_168_preload_fontawesome', 3 );

/**
 * Ảnh: decoding async; lazy cho ảnh không phải LCP
 */
function nuocda_168_optimize_image_attributes( $attr, $attachment, $size ) {
	if ( empty( $attr['decoding'] ) ) {
		$attr['decoding'] = 'async';
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

		if ('requestIdleCallback' in window) {
			requestIdleCallback(loadAnalytics, { timeout: 3500 });
		} else {
			window.addEventListener('load', function () {
				setTimeout(loadAnalytics, 2000);
			});
		}
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
