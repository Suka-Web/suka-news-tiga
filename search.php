<?php
/**
 * Template hasil pencarian.
 *
 * @package Suka_News_Satu
 */

get_header();
?>

<div class="search-page">
	<header class="search-page__header">
		<p><?php esc_html_e( 'Hasil Pencarian', 'suka-news' ); ?></p>
		<h1>
			<?php
			printf(
				/* translators: %s: kata kunci pencarian. */
				esc_html__( 'Berita untuk “%s”', 'suka-news' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
		<?php get_search_form(); ?>
	</header>

	<div class="archive-layout">
		<section class="archive-main" aria-label="<?php esc_attr_e( 'Hasil pencarian', 'suka-news' ); ?>">
			<?php if ( have_posts() ) : ?>
				<p class="search-result-count">
					<?php
					global $wp_query;
					printf(
						/* translators: %s: jumlah hasil. */
						esc_html( _n( '%s hasil ditemukan', '%s hasil ditemukan', $wp_query->found_posts, 'suka-news' ) ),
						esc_html( number_format_i18n( $wp_query->found_posts ) )
					);
					?>
				</p>
				<div class="archive-grid">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<?php get_template_part( 'template-parts/content', 'archive' ); ?>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
			<?php else : ?>
				<div class="archive-empty">
					<h2><?php esc_html_e( 'Berita tidak ditemukan', 'suka-news' ); ?></h2>
					<p><?php esc_html_e( 'Coba gunakan kata kunci lain atau telusuri kategori berita.', 'suka-news' ); ?></p>
				</div>
			<?php endif; ?>
		</section>

		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
