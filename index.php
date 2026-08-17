<?php
/**
 * Template fallback utama.
 *
 * @package Suka_News_Satu
 */

get_header();
?>

<div class="content-with-sidebar">
	<section class="latest-news">
		<h1><?php esc_html_e( 'Berita Terbaru', 'suka-news' ); ?></h1>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
				?>
			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Belum ada berita yang diterbitkan.', 'suka-news' ); ?></p>
		<?php endif; ?>
	</section>

	<?php get_sidebar(); ?>
</div>

<?php
get_footer();
