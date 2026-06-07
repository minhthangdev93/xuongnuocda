<?php
/**
 * Page header — Nước Đá 168
 *
 * @package OceanWP Child Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! oceanwp_has_page_header() ) {
	return;
}

$classes = array( 'page-header', 'h168-page-header' );

$style = oceanwp_page_header_style();

if ( $style ) {
	$classes[ $style . '-page-header' ] = $style . '-page-header';
}

$visibility = get_theme_mod( 'ocean_page_header_visibility', 'all-devices' );
if ( 'all-devices' !== $visibility ) {
	$classes[] = $visibility;
}

$classes = implode( ' ', $classes );

$heading = get_theme_mod( 'ocean_page_header_heading_tag', 'h1' );
$heading = $heading ? $heading : 'h1';
$heading = apply_filters( 'ocean_page_header_heading', $heading );

?>

<?php do_action( 'ocean_before_page_header' ); ?>

<header class="<?php echo esc_attr( $classes ); ?>">

	<?php do_action( 'ocean_before_page_header_inner' ); ?>

	<div class="container clr page-header-inner h168-page-header__inner">

		<?php if ( oceanwp_has_page_header_heading() ) : ?>

			<<?php echo esc_attr( $heading ); ?> class="page-header-title clr"<?php oceanwp_schema_markup( 'headline' ); ?>><?php echo wp_kses_post( oceanwp_has_page_title() ); ?></<?php echo esc_attr( $heading ); ?>>

			<?php get_template_part( 'partials/page-header-subheading' ); ?>

		<?php endif; ?>

		<?php do_action( 'ocean_breadcrumbs_main' ); ?>

	</div>

	<?php oceanwp_page_header_overlay(); ?>

	<?php do_action( 'ocean_after_page_header_inner' ); ?>

</header>

<?php do_action( 'ocean_after_page_header' ); ?>
