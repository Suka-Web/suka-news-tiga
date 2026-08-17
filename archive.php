<?php
/**
 * Template arsip kategori, tag, tanggal, dan penulis.
 *
 * @package Suka_News_Satu
 */

get_header();
?>

<div class="archive-page">
	<header class="archive-header">
		<nav class="breadcrumbs archive-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'suka-news' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'suka-news' ); ?></a>
			<span aria-hidden="true">/</span>
			<span aria-current="page"><?php the_archive_title(); ?></span>
		</nav>

		<p class="archive-header__eyebrow"><?php esc_html_e( 'Kumpulan Berita', 'suka-news' ); ?></p>
		<h1><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
		<p class="archive-count">
			<?php
			global $wp_query;
			printf(
				/* translators: %s: jumlah artikel. */
				esc_html( _n( '%s artikel ditemukan', '%s artikel ditemukan', $wp_query->found_posts, 'suka-news' ) ),
				esc_html( number_format_i18n( $wp_query->found_posts ) )
			);
			?>
		</p>
	</header>

	<div class="archive-layout">
		<section class="archive-main" aria-label="<?php esc_attr_e( 'Daftar berita', 'suka-news' ); ?>">
			<?php if ( have_posts() ) : ?>
				<div class="archive-grid">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'archive' ); ?>
					<?php endwhile; ?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => __( 'Sebelumnya', 'suka-news' ),
						'next_text' => __( 'Selanjutnya', 'suka-news' ),
					)
				);
				?>
			<?php else : ?>
				<div class="archive-empty">
					<h2><?php esc_html_e( 'Belum ada berita', 'suka-news' ); ?></h2>
					<p><?php esc_html_e( 'Belum ada artikel yang diterbitkan dalam arsip ini.', 'suka-news' ); ?></p>
				</div>
			<?php endif; ?>
		</section>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
