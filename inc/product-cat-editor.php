<?php
/**
 * Trình soạn thảo cho mô tả danh mục sản phẩm (product_cat).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Kiểm tra màn hình thêm/sửa danh mục sản phẩm.
 */
function nuocda_168_is_product_cat_admin_screen() {
	if ( ! is_admin() || empty( $_GET['taxonomy'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return false;
	}

	return 'product_cat' === $_GET['taxonomy']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Cấu hình wp_editor cho mô tả danh mục.
 */
function nuocda_168_get_product_cat_editor_settings() {
	return array(
		'textarea_name' => 'description',
		'textarea_rows' => 12,
		'media_buttons' => true,
		'teeny'         => false,
		'quicktags'     => true,
		'tinymce'       => array(
			'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist,link,unlink,blockquote,alignleft,aligncenter,alignright,undo,redo,fullscreen',
		),
	);
}

/**
 * Ẩn textarea mô tả mặc định (plain text).
 */
function nuocda_168_product_cat_editor_admin_head() {
	if ( ! nuocda_168_is_product_cat_admin_screen() ) {
		return;
	}
	?>
	<style>
		#addtag .form-field.term-description-wrap:not(.nuocda-term-description-wrap),
		#edittag tr.term-description-wrap:not(.nuocda-term-description-wrap) {
			display: none !important;
		}

		.nuocda-term-description-wrap .wp-editor-wrap {
			max-width: 100%;
		}
	</style>
	<?php
}
add_action( 'admin_head-edit-tags.php', 'nuocda_168_product_cat_editor_admin_head' );
add_action( 'admin_head-term.php', 'nuocda_168_product_cat_editor_admin_head' );

/**
 * Nạp script trình soạn thảo.
 */
function nuocda_168_product_cat_editor_assets( $hook ) {
	if ( 'edit-tags.php' !== $hook && 'term.php' !== $hook ) {
		return;
	}

	if ( ! nuocda_168_is_product_cat_admin_screen() ) {
		return;
	}

	wp_enqueue_editor();
}
add_action( 'admin_enqueue_scripts', 'nuocda_168_product_cat_editor_assets' );

/**
 * Form thêm danh mục — wp_editor.
 */
function nuocda_168_product_cat_add_description_editor() {
	?>
	<div class="form-field nuocda-term-description-wrap term-description-wrap">
		<label for="description"><?php esc_html_e( 'Mô tả', 'oceanwp' ); ?></label>
		<?php
		wp_editor(
			'',
			'description',
			nuocda_168_get_product_cat_editor_settings()
		);
		?>
		<p><?php esc_html_e( 'Mô tả hiển thị trên trang danh mục sản phẩm.', 'oceanwp' ); ?></p>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'nuocda_168_product_cat_add_description_editor', 20 );

/**
 * Form sửa danh mục — wp_editor.
 *
 * @param WP_Term $term Term hiện tại.
 */
function nuocda_168_product_cat_edit_description_editor( $term ) {
	$content = isset( $term->description ) ? html_entity_decode( $term->description, ENT_QUOTES, 'UTF-8' ) : '';
	?>
	<tr class="form-field nuocda-term-description-wrap term-description-wrap">
		<th scope="row" valign="top">
			<label for="description"><?php esc_html_e( 'Mô tả', 'oceanwp' ); ?></label>
		</th>
		<td>
			<?php
			wp_editor(
				$content,
				'description',
				nuocda_168_get_product_cat_editor_settings()
			);
			?>
			<p class="description"><?php esc_html_e( 'Mô tả hiển thị trên trang danh mục sản phẩm.', 'oceanwp' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'nuocda_168_product_cat_edit_description_editor', 20 );

/**
 * Cho phép lưu HTML an toàn trong mô tả danh mục sản phẩm.
 */
function nuocda_168_product_cat_description_kses( $description ) {
	if ( isset( $_POST['taxonomy'] ) && 'product_cat' === $_POST['taxonomy'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return wp_kses_post( $description );
	}

	return $description;
}

add_action( 'init', function () {
	if ( ! is_admin() ) {
		return;
	}

	remove_filter( 'pre_term_description', 'wp_filter_kses' );
	remove_filter( 'term_description', 'wp_kses_data' );
	add_filter( 'pre_term_description', 'nuocda_168_product_cat_description_kses', 1 );
} );

/**
 * Xóa textarea mô tả plain text — tránh trùng id="description" với wp_editor.
 */
function nuocda_168_product_cat_editor_footer_script() {
	if ( ! nuocda_168_is_product_cat_admin_screen() ) {
		return;
	}
	?>
	<script>
		document.querySelectorAll( '.term-description-wrap:not(.nuocda-term-description-wrap)' ).forEach( function ( el ) {
			el.remove();
		} );
	</script>
	<?php
}
add_action( 'admin_footer', 'nuocda_168_product_cat_editor_footer_script' );
