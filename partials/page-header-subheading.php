<?php
/**
 * Page subheading — Nước Đá 168 (child theme)
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $subheading = oceanwp_get_page_subheading() ) :
	?>
	<div class="clr page-subheading">
		<?php echo do_shortcode( $subheading ); ?>
	</div>
	<?php
endif;
