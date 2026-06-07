<?php
/**
 * Thanh công cụ shop — tiếng Việt, ẩn grid/list view.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tắt nút Grid / List view của OceanWP.
 */
add_filter( 'theme_mod_ocean_woo_grid_list', '__return_false' );

/**
 * Danh mục sản phẩm — 3 cột desktop, 2 tablet, 1 mobile.
 */
add_filter( 'theme_mod_ocean_woocommerce_shop_columns', function () {
	return 3;
} );
add_filter( 'theme_mod_ocean_woocommerce_tablet_shop_columns', function () {
	return 2;
} );
add_filter( 'theme_mod_ocean_woocommerce_mobile_shop_columns', function () {
	return 1;
} );
add_filter( 'loop_shop_columns', function () {
	return 3;
} );

/**
 * Tùy chọn sắp xếp sản phẩm — tiếng Việt.
 */
add_filter( 'woocommerce_catalog_orderby', function ( $sortby ) {
	$labels = array(
		'menu_order' => 'Sắp xếp mặc định',
		'popularity' => 'Phổ biến nhất',
		'rating'     => 'Đánh giá cao',
		'date'       => 'Mới nhất',
		'price'      => 'Giá: thấp đến cao',
		'price-desc' => 'Giá: cao đến thấp',
	);

	foreach ( $sortby as $key => $label ) {
		if ( isset( $labels[ $key ] ) ) {
			$sortby[ $key ] = $labels[ $key ];
		}
	}

	return $sortby;
} );

/**
 * CSS ẩn grid/list nếu theme vẫn render.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}

	$css = '.woocommerce .oceanwp-grid-list{display:none!important;}';
	wp_add_inline_style( 'nuocda-design-system', $css );
}, 35 );
