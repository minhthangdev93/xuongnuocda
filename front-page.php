<?php
/**
 * Template trang chủ Nước Đá 168
 *
 * @package OceanWP Child Theme
 */

add_filter( 'ocean_display_page_header', '__return_false' );

get_header();

get_template_part( 'template-parts/content', 'home-168' );

get_footer();
