<?php
/**
 * Mobile nav — luôn render menu Main (child theme override).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nuocda_168_has_main_mobile_menu' ) || ! nuocda_168_has_main_mobile_menu() ) {
	return;
}

$menu_args = nuocda_168_get_main_mobile_menu_args();

if ( 'sidebar' === oceanwp_mobile_menu_style() ) {
	$menu_args['menu_class'] = 'mobile-menu dropdown-menu';
}
?>

<div id="mobile-nav" class="navigation clr">
	<?php wp_nav_menu( $menu_args ); ?>
	<?php nuocda_168_render_mobile_menu_cta(); ?>
</div>
