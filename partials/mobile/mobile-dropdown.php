<?php
/**
 * Dropdown mobile menu — chỉ menu Main (child theme override).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'dropdown' !== oceanwp_mobile_menu_style()
	|| ! oceanwp_display_navigation() ) {
	return;
}

$classes = array( 'clr' );

if ( true === get_theme_mod( 'ocean_menu_social', false ) ) {
	$classes[] = 'has-social';
}

$classes               = implode( ' ', $classes );
$dropdown_menu_attrs   = apply_filters( 'oceanwp_attrs_mobile_dropdown', '' );
$menu_args             = nuocda_168_get_main_mobile_menu_args();
?>

<div id="mobile-dropdown" class="clr" <?php echo $dropdown_menu_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<nav class="<?php echo esc_attr( $classes ); ?>"<?php oceanwp_schema_markup( 'site_navigation' ); ?>>

		<?php
		if ( nuocda_168_has_main_mobile_menu() ) {
			wp_nav_menu( $menu_args );
		}

		nuocda_168_render_mobile_menu_cta();

		if ( true === get_theme_mod( 'ocean_menu_social', false ) ) {
			get_template_part( 'partials/header/social' );
		}
		?>

	</nav>

</div>
