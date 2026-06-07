<?php
/**
 * Single Product Price
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$price_class = apply_filters( 'woocommerce_product_price_class', 'price' );
$show_zalo   = nuocda_168_product_needs_zalo_quote( $product );

?>
<p class="<?php echo esc_attr( $price_class ); ?><?php echo $show_zalo ? ' price--zalo-quote' : ''; ?>">
	<?php
	if ( $show_zalo ) {
		echo nuocda_168_get_zalo_quote_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		echo $product->get_price_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</p>
