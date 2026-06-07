<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     10.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<p class="woocommerce-result-count" role="status" aria-relevant="all" <?php echo ( empty( $orderedby ) || 1 === intval( $total ) ) ? '' : 'data-is-sorted-by="true"'; ?>>
	<?php
	// phpcs:disable WordPress.Security
	if ( 1 === intval( $total ) ) {
		echo 'Hiển thị 1 sản phẩm';
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		printf(
			'Hiển thị tất cả %1$d sản phẩm%2$s',
			intval( $total ),
			empty( $orderedby ) ? '' : '<span class="screen-reader-text">' . esc_html( $orderedby ) . '</span>'
		);
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		printf(
			'Hiển thị %1$d&ndash;%2$d trong tổng %3$d sản phẩm%4$s',
			intval( $first ),
			intval( $last ),
			intval( $total ),
			empty( $orderedby ) ? '' : '<span class="screen-reader-text">' . esc_html( $orderedby ) . '</span>'
		);
	}
	// phpcs:enable WordPress.Security
	?>
</p>
