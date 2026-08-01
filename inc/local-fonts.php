<?php
/**
 * Font cục bộ — Inter (body) + Montserrat (heading)
 * Luôn nạp đủ vietnamese + latin (tránh chữ lẫn font trong 1 từ tiếng Việt).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'theme_mod_ocean_enable_google_fonts', '__return_false' );

/**
 * CSS @font-face + typography.
 */
function nuocda_168_get_local_fonts_css() {
	$base     = get_stylesheet_directory_uri() . '/assets/fonts';
	$vi_range = 'U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB';
	$latin    = 'U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD';

	// swap: luôn hiện chữ Việt đúng. Layout CLS đã xử lý bằng flex-start + min-height hero.
	$css  = "@font-face{font-family:'Inter';font-style:normal;font-weight:400 800;font-display:swap;src:url({$base}/inter/inter-400-vietnamese.woff2) format('woff2');unicode-range:{$vi_range}}";
	$css .= "@font-face{font-family:'Inter';font-style:normal;font-weight:400 800;font-display:swap;src:url({$base}/inter/inter-400-latin.woff2) format('woff2');unicode-range:{$latin}}";
	$css .= "@font-face{font-family:'Montserrat';font-style:normal;font-weight:400 800;font-display:swap;src:url({$base}/montserrat/montserrat-400-vietnamese.woff2) format('woff2');unicode-range:{$vi_range}}";
	$css .= "@font-face{font-family:'Montserrat';font-style:normal;font-weight:400 800;font-display:swap;src:url({$base}/montserrat/montserrat-400-latin.woff2) format('woff2');unicode-range:{$latin}}";

	$css .= ':root{--font-sans-fallback:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif;--font-body:"Inter",var(--font-sans-fallback);--font-heading:"Montserrat",var(--font-sans-fallback)}';
	$css .= 'body,#main #content,.entry-content,.c168-page,.h168-page,.a168-page,.footer-168,.nuocda-page-header{font-family:var(--font-body)!important}';
	$css .= 'h1,h2,h3,h4,h5,h6,.h168-section-title,.h168-hero__title,.nuocda-page-header__title{font-family:var(--font-heading)!important}';

	return $css;
}

function nuocda_168_print_local_fonts_inline() {
	if ( is_admin() ) {
		return;
	}

	echo '<style id="nuocda-local-fonts-inline">' . nuocda_168_get_local_fonts_css() . "</style>\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'nuocda_168_print_local_fonts_inline', 0 );

function nuocda_168_enqueue_local_fonts() {
	wp_register_style( 'nuocda-local-fonts', false, array(), null );
	wp_enqueue_style( 'nuocda-local-fonts' );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_local_fonts', 15 );

function nuocda_168_dequeue_remote_google_fonts() {
	if ( is_admin() ) {
		return;
	}

	global $wp_styles;

	if ( ! isset( $wp_styles->queue ) ) {
		return;
	}

	foreach ( $wp_styles->queue as $handle ) {
		if ( 0 === strpos( $handle, 'oceanwp-google-font' ) ) {
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_dequeue_remote_google_fonts', 100001 );

/**
 * Preload subset tiếng Việt (nhỏ). Latin tải theo nhu cầu qua unicode-range.
 */
function nuocda_168_preload_local_fonts() {
	if ( is_admin() ) {
		return;
	}

	$base  = get_stylesheet_directory_uri() . '/assets/fonts/';
	$files = array(
		$base . 'inter/inter-400-vietnamese.woff2',
		$base . 'montserrat/montserrat-400-vietnamese.woff2',
	);

	foreach ( $files as $file ) {
		echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url( $file ) . '" crossorigin>' . "\n";
	}
}
add_action( 'wp_head', 'nuocda_168_preload_local_fonts', 1 );
