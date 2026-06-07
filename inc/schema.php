<?php
/**
 * Schema JSON-LD — tối ưu structured data, tích hợp Rank Math.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rank Math có đang active không.
 */
function nuocda_168_is_rank_math_active() {
	return defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' );
}

/**
 * Trang landing cần schema doanh nghiệp đầy đủ.
 */
function nuocda_168_is_schema_landing_page() {
	return is_front_page()
		|| is_page_template( 'templates/page-trang-chu-168.php' )
		|| is_page_template( 'templates/page-lien-he-168.php' )
		|| is_page_template( 'templates/page-gioi-thieu-168.php' );
}

/**
 * @id Organization
 */
function nuocda_168_schema_organization_id() {
	return trailingslashit( home_url() ) . '#organization';
}

/**
 * @id WebSite
 */
function nuocda_168_schema_website_id() {
	return trailingslashit( home_url() ) . '#website';
}

/**
 * Logo cho schema.
 */
function nuocda_168_schema_get_logo_url() {
	$logo_id = (int) get_theme_mod( 'custom_logo' );

	if ( $logo_id ) {
		$url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	$site_icon = (int) get_option( 'site_icon' );
	if ( $site_icon ) {
		$url = wp_get_attachment_image_url( $site_icon, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_yyTfY0SS.webp';
}

/**
 * Ảnh đại diện doanh nghiệp.
 */
function nuocda_168_schema_get_image_url() {
	return 'https://xuongnuocda.com/wp-content/uploads/2025/12/nha-may-san-xuat-nuoc-da-168_yyTfY0SS.webp';
}

/**
 * Giờ mở cửa 24/7.
 */
function nuocda_168_schema_opening_hours() {
	$days = array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );

	return array(
		array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $days,
			'opens'     => '00:00',
			'closes'    => '23:59',
		),
	);
}

/**
 * Schema Organization + LocalBusiness.
 */
function nuocda_168_schema_get_organization() {
	$contact = nuocda_168_get_contact();
	$company = nuocda_168_get_company();
	$phone   = nuocda_168_format_phone_e164( $contact['hotline'] );

	$schema = array(
		'@type'      => array( 'Organization', 'LocalBusiness' ),
		'@id'        => nuocda_168_schema_organization_id(),
		'name'       => nuocda_168_get_brand_name(),
		'legalName'  => $company['name'],
		'url'        => home_url( '/' ),
		'logo'       => nuocda_168_schema_get_logo_url(),
		'image'      => nuocda_168_schema_get_image_url(),
		'email'      => $contact['email'],
		'description' => 'Nhà sản xuất và phân phối nước đá sạch tại TP.HCM — giao hàng 24/7, đạt chuẩn HACCP & ISO 9001:2015.',
		'address'    => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $company['address'],
			'addressLocality' => 'Thành phố Hồ Chí Minh',
			'addressRegion'   => 'Hồ Chí Minh',
			'addressCountry'  => 'VN',
		),
		'areaServed' => array(
			array(
				'@type' => 'City',
				'name'  => 'Thành phố Hồ Chí Minh',
			),
			array(
				'@type' => 'AdministrativeArea',
				'name'  => 'Đông Nam Bộ, Việt Nam',
			),
		),
		'openingHoursSpecification' => nuocda_168_schema_opening_hours(),
		'priceRange'                => '$$',
		'sameAs'                    => array_values(
			array_filter(
				array(
					$contact['zalo'],
				)
			)
		),
	);

	if ( $phone ) {
		$schema['telephone'] = $phone;
	}

	$departments = array();
	foreach ( nuocda_168_get_stores() as $index => $store ) {
		$departments[] = array(
			'@type'   => 'LocalBusiness',
			'@id'     => trailingslashit( home_url() ) . '#store-' . ( $index + 1 ),
			'name'    => $store['name'],
			'address' => array(
				'@type'         => 'PostalAddress',
				'streetAddress' => $store['address'],
				'addressCountry' => 'VN',
			),
		);
	}

	if ( $departments ) {
		$schema['department'] = $departments;
	}

	return $schema;
}

/**
 * Schema WebSite + SearchAction.
 */
function nuocda_168_schema_get_website() {
	$search_url = home_url( '/?s={search_term_string}' );

	if ( function_exists( 'wc_get_page_id' ) ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( $shop_id > 0 ) {
			$search_url = add_query_arg( 's', '{search_term_string}', get_permalink( $shop_id ) );
		}
	}

	return array(
		'@type'            => 'WebSite',
		'@id'              => nuocda_168_schema_website_id(),
		'url'              => home_url( '/' ),
		'name'             => nuocda_168_get_brand_name(),
		'publisher'        => array(
			'@id' => nuocda_168_schema_organization_id(),
		),
		'inLanguage'       => 'vi-VN',
		'potentialAction'  => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $search_url,
			),
			'query-input' => 'required name=search_term_string',
		),
	);
}

/**
 * Schema FAQPage từ mảng q/a.
 *
 * @param array $faqs Mảng [ ['q'=>'', 'a'=>''] ].
 */
function nuocda_168_schema_get_faq_page( $faqs ) {
	if ( empty( $faqs ) || ! is_array( $faqs ) ) {
		return array();
	}

	$entities = array();

	foreach ( $faqs as $faq ) {
		if ( empty( $faq['q'] ) || empty( $faq['a'] ) ) {
			continue;
		}

		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $faq['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $faq['a'],
			),
		);
	}

	if ( ! $entities ) {
		return array();
	}

	$page_url = is_front_page() ? home_url( '/' ) : get_permalink();
	if ( ! $page_url ) {
		$page_url = home_url( '/' );
	}

	return array(
		'@type'      => 'FAQPage',
		'@id'        => trailingslashit( $page_url ) . '#faq',
		'mainEntity' => $entities,
	);
}

/**
 * Schema CollectionPage cho danh mục / shop.
 */
function nuocda_168_schema_get_collection_page() {
	if ( is_shop() ) {
		$shop_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
		$name    = $shop_id ? get_the_title( $shop_id ) : __( 'Sản phẩm', 'oceanwp' );
		$url     = $shop_id ? get_permalink( $shop_id ) : home_url( '/san-pham/' );
		$desc    = $shop_id ? wp_strip_all_tags( get_post_field( 'post_excerpt', $shop_id ) ) : '';
	} elseif ( is_product_taxonomy() ) {
		$term = get_queried_object();
		if ( ! $term || empty( $term->term_id ) ) {
			return array();
		}

		$name = $term->name;
		$url  = get_term_link( $term );
		if ( is_wp_error( $url ) ) {
			return array();
		}
		$desc = '';

		if ( function_exists( 'nuocda_168_get_product_cat_seo_description' ) ) {
			$desc = nuocda_168_get_product_cat_seo_description( $term->term_id );
		}

		if ( ! $desc && ! empty( $term->description ) ) {
			$desc = wp_trim_words( wp_strip_all_tags( $term->description ), 40, '…' );
		}
	} else {
		return array();
	}

	$schema = array(
		'@type'       => 'CollectionPage',
		'name'        => $name,
		'url'         => $url,
		'isPartOf'    => array(
			'@id' => nuocda_168_schema_website_id(),
		),
		'about'       => array(
			'@id' => nuocda_168_schema_organization_id(),
		),
	);

	if ( $desc ) {
		$schema['description'] = $desc;
	}

	$item_list = nuocda_168_schema_get_product_item_list();
	if ( $item_list ) {
		$schema['mainEntity'] = $item_list;
	}

	return $schema;
}

/**
 * ItemList sản phẩm trên trang archive hiện tại.
 */
function nuocda_168_schema_get_product_item_list() {
	global $wp_query;

	if ( empty( $wp_query->posts ) || ! is_array( $wp_query->posts ) ) {
		return array();
	}

	$items    = array();
	$position = 1;
	$max_items = 12;

	foreach ( $wp_query->posts as $post ) {
		if ( $position > $max_items ) {
			break;
		}

		if ( empty( $post->ID ) || 'product' !== $post->post_type ) {
			continue;
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'url'      => get_permalink( $post->ID ),
			'name'     => get_the_title( $post->ID ),
		);
		++$position;
	}

	if ( ! $items ) {
		return array();
	}

	return array(
		'@type'           => 'ItemList',
		'itemListElement' => $items,
	);
}

/**
 * Tìm key entity theo @type trong graph Rank Math.
 *
 * @param array  $data Graph schema.
 * @param string $type Schema type.
 */
function nuocda_168_schema_find_entity_key( $data, $type ) {
	foreach ( $data as $key => $entity ) {
		if ( ! is_array( $entity ) || empty( $entity['@type'] ) ) {
			continue;
		}

		$types = (array) $entity['@type'];
		if ( in_array( $type, $types, true ) ) {
			return $key;
		}
	}

	return null;
}

/**
 * Gộp entity schema vào graph.
 *
 * @param array $data   Graph hiện tại.
 * @param array $entity Entity mới.
 * @param string $key   Key ưu tiên.
 */
function nuocda_168_schema_merge_entity( $data, $entity, $key ) {
	if ( empty( $entity ) || ! is_array( $data ) ) {
		return $data;
	}

	if ( isset( $data[ $key ] ) && is_array( $data[ $key ] ) ) {
		$data[ $key ] = array_merge( $data[ $key ], $entity );
	} else {
		$data[ $key ] = $entity;
	}

	return $data;
}

/**
 * Tăng cường schema Product trên trang chi tiết.
 *
 * @param array $data Graph Rank Math.
 */
function nuocda_168_schema_enhance_product( $data ) {
	if ( ! is_product() ) {
		return $data;
	}

	global $product;
	if ( ! $product instanceof WC_Product ) {
		return $data;
	}

	$key = nuocda_168_schema_find_entity_key( $data, 'Product' );
	if ( null === $key || empty( $data[ $key ] ) || ! is_array( $data[ $key ] ) ) {
		return $data;
	}

	$contact = nuocda_168_get_contact();
	$brand   = array(
		'@type' => 'Brand',
		'name'  => nuocda_168_get_brand_name(),
	);

	$data[ $key ]['brand'] = $brand;
	$data[ $key ]['manufacturer'] = array(
		'@id' => nuocda_168_schema_organization_id(),
	);

	$categories = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
	if ( ! is_wp_error( $categories ) && $categories ) {
		$data[ $key ]['category'] = implode( ' > ', $categories );
	}

	$image_id = $product->get_image_id();
	if ( $image_id ) {
		$image_url = wp_get_attachment_image_url( $image_id, 'full' );
		if ( $image_url ) {
			$data[ $key ]['image'] = $image_url;
		}
	}

	if ( function_exists( 'nuocda_168_product_needs_zalo_quote' ) && nuocda_168_product_needs_zalo_quote( $product ) ) {
		$data[ $key ]['offers'] = array(
			'@type'         => 'Offer',
			'url'           => get_permalink( $product->get_id() ),
			'priceCurrency' => 'VND',
			'availability'  => 'https://schema.org/InStock',
			'seller'        => array(
				'@id' => nuocda_168_schema_organization_id(),
			),
			'description'   => 'Liên hệ Zalo hoặc hotline để nhận báo giá.',
		);
	} elseif ( $product->get_price() ) {
		$data[ $key ]['offers'] = array(
			'@type'           => 'Offer',
			'url'             => get_permalink( $product->get_id() ),
			'priceCurrency'   => 'VND',
			'price'           => wc_format_decimal( $product->get_price(), wc_get_price_decimals() ),
			'availability'    => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			'itemCondition'   => 'https://schema.org/NewCondition',
			'seller'          => array(
				'@id' => nuocda_168_schema_organization_id(),
			),
		);
	}

	if ( empty( $data[ $key ]['sku'] ) && $product->get_sku() ) {
		$data[ $key ]['sku'] = $product->get_sku();
	}

	return $data;
}

/**
 * Filter Rank Math JSON-LD.
 *
 * @param array $data   Schema graph.
 * @param mixed $jsonld Rank Math instance.
 */
function nuocda_168_filter_rank_math_json_ld( $data, $jsonld ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	if ( ! is_array( $data ) ) {
		$data = array();
	}

	unset( $jsonld );

	// Gỡ LocalBusiness trùng trên trang không phải landing (tránh rich result lỗi).
	if ( ! nuocda_168_is_schema_landing_page() && ! is_shop() && ! is_product_taxonomy() ) {
		if ( isset( $data['publisher'] ) ) {
			unset( $data['publisher'] );
		}
		if ( isset( $data['place'] ) ) {
			unset( $data['place'] );
		}
	}

	$data = nuocda_168_schema_enhance_product( $data );

	if ( nuocda_168_is_schema_landing_page() ) {
		$data = nuocda_168_schema_merge_entity( $data, nuocda_168_schema_get_organization(), 'nuocda_organization' );
		$data = nuocda_168_schema_merge_entity( $data, nuocda_168_schema_get_website(), 'nuocda_website' );

		$faqs = array();
		if ( is_front_page() || is_page_template( 'templates/page-trang-chu-168.php' ) ) {
			$faqs = nuocda_168_get_home_faqs();
		} elseif ( is_page_template( 'templates/page-lien-he-168.php' ) ) {
			$faqs = nuocda_168_get_contact_faqs();
		}

		$faq_schema = nuocda_168_schema_get_faq_page( $faqs );
		if ( $faq_schema ) {
			$data = nuocda_168_schema_merge_entity( $data, $faq_schema, 'nuocda_faq' );
		}
	}

	if ( is_shop() || is_product_taxonomy() ) {
		$collection = nuocda_168_schema_get_collection_page();
		if ( $collection ) {
			$data = nuocda_168_schema_merge_entity( $data, $collection, 'nuocda_collection' );
		}
	}

	if ( is_singular( 'post' ) ) {
		$org_key = nuocda_168_schema_find_entity_key( $data, 'Organization' );
		if ( null === $org_key ) {
			$data['nuocda_publisher'] = array(
				'@type' => 'Organization',
				'@id'   => nuocda_168_schema_organization_id(),
				'name'  => nuocda_168_get_brand_name(),
			);
		}
	}

	return $data;
}
add_filter( 'rank_math/json_ld', 'nuocda_168_filter_rank_math_json_ld', 99, 2 );

/**
 * In JSON-LD khi không có Rank Math.
 */
function nuocda_168_output_fallback_schema() {
	if ( nuocda_168_is_rank_math_active() || is_admin() ) {
		return;
	}

	$graph = array();

	if ( nuocda_168_is_schema_landing_page() ) {
		$graph[] = nuocda_168_schema_get_organization();
		$graph[] = nuocda_168_schema_get_website();

		$faqs = array();
		if ( is_front_page() || is_page_template( 'templates/page-trang-chu-168.php' ) ) {
			$faqs = nuocda_168_get_home_faqs();
		} elseif ( is_page_template( 'templates/page-lien-he-168.php' ) ) {
			$faqs = nuocda_168_get_contact_faqs();
		}

		$faq_schema = nuocda_168_schema_get_faq_page( $faqs );
		if ( $faq_schema ) {
			$graph[] = $faq_schema;
		}
	}

	if ( is_shop() || is_product_taxonomy() ) {
		$collection = nuocda_168_schema_get_collection_page();
		if ( $collection ) {
			$graph[] = $collection;
		}
	}

	if ( is_product() ) {
		global $product;
		if ( $product instanceof WC_Product ) {
			$product_schema = array(
				'@type' => 'Product',
				'@id'   => get_permalink() . '#product',
				'name'  => $product->get_name(),
				'url'   => get_permalink(),
			);

			$wrapped = nuocda_168_schema_enhance_product( array( 'product' => $product_schema ) );
			if ( ! empty( $wrapped['product'] ) ) {
				$graph[] = $wrapped['product'];
			}
		}
	}

	$graph = array_values( array_filter( $graph ) );
	if ( ! $graph ) {
		return;
	}

	$payload = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'nuocda_168_output_fallback_schema', 99 );
