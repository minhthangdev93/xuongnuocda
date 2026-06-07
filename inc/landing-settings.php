<?php
/**
 * Cài đặt trang landing — getter & sanitize.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_stylesheet_directory() . '/inc/landing-settings-defaults.php';

/**
 * Danh sách trang landing được hỗ trợ.
 */
function nuocda_168_landing_pages() {
	return array(
		'home'    => __( 'Trang chủ', 'oceanwp' ),
		'about'   => __( 'Giới thiệu', 'oceanwp' ),
		'contact' => __( 'Liên hệ', 'oceanwp' ),
		'footer'  => __( 'Footer', 'oceanwp' ),
	);
}

/**
 * Option key theo trang.
 */
function nuocda_168_landing_option_key( $page ) {
	return 'nuocda_168_landing_' . sanitize_key( $page );
}

/**
 * Defaults theo trang.
 */
function nuocda_168_landing_get_defaults( $page ) {
	switch ( $page ) {
		case 'about':
			return nuocda_168_landing_defaults_about();
		case 'contact':
			return nuocda_168_landing_defaults_contact();
		case 'footer':
			return nuocda_168_landing_defaults_footer();
		case 'home':
		default:
			return nuocda_168_landing_defaults_home();
	}
}

/**
 * Gộp đệ quy mảng — giữ key mặc định nếu thiếu.
 */
function nuocda_168_landing_array_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	$merged = $defaults;

	foreach ( $saved as $key => $value ) {
		if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) && nuocda_168_landing_is_assoc( $merged[ $key ] ) && nuocda_168_landing_is_assoc( $value ) ) {
			$merged[ $key ] = nuocda_168_landing_array_merge( $merged[ $key ], $value );
		} else {
			$merged[ $key ] = $value;
		}
	}

	return $merged;
}

/**
 * Kiểm tra mảng associative.
 */
function nuocda_168_landing_is_assoc( $array ) {
	if ( ! is_array( $array ) || array() === $array ) {
		return false;
	}

	return array_keys( $array ) !== range( 0, count( $array ) - 1 );
}

/**
 * Lấy cài đặt trang (đã merge defaults).
 *
 * @param string $page home|about|contact|footer.
 */
function nuocda_168_get_landing_settings( $page = 'home' ) {
	$page = sanitize_key( $page );
	if ( ! isset( nuocda_168_landing_pages()[ $page ] ) ) {
		$page = 'home';
	}

	$defaults = nuocda_168_landing_get_defaults( $page );
	$saved    = get_option( nuocda_168_landing_option_key( $page ), array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return nuocda_168_landing_array_merge( $defaults, $saved );
}

/**
 * Sanitize URL ảnh / link.
 */
function nuocda_168_landing_sanitize_url( $url ) {
	return esc_url_raw( trim( (string) $url ) );
}

/**
 * Sanitize URL liên kết — chấp nhận đường dẫn tương đối (/about-us/, /#anchor).
 */
function nuocda_168_landing_sanitize_link_url( $url ) {
	$url = trim( (string) $url );

	if ( ! $url ) {
		return '';
	}

	if ( '/' === $url[0] || '#' === $url[0] ) {
		return esc_url_raw( home_url( $url ) );
	}

	return esc_url_raw( $url );
}

/**
 * Sanitize danh sách stat.
 */
function nuocda_168_landing_sanitize_stats( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$num   = sanitize_text_field( $item['num'] ?? '' );
		$label = sanitize_text_field( $item['label'] ?? '' );
		if ( $num && $label ) {
			$out[] = array( 'num' => $num, 'label' => $label );
		}
	}
	return $out;
}

/**
 * Sanitize FAQ.
 */
function nuocda_168_landing_sanitize_faq( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$q = sanitize_text_field( $item['q'] ?? '' );
		$a = sanitize_textarea_field( $item['a'] ?? '' );
		if ( $q && $a ) {
			$out[] = array( 'q' => $q, 'a' => $a );
		}
	}
	return $out;
}

/**
 * Sanitize why / highlight items.
 */
function nuocda_168_landing_sanitize_icon_items( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$icon  = sanitize_text_field( $item['icon'] ?? 'fa-check' );
		$title = sanitize_text_field( $item['title'] ?? '' );
		$desc  = sanitize_textarea_field( $item['desc'] ?? '' );
		if ( $title ) {
			$out[] = array( 'icon' => $icon, 'title' => $title, 'desc' => $desc );
		}
	}
	return $out;
}

/**
 * Sanitize sản phẩm home.
 */
function nuocda_168_landing_sanitize_products( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$name = sanitize_text_field( $item['name'] ?? '' );
		if ( ! $name ) {
			continue;
		}
		$out[] = array(
			'name' => $name,
			'desc' => sanitize_textarea_field( $item['desc'] ?? '' ),
			'img'  => nuocda_168_landing_sanitize_url( $item['img'] ?? '' ),
			'link' => nuocda_168_landing_sanitize_url( $item['link'] ?? '' ),
		);
	}
	return $out;
}

/**
 * Sanitize đánh giá.
 */
function nuocda_168_landing_sanitize_reviews( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$text = sanitize_textarea_field( $item['text'] ?? '' );
		if ( ! $text ) {
			continue;
		}
		$stars = max( 1, min( 5, absint( $item['stars'] ?? 5 ) ) );
		$out[] = array(
			'stars'  => $stars,
			'text'   => $text,
			'author' => sanitize_text_field( $item['author'] ?? '' ),
		);
	}
	return $out;
}

/**
 * Sanitize danh sách text (tags, products pills).
 */
function nuocda_168_landing_sanitize_text_list( $items ) {
	if ( ! is_array( $items ) ) {
		if ( is_string( $items ) ) {
			$items = preg_split( '/\r\n|\r|\n/', $items );
		} else {
			return array();
		}
	}

	$out = array();
	foreach ( $items as $item ) {
		$item = sanitize_text_field( $item );
		if ( $item ) {
			$out[] = $item;
		}
	}
	return $out;
}

/**
 * Sanitize toàn bộ settings trang chủ.
 */
function nuocda_168_landing_sanitize_home( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'home' );
	$input    = is_array( $input ) ? $input : array();

	$hero = $input['hero'] ?? array();
	$out  = array(
		'hero'        => array(
			'badge'        => sanitize_text_field( $hero['badge'] ?? $defaults['hero']['badge'] ),
			'title'        => sanitize_text_field( $hero['title'] ?? '' ),
			'title_accent' => sanitize_text_field( $hero['title_accent'] ?? '' ),
			'desc'         => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'           => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
			'stats'        => nuocda_168_landing_sanitize_stats( $hero['stats'] ?? array() ),
		),
		'about_quick' => array(
			'image'      => nuocda_168_landing_sanitize_url( $input['about_quick']['image'] ?? '' ),
			'badge_num'  => sanitize_text_field( $input['about_quick']['badge_num'] ?? '' ),
			'badge_text' => sanitize_text_field( $input['about_quick']['badge_text'] ?? '' ),
			'label'      => sanitize_text_field( $input['about_quick']['label'] ?? '' ),
			'heading'    => sanitize_text_field( $input['about_quick']['heading'] ?? '' ),
			'lead'       => sanitize_textarea_field( $input['about_quick']['lead'] ?? '' ),
			'link_url'   => nuocda_168_landing_sanitize_url( $input['about_quick']['link_url'] ?? '' ),
			'link_text'  => sanitize_text_field( $input['about_quick']['link_text'] ?? '' ),
		),
		'products'    => array(
			'label'   => sanitize_text_field( $input['products']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['products']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['products']['desc'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_products( $input['products']['items'] ?? array() ),
		),
		'why'         => array(
			'label'   => sanitize_text_field( $input['why']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['why']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['why']['items'] ?? array() ),
		),
		'stats'       => nuocda_168_landing_sanitize_stats( $input['stats'] ?? array() ),
		'cta'         => array(
			'title' => sanitize_text_field( $input['cta']['title'] ?? '' ),
			'desc'  => sanitize_textarea_field( $input['cta']['desc'] ?? '' ),
			'bg'    => nuocda_168_landing_sanitize_url( $input['cta']['bg'] ?? '' ),
		),
		'stores'      => array(
			'label'   => sanitize_text_field( $input['stores']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['stores']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['stores']['desc'] ?? '' ),
		),
		'map'         => array(
			'label'   => sanitize_text_field( $input['map']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['map']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['map']['desc'] ?? '' ),
			'embed'   => nuocda_168_landing_sanitize_url( $input['map']['embed'] ?? '' ),
		),
		'reviews'     => array(
			'label'   => sanitize_text_field( $input['reviews']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['reviews']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_reviews( $input['reviews']['items'] ?? array() ),
		),
		'media'       => array(
			'label'   => sanitize_text_field( $input['media']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['media']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['media']['desc'] ?? '' ),
		),
		'faq'         => array(
			'label'   => sanitize_text_field( $input['faq']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['faq']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_faq( $input['faq']['items'] ?? array() ),
		),
	);

	return nuocda_168_landing_array_merge( $defaults, $out );
}

/**
 * Sanitize trang giới thiệu.
 */
function nuocda_168_landing_sanitize_about( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'about' );
	$input    = is_array( $input ) ? $input : array();
	$hero     = $input['hero'] ?? array();

	$out = array(
		'hero'   => array(
			'badge' => sanitize_text_field( $hero['badge'] ?? '' ),
			'title' => sanitize_text_field( $hero['title'] ?? '' ),
			'desc'  => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'    => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
			'stats' => nuocda_168_landing_sanitize_stats( $hero['stats'] ?? array() ),
		),
		'intro'  => array(
			'image'      => nuocda_168_landing_sanitize_url( $input['intro']['image'] ?? '' ),
			'label'      => sanitize_text_field( $input['intro']['label'] ?? '' ),
			'heading'    => sanitize_text_field( $input['intro']['heading'] ?? '' ),
			'lead'       => sanitize_textarea_field( $input['intro']['lead'] ?? '' ),
			'highlights' => nuocda_168_landing_sanitize_icon_items( $input['intro']['highlights'] ?? array() ),
			'products'   => nuocda_168_landing_sanitize_text_list( $input['intro']['products'] ?? array() ),
		),
		'values' => array(
			'label'   => sanitize_text_field( $input['values']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['values']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['values']['items'] ?? array() ),
		),
		'tech'   => array(
			'image'   => nuocda_168_landing_sanitize_url( $input['tech']['image'] ?? '' ),
			'label'   => sanitize_text_field( $input['tech']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['tech']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['tech']['desc'] ?? '' ),
		),
		'cta'    => array(
			'title' => sanitize_text_field( $input['cta']['title'] ?? '' ),
			'desc'  => sanitize_textarea_field( $input['cta']['desc'] ?? '' ),
			'bg'    => nuocda_168_landing_sanitize_url( $input['cta']['bg'] ?? '' ),
		),
	);

	return nuocda_168_landing_array_merge( $defaults, $out );
}

/**
 * Sanitize trang liên hệ.
 */
function nuocda_168_landing_sanitize_contact( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'contact' );
	$input    = is_array( $input ) ? $input : array();
	$hero     = $input['hero'] ?? array();

	$out = array(
		'hero'   => array(
			'badge' => sanitize_text_field( $hero['badge'] ?? '' ),
			'title' => sanitize_text_field( $hero['title'] ?? '' ),
			'desc'  => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'    => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
		),
		'form'   => array(
			'label'   => sanitize_text_field( $input['form']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['form']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['form']['desc'] ?? '' ),
			'bullets' => nuocda_168_landing_sanitize_text_list( $input['form']['bullets'] ?? array() ),
		),
		'areas'  => array(
			'label'   => sanitize_text_field( $input['areas']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['areas']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['areas']['desc'] ?? '' ),
			'tags'    => nuocda_168_landing_sanitize_text_list( $input['areas']['tags'] ?? array() ),
		),
		'stores' => array(
			'label'   => sanitize_text_field( $input['stores']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['stores']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['stores']['desc'] ?? '' ),
		),
		'map'    => array(
			'label'   => sanitize_text_field( $input['map']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['map']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['map']['desc'] ?? '' ),
			'embed'   => nuocda_168_landing_sanitize_url( $input['map']['embed'] ?? '' ),
		),
		'faq'    => array(
			'label'   => sanitize_text_field( $input['faq']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['faq']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_faq( $input['faq']['items'] ?? array() ),
		),
		'cta'    => array(
			'title' => sanitize_text_field( $input['cta']['title'] ?? '' ),
			'desc'  => sanitize_textarea_field( $input['cta']['desc'] ?? '' ),
		),
	);

	return nuocda_168_landing_array_merge( $defaults, $out );
}

/**
 * Sanitize liên kết footer.
 */
function nuocda_168_landing_sanitize_link_items( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$label = sanitize_text_field( $item['label'] ?? '' );
		$url   = nuocda_168_landing_sanitize_link_url( $item['url'] ?? '' );
		if ( $label && $url ) {
			$out[] = array( 'label' => $label, 'url' => $url );
		}
	}
	return $out;
}

/**
 * Sanitize footer.
 */
function nuocda_168_landing_sanitize_footer( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'footer' );
	$input    = is_array( $input ) ? $input : array();

	$out = array(
		'brand'   => array(
			'fallback_name' => sanitize_text_field( $input['brand']['fallback_name'] ?? '' ),
			'tagline'       => sanitize_textarea_field( $input['brand']['tagline'] ?? '' ),
		),
		'links'   => array(
			'title' => sanitize_text_field( $input['links']['title'] ?? '' ),
			'items' => nuocda_168_landing_sanitize_link_items( $input['links']['items'] ?? array() ),
		),
		'company' => array(
			'title'          => sanitize_text_field( $input['company']['title'] ?? '' ),
			'name'           => sanitize_text_field( $input['company']['name'] ?? '' ),
			'trade_name'     => sanitize_text_field( $input['company']['trade_name'] ?? '' ),
			'tax_code'       => sanitize_text_field( $input['company']['tax_code'] ?? '' ),
			'address'        => sanitize_textarea_field( $input['company']['address'] ?? '' ),
			'representative' => sanitize_text_field( $input['company']['representative'] ?? '' ),
			'license_date'   => sanitize_text_field( $input['company']['license_date'] ?? '' ),
		),
		'contact' => array(
			'title'         => sanitize_text_field( $input['contact']['title'] ?? '' ),
			'hotline'       => sanitize_text_field( $input['contact']['hotline'] ?? '' ),
			'hotline_label' => sanitize_text_field( $input['contact']['hotline_label'] ?? '' ),
			'email'         => sanitize_email( $input['contact']['email'] ?? '' ),
			'zalo_url'      => nuocda_168_landing_sanitize_url( $input['contact']['zalo_url'] ?? '' ),
			'zalo_label'    => sanitize_text_field( $input['contact']['zalo_label'] ?? '' ),
			'hours_title'   => sanitize_text_field( $input['contact']['hours_title'] ?? '' ),
			'hours'         => sanitize_text_field( $input['contact']['hours'] ?? '' ),
			'hours_note'    => sanitize_textarea_field( $input['contact']['hours_note'] ?? '' ),
		),
		'quote'   => array(
			'title'       => sanitize_text_field( $input['quote']['title'] ?? '' ),
			'desc'        => sanitize_textarea_field( $input['quote']['desc'] ?? '' ),
			'placeholder' => sanitize_text_field( $input['quote']['placeholder'] ?? '' ),
			'button'      => sanitize_text_field( $input['quote']['button'] ?? '' ),
		),
		'stores'  => array(
			'heading' => sanitize_text_field( $input['stores']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['stores']['desc'] ?? '' ),
		),
		'bottom'  => array(
			'copyright' => sanitize_text_field( $input['bottom']['copyright'] ?? '' ),
			'subtitle'  => sanitize_text_field( $input['bottom']['subtitle'] ?? '' ),
		),
	);

	return nuocda_168_landing_array_merge( $defaults, $out );
}

/**
 * Sanitize callback theo trang.
 */
function nuocda_168_landing_sanitize_settings( $input ) {
	$page = isset( $_POST['nuocda_landing_page'] ) ? sanitize_key( wp_unslash( $_POST['nuocda_landing_page'] ) ) : 'home'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	switch ( $page ) {
		case 'about':
			return nuocda_168_landing_sanitize_about( $input );
		case 'contact':
			return nuocda_168_landing_sanitize_contact( $input );
		case 'footer':
			return nuocda_168_landing_sanitize_footer( $input );
		case 'home':
		default:
			return nuocda_168_landing_sanitize_home( $input );
	}
}
