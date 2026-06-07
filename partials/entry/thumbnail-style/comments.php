<?php
/**
 * Thay link bình luận (hiện "Chức năng bình luận bị tắt") bằng nút Xem chi tiết.
 *
 * @package Nuoc Da Sach 168
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'post' !== get_post_type() ) {
	return;
}

$post_link   = ocean_link_post_url( get_the_ID() );
$link_target = ocean_link_post_url_target( get_the_ID() );
?>

<div class="blog-entry-comments clr">
	<a href="<?php echo esc_url( $post_link ); ?>"
		class="h168-btn h168-btn--blog"
		<?php if ( $link_target ) { ?>
			target="<?php echo esc_attr( $link_target ); ?>"
		<?php } ?>>
		<?php esc_html_e( 'Xem chi tiết', 'oceanwp' ); ?>
		<span class="screen-reader-text"><?php the_title(); ?></span>
	</a>
</div>
