<?php
/**
 * CTA Nhận báo giá — header desktop (Zalo).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact = nuocda_168_get_contact();
?>

<div class="nuocda-header-cta">
	<a
		href="<?php echo esc_url( $contact['zalo'] ); ?>"
		class="h168-btn h168-btn--zalo h168-btn--sm nuocda-header-cta__btn"
		target="_blank"
		rel="noopener noreferrer"
	>
		<i class="fas fa-comment-dots" aria-hidden="true"></i>
		<span>Nhận báo giá</span>
	</a>
</div>
