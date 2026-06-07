<?php
/**
 * Nút Xem chi tiết trên danh sách tin tức.
 *
 * @package Nuoc Da Sach 168
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_link   = ocean_link_post_url( get_the_ID() );
$link_target = ocean_link_post_url_target( get_the_ID() );

do_action( 'ocean_before_blog_entry_readmore' );
?>

<div class="blog-entry-readmore clr">
	<a href="<?php echo esc_url( $post_link ); ?>"
		class="h168-btn h168-btn--blog"
		<?php if ( $link_target ) { ?>
			target="<?php echo esc_attr( $link_target ); ?>"
		<?php } ?>>
		<?php echo esc_html( oceanwp_theme_strings( 'owp-string-post-continue-reading', false ) ); ?>
		<span class="screen-reader-text"><?php the_title(); ?></span>
	</a>
</div><!-- .blog-entry-readmore -->

<?php do_action( 'ocean_after_blog_entry_readmore' ); ?>
