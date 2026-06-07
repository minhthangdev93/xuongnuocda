<?php
/**
 * Fullscreen mobile menu — chỉ menu Main (child theme override).
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'fullscreen' !== oceanwp_mobile_menu_style()
	|| ! oceanwp_display_navigation() ) {
	return;
}

$classes = array( 'clr' );

if ( true === get_theme_mod( 'ocean_menu_social', false ) ) {
	$classes[] = 'has-social';
}

$classes               = implode( ' ', $classes );
$fullscreen_menu_attrs = apply_filters( 'oceanwp_attrs_mobile_fullscreen', '' );
$fs_menu_close_attrs   = apply_filters( 'oceanwp_attrs_mobile_fullscreen_close', '' );
$menu_args             = nuocda_168_get_main_mobile_menu_args( array( 'menu_class' => 'fs-dropdown-menu' ) );
$anchorlink_text       = esc_html( oceanwp_theme_strings( 'owp-string-mobile-fullscreen-anchor', false ) );
?>

<div id="mobile-fullscreen" class="clr" <?php echo $fullscreen_menu_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div id="mobile-fullscreen-inner" class="clr">

		<a href="<?php echo esc_url( ocean_get_site_name_anchors( $anchorlink_text ) ); ?>" class="close" aria-label="<?php echo esc_attr( oceanwp_theme_strings( 'owp-string-close-mobile-menu', false ) ); ?>" <?php echo $fs_menu_close_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="close-icon-wrap">
				<div class="close-icon-inner"></div>
			</div>
		</a>

		<nav class="<?php echo esc_attr( $classes ); ?>"<?php oceanwp_schema_markup( 'site_navigation' ); ?> role="navigation">

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

</div>
