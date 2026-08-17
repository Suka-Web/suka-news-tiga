<?php
/**
 * Kartu artikel untuk halaman archive.
 *
 * @package Suka_News_Satu
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="archive-card__image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'suka-archive-card', array( 'loading' => 'lazy' ) ); ?>
		</a>
	<?php endif; ?>

	<div class="archive-card__content">
		<?php echo wp_kses_post( suka_news_satu_get_category_bubbles() ); ?>
		<h2 class="archive-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php echo suka_news_satu_get_news_meta(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Seluruh nilai dinamis di-escape di dalam helper. ?>
		<div class="archive-card__excerpt"><?php the_excerpt(); ?></div>
		<a class="archive-card__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Baca selengkapnya', 'suka-news' ); ?> <span aria-hidden="true">&rarr;</span></a>
	</div>
</article>
