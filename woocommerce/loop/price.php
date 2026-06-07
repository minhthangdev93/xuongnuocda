<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( function_exists( 'nuocda_168_product_needs_zalo_quote' ) && nuocda_168_product_needs_zalo_quote( $product ) ) {
	echo '<span class="price price--zalo-quote">' . nuocda_168_get_zalo_quote_html() . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} elseif ( $price_html = $product->get_price_html() ) {
	echo '<span class="price">' . $price_html . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
