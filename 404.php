<?php
/**
 * Template halaman tidak ditemukan.
 *
 * @package Suka_News_Satu
 */

get_header();

$latest_posts = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
	)
);
?>

<section class="error-page">
	<p class="error-page__code" aria-hidden="true">404</p>
	<p class="error-page__eyebrow"><?php esc_html_e( 'Halaman Tidak Ditemukan', 'suka-news' ); ?></p>
	<h1><?php esc_html_e( 'Sepertinya halaman ini sudah berpindah.', 'suka-news' ); ?></h1>
	<p><?php esc_html_e( 'Periksa kembali alamatnya, cari berita lain, atau kembali ke halaman depan.', 'suka-news' ); ?></p>
	<div class="error-page__search"><?php get_search_form(); ?></div>
	<a class="error-page__home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'suka-news' ); ?></a>

	<?php if ( $latest_posts ) : ?>
		<div class="error-page__latest">
			<h2><?php esc_html_e( 'Berita Terbaru', 'suka-news' ); ?></h2>
			<div class="error-latest-grid">
				<?php foreach ( $latest_posts as $latest_post ) : ?>
					<a href="<?php echo esc_url( get_permalink( $latest_post ) ); ?>"><?php echo esc_html( get_the_title( $latest_post ) ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</section>

<?php get_footer(); ?>
