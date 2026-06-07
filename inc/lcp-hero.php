<?php
/**
 * LCP hero — ảnh responsive + srcset cho mobile
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Kích thước ảnh hero tối ưu mobile/desktop.
 */
function nuocda_168_register_hero_image_sizes() {
	add_image_size( 'nuocda-hero-mobile', 640, 0, false );
	add_image_size( 'nuocda-hero-tablet', 1024, 0, false );
	add_image_size( 'nuocda-hero-desktop', 1280, 0, false );
}
add_action( 'after_setup_theme', 'nuocda_168_register_hero_image_sizes' );

/**
 * Trang chủ dùng template landing.
 */
function nuocda_168_is_home_landing() {
	return is_front_page() || is_page_template( 'templates/page-trang-chu-168.php' );
}

/**
 * MIME type từ URL ảnh.
 */
function nuocda_168_image_mime_from_url( $url ) {
	if ( false !== strpos( $url, '.webp' ) ) {
		return 'image/webp';
	}
	if ( false !== strpos( $url, '.png' ) ) {
		return 'image/png';
	}
	return 'image/jpeg';
}

/**
 * Dữ liệu ảnh hero — mobile nhỏ cho LCP, desktop lớn hơn.
 *
 * @param string $url URL ảnh từ landing settings.
 * @return array
 */
function nuocda_168_get_hero_image_data( $url ) {
	$url = esc_url_raw( $url );

	$data = array(
		'src'     => $url,
		'mobile'  => $url,
		'tablet'  => $url,
		'desktop' => $url,
		'srcset'  => '',
		'sizes'   => '100vw',
		'width'   => 1920,
		'height'  => 1080,
		'type'    => nuocda_168_image_mime_from_url( $url ),
	);

	if ( ! $url ) {
		return $data;
	}

	$attachment_id = attachment_url_to_postid( $url );
	if ( ! $attachment_id ) {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		if ( $path ) {
			$local_url = home_url( $path );
			if ( $local_url !== $url ) {
				$attachment_id = attachment_url_to_postid( $local_url );
			}
		}
	}
	if ( ! $attachment_id ) {
		return $data;
	}

	$mobile  = wp_get_attachment_image_url( $attachment_id, 'nuocda-hero-mobile' );
	$tablet  = wp_get_attachment_image_url( $attachment_id, 'nuocda-hero-tablet' );
	$desktop = wp_get_attachment_image_url( $attachment_id, 'nuocda-hero-desktop' );

	if ( ! $mobile ) {
		$mobile = wp_get_attachment_image_url( $attachment_id, 'medium_large' );
	}
	if ( ! $mobile ) {
		$mobile = wp_get_attachment_image_url( $attachment_id, 'medium' );
	}
	if ( ! $tablet ) {
		$tablet = wp_get_attachment_image_url( $attachment_id, 'large' );
	}
	if ( ! $desktop ) {
		$desktop = wp_get_attachment_image_url( $attachment_id, 'large' );
	}

	$mobile  = $mobile ? $mobile : $url;
	$tablet  = $tablet ? $tablet : $mobile;
	$desktop = $desktop ? $desktop : $tablet;

	$srcset_parts = array();
	$meta         = wp_get_attachment_metadata( $attachment_id );

	if ( $mobile ) {
		$w              = isset( $meta['sizes']['nuocda-hero-mobile']['width'] ) ? (int) $meta['sizes']['nuocda-hero-mobile']['width'] : 640;
		$srcset_parts[] = esc_url( $mobile ) . ' ' . $w . 'w';
	}
	if ( $tablet && $tablet !== $mobile ) {
		$w              = isset( $meta['sizes']['nuocda-hero-tablet']['width'] ) ? (int) $meta['sizes']['nuocda-hero-tablet']['width'] : 1024;
		$srcset_parts[] = esc_url( $tablet ) . ' ' . $w . 'w';
	}
	if ( $desktop && $desktop !== $tablet ) {
		$w              = isset( $meta['sizes']['nuocda-hero-desktop']['width'] ) ? (int) $meta['sizes']['nuocda-hero-desktop']['width'] : 1280;
		$srcset_parts[] = esc_url( $desktop ) . ' ' . $w . 'w';
	}

	$full_srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
	if ( $full_srcset ) {
		$data['srcset'] = $full_srcset;
	} elseif ( $srcset_parts ) {
		$data['srcset'] = implode( ', ', $srcset_parts );
	}

	$full = wp_get_attachment_image_src( $attachment_id, 'nuocda-hero-mobile' );
	if ( $full ) {
		$data['width']  = (int) $full[1];
		$data['height'] = (int) $full[2];
	}

	$data['src']     = $mobile;
	$data['mobile']  = $mobile;
	$data['tablet']  = $tablet;
	$data['desktop'] = $desktop;
	$data['type']    = nuocda_168_image_mime_from_url( $mobile );

	return $data;
}
