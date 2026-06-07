<?php
/**
 * Tối ưu Lighthouse — giảm unused CSS/JS, TBT, LCP
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Font Awesome subset — solid only (~160KB woff2 thay vì all.min ~74KB css + nhiều font)
 */
add_filter( 'theme_mod_ocean_performance_fontawesome', function () {
	return 'disabled';
} );

/**
 * Enqueue FA solid subset cục bộ.
 */
function nuocda_168_enqueue_fa_solid_subset() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );
	$base    = get_stylesheet_directory_uri() . '/assets/fonts/fontawesome/css/';

	wp_dequeue_style( 'font-awesome' );
	wp_deregister_style( 'font-awesome' );
	wp_dequeue_style( 'fontawesome' );
	wp_deregister_style( 'fontawesome' );

	wp_enqueue_style( 'nuocda-fa-base', $base . 'fontawesome.min.css', array(), '6.7.2' );
	wp_enqueue_style( 'nuocda-fa-solid', $base . 'solid.min.css', array( 'nuocda-fa-base' ), '6.7.2' );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_fa_solid_subset', 30 );

/**
 * Landing pages — bỏ oceanwp-style + jQuery stack, dùng header/menu nhẹ
 */
function nuocda_168_landing_lite_assets() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() || ! nuocda_168_is_custom_landing_template() ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );
	$css_dir = get_stylesheet_directory_uri() . '/assets/css/';

	wp_dequeue_style( 'oceanwp-style' );
	wp_deregister_style( 'oceanwp-style' );

	wp_enqueue_style(
		'nuocda-header-lite',
		$css_dir . '11-header-lite.css',
		array( 'nuocda-global' ),
		$version
	);

	$scripts = array(
		'jquery',
		'jquery-core',
		'jquery-migrate',
		'oceanwp-main',
		'imagesloaded',
		'oceanwp-drop-down-mobile-menu',
		'oceanwp-full-screen-mobile-menu',
		'oceanwp-sidebar-mobile-menu',
		'ow-sidr',
		'oceanwp-drop-down-search',
		'oceanwp-header-replace-search',
		'oceanwp-overlay-search',
		'oceanwp-full-screen-menu',
		'oceanwp-vertical-header',
	);

	foreach ( $scripts as $handle ) {
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}

	wp_enqueue_script(
		'nuocda-mobile-menu-lite',
		get_stylesheet_directory_uri() . '/js/mobile-menu-lite.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_landing_lite_assets', 100002 );

/**
 * Gỡ CSS/JS plugin không cần trên frontend
 */
function nuocda_168_dequeue_plugin_bloat() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() ) {
		return;
	}

	$style_prefixes = array(
		'rank-math',
		'contact-form-7',
		'wpcf7',
	);

	$script_prefixes = array(
		'rank-math',
		'contact-form-7',
		'wpcf7-',
	);

	if ( nuocda_168_is_custom_landing_template() ) {
		$style_prefixes[]  = 'elementor';
		$script_prefixes[] = 'elementor-';
	}

	global $wp_styles, $wp_scripts;

	if ( isset( $wp_styles->queue ) ) {
		foreach ( $wp_styles->queue as $handle ) {
			foreach ( $style_prefixes as $prefix ) {
				if ( 0 === strpos( $handle, $prefix ) ) {
					wp_dequeue_style( $handle );
					break;
				}
			}
		}
	}

	if ( isset( $wp_scripts->queue ) ) {
		foreach ( $wp_scripts->queue as $handle ) {
			foreach ( $script_prefixes as $prefix ) {
				if ( 0 === strpos( $handle, $prefix ) ) {
					wp_dequeue_script( $handle );
					break;
				}
			}
		}
	}

	wp_dequeue_script( 'imagesloaded' );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_dequeue_plugin_bloat', 100003 );

/**
 * Async FA subset — header-lite phải load đồng bộ (menu critical)
 */
function nuocda_168_lighthouse_async_styles( $html, $handle, $href, $media ) {
	if ( nuocda_168_skip_frontend_optimizations() ) {
		return $html;
	}

	$async = array( 'nuocda-fa-base', 'nuocda-fa-solid' );

	if ( ! in_array( $handle, $async, true ) ) {
		return $html;
	}

	$out  = '<link rel="stylesheet" id="' . esc_attr( $handle ) . '-css" href="' . esc_url( $href ) . '" media="print" onload="this.media=\'all\'">' . "\n";
	$out .= '<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '"></noscript>';

	return $out;
}
add_filter( 'style_loader_tag', 'nuocda_168_lighthouse_async_styles', 11, 4 );

/**
 * Chiều cao header landing — inline nhẹ (file CSS load đồng bộ riêng).
 */
function nuocda_168_inline_header_lite_css() {
	if ( is_admin() || nuocda_168_skip_frontend_optimizations() || ! nuocda_168_is_custom_landing_template() ) {
		return;
	}

	$header_h = absint( get_theme_mod( 'ocean_header_height', 74 ) );
	$header_h = $header_h >= 50 ? $header_h : 74;

	echo '<style id="nuocda-header-lite-var">#site-header{--nuocda-header-h:' . (int) $header_h . "px;}</style>\n";
}
add_action( 'wp_head', 'nuocda_168_inline_header_lite_css', 2 );
