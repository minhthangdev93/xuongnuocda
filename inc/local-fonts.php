<?php
/**
 * Font cục bộ — Inter (body) + Montserrat (heading)
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Không tải Google Fonts từ CDN — dùng file trong child theme.
 */
add_filter( 'theme_mod_ocean_enable_google_fonts', '__return_false' );

/**
 * Enqueue @font-face (blocking, trước design-system).
 */
function nuocda_168_enqueue_local_fonts() {
	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	wp_enqueue_style(
		'nuocda-local-fonts',
		get_stylesheet_directory_uri() . '/assets/css/00-local-fonts.css',
		array(),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_local_fonts', 15 );

/**
 * Áp dụng font-family toàn site.
 */
function nuocda_168_local_fonts_typography() {
	$body = '"Inter", var(--font-sans-fallback)';
	$head = '"Montserrat", var(--font-sans-fallback)';

	$css  = ':root{--font-body:' . $body . ';--font-heading:' . $head . ';}';
	$css .= 'body,#main #content,.entry-content,.c168-page,.h168-page,.a168-page,.footer-168,.nuocda-page-header{font-family:var(--font-body);}';
	$css .= 'h1,h2,h3,h4,h5,h6,.h168-section-title,.nuocda-page-header__title{font-family:var(--font-heading);}';

	wp_add_inline_style( 'nuocda-local-fonts', $css );
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_local_fonts_typography', 16 );

/**
 * Gỡ font OceanWP/Google CDN nếu plugin vẫn enqueue.
 */
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
 * Preload font woff2 quan trọng — giảm FOUT.
 */
function nuocda_168_preload_local_fonts() {
	if ( is_admin() ) {
		return;
	}

	$base = get_stylesheet_directory_uri() . '/assets/fonts/inter/';
	$files = array(
		$base . 'inter-400-vietnamese.woff2',
		$base . 'inter-400-latin.woff2',
	);

	foreach ( $files as $file ) {
		echo '<link rel="preload" as="font" type="font/woff2" href="' . esc_url( $file ) . '" crossorigin>' . "\n";
	}
}
add_action( 'wp_head', 'nuocda_168_preload_local_fonts', 2 );
