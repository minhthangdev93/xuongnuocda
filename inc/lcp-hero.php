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
 * Attachment ID từ URL ảnh (kể cả path tương đối).
 *
 * @param string $url URL ảnh.
 * @return int
 */
function nuocda_168_attachment_id_from_url( $url ) {
	$url = esc_url_raw( $url );
	if ( ! $url ) {
		return 0;
	}

	$attachment_id = attachment_url_to_postid( $url );
	if ( $attachment_id ) {
		return (int) $attachment_id;
	}

	$path = wp_parse_url( $url, PHP_URL_PATH );
	if ( ! $path ) {
		return 0;
	}

	$local_url = home_url( $path );
	if ( $local_url !== $url ) {
		$attachment_id = attachment_url_to_postid( $local_url );
		if ( $attachment_id ) {
			return (int) $attachment_id;
		}
	}

	// Fallback: tìm theo basename trong uploads (khi CDN/webp đổi URL).
	$basename = wp_basename( $path );
	if ( ! $basename ) {
		return 0;
	}

	global $wpdb;
	$like = '%' . $wpdb->esc_like( $basename );
	$id   = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s LIMIT 1",
			$like
		)
	);

	return $id > 0 ? $id : 0;
}

/**
 * Chọn URL ảnh theo kích thước mục tiêu từ metadata.
 *
 * @param int $attachment_id Attachment ID.
 * @param int $target_w      Chiều rộng mục tiêu.
 * @return array{url:string,width:int,height:int}|null
 */
function nuocda_168_pick_attachment_size( $attachment_id, $target_w ) {
	$attachment_id = (int) $attachment_id;
	$target_w      = (int) $target_w;

	if ( $attachment_id <= 0 || $target_w <= 0 ) {
		return null;
	}

	$meta = wp_get_attachment_metadata( $attachment_id );
	if ( empty( $meta ) || ! is_array( $meta ) ) {
		$url = wp_get_attachment_url( $attachment_id );
		return $url ? array(
			'url'    => $url,
			'width'  => isset( $meta['width'] ) ? (int) $meta['width'] : $target_w,
			'height' => isset( $meta['height'] ) ? (int) $meta['height'] : (int) round( $target_w * 0.56 ),
		) : null;
	}

	$candidates = array();

	if ( ! empty( $meta['sizes'] ) && is_array( $meta['sizes'] ) ) {
		foreach ( $meta['sizes'] as $size_name => $size ) {
			if ( empty( $size['file'] ) || empty( $size['width'] ) ) {
				continue;
			}
			$url = wp_get_attachment_image_url( $attachment_id, $size_name );
			if ( ! $url ) {
				continue;
			}
			$candidates[] = array(
				'url'    => $url,
				'width'  => (int) $size['width'],
				'height' => isset( $size['height'] ) ? (int) $size['height'] : 0,
			);
		}
	}

	$full_url = wp_get_attachment_url( $attachment_id );
	if ( $full_url && ! empty( $meta['width'] ) ) {
		$candidates[] = array(
			'url'    => $full_url,
			'width'  => (int) $meta['width'],
			'height' => isset( $meta['height'] ) ? (int) $meta['height'] : 0,
		);
	}

	if ( ! $candidates ) {
		return null;
	}

	$best      = null;
	$best_diff = PHP_INT_MAX;

	foreach ( $candidates as $candidate ) {
		// Ưu tiên size >= target (tránh upscale mờ), gần target nhất.
		$diff = $candidate['width'] >= $target_w
			? ( $candidate['width'] - $target_w )
			: ( ( $target_w - $candidate['width'] ) + 10000 );

		if ( $diff < $best_diff ) {
			$best_diff = $diff;
			$best      = $candidate;
		}
	}

	return $best;
}

/**
 * Dữ liệu ảnh hero — mobile nhỏ cho LCP, desktop lớn hơn.
 * Không dùng full srcset (tránh preload miss trên mobile).
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
		'width'   => 640,
		'height'  => 360,
		'type'    => nuocda_168_image_mime_from_url( $url ),
	);

	if ( ! $url ) {
		return $data;
	}

	$attachment_id = nuocda_168_attachment_id_from_url( $url );
	if ( ! $attachment_id ) {
		return $data;
	}

	// Mobile LCP: ưu tiên ~640–768w (nhẹ hơn 1536 trên 4G).
	$mobile  = nuocda_168_pick_attachment_size( $attachment_id, 768 );
	$tablet  = nuocda_168_pick_attachment_size( $attachment_id, 1024 );
	$desktop = nuocda_168_pick_attachment_size( $attachment_id, 1280 );

	if ( ! $mobile ) {
		return $data;
	}

	$mobile_url  = $mobile['url'];
	$tablet_url  = $tablet ? $tablet['url'] : $mobile_url;
	$desktop_url = $desktop ? $desktop['url'] : $tablet_url;

	// Srcset phải chứa đúng URL preload (mobile/tablet/desktop) — tránh cảnh báo "preloaded but not used".
	$srcset_map = array();
	foreach ( array( $mobile, $tablet, $desktop ) as $candidate ) {
		if ( ! $candidate || empty( $candidate['url'] ) || empty( $candidate['width'] ) ) {
			continue;
		}
		$w = (int) $candidate['width'];
		if ( $w <= 0 || $w > 1920 ) {
			continue;
		}
		$srcset_map[ $w ] = esc_url( $candidate['url'] ) . ' ' . $w . 'w';
	}

	ksort( $srcset_map );

	$data['src']     = $mobile_url;
	$data['mobile']  = $mobile_url;
	$data['tablet']  = $tablet_url;
	$data['desktop'] = $desktop_url;
	$data['srcset']  = implode( ', ', $srcset_map );
	$data['width']   = (int) $mobile['width'];
	$data['height']  = (int) ( $mobile['height'] ? $mobile['height'] : round( $mobile['width'] * 0.56 ) );
	$data['type']    = nuocda_168_image_mime_from_url( $mobile_url );

	return $data;
}
