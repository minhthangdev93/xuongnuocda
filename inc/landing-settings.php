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
		'agents'  => __( 'Đại lý', 'oceanwp' ),
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
		case 'agents':
			return nuocda_168_landing_defaults_agents();
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

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $saved ),
		$defaults
	);
}

/**
 * Sau merge: khôi phục list rỗng + chuỗi text rỗng từ defaults.
 *
 * @param array $merged   Settings đã merge.
 * @param array $defaults Defaults gốc.
 * @return array
 */
function nuocda_168_landing_finalize_settings( $merged, $defaults ) {
	$merged = nuocda_168_landing_restore_empty_lists( $merged, $defaults );
	return nuocda_168_landing_restore_empty_scalars( $merged, $defaults );
}

/**
 * Nếu danh sách (mảng số) bị lưu rỗng trong option thì lấy lại defaults —
 * tránh section "Tại sao chọn", stats, FAQ… mất nội dung khi admin lưu nhầm form trống.
 *
 * @param array $merged   Settings đã merge.
 * @param array $defaults Defaults gốc.
 * @return array
 */
function nuocda_168_landing_restore_empty_lists( $merged, $defaults ) {
	if ( ! is_array( $merged ) || ! is_array( $defaults ) ) {
		return $merged;
	}

	foreach ( $defaults as $key => $default_value ) {
		if ( ! is_array( $default_value ) ) {
			continue;
		}

		if ( ! isset( $merged[ $key ] ) || ! is_array( $merged[ $key ] ) ) {
			continue;
		}

		$default_is_list = ! nuocda_168_landing_is_assoc( $default_value );
		$merged_is_list  = ! nuocda_168_landing_is_assoc( $merged[ $key ] );

		if ( $default_is_list && $merged_is_list && array() === $merged[ $key ] && array() !== $default_value ) {
			$merged[ $key ] = $default_value;
			continue;
		}

		if ( nuocda_168_landing_is_assoc( $default_value ) && nuocda_168_landing_is_assoc( $merged[ $key ] ) ) {
			$merged[ $key ] = nuocda_168_landing_restore_empty_lists( $merged[ $key ], $default_value );
		}
	}

	return $merged;
}

/**
 * Chuỗi text bị lưu rỗng trong option → lấy lại defaults (vd. badge 10+, "Tìm hiểu thêm").
 * Không đụng URL/field defaults vốn là chuỗi rỗng (vd. hero btn_primary_url = Zalo).
 *
 * @param array $merged   Settings đã merge.
 * @param array $defaults Defaults gốc.
 * @return array
 */
function nuocda_168_landing_restore_empty_scalars( $merged, $defaults ) {
	if ( ! is_array( $merged ) || ! is_array( $defaults ) ) {
		return $merged;
	}

	foreach ( $defaults as $key => $default_value ) {
		if ( is_array( $default_value ) ) {
			if ( isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) && nuocda_168_landing_is_assoc( $default_value ) && nuocda_168_landing_is_assoc( $merged[ $key ] ) ) {
				$merged[ $key ] = nuocda_168_landing_restore_empty_scalars( $merged[ $key ], $default_value );
			}
			continue;
		}

		if ( ! is_string( $default_value ) || '' === $default_value ) {
			continue;
		}

		if ( ! isset( $merged[ $key ] ) || ! is_string( $merged[ $key ] ) || '' === trim( $merged[ $key ] ) ) {
			$merged[ $key ] = $default_value;
		}
	}

	return $merged;
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
			'link' => nuocda_168_landing_sanitize_link_url( $item['link'] ?? '' ),
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

	$hero  = $input['hero'] ?? array();
	$about = $input['about_quick'] ?? array();
	$cta   = $input['cta'] ?? array();
	$media = $input['media'] ?? array();

	$out = array(
		'hero'        => array(
			'badge'              => sanitize_text_field( $hero['badge'] ?? $defaults['hero']['badge'] ),
			'title'              => sanitize_text_field( $hero['title'] ?? '' ),
			'title_accent'       => sanitize_text_field( $hero['title_accent'] ?? '' ),
			'desc'               => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'                 => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
			'btn_primary_text'   => sanitize_text_field( $hero['btn_primary_text'] ?? '' ),
			'btn_primary_url'    => nuocda_168_landing_sanitize_button_url( $hero['btn_primary_url'] ?? '' ),
			'btn_secondary_text' => sanitize_text_field( $hero['btn_secondary_text'] ?? '' ),
			'btn_secondary_url'  => nuocda_168_landing_sanitize_button_url( $hero['btn_secondary_url'] ?? '' ),
			'stats'              => nuocda_168_landing_sanitize_stats( $hero['stats'] ?? array() ),
		),
		'about_quick' => array(
			'image'      => nuocda_168_landing_sanitize_url( $about['image'] ?? '' ),
			'image_alt'  => sanitize_text_field( $about['image_alt'] ?? '' ),
			'badge_num'  => sanitize_text_field( $about['badge_num'] ?? '' ),
			'badge_text' => sanitize_text_field( $about['badge_text'] ?? '' ),
			'label'      => sanitize_text_field( $about['label'] ?? '' ),
			'heading'    => sanitize_text_field( $about['heading'] ?? '' ),
			'lead'       => sanitize_textarea_field( $about['lead'] ?? '' ),
			'highlights' => nuocda_168_landing_sanitize_icon_items( $about['highlights'] ?? array() ),
			'link_url'   => nuocda_168_landing_sanitize_link_url( $about['link_url'] ?? '' ),
			'link_text'  => sanitize_text_field( $about['link_text'] ?? '' ),
		),
		'products'    => array(
			'label'      => sanitize_text_field( $input['products']['label'] ?? '' ),
			'heading'    => sanitize_text_field( $input['products']['heading'] ?? '' ),
			'desc'       => sanitize_textarea_field( $input['products']['desc'] ?? '' ),
			'link_label' => sanitize_text_field( $input['products']['link_label'] ?? '' ),
			'items'      => nuocda_168_landing_sanitize_products( $input['products']['items'] ?? array() ),
		),
		'why'         => array(
			'label'   => sanitize_text_field( $input['why']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['why']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['why']['items'] ?? array() ),
		),
		'stats'       => nuocda_168_landing_sanitize_stats( $input['stats'] ?? array() ),
		'cta'         => array(
			'title'            => sanitize_text_field( $cta['title'] ?? '' ),
			'desc'             => sanitize_textarea_field( $cta['desc'] ?? '' ),
			'bg'               => nuocda_168_landing_sanitize_url( $cta['bg'] ?? '' ),
			'btn_phone_prefix' => sanitize_text_field( $cta['btn_phone_prefix'] ?? '' ),
			'btn_zalo_text'    => sanitize_text_field( $cta['btn_zalo_text'] ?? '' ),
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
			'title'   => sanitize_text_field( $input['map']['title'] ?? '' ),
		),
		'reviews'     => array(
			'label'   => sanitize_text_field( $input['reviews']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['reviews']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_reviews( $input['reviews']['items'] ?? array() ),
		),
		'media'       => array(
			'label'       => sanitize_text_field( $media['label'] ?? '' ),
			'heading'     => sanitize_text_field( $media['heading'] ?? '' ),
			'desc'        => sanitize_textarea_field( $media['desc'] ?? '' ),
			'tab_factory' => sanitize_text_field( $media['tab_factory'] ?? '' ),
			'tab_cert'    => sanitize_text_field( $media['tab_cert'] ?? '' ),
			'tabs_aria'   => sanitize_text_field( $media['tabs_aria'] ?? '' ),
		),
		'faq'         => array(
			'label'   => sanitize_text_field( $input['faq']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['faq']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_faq( $input['faq']['items'] ?? array() ),
		),
	);

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $out ),
		$defaults
	);
}

/**
 * Sanitize trang giới thiệu.
 */
/**
 * Sanitize URL nút — giữ nguyên #anchor, còn lại dùng sanitize_link_url.
 *
 * @param string $url URL.
 * @return string
 */
function nuocda_168_landing_sanitize_button_url( $url ) {
	$url = trim( (string) $url );
	if ( ! $url ) {
		return '';
	}
	if ( '#' === $url[0] ) {
		return sanitize_text_field( $url );
	}
	return nuocda_168_landing_sanitize_link_url( $url );
}

function nuocda_168_landing_sanitize_about( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'about' );
	$input    = is_array( $input ) ? $input : array();
	$hero     = $input['hero'] ?? array();
	$intro    = $input['intro'] ?? array();
	$ops      = $input['ops'] ?? array();
	$dist     = $input['distribution'] ?? array();
	$cta      = $input['cta'] ?? array();

	$out = array(
		'hero'         => array(
			'badge'              => sanitize_text_field( $hero['badge'] ?? '' ),
			'title'              => sanitize_text_field( $hero['title'] ?? '' ),
			'desc'               => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'                 => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
			'btn_primary_text'   => sanitize_text_field( $hero['btn_primary_text'] ?? '' ),
			'btn_primary_url'    => nuocda_168_landing_sanitize_button_url( $hero['btn_primary_url'] ?? '' ),
			'btn_secondary_text' => sanitize_text_field( $hero['btn_secondary_text'] ?? '' ),
			'btn_secondary_url'  => nuocda_168_landing_sanitize_button_url( $hero['btn_secondary_url'] ?? '' ),
			'stats'              => nuocda_168_landing_sanitize_stats( $hero['stats'] ?? array() ),
		),
		'intro'        => array(
			'image'      => nuocda_168_landing_sanitize_url( $intro['image'] ?? '' ),
			'image_alt'  => sanitize_text_field( $intro['image_alt'] ?? '' ),
			'badge_num'  => sanitize_text_field( $intro['badge_num'] ?? '' ),
			'badge_text' => sanitize_text_field( $intro['badge_text'] ?? '' ),
			'label'      => sanitize_text_field( $intro['label'] ?? '' ),
			'heading'    => sanitize_text_field( $intro['heading'] ?? '' ),
			'lead'       => sanitize_textarea_field( $intro['lead'] ?? '' ),
			'highlights' => nuocda_168_landing_sanitize_icon_items( $intro['highlights'] ?? array() ),
			'products'   => nuocda_168_landing_sanitize_text_list( $intro['products'] ?? array() ),
		),
		'values'       => array(
			'label'   => sanitize_text_field( $input['values']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['values']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['values']['items'] ?? array() ),
		),
		'tech'         => array(
			'image'     => nuocda_168_landing_sanitize_url( $input['tech']['image'] ?? '' ),
			'image_alt' => sanitize_text_field( $input['tech']['image_alt'] ?? '' ),
			'label'     => sanitize_text_field( $input['tech']['label'] ?? '' ),
			'heading'   => sanitize_text_field( $input['tech']['heading'] ?? '' ),
			'desc'      => sanitize_textarea_field( $input['tech']['desc'] ?? '' ),
			'items'     => nuocda_168_landing_sanitize_icon_items( $input['tech']['items'] ?? array() ),
		),
		'process'      => array(
			'label'   => sanitize_text_field( $input['process']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['process']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['process']['desc'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['process']['items'] ?? array() ),
		),
		'certs'        => array(
			'label'   => sanitize_text_field( $input['certs']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['certs']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['certs']['desc'] ?? '' ),
		),
		'ops'          => array(
			'label'       => sanitize_text_field( $ops['label'] ?? '' ),
			'heading'     => sanitize_text_field( $ops['heading'] ?? '' ),
			'desc'        => sanitize_textarea_field( $ops['desc'] ?? '' ),
			'stats'       => nuocda_168_landing_sanitize_stats( $ops['stats'] ?? array() ),
			'departments' => nuocda_168_landing_sanitize_icon_items( $ops['departments'] ?? array() ),
			'erp_title'   => sanitize_text_field( $ops['erp_title'] ?? '' ),
			'erp_desc'    => sanitize_textarea_field( $ops['erp_desc'] ?? '' ),
		),
		'distribution' => array(
			'label'           => sanitize_text_field( $dist['label'] ?? '' ),
			'heading'         => sanitize_text_field( $dist['heading'] ?? '' ),
			'lead'            => sanitize_textarea_field( $dist['lead'] ?? '' ),
			'hq_label'        => sanitize_text_field( $dist['hq_label'] ?? '' ),
			'hq_text'         => sanitize_textarea_field( $dist['hq_text'] ?? '' ),
			'areas_heading'   => sanitize_text_field( $dist['areas_heading'] ?? '' ),
			'areas'           => nuocda_168_landing_sanitize_text_list( $dist['areas'] ?? array() ),
			'btn_stores_text' => sanitize_text_field( $dist['btn_stores_text'] ?? '' ),
			'btn_stores_url'  => nuocda_168_landing_sanitize_link_url( $dist['btn_stores_url'] ?? '' ),
			'btn_agent_text'  => sanitize_text_field( $dist['btn_agent_text'] ?? '' ),
			'btn_agent_url'   => nuocda_168_landing_sanitize_link_url( $dist['btn_agent_url'] ?? '' ),
			'map_embed'       => nuocda_168_landing_sanitize_url( $dist['map_embed'] ?? '' ),
			'map_caption'     => sanitize_text_field( $dist['map_caption'] ?? '' ),
		),
		'commit'       => array(
			'label'   => sanitize_text_field( $input['commit']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['commit']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['commit']['items'] ?? array() ),
		),
		'factory'      => array(
			'label'   => sanitize_text_field( $input['factory']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['factory']['heading'] ?? '' ),
			'desc'    => sanitize_textarea_field( $input['factory']['desc'] ?? '' ),
		),
		'cta'          => array(
			'title'            => sanitize_text_field( $cta['title'] ?? '' ),
			'desc'             => sanitize_textarea_field( $cta['desc'] ?? '' ),
			'bg'               => nuocda_168_landing_sanitize_url( $cta['bg'] ?? '' ),
			'btn_phone_prefix' => sanitize_text_field( $cta['btn_phone_prefix'] ?? '' ),
			'btn_zalo_text'    => sanitize_text_field( $cta['btn_zalo_text'] ?? '' ),
		),
	);

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $out ),
		$defaults
	);
}

/**
 * Sanitize danh sách option value|label (select form).
 *
 * @param mixed $items Array of pairs hoặc chuỗi nhiều dòng "value|Label".
 * @return array
 */
function nuocda_168_landing_sanitize_option_pairs( $items ) {
	if ( is_string( $items ) ) {
		$items = preg_split( '/\r\n|\r|\n/', $items );
	}

	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( is_array( $item ) ) {
			$label = sanitize_text_field( $item['label'] ?? '' );
			$value = sanitize_title( $item['value'] ?? '' );
			if ( ! $label ) {
				continue;
			}
			if ( ! $value ) {
				$value = sanitize_title( $label );
			}
			$out[] = array( 'value' => $value, 'label' => $label );
			continue;
		}

		$line = trim( (string) $item );
		if ( ! $line ) {
			continue;
		}

		if ( false !== strpos( $line, '|' ) ) {
			$parts = array_map( 'trim', explode( '|', $line, 2 ) );
			$value = sanitize_title( $parts[0] ?? '' );
			$label = sanitize_text_field( $parts[1] ?? '' );
		} else {
			$label = sanitize_text_field( $line );
			$value = sanitize_title( $label );
		}

		if ( $label && $value ) {
			$out[] = array( 'value' => $value, 'label' => $label );
		}
	}

	return $out;
}

/**
 * Sanitize thẻ kênh liên hệ nhanh.
 *
 * @param mixed $items Items.
 * @return array
 */
function nuocda_168_landing_sanitize_channels( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$allowed_types = array( 'phone', 'zalo', 'email', 'quote', 'custom' );
	$out           = array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$type = sanitize_key( $item['type'] ?? 'custom' );
		if ( ! in_array( $type, $allowed_types, true ) ) {
			$type = 'custom';
		}

		$title = sanitize_text_field( $item['title'] ?? '' );
		$desc  = sanitize_textarea_field( $item['desc'] ?? '' );
		$btn   = sanitize_text_field( $item['btn'] ?? '' );
		$value = sanitize_text_field( $item['value'] ?? '' );
		$icon  = sanitize_text_field( $item['icon'] ?? 'fa-check' );
		$class = preg_replace( '/[^A-Za-z0-9_-]/', '', (string) ( $item['class'] ?? '' ) );

		$url = trim( (string) ( $item['url'] ?? '' ) );
		if ( $url && '#' === $url[0] ) {
			$url = sanitize_text_field( $url );
		} elseif ( $url ) {
			$url = nuocda_168_landing_sanitize_link_url( $url );
		}

		// Giữ thẻ phone/zalo/email (tự resolve từ Footer) và quote/custom nếu còn url/icon/class.
		$keep_by_type = in_array( $type, array( 'phone', 'zalo', 'email', 'quote' ), true );
		$has_content  = $title || $desc || $btn || $value || $url || $class;
		if ( ! $keep_by_type && ! $has_content ) {
			continue;
		}

		$out[] = array(
			'type'  => $type,
			'icon'  => $icon ? $icon : 'fa-check',
			'title' => $title,
			'value' => $value,
			'desc'  => $desc,
			'btn'   => $btn,
			'url'   => $url,
			'class' => $class,
		);
	}

	return $out;
}

/**
 * Sanitize toàn bộ settings trang liên hệ.
 */
function nuocda_168_landing_sanitize_contact( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'contact' );
	$input    = is_array( $input ) ? $input : array();
	$hero     = $input['hero'] ?? array();
	$form     = $input['form'] ?? array();
	$cta      = $input['cta'] ?? array();
	$mobile   = $input['mobile'] ?? array();

	$out = array(
		'hero'     => array(
			'badge'            => sanitize_text_field( $hero['badge'] ?? '' ),
			'title'            => sanitize_text_field( $hero['title'] ?? '' ),
			'desc'             => sanitize_textarea_field( $hero['desc'] ?? '' ),
			'bg'               => nuocda_168_landing_sanitize_url( $hero['bg'] ?? '' ),
			'btn_phone_prefix' => sanitize_text_field( $hero['btn_phone_prefix'] ?? '' ),
			'btn_zalo_text'    => sanitize_text_field( $hero['btn_zalo_text'] ?? '' ),
			'btn_form_text'    => sanitize_text_field( $hero['btn_form_text'] ?? '' ),
			'btn_form_url'     => nuocda_168_landing_sanitize_button_url( $hero['btn_form_url'] ?? '' ),
		),
		'channels' => array(
			'items' => nuocda_168_landing_sanitize_channels( $input['channels']['items'] ?? array() ),
		),
		'form'     => array(
			'label'                     => sanitize_text_field( $form['label'] ?? '' ),
			'heading'                   => sanitize_text_field( $form['heading'] ?? '' ),
			'desc'                      => sanitize_textarea_field( $form['desc'] ?? '' ),
			'bullets'                   => nuocda_168_landing_sanitize_text_list( $form['bullets'] ?? array() ),
			'priority_text'             => sanitize_text_field( $form['priority_text'] ?? '' ),
			'submit_text'               => sanitize_text_field( $form['submit_text'] ?? '' ),
			'name_label'                => sanitize_text_field( $form['name_label'] ?? '' ),
			'name_placeholder'          => sanitize_text_field( $form['name_placeholder'] ?? '' ),
			'phone_label'               => sanitize_text_field( $form['phone_label'] ?? '' ),
			'phone_placeholder'         => sanitize_text_field( $form['phone_placeholder'] ?? '' ),
			'address_label'             => sanitize_text_field( $form['address_label'] ?? '' ),
			'address_placeholder'       => sanitize_text_field( $form['address_placeholder'] ?? '' ),
			'email_label'               => sanitize_text_field( $form['email_label'] ?? '' ),
			'email_placeholder'         => sanitize_text_field( $form['email_placeholder'] ?? '' ),
			'customer_type_label'       => sanitize_text_field( $form['customer_type_label'] ?? '' ),
			'customer_type_placeholder' => sanitize_text_field( $form['customer_type_placeholder'] ?? '' ),
			'customer_types'            => nuocda_168_landing_sanitize_option_pairs( $form['customer_types'] ?? array() ),
			'ice_type_label'            => sanitize_text_field( $form['ice_type_label'] ?? '' ),
			'ice_type_placeholder'      => sanitize_text_field( $form['ice_type_placeholder'] ?? '' ),
			'ice_types'                 => nuocda_168_landing_sanitize_option_pairs( $form['ice_types'] ?? array() ),
			'quantity_label'            => sanitize_text_field( $form['quantity_label'] ?? '' ),
			'quantity_placeholder'      => sanitize_text_field( $form['quantity_placeholder'] ?? '' ),
			'delivery_label'            => sanitize_text_field( $form['delivery_label'] ?? '' ),
			'delivery_placeholder'      => sanitize_text_field( $form['delivery_placeholder'] ?? '' ),
			'message_label'             => sanitize_text_field( $form['message_label'] ?? '' ),
			'message_placeholder'       => sanitize_text_field( $form['message_placeholder'] ?? '' ),
		),
		'areas'    => array(
			'label'    => sanitize_text_field( $input['areas']['label'] ?? '' ),
			'heading'  => sanitize_text_field( $input['areas']['heading'] ?? '' ),
			'desc'     => sanitize_textarea_field( $input['areas']['desc'] ?? '' ),
			'btn_text' => sanitize_text_field( $input['areas']['btn_text'] ?? '' ),
			'tags'     => nuocda_168_landing_sanitize_text_list( $input['areas']['tags'] ?? array() ),
		),
		'stores'   => array(
			'label'    => sanitize_text_field( $input['stores']['label'] ?? '' ),
			'heading'  => sanitize_text_field( $input['stores']['heading'] ?? '' ),
			'desc'     => sanitize_textarea_field( $input['stores']['desc'] ?? '' ),
			'btn_call' => sanitize_text_field( $input['stores']['btn_call'] ?? '' ),
			'btn_dir'  => sanitize_text_field( $input['stores']['btn_dir'] ?? '' ),
		),
		'map'      => array(
			'label'     => sanitize_text_field( $input['map']['label'] ?? '' ),
			'heading'   => sanitize_text_field( $input['map']['heading'] ?? '' ),
			'desc'      => sanitize_textarea_field( $input['map']['desc'] ?? '' ),
			'embed'     => nuocda_168_landing_sanitize_url( $input['map']['embed'] ?? '' ),
			'title'     => sanitize_text_field( $input['map']['title'] ?? '' ),
			'hq_prefix' => sanitize_text_field( $input['map']['hq_prefix'] ?? '' ),
			'btn_dir'   => sanitize_text_field( $input['map']['btn_dir'] ?? '' ),
			'btn_call'  => sanitize_text_field( $input['map']['btn_call'] ?? '' ),
		),
		'process'  => array(
			'label'   => sanitize_text_field( $input['process']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['process']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_icon_items( $input['process']['items'] ?? array() ),
		),
		'faq'      => array(
			'label'   => sanitize_text_field( $input['faq']['label'] ?? '' ),
			'heading' => sanitize_text_field( $input['faq']['heading'] ?? '' ),
			'items'   => nuocda_168_landing_sanitize_faq( $input['faq']['items'] ?? array() ),
		),
		'cta'      => array(
			'title'            => sanitize_text_field( $cta['title'] ?? '' ),
			'desc'             => sanitize_textarea_field( $cta['desc'] ?? '' ),
			'btn_phone_prefix' => sanitize_text_field( $cta['btn_phone_prefix'] ?? '' ),
			'btn_zalo_text'    => sanitize_text_field( $cta['btn_zalo_text'] ?? '' ),
		),
		'mobile'   => array(
			'aria'     => sanitize_text_field( $mobile['aria'] ?? '' ),
			'btn_call' => sanitize_text_field( $mobile['btn_call'] ?? '' ),
			'btn_zalo' => sanitize_text_field( $mobile['btn_zalo'] ?? '' ),
		),
	);

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $out ),
		$defaults
	);
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
 * Sanitize danh sách cửa hàng / đại lý.
 *
 * @param mixed $items Items.
 * @return array
 */
function nuocda_168_landing_sanitize_store_items( $items ) {
	if ( ! is_array( $items ) ) {
		return array();
	}

	$out = array();
	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}
		$name    = sanitize_text_field( $item['name'] ?? '' );
		$address = sanitize_textarea_field( $item['address'] ?? '' );
		if ( ! $name && ! $address ) {
			continue;
		}
		$out[] = array(
			'name'    => $name,
			'address' => $address,
		);
	}

	return $out;
}

/**
 * Sanitize tab Đại lý.
 *
 * @param mixed $input Input.
 * @return array
 */
function nuocda_168_landing_sanitize_agents( $input ) {
	$defaults = nuocda_168_landing_get_defaults( 'agents' );
	$input    = is_array( $input ) ? $input : array();

	$out = array(
		'items' => nuocda_168_landing_sanitize_store_items( $input['items'] ?? array() ),
	);

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $out ),
		$defaults
	);
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

	return nuocda_168_landing_finalize_settings(
		nuocda_168_landing_array_merge( $defaults, $out ),
		$defaults
	);
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
		case 'agents':
			return nuocda_168_landing_sanitize_agents( $input );
		case 'footer':
			return nuocda_168_landing_sanitize_footer( $input );
		case 'home':
		default:
			return nuocda_168_landing_sanitize_home( $input );
	}
}

/**
 * Option key thư viện ảnh dùng chung (trang chủ + giới thiệu).
 */
function nuocda_168_landing_galleries_option_key() {
	return 'nuocda_168_landing_galleries';
}

/**
 * Chuẩn hóa danh sách ID (không query DB).
 *
 * @param mixed $ids Raw IDs.
 * @return int[]
 */
function nuocda_168_landing_normalize_ids( $ids ) {
	if ( ! is_array( $ids ) ) {
		return array();
	}

	$out = array();

	foreach ( $ids as $id ) {
		$id = absint( $id );

		if ( $id < 1 || in_array( $id, $out, true ) ) {
			continue;
		}

		$out[] = $id;
	}

	return $out;
}

/**
 * Lấy cấu hình gallery đã lưu.
 *
 * @return array{factory_ids: int[], cert_ids: int[]}
 */
function nuocda_168_get_landing_galleries() {
	$saved = get_option( nuocda_168_landing_galleries_option_key(), array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return array(
		'factory_ids' => nuocda_168_landing_normalize_ids( $saved['factory_ids'] ?? array() ),
		'cert_ids'    => nuocda_168_landing_normalize_ids( $saved['cert_ids'] ?? array() ),
	);
}

/**
 * Sanitize danh sách attachment ID khi lưu admin.
 *
 * @param mixed $ids Raw IDs.
 * @return int[]
 */
function nuocda_168_landing_sanitize_attachment_ids( $ids ) {
	$out = array();

	foreach ( nuocda_168_landing_normalize_ids( $ids ) as $id ) {
		if ( 'attachment' !== get_post_type( $id ) ) {
			continue;
		}

		$out[] = $id;
	}

	return $out;
}

/**
 * Sanitize option galleries — giữ nguyên nhóm không có trong form (tránh xóa cert khi lưu tab Giới thiệu).
 *
 * @param mixed $input Raw input.
 * @return array{factory_ids: int[], cert_ids: int[]}
 */
function nuocda_168_landing_sanitize_galleries( $input ) {
	$prev  = nuocda_168_get_landing_galleries();
	$input = is_array( $input ) ? $input : array();
	$out   = $prev;

	if ( ! empty( $input['factory_present'] ) ) {
		$out['factory_ids'] = nuocda_168_landing_sanitize_attachment_ids( $input['factory_ids'] ?? array() );
	}

	if ( ! empty( $input['cert_present'] ) ) {
		$out['cert_ids'] = nuocda_168_landing_sanitize_attachment_ids( $input['cert_ids'] ?? array() );
	}

	return $out;
}

/**
 * Build danh sách ảnh gallery từ attachment IDs.
 *
 * @param int[]  $ids Attachment IDs.
 * @param string $fallback_alt Alt mặc định.
 * @return array<int, array<string, mixed>>
 */
function nuocda_168_landing_items_from_attachment_ids( $ids, $fallback_alt = '' ) {
	$items = array();

	foreach ( $ids as $index => $id ) {
		$id  = absint( $id );
		$src = $id ? wp_get_attachment_image_url( $id, 'large' ) : '';

		if ( ! $src ) {
			$src = $id ? wp_get_attachment_url( $id ) : '';
		}

		if ( ! $src ) {
			continue;
		}

		$alt = trim( (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) );

		if ( '' === $alt ) {
			$alt = get_the_title( $id );
		}

		if ( '' === $alt ) {
			$alt = $fallback_alt ? sprintf( '%s — %d', $fallback_alt, $index + 1 ) : '';
		}

		$meta   = wp_get_attachment_metadata( $id );
		$width  = isset( $meta['width'] ) ? absint( $meta['width'] ) : 1280;
		$height = isset( $meta['height'] ) ? absint( $meta['height'] ) : 960;

		if ( $width < 1 ) {
			$width = 1280;
		}
		if ( $height < 1 ) {
			$height = 960;
		}

		$items[] = array(
			'src'        => $src,
			'caption'    => $alt,
			'alt'        => $alt,
			'file'       => basename( (string) get_post_meta( $id, '_wp_attached_file', true ) ),
			'attachment' => $id,
			'width'      => $width,
			'height'     => $height,
		);
	}

	return $items;
}
