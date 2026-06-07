<?php
/**
 * Mô tả danh mục SP — hiển thị dưới danh sách, thu gọn 5 dòng.
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bỏ mô tả danh mục ở đầu trang (header).
 */
add_action( 'init', function () {
	remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
}, 20 );

/**
 * Nạp JS/CSS mô tả danh mục.
 */
function nuocda_168_enqueue_product_cat_description_assets() {
	if ( ! is_product_taxonomy() || absint( get_query_var( 'paged' ) ) > 0 ) {
		return;
	}

	$term = get_queried_object();
	if ( ! $term || empty( $term->description ) ) {
		return;
	}

	$theme   = wp_get_theme();
	$version = $theme->get( 'Version' );

	wp_enqueue_script(
		'nuocda-product-cat-description',
		get_stylesheet_directory_uri() . '/js/product-cat-description.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'nuocda_168_enqueue_product_cat_description_assets' );

/**
 * In mô tả danh mục dưới danh sách sản phẩm.
 */
function nuocda_168_render_category_description_below() {
	static $rendered = false;

	if ( $rendered ) {
		return;
	}

	if ( ! is_product_taxonomy() || absint( get_query_var( 'paged' ) ) > 0 ) {
		return;
	}

	$term = get_queried_object();
	if ( ! $term || empty( $term->description ) ) {
		return;
	}

	$term_description = apply_filters( 'woocommerce_taxonomy_archive_description_raw', $term->description, $term );
	if ( '' === trim( wp_strip_all_tags( $term_description ) ) ) {
		return;
	}

	$rendered = true;
	$content  = wc_format_content( wp_kses_post( $term_description ) );
	?>
	<section class="nuocda-cat-description" aria-label="<?php esc_attr_e( 'Mô tả danh mục', 'oceanwp' ); ?>">
		<div class="nuocda-cat-description__inner">
			<div class="nuocda-cat-description__content is-collapsed" id="nuocda-cat-desc-<?php echo esc_attr( (string) $term->term_id ); ?>">
				<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<button
				type="button"
				class="nuocda-cat-description__toggle"
				aria-expanded="false"
				aria-controls="nuocda-cat-desc-<?php echo esc_attr( (string) $term->term_id ); ?>"
				hidden
			>
				<span class="nuocda-cat-description__toggle-more">Xem thêm</span>
				<span class="nuocda-cat-description__toggle-less" hidden>Thu gọn</span>
			</button>
		</div>
	</section>
	<?php
}
add_action( 'woocommerce_after_shop_loop', 'nuocda_168_render_category_description_below', 25 );
add_action( 'woocommerce_no_products_found', 'nuocda_168_render_category_description_below', 25 );
