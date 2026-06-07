<?php
/**
 * Template Name: Liên hệ 168
 * Template Post Type: page
 *
 * @package OceanWP Child Theme
 */

add_filter( 'ocean_display_page_header', '__return_false' );

get_header();

get_template_part( 'template-parts/content', 'contact-168' );

get_footer();
